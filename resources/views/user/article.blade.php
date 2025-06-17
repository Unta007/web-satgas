@extends('layout.app')

@section('title', $article->title)

@section('content')
    @php
        $breadcrumbs = [
            ['name' => 'Beranda', 'url' => route('home')],
            ['name' => 'Pusat Pengetahuan', 'url' => route('articles.index')],
            ['name' => Str::limit($article->title, 40)],
        ];
    @endphp
    <x-hero title="Pusat Pengetahuan" subtitle="Jelajahi berbagai artikel, panduan, dan sumber daya untuk meningkatkan kesadaran dan pemahaman Anda." :breadcrumbs="$breadcrumbs" />

    <div class="educational-container">
        <div class="article-layout-grid">

            <main class="article-detail-content">
                <header class="article-header">
                    <h1>{{ $article->title }}</h1>
                    <div class="article-meta-info">
                        <span>{{ $article->author }}</span>
                        <span class="meta-separator">|</span>
                        <span>{{ $article->published_at->format('d F Y') }}</span>
                        <span class="meta-separator">|</span>
                        <span><i class="bi bi-clock me-1"></i>{{ $article->getReadingTimeAttribute() }}</span>
                    </div>
                </header>

                @if ($article->image)
                    <figure class="article-image-container">
                        <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : asset('storage/' . $article->image) }}"
                            alt="{{ $article->title }}" class="article-image">
                    </figure>
                @endif

                <div class="article-body">
                    {!! $article->description !!}
                </div>
            </main>


            @include('user.partials._sidebar')

        </div>
    </div>
@endsection
