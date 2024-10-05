<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sistema de Paquetería UMG</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Poppins:wght@200;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
	<link rel="stylesheet" href="{{ asset('principal/css/bootstrap.min.css') }}" />
    <!-- Template Stylesheet -->
    <link href="{{ asset('principal/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid sticky-top " style="background: teal">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light p-0">
                <a href="#" class="navbar-brand">
                    <h2 class="text-white">Sistema de Paquetería UMG</h2>
                </a>
                <button type="button" class="navbar-toggler ms-auto me-0" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="{{ url("/")}}" class="nav-item nav-link active">Inicio</a>
                        <a href="{{ url("/consulta")}}" class="nav-item nav-link">Mi envio</a>
                        <!-- <a href="{{ url("/reclamo")}}" class="nav-item nav-link">Reclamo</a> -->
						@if (Auth::guest())
							<a href="{{ url("/login")}}" class="btn btn-dark py-2 px-4 d-none d-lg-inline-block">Comenzar</a>
						@else
							@if(Auth::user()->role == "0")
								<a href="{{ url("/admin")}}" class="btn btn-dark py-2 px-4 d-none d-lg-inline-block">Panael Administrativo</a>
							@else
								<a href="{{ url("/")}}" class="btn btn-dark py-2 px-4 d-none d-lg-inline-block">Panael Administrativo</a>
							@endif
								<a href="{{ url("/logout")}}" class="btn btn-dark py-2 px-4 d-none d-lg-inline-block">Cerrar</a>
						@endif			
                       
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Newsletter Start -->
    <div class="container-fluid newsletter " style="background: teal">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="text-white mb-3"><span class="fw-light text-dark">Consulta el estado del </span> Envio</h1>
                <p class="text-white mb-4">Ingresa el codigo del envio</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7 wow fadeIn" data-wow-delay="0.5s">
                    <div class="position-relative w-100 mt-3 mb-2">
                        <form method ="GET">
                            <input class="form-control w-100 py-4 ps-4 pe-5" name="name" type="text" placeholder="Ejemplo:qrajOSqYAB" style="height: 48px;">
                            <button type="submit" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2">
                                <i class="fa fa-paper-plane text-white fs-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @if(count((is_countable($auditoria)?$auditoria:[])))
                @foreach($auditoria as $item)
                    <div class="card">
                        <div class="card-body">
                            <h4>{!! \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') !!} </h4>
                            @foreach ($item->accion as $documen)
                                <h5 class="card-title">Acción: {{ $documen['accion'] }}</h5>
                                <p class="card-text">Estado: {{ $documen['Estado'] }}</p>
                                <p class="card-text">Nombre: {{ $documen['name'] }}</p>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <!-- Newsletter End -->
    <!-- Footer Start -->
    <div class="container-fluid bg-white footer">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                    <a href="index.html" class="d-inline-block mb-3">
                        <h1 class="text-primary">Hairnic</h1>
                    </a>
                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet, erat non malesuada consequat, nibh erat tempus risus, vitae porttitor purus nisl vitae purus.</p>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                    <h5 class="mb-4">Get In Touch</h5>
                    <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-primary me-1" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-primary me-1" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-primary me-1" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-outline-primary me-1" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">
                    <h5 class="mb-4">Our Products</h5>
                    <a class="btn btn-link" href="">Hair Shining Shampoo</a>
                    <a class="btn btn-link" href="">Anti-dandruff Shampoo</a>
                    <a class="btn btn-link" href="">Anti Hair Fall Shampoo</a>
                    <a class="btn btn-link" href="">Hair Growing Shampoo</a>
                    <a class="btn btn-link" href="">Anti smell Shampoo</a>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.7s">
                    <h5 class="mb-4">Popular Link</h5>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Privacy Policy</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Career</a>
                </div>
            </div>
        </div>
        <div class="container wow fadeIn" data-wow-delay="0.1s">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed by <a href="https://themewagon.com">ThemeWagon</a>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="">Home</a>
                            <a href="">Cookies</a>
                            <a href="">Help</a>
                            <a href="">FAQs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
   <!-- Scripts -->
   <script src="{{ asset('principal/js/main.js') }}"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>