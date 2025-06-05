@extends('layout.app')

@section('title', 'Educational Contents on Sexual Harassment')

@section('content')
    <div class="magazine-container">
        <header class="magazine-header">
            <h1>Educational Contents</h1>
            <p>Explore our collection of educational articles and resources focused on sexual harassment awareness,
                prevention, and support.</p>
        </header>

        @if ($featuredArticle)
            <section class="featured-article">
                <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="featured-article-link">
                    {{-- Gunakan gambar dari database, berikan default jika tidak ada --}}
                    <img src="{{ $featuredArticle->image ? asset('storage/' . $featuredArticle->image) : Vite::asset('resources/images/scope.png') }}"
                        alt="{{ $featuredArticle->title }}" />
                    <div class="featured-article-content">
                        <h2>Featured: {{ $featuredArticle->title }}</h2>
                        {{-- Anda bisa menambahkan ringkasan/excerpt di model jika perlu --}}
                        <p>{{ Str::limit(strip_tags($featuredArticle->description), 150) }}</p>
                        <small>Published on {{ $featuredArticle->published_at->format('F d, Y') }}</small>
                    </div>
                </a>
            </section>
        @endif

        @if ($articles->isNotEmpty())
            <section class="magazine-articles">
                @foreach ($articles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}" class="magazine-article-card">
                        <img src="{{ $article->image ? asset('storage/' . $article->image) : Vite::asset('resources/images/default.jpg') }}"
                            alt="{{ $article->title }}" class="magazine-article-image" />
                        <div class="magazine-article-content">
                            <h3>{{ $article->title }}</h3>
                            <p>{{ Str::limit(strip_tags($article->description), 100) }}</p>
                            <small>Published on {{ $article->published_at->format('F d, Y') }}</small>
                        </div>
                    </a>
                @endforeach
            </section>
        @else
            <p class="text-center">No more articles found.</p>
        @endif
    </div>
@endsection
