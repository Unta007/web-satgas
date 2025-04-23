<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    @vite('resources/sass/app.scss')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/welcome.css') }}">
</head>

<body>

    <nav id="navbar-home" class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ Vite::asset('resources/images/tel-u_putih.png') }}" alt="Bootstrap" width="140"
                    height="56">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" aria-current="page" href="#">Home</a>
                    <a class="nav-link" href="#">Educational Contents</a>
                    <a class="nav-link" href="#">Form Report</a>
                    <a class="nav-link" href="#">About Us</a>
                </div>
            </div>
        </div>
    </nav>

    <div id="carousel-home" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ Vite::asset('resources/images/tel-u.png') }}" class="d-block w-100" alt="Database image">
            </div>
            <div class="carousel-item">
                <img src="{{ Vite::asset('resources/images/ls.png') }}" class="d-block w-100" alt="LS image">
            </div>
            <div class="carousel-item">
                <img src="{{ Vite::asset('resources/images/maya.png') }}" class="d-block w-100" alt="Maya image">
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

    <div id="main-container" class="container-lg">

        <h3 id="educational-header">Most Popular</h3>
        <p id="educational-subheader">Our Educational Contents</p>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100">
                    <img src="{{ Vite::asset('resources/images/tel-u.png') }}" class="card-img-top" alt="Tel-U logo">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet
                            dolor libero. Etiam sem sem, porta nec vulputate id, mollis pharetra leo.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="{{ Vite::asset('resources/images/tel-u.png') }}" class="card-img-top" alt="Kuching image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet
                            dolor libero. Etiam sem sem, porta nec vulputate id, mollis pharetra leo.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="{{ Vite::asset('resources/images/tel-u.png') }}" class="card-img-top" alt="Tel-U logo">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet
                            dolor libero. Etiam sem sem, porta nec vulputate id, mollis pharetra leo.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>

        <h3 id="testi-header">Testimonials</h3>
        <p id="testi-subheader">What They Says About Our Services</p>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100">
                    <img src="{{ Vite::asset('resources/images/tel-u.png') }}" class="card-img-top" alt="Tel-U logo">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet
                            dolor libero. Etiam sem sem, porta nec vulputate id, mollis pharetra leo.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="{{ Vite::asset('resources/images/tel-u.png') }}" class="card-img-top" alt="Tel-U logo">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet
                            dolor libero. Etiam sem sem, porta nec vulputate id, mollis pharetra leo.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="{{ Vite::asset('resources/images/tel-u.png') }}" class="card-img-top"
                        alt="Tel-U logo">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet
                            dolor libero. Etiam sem sem, porta nec vulputate id, mollis pharetra leo.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-4">
                    <h5>About Us</h5>
                    <p>Providing quality educational content and services to help you learn and grow.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white text-decoration-none">Home</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Educational Contents</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Form Report</a></li>
                        <li><a href="#" class="text-white text-decoration-none">About Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Follow Us</h5>
                    <a href="https://www.instagram.com/satgasppks.tus/#" class="text-white me-3"><i
                            class="bi bi-instagram"></i> satgasppks.tus</a>
                </div>
            </div>
            <div class="text-center mt-3">
                <small>&copy; 2024 Your Company. All rights reserved.</small>
            </div>
        </div>
    </footer>
    @vite('resources/js/app.js')
</body>

</html>
