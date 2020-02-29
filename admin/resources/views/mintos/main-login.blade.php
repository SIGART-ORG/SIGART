<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Login - {{ env( 'NAME_PROJECT' ) }}</title>
    <meta name="description" content="A responsive bootstrap 4 admin dashboard template by hencework" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::asset( 'images/favicon.ico' ) }}">
    <link rel="icon" href="{{ URL::asset( 'images/favicon.ico' ) }}" type="image/x-icon">

    <!-- Custom CSS -->
    <link href="{{ asset( 'assets/dist/css/style.css' ) }}" rel="stylesheet" type="text/css">
</head>

<body>
<!-- Preloader -->
<div class="preloader-it">
    <div class="loader-pendulums"></div>
</div>
<!-- /Preloader -->

<!-- HK Wrapper -->
<div class="hk-wrapper">

    <!-- Main Content -->
    <div class="hk-pg-wrapper hk-auth-wrapper">
        <header class="d-flex justify-content-between align-items-center">
            <a class="d-flex auth-brand" href="#">
                <img class="brand-img" src="{{ asset( 'images/logo-dark.png' ) }}" alt="brand" />
            </a>
            <div class="btn-group btn-group-sm">
                <a href="#" class="btn btn-outline-secondary">Ayuda</a>
                <a href="#" class="btn btn-outline-info">Sobre nosotros</a>
            </div>
        </header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5 pa-0">
                    <div id="owl_demo_1" class="owl-carousel dots-on-item owl-theme">
                        <div class="fadeOut item auth-cover-img overlay-wrap" style="background-image:url( {{ asset( 'images/login-carpinteria.jpg') }} );">
                            <div class="auth-cover-info py-xl-0 pt-100 pb-50">
                                <div class="auth-cover-content text-center w-xxl-75 w-sm-90 w-xs-100">
                                    <h1 class="display-3 text-white mb-20">Experiencia y calidad.</h1>
                                    <p class="text-white">La experiancia es importante para realizar trabajos de calidad.</p>
                                </div>
                            </div>
                            <div class="bg-overlay bg-trans-dark-50"></div>
                        </div>
                        <div class="fadeOut item auth-cover-img overlay-wrap" style="background-image:url( {{ asset( 'images/login-carpinteria-second.jpg' ) }} );">
                            <div class="auth-cover-info py-xl-0 pt-100 pb-50">
                                <div class="auth-cover-content text-center w-xxl-75 w-sm-90 w-xs-100">
                                    <h1 class="display-3 text-white mb-20">Trabajos de calidad</h1>
                                    <p class="text-white">El secreto de la alegría en el trabajo está contenida en una palabra: excelencia. Saber cómo hacer algo así es disfrutarlo.</p>
                                </div>
                            </div>
                            <div class="bg-overlay bg-trans-dark-50"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 pa-0">
                    <div class="auth-form-wrap py-xl-0 py-50">
                        <div class="auth-form w-xxl-55 w-xl-75 w-sm-90 w-xs-100">
                            <form class="login-form" action="{{ route('login') }}" method="post">
                                {{ csrf_field() }}
                                <h1 class="display-4 mb-10">Bienvenido&nbsp;&nbsp;:)</h1>
                                <p class="mb-30">Inicia sesión en tu cuenta y disfruta de esta experiencia maravillosa con <b>SIGART</b>.</p>
                                <div class="form-group">
                                    <input class="form-control" type="email" name="email" id="email" placeholder="Email" autofocus value="{{ old( 'email' ) }}">
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" type="password" name="password" id="password" placeholder="Contraseña">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><span class="feather-icon"><i data-feather="eye-off"></i></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="custom-control custom-checkbox mb-25">
                                    <input class="custom-control-input" id="same-address" type="checkbox" checked>
                                    <label class="custom-control-label font-14" for="same-address">Recordarme</label>
                                </div>
                                <button class="btn btn-primary btn-block" type="submit">Inicia Sesión</button>
                                <div class="option-sep"></div>
                                <p class="text-center">¿Olvidaste tu contraseña? <a href="#">Recuperala aquí</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Content -->

</div>
<!-- /HK Wrapper -->

<!-- jQuery -->
<script src="{{ asset( 'assets/vendors/jquery/dist/jquery.min.js' ) }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset( 'assets/vendors/popper.js/dist/umd/popper.min.js' ) }}"></script>
<script src="{{ asset( 'assets/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Slimscroll JavaScript -->
<script src="{{ asset( 'assets/dist/js/jquery.slimscroll.js' ) }}"></script>

<!-- Fancy Dropdown JS -->
<script src="{{ asset( 'assets/dist/js/dropdown-bootstrap-extended.js' ) }}"></script>

<!-- Owl JavaScript -->
<script src="{{ asset( 'assets/vendors/owl.carousel/dist/owl.carousel.min.js' ) }}"></script>

<!-- FeatherIcons JavaScript -->
<script src="{{ asset( 'assets/dist/js/feather.min.js' ) }}"></script>

<!-- Init JavaScript -->
<script src="{{ asset( 'assets/dist/js/init.js' ) }}"></script>
<script src="{{ asset( 'assets/dist/js/login-data.js') }}"></script>
</body>

</html>
