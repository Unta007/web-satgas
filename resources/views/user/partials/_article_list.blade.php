@foreach ($latestArticles as $article)
    <a href="{{ route('articles.show', $article->slug) }}" class="news-list-item">
        <img src="{{ $article->image ? (Str::startsWith($article->image, 'http') ? $article->image : asset('storage/' . $article->image)) : 'https://placehold.co/150x100/e0e0e0/555?text=Image' }}"
            alt="{{ $article->title }}" class="news-list-item-image" />

        <div class="news-list-item-content">
            <h3>{{ $article->title }}</h3>

            <div class="card-meta">
                <small>{{ $article->published_at->diffForHumans() }}</small>
                <span class="meta-separator">|</span>
                <small>{{ $article->author }}</small>
                <span class="meta-separator">|</span>
                <small><i class="bi bi-clock me-1"></i>{{ $article->reading_time }}</small>
            </div>

            <div class="news-list-item-description">
                <p>{{ \Illuminate\Support\Str::limit(strip_tags($article->description), 375) }}</p>
            </div>
        </div>
    </a>
@endforeach
