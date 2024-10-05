<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Paquetería</title>
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
    @if(count($anuncios) > 0)
    <!-- Tu modal -->
    <div class="modal" tabindex="-1" id="miModal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Anuncios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach ($anuncios as $anuncio)
                    <div class="card mb-3" >
                        <div class="row g-0">
                          <div class="col-md-4">
                            <img src="{{ asset('uploads/'.$anuncio->file_path.'/'.$anuncio->imagen_anuncio) }}" class="img-fluid  w-100 rounded-start" alt="...">
                          </div>
                          <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{$anuncio->titulo}}</h5>
                                @if ($anuncio->sucursal_id != null)
                                <button type="button" class="btn btn-info  btn-sm">Valido para la suscursal <strong>{{$anuncio->suc->depart->name}} / {{$anuncio->suc->provin->name}} / {{$anuncio->suc->sucursal}}</strong></button>
                                @endif
                                <p class="card-text">{!! htmlspecialchars_decode($anuncio->texto)!!}</p>
                                <hr>
                                <p class="card-text"><small class="text-body-secondary">{{$anuncio->created_at}}</small></p>
                            </div>
                          </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Espera a que el documento esté completamente cargado
        document.addEventListener("DOMContentLoaded", function() {
          // Muestra el modal automáticamente si hay anuncios
          var myModal = new bootstrap.Modal(document.getElementById('miModal'));
          myModal.show();
        });
    </script>
    @endif
    <!-- Navbar Start -->
    <div class="container-fluid sticky-top">
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
                        <a href="{{ url( '/' )}} " class="nav-item nav-link active">Inicio</a>
                        <a href="{{ url( '/consulta' )}} " class="nav-item nav-link">Mi envio</a>
                        <a href="{{ url( '/reclamo' )}} " class="nav-item nav-link">Reclamo</a>
						@if (Auth::guest())
							<a href="{{ url("/login")}}" class="btn btn-dark py-2 px-4 d-none d-lg-inline-block">Comenzar</a>
						@else
							@if(Auth::user()->role == "0"  || Auth::user()->role == "1" )
								<a href="{{ url("/admin")}}" class="btn btn-dark py-2 px-4 d-none d-lg-inline-block">Panael Administrativo</a>
							@else
								<a href="{{ url("/")}}" class="btn btn-dark py-2 px-4 d-none d-lg-inline-block">Panel Administrativo</a>
							@endif
								<a href="{{ url("/logout")}}" class="btn btn-dark py-2 px-4 d-none d-lg-inline-block">Cerrar</a>
						@endif			
                       
                    </div>
                   
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
    <!-- Hero Start -->
    <div class="container-fluid hero-header mb-5" style="background: teal">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h3 class="fw-light text-white animated slideInRight">Seguridad & Confianza</h3>
                    <h1 class="display-4 text-white animated slideInRight">Somos <span class="fw-light text-white">UMG</span> Servicios de Paquetería</h1>
                    <p class="text-white mb-4 animated slideInRight">Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit. Etiam feugiat rutrum lectus, sed auctor ex malesuada id. Orci varius natoque penatibus et
                        magnis dis parturient montes.</p>
                    <a href="" class="btn btn-dark py-2 px-4 me-3 animated slideInRight">Segumiento de mi envio</a>
                    <a href="#" class="btn btn-outline-dark py-2 px-4 animated slideInRight">Contato</a>
                </div>
                <div class="col-lg-6"> 
                    <img class="img-fluid animated pulse infinite" src="{{ asset('../assets/css/images/login.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Feature Start -->
    <!-- <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="feature-item position-relative text-center p-3" style="background: brown">
                        <div class="border py-5 px-3">
                            <i class="fa fa-leaf fa-3x text-dark mb-4"></i>
                            <h5 class="text-white mb-0">100% Natural</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="feature-item position-relative text-center p-3" style="background: brown">
                        <div class="border py-5 px-3">
                            <i class="fa fa-tint-slash fa-3x text-dark mb-4"></i>
                            <h5 class="text-white mb-0">Anti Hair Fall</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="feature-item position-relative text-center p-3" style="background: brown">
                        <div class="border py-5 px-3">
                            <i class="fa fa-times fa-3x text-dark mb-4"></i>
                            <h5 class="text-white mb-0">Hypoallergenic</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Feature End -->

    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
					<img class="img-fluid animated pulse infinite" src="{{ asset('../assets/css/images/registro.png') }}" alt="">
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="mb-4" style="color: brown">Vehiculos <span class="fw-light text-dark">De primera categoria</span></h1>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet, erat non malesuada consequat, nibh erat tempus risus, vitae porttitor purus nisl vitae purus. Praesent tristique odio ut rutrum pellentesque. Fusce eget molestie est, at rutrum est.</p>
                    <p class="mb-4">Aliqu diam amet diam et eos labore. Clita erat ipsum et lorem et sit, sed stet no
                        labore lorem sit. Sanctus clita duo justo et tempor.</p>
                    <a class="btn py-2 px-4" href="" style="background: brown;color: rgb(253, 253, 253)">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
    <!-- SUCURSALES -->
    <div class="container-fluid deal my-5 py-5" style="background: teal">
        <h2 style="color: white">SUCURSALES</h2>
        <hr>
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                @foreach ($sucursales as $sucursal)
                <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                    <div class="container py-5">
                        <div class="row g-5 align-items-center">
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                                <img class="img-fluid animated pulse infinite" src="{{ asset('uploads/'.$sucursal->file_path.'/'.$sucursal->imagen_tienda) }}">
                            </div>
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="text-center p-4">
                                    <div class="p-4 bg-white" style="border-radius: 23px">
                                        <h5>{{ $sucursal->depart->name }} - {{ $sucursal->provin->name }} - {{ $sucursal->sucursal }}</h5>
                                        <h6 class=" text-primary mb-4">{{ $sucursal->hora_apertura }} - {{ $sucursal->hora_cierre }}</h6>
                                        <a class="btn btn-success btn-sm" target="_blank" href="https://wa.me/+51{{$sucursal->telefono}}?text=Información">
                                            <i class="fab fa-whatsapp"></i> Contactanos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Deal End -->

    <!-- Feature Start -->
  
    <!-- Feature End -->
    <!-- How To Use End -->
    <!-- Footer Start -->
    <div class="container-fluid bg-white footer">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                    <a href="index.html" class="d-inline-block mb-3">
                        <h1 class="text-primary">Sistema de paquetería UMG</h1>
                    </a>
                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet, erat non malesuada consequat, nibh erat tempus risus, vitae porttitor purus nisl vitae purus.</p>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                    <h5 class="mb-4">Get In Touch</h5>
                    <p><i class="fa fa-map-marker-alt me-3"></i>Santa Cruz del Quiché</p>
                    <p><i class="fa fa-phone-alt me-3"></i>+(502)0000 0000</p>
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
    <a href="#" class="btn btn-lg btn-danger btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
   <!-- Scripts -->
   <script src="{{ asset('principal/js/main.js') }}"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>