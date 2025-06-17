@props([
    'title',
    'subtitle' => '',
    'breadcrumbs' => []
])

<section class="page-hero">
    {{-- Breadcrumbs --}}
    @if (!empty($breadcrumbs))
        <nav class="breadcrumbs-nav" aria-label="breadcrumb">
            <ol class="breadcrumb-list">
                @foreach ($breadcrumbs as $i => $breadcrumb)
                    @if (!$loop->last)
                        <li class="breadcrumb-item">
                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                        </li>
                        <li class="breadcrumb-separator">/</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $breadcrumb['name'] }}
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
    @endif

    {{-- Konten Utama Hero --}}
    <div class="container">
        <h1 class="scroll-animate">{{ $title }}</h1>
        @if ($subtitle)
            <p class="lead scroll-animate" style="transition-delay: 100ms;">
                {{ $subtitle }}
            </p>
        @endif
    </div>
</section>
