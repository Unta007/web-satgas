@extends('layout.app')

@section('title', 'Laman Edukasi')

@section('content')
    <div class="educational-container">

        <div class="upper-separator">
            <span class="upper-separator-text">Konten Terbaru</span>
        </div>

        @if ($featuredArticle)
            <section class="top-section-grid">
                <div class="featured-top-article">
                    <a href="{{ route('articles.show', $featuredArticle->slug) }}">
                        <img src="{{ $featuredArticle->image ? (Str::startsWith($featuredArticle->image, 'http') ? $featuredArticle->image : asset('storage/' . $featuredArticle->image)) : 'https://placehold.co/800x600/e0e0e0/555?text=Featured' }}"
                            alt="{{ $featuredArticle->title }}">

                        <div class="caption">
                            <h2>{{ $featuredArticle->title }}</h2>

                            <div class="featured-article-meta">
                                <small>{{ $featuredArticle->published_at->diffForHumans() }}</small>
                                <span class="meta-separator">|</span>
                                <small>{{ $featuredArticle->author }}</small>
                                <span class="meta-separator">|</span>
                                <small><i class="bi bi-clock me-1"></i>{{ $featuredArticle->reading_time }}</small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="grid-articles-group">
                    @if ($gridArticles->isNotEmpty())
                        @foreach ($gridArticles as $article)
                            <div class="grid-article-item">
                                <img src="{{ $article->image ? (Str::startsWith($article->image, 'http') ? $article->image : asset('storage/' . $article->image)) : 'https://placehold.co/120x90/e0e0e0/555?text=Image' }}"
                                    alt="{{ $article->title }}" class="grid-article-image">

                                <div class="grid-article-text-content">
                                    <a href="{{ route('articles.show', $article->slug) }}">
                                        <h3>{{ $article->title }}</h3>
                                    </a>

                                    <div class="grid-article-meta">
                                        <small>{{ $article->published_at->diffForHumans() }}</small>
                                        <span class="meta-separator">|</span>
                                        <small>{{ $article->author }}</small>
                                        <span class="meta-separator">|</span>
                                        <small><i class="bi bi-clock me-1"></i>{{ $article->reading_time }}</small>
                                    </div>

                                    <p class="grid-article-description">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($article->description), 290) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>
        @endif

        <div class="section-separator">
            <span class="section-separator-text">Jelajahi Konten Kami</span>
        </div>

        <div class="main-layout-grid">

            <div class="latest-news-section" id="article-list-container">
                {{-- Muat artikel awal menggunakan partial --}}
                @include('user.partials._article_list', ['latestArticles' => $latestArticles])
            </div>

            @include('user.partials._sidebar')
        </div>

        <div id="load-more-container" class="text-center mt-5">
            @if ($latestArticles->hasMorePages())
                <button id="load-more-btn" class="btn btn-danger" data-next-page="{{ $latestArticles->nextPageUrl() }}">
                    Muat Lebih Banyak
                </button>
            @endif
        </div>

        <button id="backToTopBtn" title="Kembali ke Atas" aria-label="Kembali ke Atas">&#8679;</button>

    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/load_more.js')
@endpush
