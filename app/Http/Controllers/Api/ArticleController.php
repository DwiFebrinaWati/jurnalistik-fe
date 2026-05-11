<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
        public function index(Request $request)
    {
        $query = Article::with('author');

        if ($request->has('status')) {
            // Biarkan controller menerima status apa adanya dari JS (draft/submitted/published)
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'published');
        }

        $articles = $query->latest()->get();
        return ArticleResource::collection($articles);
    }

    public function updateStatus(Request $request, $id)
{
    // Cek apakah user adalah admin/editor (sesuai role_id di sistemmu)
    // Jika editor role_id-nya misal 1 atau 2, sesuaikan di sini
    if (Auth::user()->role_id == 3) { // Contoh: 3 adalah penulis, maka penulis dilarang
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $article = Article::findOrFail($id);

    $request->validate([
        'status' => 'required|in:accepted,rejected,published',
        'message' => 'required_if:status,rejected|string', // Pesan wajib jika status ditolak
        'title' => 'sometimes|string',
        'content' => 'sometimes'
    ]);

    // Gunakan Transaction agar jika salah satu gagal, semua dibatalkan
    return DB::transaction(function () use ($request, $article, $id) {

        // 1. Update data artikel (termasuk judul/konten jika diedit editor)
        $article->update([
            'status' => $request->status,
            'title' => $request->title ?? $article->title,
            'content' => $request->content ?? $article->content,
            'publish_date' => ($request->status === 'published') ? now() : $article->publish_date,
        ]);

        // 2. Jika statusnya rejected, masukkan alasan ke tabel comments
        if ($request->status === 'rejected') {
            DB::table('comments')->insert([
                'article_id' => $id,
                'user_id'    => Auth::id(), // ID Editor yang menolak
                'message'    => $request->message,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'message' => "Article status updated to {$request->status}",
            'data' => new ArticleResource($article)
        ], 200);
    });
}

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'nullable|in:draft,submitted'
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('photo')) {
            $thumbnailPath = $request->file('photo')->store('thumbnails', 'public');
        }

        $article = Article::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'content' => $request->content,
            'photo' => $thumbnailPath,
            'status' => $request->status ?? 'draft',
        ]);

        return response()->json([
            'message' => 'Article created successfully',
            'article' => new ArticleResource($article),
        ], 201);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('editor-images', 'public');
            $url = asset('storage/' . $path);

            return response()->json(['url' => $url]);
        }

        return response()->json(['message' => 'No image uploaded'], 400);
    }

    public function submit($id)
    {
        $article = Article::where('user_id', Auth::id())->findOrFail($id);

        if ($article->status !== 'draft' && $article->status !== 'rejected') {
            return response()->json(['message' => 'Only draft or rejected articles can be submitted'], 400);
        }

        $article->update(['status' => 'submitted']);

        return response()->json(['message' => 'Article submitted for review'], 200);
    }

    public function update(Request $request, $id) {
    $article = Article::where('article_id', $id)->where('user_id', Auth::id())->firstOrFail();

    $request->validate([
        'title' => 'sometimes|required',
        'content' => 'sometimes|required',
        'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $data = $request->only(['title', 'content', 'status']);

    if ($request->hasFile('photo')) {
        if ($article->photo) Storage::disk('public')->delete($article->photo);
        $data['photo'] = $request->file('photo')->store('thumbnails', 'public');
    }

    $article->update($data);
    return response()->json(['message' => 'Updated', 'data' => $article]);
    }

    public function takedown($id)
    {
        if (Auth::user()->role_id !== 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $article = Article::findOrFail($id);

        $article->update([
            'status' => 'archived',
            'publish_date' => null]);

        return response()->json(['message' => 'Article taken down successfully'], 200);

    }
    public function myArticles()
    {
        $articles = Article::where('user_id', Auth::id())->latest()->get();

        return ArticleResource::collection($articles);
    }

    public function show($id)
    {
        $article = Article::with('author')->findOrFail($id);
        return new ArticleResource($article);
    }

    public function approve($id)
    {
    $article = Article::findOrFail($id);
    $article->update([
        'status' => 'published',
        'publish_date' => now()
    ]);

    return response()->json(['message' => 'Article published successfully']);
    }

    public function destroy($id) {
    $article = Article::where('article_id', $id)->where('user_id', Auth::id())->first();

    if (!$article) return response()->json(['message' => 'Unauthorized/Not Found'], 404);

    if ($article->photo) Storage::disk('public')->delete($article->photo);
    $article->delete();

    return response()->json(['message' => 'Berhasil dihapus']);
    }
}
