@extends('layout.app')

@section('title', 'Home')

@section('content')

    <div class="container-fluid">
        <div id="carousel-home" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel-home" data-bs-slide-to="0" class="active" aria-current="true"
                    aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carousel-home" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carousel-home" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ Vite::asset('resources/images/carousel-1.jpg') }}" class="d-block w-100"
                        alt="Database image">
                </div>
                <div class="carousel-item">
                    <img src="{{ Vite::asset('resources/images/carousel-2.jpg') }}" class="d-block w-100" alt="LS image">
                </div>
                <div class="carousel-item">
                    <img src="{{ Vite::asset('resources/images/carousel-3.jpg') }}" class="d-block w-100" alt="Maya image">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-home" data-bs-slide="prev"
                aria-label="Previous slide">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel-home" data-bs-slide="next"
                aria-label="Next slide">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    {{-- Welcome greetings section by head of the sexual prevention task force --}}
    <div class="container-lg my-5">
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
    <div class="container-lg my-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="{{ Vite::asset('resources/images/hand.jpg') }}" alt="Section Image" class="img-fluid" />
            </div>
            <div class="col-md-6">
                <h2>Report Sexual Harassment Confidentially</h2>
                <p>If you or someone you know has experienced sexual harassment, please do not hesitate to report it. Your
                    safety and privacy are our top priorities.</p>
                <p>Use the form below to submit your report confidentially and securely.</p>
                <a href="#" class="btn btn-danger">Go to Report Form</a>
            </div>
        </div>
    </div>

    <div id="main-container" class="container-lg">

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

@endsection
