@extends('layout.app')

@section('title', $article->title)

@section('content')
<div class="article-detail-container" style="padding: 40px 15%;">
    <h1>{{ $article->title }}</h1>
    <p class="text-muted">By {{ $article->author }} | Published on {{ $article->published_at->format('F d, Y') }}</p>

    @if($article->image)
        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" style="width: 100%; height: auto; margin-bottom: 20px;">
    @endif

    <div class="article-content">
        {{-- PENTING: Gunakan {!! !!} untuk merender HTML dari rich text editor --}}
        {{-- Pastikan Anda membersihkan input HTML untuk mencegah serangan XSS --}}
        {!! $article->description !!}
    </div>
</div>
@endsection
