<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class UserNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan semua notifikasi pengguna.
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(10); // Paginasi notifikasi

        // Anda bisa juga menandai semua notifikasi yang belum dibaca sebagai terbaca saat halaman ini dibuka
        // $user->unreadNotifications->markAsRead();

        return view('user.notifications.index', compact('notifications')); // Buat view ini
    }

    /**
     * Menampilkan notifikasi tunggal (dan menandainya sebagai terbaca), lalu redirect.
     */
    public function show(DatabaseNotification $notification)
    {
        if ($notification->notifiable_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $notification->markAsRead();

        $targetUrlFromNotificationData = $notification->data['url'] ?? null;
        // Pastikan Anda memiliki route 'home' atau ganti dengan route dashboard pengguna yang valid
        $fallbackUrl = route('home');

        $finalRedirectUrl = $targetUrlFromNotificationData ?: $fallbackUrl;

        if (empty($finalRedirectUrl)) {
            Log::warning('URL redirect notifikasi kosong untuk notifikasi ID: ' . $notification->id . '. Menggunakan fallback ke home.');
            return redirect()->route('home')->with('warning', 'Tidak dapat menemukan tujuan notifikasi, dialihkan ke beranda.');
        }

        // Log URL sebelum redirect untuk memastikan (bisa dihapus setelah fix)
        // Log::info('Redirecting notification click to: ' . $finalRedirectUrl);

        return redirect($finalRedirectUrl);
    }

    /**
     * Menandai semua notifikasi yang belum dibaca sebagai terbaca.
     */
    public function markAllAsRead(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();

        // Bisa redirect kembali atau mengembalikan response JSON jika dipanggil via AJAX
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Semua notifikasi telah ditandai terbaca.']);
        }
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai terbaca.');
    }
}
