<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Article;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): View
    {
        $latestArticles = Article::latest()->take(3)->get();

        $testimonials = Testimonial::where('is_active', true)->inRandomOrder()->get();

        return view('user.index', compact('latestArticles', 'testimonials'));
    }
}
