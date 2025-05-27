@extends('layout.app')

@section('title', 'Educational Contents on Sexual Harassment')

@section('content')
    <div class="magazine-container">
        <header class="magazine-header">
            <h1>Educational Contents</h1>
            <p>Explore our collection of educational articles and resources focused on sexual harassment awareness, prevention, and support.</p>
        </header>

        <section class="featured-article">
            <a href="{{ route('article.show', ['slug' => 'understanding-sexual-harassment']) }}" class="featured-article-link">
                <img src="{{ Vite::asset('resources/images/carousel-1.jpg') }}" alt="Featured Article Image" />
                <div class="featured-article-content">
                    <h2>Featured: Understanding Sexual Harassment</h2>
                    <p>An in-depth look at what constitutes sexual harassment, its impact, and how to recognize it in various environments.</p>
                    <small>Published on April 27, 2024</small>
                </div>
            </a>
        </section>

        <section class="magazine-articles">
            <a href="{{ route('article.show', ['slug' => 'recognizing-signs']) }}" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/carousel-2.jpg') }}" alt="Article 1 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>Recognizing Signs of Sexual Harassment</h3>
                    <p>Learn to identify the common signs and behaviors that indicate sexual harassment in the workplace and beyond.</p>
                    <small>Published on April 20, 2024</small>
                </div>
            </a>
            <a href="{{ route('article.show', ['slug' => 'how-to-prevent']) }}" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/carousel-3.jpg') }}" alt="Article 2 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>How to Prevent Sexual Harassment</h3>
                    <p>Effective strategies and policies to create safe environments and prevent sexual harassment.</p>
                    <small>Published on April 22, 2024</small>
                </div>
            </a>
            <a href="{{ route('article.show', ['slug' => 'support-resources']) }}" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/carousel-1.jpg') }}" alt="Article 3 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>Support Resources for Victims</h3>
                    <p>Information on where and how victims of sexual harassment can find help and support.</p>
                    <small>Published on April 24, 2024</small>
                </div>
            </a>
            <a href="{{ route('article.show', ['slug' => 'legal-rights']) }}" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/carousel-3.jpg') }}" alt="Article 4 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>Legal Rights and Reporting Procedures</h3>
                    <p>Understand your legal rights and the proper steps to report sexual harassment incidents.</p>
                    <small>Published on April 25, 2024</small>
                </div>
            </a>
            <a href="{{ route('article.show', ['slug' => 'workplace-culture']) }}" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/carousel-2.jpg') }}" alt="Article 5 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>Building a Respectful Workplace Culture</h3>
                    <p>Strategies to foster respect and inclusivity to prevent harassment in the workplace.</p>
                    <small>Published on April 26, 2024</small>
                </div>
            </a>
            <a href="{{ route('article.show', ['slug' => 'reporting-channels']) }}" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/carousel-3.jpg') }}" alt="Article 6 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>Effective Reporting Channels</h3>
                    <p>How to use official channels to report incidents safely and confidentially.</p>
                    <small>Published on April 27, 2024</small>
                </div>
            </a>
            <a href="{{ route('article.show', ['slug' => 'emotional-impact']) }}" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/carousel-1.jpg') }}" alt="Article 7 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>The Emotional Impact of Harassment</h3>
                    <p>Understanding the psychological effects and how to support victims.</p>
                    <small>Published on April 28, 2024</small>
                </div>
            </a>
            <a href="{{ route('article.show', ['slug' => 'bystander-intervention']) }}" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/carousel-2.jpg') }}" alt="Article 8 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>Bystander Intervention Techniques</h3>
                    <p>How to safely intervene and prevent harassment in various situations.</p>
                    <small>Published on April 29, 2024</small>
                </div>
            </a>
            <a href="{{ route('article.show', ['slug' => 'policy-development']) }}" class="magazine-article-card">
                <img src="{{ Vite::asset('resources/images/carousel-3.jpg') }}" alt="Article 9 Image" class="magazine-article-image" />
                <div class="magazine-article-content">
                    <h3>Developing Effective Anti-Harassment Policies</h3>
                    <p>Guidelines for creating and implementing workplace policies.</p>
                    <small>Published on April 30, 2024</small>
                </div>
            </a>
        </section>
    </div>
@endsection
