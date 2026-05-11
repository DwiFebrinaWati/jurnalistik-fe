<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Work;
use Illuminate\Support\Facades\Storage;

class WorkController extends Controller
{
    public function index() {
        return response()->json(Work::latest()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'fileType'    => 'required|in:Fotografi,Videografi,Penulisan',
            'title'       => 'required|string',
            'url'        => 'required|url',
            'cover_by'    => 'required|string',
            'cover_image' => 'required|image|max:2048',
        ]);

        $path = $request->file('cover_image')->store('works', 'public');

        $work = Work::create([
            'fileType'    => $request->fileType,
            'title'       => $request->title,
            'url'        => $request->url,
            'cover_by'    => $request->cover_by,
            'cover_image' => $path,
        ]);

        return response()->json(['message' => 'Karya berhasil ditambah!', 'data' => $work], 201);
    }

    public function update(Request $request, Work $work) {
        $data = $request->only(['fileType', 'title', 'url', 'cover_by', 'cover_image']);

        if ($request->hasFile('cover_image')) {
            if ($work->cover_image) Storage::disk('public')->delete($work->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('works', 'public');
        }

        $work->update($data);
        return response()->json(['message' => 'Data karya diperbarui']);
    }

    public function destroy(Work $work) {
        if ($work->cover_image) Storage::disk('public')->delete($work->cover_image);
        $work->delete();
        return response()->json(['message' => 'Karya berhasil dihapus']);
    }
}
