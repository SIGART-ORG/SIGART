<!DOCTYPE html>
<html lang="{{ str_replace( '_', '-', app()->getLocale() ) }}" class="fixed">
<head>
    <title>Login - {{ env( 'NAME_PROJECT' ) }}</title>
    @include('inc.meta')
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ mix( 'css/main.min.css' ) }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        <h1>{{ env( 'NAME_COMMERCIAL_PROJECT' ) }}</h1>
    </div>
    <div class="login-box">
        <form class="login-form" action="{{ route('login') }}" method="post">
            {{ csrf_field() }}
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Ingreso al Sistema</h3>
            <div class="form-group">
                <label class="control-label">Correo</label>
                <input class="form-control" name="email" id="email" type="email" placeholder="Email" autofocus value="{{ old( 'email' ) }}">
            </div>
            <div class="form-group">
                <label class="control-label">Contraseña</label>
                <input name="password" id="password" class="form-control" type="password" placeholder="Contraseña">
            </div>
            <div class="form-group">
                <div class="utility">
                    <div class="animated-checkbox">
                        <label>
                            <input type="checkbox"><span class="label-text">Manténgase conectado</span>
                        </label>
                    </div>
                    <p class="semibold-text mb-2"><a href="#" data-toggle="flip">¿Olvidó su contraseña?</a></p>
                </div>
            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Iniciar Sesión</button>
            </div>
        </form>
    </div>
</section>
<!-- Essential javascripts for application to work-->
<script src="{{ mix( 'js/jquery-3.2.1.min.js' ) }}"></script>
<script src="{{ mix( 'js/popper.min.js' ) }}"></script>
<script src="{{ mix( 'js/bootstrap.min.js' ) }}"></script>
<script src="{{ mix( 'js/main.min.js' ) }}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{{ mix( 'js/plugins/pace.min.js' ) }}"></script>
<script type="text/javascript">
    // Login Page Flipbox control
    $('.login-content [data-toggle="flip"]').click(function() {
        $('.login-box').toggleClass('flipped');
        return false;
    });
</script>
</body>
</html>
