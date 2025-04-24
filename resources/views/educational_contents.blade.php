@extends('layout.app')

@section('title', 'Educational Contents on Sexual Harassment')

@section('content')
    <div class="magazine-container">
        <header class="magazine-header">
            <h1>Educational Contents</h1>
            <p>Explore our collection of educational articles and resources focused on sexual harassment awareness, prevention, and support.</p>
        </header>

        <section class="featured-article">
            <a href="#" class="featured-article-link">
                <img src="{{ Vite::asset('resources/images/sexual_harassment_awareness.jpg') }}" alt="Featured Article Image" />
                <div class="featured-article-content">
                    <h2>Featured: Understanding Sexual Harassment</h2>
                    <p>An in-depth look at what constitutes sexual harassment, its impact, and how to recognize it in various environments.</p>
                    <small>Published on April 27, 2024</small>
                </div>
            </a>
        </section>

        <section class="magazine-articles">
            <a href="#" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/recognizing_signs.jpg') }}" alt="Article 1 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>Recognizing Signs of Sexual Harassment</h3>
                    <p>Learn to identify the common signs and behaviors that indicate sexual harassment in the workplace and beyond.</p>
                    <small>Published on April 20, 2024</small>
                </div>
            </a>
            <a href="#" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/prevention.jpg') }}" alt="Article 2 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>How to Prevent Sexual Harassment</h3>
                    <p>Effective strategies and policies to create safe environments and prevent sexual harassment.</p>
                    <small>Published on April 22, 2024</small>
                </div>
            </a>
            <a href="#" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/support_resources.jpg') }}" alt="Article 3 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>Support Resources for Victims</h3>
                    <p>Information on where and how victims of sexual harassment can find help and support.</p>
                    <small>Published on April 24, 2024</small>
                </div>
            </a>
            <a href="#" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/legal_rights.jpg') }}" alt="Article 4 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>Legal Rights and Reporting Procedures</h3>
                    <p>Understand your legal rights and the proper steps to report sexual harassment incidents.</p>
                    <small>Published on April 25, 2024</small>
                </div>
            </a>
        </section>
    </div>
@endsection
