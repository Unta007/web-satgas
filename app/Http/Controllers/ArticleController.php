<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Method index tidak berubah, hanya pemanggilan helpernya disesuaikan
    public function index(Request $request)
    {
        $articlesQuery = Article::whereNotNull('published_at')->latest('published_at');
        $allArticles = (clone $articlesQuery)->limit(3)->get();
        $featuredArticle = $allArticles->first();
        $gridArticles = $allArticles->slice(1, 2);
        $displayedIds = collect([$featuredArticle->id ?? null])->concat($gridArticles->pluck('id'))->filter();
        $latestArticles = (clone $articlesQuery)->whereNotIn('id', $displayedIds)->paginate(5);

        if ($request->ajax()) {
            $view = view('user.partials._article_list', ['latestArticles' => $latestArticles])->render();
            return response()->json(['html' => $view, 'next_page_url' => $latestArticles->nextPageUrl()]);
        }

        $mainPageDisplayedIds = $displayedIds->concat($latestArticles->pluck('id'));
        $otherArticles = $this->getSidebarArticles($mainPageDisplayedIds->toArray());

        return view('user.educational_contents', [
            'featuredArticle' => $featuredArticle,
            'gridArticles'    => $gridArticles,
            'latestArticles'  => $latestArticles,
            'otherArticles'   => $otherArticles,
            'searchQuery'     => $request->input('search'),
        ]);
    }

    // Method search tidak berubah, hanya pemanggilan helpernya disesuaikan
    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
        if (empty($searchQuery)) {
            return redirect()->route('articles.index');
        }

        $articles = Article::whereNotNull('published_at')
            ->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', "%{$searchQuery}%")->orWhere('description', 'like', "%{$searchQuery}%");
            })->latest('published_at')->limit(20)->get();

        $mainPageDisplayedIds = Article::whereNotNull('published_at')->latest('published_at')->limit(8)->pluck('id');
        $otherArticles = $this->getSidebarArticles($mainPageDisplayedIds->toArray());

        return view('user.search_results', [
            'articles'       => $articles,
            'searchQuery'    => $searchQuery,
            'otherArticles'  => $otherArticles
        ]);
    }

    // --- PERUBAHAN DI METHOD SHOW ---
    public function show(Request $request, Article $article)
    {
        // Ambil data untuk sidebar, kecualikan artikel yang sedang dibaca
        $otherArticles = $this->getSidebarArticles([$article->id]);

        return view('user.article', [ // Ganti nama view jika perlu
            'article'       => $article,
            'otherArticles' => $otherArticles,
            'searchQuery'   => $request->input('search')
        ]);
    }

    // --- FUNGSI HELPER YANG DISEMPURNAKAN ---
    private function getSidebarArticles(array $excludeIds = [])
    {
        return Article::whereNotNull('published_at')
            ->whereNotIn('id', $excludeIds)
            ->latest('published_at')
            ->limit(9)
            ->get();
    }
}
