<!DOCTYPE html>
<html lang="{{ str_replace( '_', '-', app()->getLocale() ) }}" class="fixed">
<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::asset( 'images/favicon.ico' ) }}">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset( 'css/main.min.css' ) }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login - {{ env( 'NAME_PROJECT' ) }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="{{ env( 'META_DESCRIPTION' ) }}">
    <meta name="Keywords" content="pintart, acceso al sistema, sistema de gestion de calidad, d pintart, d' pintart, sistema integrado de gestion, control de acceso" />
    <link rel=”canonical” href=”{{ env( 'APP_URL' ) }}” />

    <!-- MArcado Schema.org para Google+ -->
    <meta itemprop="name" content="Login - {{ env( 'NAME_PROJECT' ) }}">
    <meta itemprop="description" content="{{ env( 'META_DESCRIPTION' ) }}">
    <meta itemprop="image" content="{{ URL::asset( 'images/logo.png' ) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@JulioSalsavilca">
    <meta name="twitter:title" content="Login - {{ env( 'NAME_PROJECT' ) }}">
    <meta name="twitter:description" content="{{ env( 'META_DESCRIPTION' ) }}">
    <meta name="twitter:creator" content="@JulioSalsavilca">
    <meta name="twitter:image" content="{{ URL::asset( 'images/logo.png' ) }}">
    <meta name="twitter:url" content="{{ env( 'APP_URL' ) }}" />

    <!-- Open Graph data -->
    <meta property="og:title" content="Login - {{ env( 'NAME_PROJECT' ) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ env( 'APP_URL' ) }}" />
    <meta property="og:image" content="{{ URL::asset( 'images/logo.png' ) }}" />
    <meta property="og:description" content="{{ env( 'META_DESCRIPTION' ) }}" />
    <meta property="og:site_name" content="{{ env( 'NAME_PROJECT' ) }}" />
    <meta property="og:locale" content="es_LA" />
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Corporation",
      "name": "{{ env( 'NAME_PROJECT' ) }}",
      "alternateName": "Login - {{ env( 'NAME_PROJECT' ) }}",
      "url": "{{ env( 'APP_URL' ) }}",
      "logo": "{{ URL::asset( 'images/logo.png' ) }}",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+51 927-315-556",
        "contactType": "customer service",
        "contactOption": "TollFree",
        "areaServed": "PE",
        "availableLanguage": "Spanish"
      },
      "sameAs": "https://www.facebook.com/dpintart/"
    }
    </script>
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
<script src="{{ URL::asset( 'js/jquery-3.2.1.min.js' ) }}"></script>
<script src="{{ URL::asset( 'js/popper.min.js' ) }}"></script>
<script src="{{ URL::asset( 'js/bootstrap.min.js' ) }}"></script>
<script src="{{ URL::asset( 'js/main.min.js' ) }}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{{ URL::asset( 'js/plugins/pace.min.js' ) }}"></script>
<script type="text/javascript">
    // Login Page Flipbox control
    $('.login-content [data-toggle="flip"]').click(function() {
        $('.login-box').toggleClass('flipped');
        return false;
    });
</script>
</body>
</html>
