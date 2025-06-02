@extends('layout.app')

@section('title', 'Home')


@section('content')
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            {{-- Slide 1 (Contoh, sesuaikan dengan gambar dan teks Anda) --}}
            <div class="carousel-item active first"
                style="background-image: url('{{ Vite::asset('resources/images/kampus.jpg') }}');">
                <div class="carousel-caption d-none d-md-block text-start">
                    {{-- text-start untuk rata kiri, sesuaikan jika perlu --}}
                    <div class="container">
                        <h1 class="display-4 fw-bold">Selamat Datang di Laman Satgas PPKS Kampus Surabaya</h1>
                        <p class="lead col-lg-8">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vulputate ut
                            laoreet velit ma.</p>
                        <p><a class="btn btn-lg btn-danger mt-3" href="#">Pelajari Lebih Lanjut</a></p>
                    </div>
                </div>
            </div>

            <div class="carousel-item"
                style="background-image: url('{{ Vite::asset('resources/images/environment.jpg') }}');">
                <div class="carousel-caption d-none d-md-block text-start">
                    <div class="container">
                        <h1 class="display-4 fw-bold">Judul Slide Kedua</h1>
                        <p class="lead col-lg-8">Deskripsi singkat untuk slide kedua.</p>
                    </div>
                </div>
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div>

    
    <div class="container-lg my-5 fade-in-section welcome-greetings">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="{{ Vite::asset('resources/images/avatar.jpg') }}" alt="Section Image" class="img-fluid" />
            </div>
            <div class="col-md-6">
                <h2>Welcome from the Head of the Sexual Prevention Task Force</h2>
                <p>We are committed to creating a safe and supportive environment for everyone. Our task force works
                    tirelessly to raise awareness, provide education, and support victims of sexual harassment.</p>
                <p>Together, we can make a difference and foster a culture of respect and dignity.</p>
            </div>
        </div>
    </div>

    {{-- A reminder about sexual harassment report, with logo, paragraph, and button to form report --}}
    <div class="container-lg my-5 fade-in-section">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="{{ Vite::asset('resources/images/hand.jpg') }}" alt="Section Image" class="img-fluid" />
            </div>
            <div class="col-md-6">
                <h2>Report Sexual Harassment Confidentially</h2>
                <p>If you or someone you know has experienced sexual harassment, please do not hesitate to report it. Your
                    safety and privacy are our top priorities.</p>
                <p>Use the form below to submit your report confidentially and securely.</p>
                <a href="#" class="btn btn-danger btn-animated">Go to Report Form</a>
            </div>
        </div>
    </div>

    <div id="main-container" class="container-lg fade-in-section">

        <h3 id="educational-header">Most Popular</h3>
        <p id="educational-subheader">Explore our collection of educational articles and resources</p>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="{{ Vite::asset('resources/images/tel-u.png') }}" class="card-img-top" alt="Tel-U logo">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Understanding Sexual Harassment</h5>
                        <p class="card-text flex-grow-1">Learn about what constitutes sexual harassment and how to recognize
                            it in various environments.</p>
                        <a href="#" class="btn btn-primary mt-auto align-self-start">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="{{ Vite::asset('resources/images/hand.jpg') }}" class="card-img-top" alt="Helping hand">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Support Resources</h5>
                        <p class="card-text flex-grow-1">Find out about the support services available for victims and how
                            to access them confidentially.</p>
                        <a href="#" class="btn btn-primary mt-auto align-self-start">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="{{ Vite::asset('resources/images/avatar.jpg') }}" class="card-img-top" alt="Avatar">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Prevention Strategies</h5>
                        <p class="card-text flex-grow-1">Explore effective strategies and best practices to prevent sexual
                            harassment in your community.</p>
                        <a href="#" class="btn btn-primary mt-auto align-self-start">Discover</a>
                    </div>
                </div>
            </div>
        </div>

        <h3 id="testi-header">Testimonials</h3>
        <p id="testi-subheader">What they say about our services</p>

        <div id="testimonialSlider" class="slider-container">
            <div class="slider-wrapper">
                <div class="slide active">
                    <div class="card h-100 mx-auto" style="max-width: 600px;">
                        <div class="card-body">
                            <p class="card-text fst-italic">"I felt safe and heard thanks to the dedicated team. Highly
                                recommend their services."</p>
                        </div>
                    </div>
                </div>
                <div class="slide">
                    <div class="card h-100 mx-auto" style="max-width: 600px;">
                        <div class="card-body">
                            <p class="card-text fst-italic">"Professional, compassionate, and effective. A truly valuable
                                resource for anyone in need."</p>
                        </div>
                    </div>
                </div>
                <div class="slide">
                    <div class="card h-100 mx-auto" style="max-width: 600px;">
                        <div class="card-body">
                            <p class="card-text fst-italic">"This service has been a lifesaver. The support and resources
                                provided are exceptional."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <button id="backToTopBtn" title="Back to Top" aria-label="Back to Top">&#8679;</button>

@endsection
