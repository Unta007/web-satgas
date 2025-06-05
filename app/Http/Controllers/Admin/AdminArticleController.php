<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminArticleController extends Controller
{
    // Menampilkan daftar artikel (List Article)
    public function index()
    {
        $articles = Article::latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    // Menampilkan form tambah artikel (Create Article)
    public function create()
    {
        return view('admin.articles.create');
    }

    // Menyimpan artikel baru ke database
    public function store(Request $request) // HAPUS 'Article $article' dari parameter
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
        }

        // Simpan instance artikel yang baru dibuat ke variabel
        $newlyCreatedArticle = Article::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'slug' => Str::slug($request->title) . '-' . time(),
            'image' => $path,
            'published_at' => now(),
        ]);

        // Gunakan instance yang baru dibuat untuk logging
        activity()
            ->causedBy(Auth::user())
            ->performedOn($newlyCreatedArticle) // <-- GUNAKAN $newlyCreatedArticle
            ->log("<strong>menambahkan</strong> artikel baru: \"<strong>{$newlyCreatedArticle->title}</strong>\".");

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('file')->store('content-images', 'public');

        return response()->json(['location' => asset('storage/' . $path)]);
    }

    // Menampilkan form edit artikel
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    // Memperbarui artikel di database
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $article->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $path = $request->file('image')->store('articles', 'public');
        }

        $article->update([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'slug' => Str::slug($request->title) . '-' . $article->id, // Update slug jika judul berubah
            'image' => $path,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($article)
            ->log("<strong>mengedit</strong> artikel: \"<strong>{$article->title}</strong>\".");

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    // Menghapus artikel dari database
    public function destroy(Article $article) // $article di sini dari Route Model Binding - INI BENAR
    {
        $articleTitle = $article->title; // Simpan sebelum dihapus
        $articleId = $article->id; // Simpan ID sebelum dihapus

        // ... (logika hapus gambar) ...
        $article->delete();

        activity()
            ->causedBy(Auth::user())
            // ->performedOn($article) // Model sudah dihapus, jadi tidak bisa di-pass ke performedOn jika ingin akses propertinya
            ->withProperties(['article_id' => $articleId, 'title' => $articleTitle]) // Simpan detail penting
            ->log("<strong>menghapus</strong> artikel: \"<strong>{$articleTitle}</strong>\".");

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
