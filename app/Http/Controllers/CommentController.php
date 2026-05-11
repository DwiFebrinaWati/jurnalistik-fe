<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $article = Article::findOrFail($articleId);

        $comment = Comment::create([
            'article_id' => $article->article_id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return response()->json([
            'messages' => 'Komentar berhasil dikirim ke penulis.',
            'data' => $comment->load('user:id,name')
        ], 201);
    }

    public function moderate(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $user = Auth::user();

        $request->validate([
            'message' => 'required|string',
            'status' => 'required|string'
        ]);

        if ($user->role_id == 2) { // Asumsi 2 = Editor
            if (!in_array($request->status, ['accepted', 'rejected'])) {
                return response()->json(['messages' => 'Editor hanya boleh Accepted atau Rejected'], 403);
            }
        }

        if ($user->role_id == 1) { // Asumsi 1 = Admin
            if (!in_array($request->status, ['published', 'takedown'])) {
                return response()->json(['messages' => 'Admin hanya boleh Published atau Takedown'], 403);
            }
        }

        Comment::create([
            'article_id' => $article->article_id,
            'user_id' => $user->user_id,
            'message' => "[".strtoupper($request->status)."] " . $request->message,
        ]);

        $article->update(['status' => $request->status]);

        return response()->json([
            'messages' => "Status artikel berhasil diubah menjadi {$request->status}",
            'current_status' => $article->status
        ]);
    }
}
