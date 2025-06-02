@extends('layout.app')

@section('title', $article['title'])

@section('content')
    <div class="article-container">
        <nav class="breadcrumb">
            <a href="{{ url('/') }}">Home</a> &raquo;
            <a href="{{ url('/educational-contents') }}">Educational Contents</a> &raquo;
            <span>{{ $article['title'] }}</span>
        </nav>

        <header class="article-header">
            <h1>{{ $article['title'] }}</h1>
            <small>Published on {{ $article['published_date'] }}</small>
        </header>

        <div class="article-image">
            <img src="{{ Vite::asset('resources/images/' . $article['image']) }}" alt="{{ $article['title'] }}" />
        </div>

        <div class="article-content">
            @if(is_array($article['content']))
                @foreach($article['content'] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            @else
                <p>{{ $article['content'] }}</p>
            @endif
        </div>
    </div>
@endsection
