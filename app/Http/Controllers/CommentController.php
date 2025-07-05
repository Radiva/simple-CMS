<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'commentable_type' => 'required|in:artikel,portfolio',
            'commentable_id' => 'required|integer',
            'content' => 'required|min:3|max:1000',
        ]);

        $typeMap = [
            'artikel' => 'App\Models\Artikel',
            'portfolio' => 'App\Models\Portfolio',
        ];

        DB::table('comments')->insert([
            'user_id' => Auth::id(),
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $typeMap[$request->commentable_type],
            'content' => $request->content,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Komentar berhasil dikirim dan menunggu persetujuan.');
    }
}
