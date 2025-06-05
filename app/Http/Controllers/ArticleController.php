<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Menampilkan semua artikel di halaman "educational contents"
    public function index()
    {
        // Ambil semua artikel yang sudah dipublish, urutkan dari yang terbaru
        $articles = Article::whereNotNull('published_at')->latest('published_at')->get();

        // Pisahkan artikel pertama sebagai "featured"
        $featuredArticle = $articles->shift();

        return view('user.educational_contents', [
            'featuredArticle' => $featuredArticle,
            'articles' => $articles
        ]);
    }

    // Menampilkan satu artikel secara detail
    public function show(Article $article) // Menggunakan Route Model Binding
    {
        // Laravel akan otomatis mencari artikel berdasarkan slug dan menampilkan 404 jika tidak ditemukan
        return view('user.article', ['article' => $article]);
    }
}
