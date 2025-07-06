<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = DB::table('contacts')
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Admin/Contacts', [
            'contacts' => $contacts,
        ]);
    }

    public function destroy($id)
    {
        DB::table('contacts')->where('id', $id)->delete();
        return back()->with('success', 'Pesan dihapus.');
    }
}
