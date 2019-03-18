<!DOCTYPE html>
<html lang="{{ str_replace( '_', '-', app()->getLocale() ) }}" class="fixed">
    @include( 'inc.head' )
<body class="app sidebar-mini rtl">
<!-- Navbar-->
@include('inc.header')
<!-- start: sidebar -->
@include('inc.sidebar')
<!-- end: sidebar -->
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            <p>Bienvenido</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
    </div>
    <div id="app">
        @yield('contenido')
    </div>
</main>
@include('inc.footer')
</body>
</html>
