@extends('layout.app')

@section('title', 'Hasil Pencarian untuk "' . e($searchQuery) . '"')

@section('content')
<div class="educational-container">

    <div class="upper-separator">
        <span class="upper-separator-text">Menampilkan hasil pencarian untuk: "{{ e($searchQuery) }}"</span>
    </div>

    <div class="main-layout-grid">

        <main>
            @if ($articles->isNotEmpty())
                <div class="latest-news-section" id="article-list-container">
                    @include('user.partials._article_list', ['latestArticles' => $articles])
                </div>
            @else
                <div class="text-center py-5">
                    <p class="h4">Oops! Tidak ada artikel yang cocok.</p>
                    <p class="text-muted">Coba gunakan kata kunci lain atau kembali ke halaman utama.</p>
                    <a href="{{ route('articles.index') }}" class="btn btn-danger mt-3">Kembali ke halaman utama</a>
                </div>
            @endif
        </main>

        @include('user.partials._sidebar')

    </div>
</div>
@endsection
