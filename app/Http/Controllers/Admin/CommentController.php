<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = DB::table('comments')
            ->orderByDesc('created_at')
            ->get();

        return inertia('Admin/Comments', [
            'comments' => $comments,
        ]);
    }

    public function approve($id)
    {
        DB::table('comments')->where('id', $id)->update(['status' => 'approved']);
        return back()->with('success', 'Komentar disetujui.');
    }

    public function reject($id)
    {
        DB::table('comments')->where('id', $id)->update(['status' => 'rejected']);
        return back()->with('success', 'Komentar ditolak.');
    }

    public function destroy($id)
    {
        DB::table('comments')->where('id', $id)->delete();
        return back()->with('success', 'Komentar dihapus.');
    }
}
