<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        // Ambil semua notifikasi untuk user yang login
        $notifikasis = Auth::user()->notifications()->paginate(15);
        return view('admin.notifikasi.index', compact('notifikasis'));
    }

    public function markAllAsRead()
    {
        // Tandai semua notifikasi yang belum dibaca sebagai sudah dibaca
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    }
}