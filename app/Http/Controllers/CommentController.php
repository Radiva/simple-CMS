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
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'content' => 'required|min:3|max:1000',
            'website' => 'nullable|string|max:100', // honeypot
            'start_time' => 'required|numeric',
        ]);

        // 🕳️ Honeypot check
        if (!empty($request->website)) {
            return response()->json(['error' => 'Spam detected'], 422);
        }

        // ⏳ Delay check (5 detik minimum)
        $elapsed = now()->diffInSeconds(Carbon::createFromTimestampMs($request->start_time));
        if ($elapsed < 5) {
            return response()->json(['error' => 'Form submitted too quickly'], 422);
        }

        $typeMap = [
            'artikel' => \App\Models\Artikel::class,
            'portfolio' => \App\Models\Portfolio::class,
        ];

        DB::table('comments')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $typeMap[$request->commentable_type],
            'content' => $request->content,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Komentar berhasil dikirim dan akan ditinjau terlebih dahulu.');
    }
}
