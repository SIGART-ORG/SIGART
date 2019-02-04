<!DOCTYPE html>
<html lang="{{ str_replace( '_', '-', app()->getLocale() ) }}">
    @include('inc.head')
    <body class="body-wrapper">
        @include('inc.sidebar')
        @yield('content')
        @include('inc.footer')
    </body>
</html>