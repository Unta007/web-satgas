<aside class="sidebar-wrapper">
    <div class="sidebar-block">
        <h4>Cari Artikel</h4>
        <form action="{{ route('articles.search') }}" method="GET" class="search-form">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Judul artikel.."
                    value="{{ $searchQuery ?? '' }}">
                <button class="btn btn-custom-search" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="sidebar-block">
        <h4>Konten Lainnya</h4>
        <div class="other-articles-list">
            @if (isset($otherArticles) && $otherArticles->isNotEmpty())
                @foreach ($otherArticles as $article)
                    <div class="article-link-item">
                        <a href="{{ route('articles.show', $article->slug) }}">
                            {{ $article->title }}
                        </a>
                    </div>
                @endforeach
            @else
                <p class="text-muted">Tidak ada artikel lain ditemukan.</p>
            @endif
        </div>
    </div>
</aside>
