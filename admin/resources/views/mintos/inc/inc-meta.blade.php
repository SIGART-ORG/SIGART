    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <meta name="description" content="{{ env( 'META_DESCRIPTION' ) }}">
    <meta name="Keywords" content="pintart, acceso al sistema, sistema de gestion de calidad, d pintart, d' pintart, sistema integrado de gestion, control de acceso" />
    <link rel=”canonical” href=”{{ env( 'APP_URL' ) }}” />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::asset( 'images/favicon.ico' ) }}">

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
