<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo e(env('NAME_COMMERCIAL_PROJECT')); ?>">
    <meta name="author" content="Incanatoit.com">
    <meta name="keyword" content="Sistema ventas Laravel Vue Js, Sistema compras Laravel Vue Js">
    <link rel="shortcut icon" href="<?php echo e(URL::asset('vendors/img/favicon.png')); ?>">
    <title><?php echo e(env('NAME_PROJECT')); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="<?php echo e(URL::asset('dist/css/plantilla.css')); ?>" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
        <header class="app-header navbar">
            <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
            <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
            <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="nav navbar-nav d-md-down-none">
                <li class="nav-item px-3">
                    <a class="nav-link" href="#">Escritorio</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="#">Configuraciones</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item d-md-down-none">
                    <a class="nav-link" href="#" data-toggle="dropdown">
                        <i class="icon-home"></i>
                        <strong class="text-info">Principal</strong>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg">
                        <div class="dropdown-header text-center"><strong>Sedes</strong></div>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-building"></i> <strong class="text-info">Principal</strong>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-building"></i> Ica
                        </a>
                    </div>
                </li>
                <li class="nav-item d-md-down-none">
                    <a class="nav-link" href="#" data-toggle="dropdown">
                        <i class="icon-bell"></i>
                        <span class="badge badge-pill badge-danger">5</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                            <strong>Notificaciones</strong>
                        </div>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope-o"></i> Ingresos
                            <span class="badge badge-success">3</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-tasks"></i> Ventas
                            <span class="badge badge-danger">2</span>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo e(URL::asset('dist/img/avatars/6.jpg')); ?>" class="img-avatar" alt="<?php echo e(Auth::user()->email); ?>">
                        <span class="d-md-down-none"><?php echo e(Auth::user()->name); ?> </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                            <strong>Cuenta</strong>
                        </div>
                        <a class="dropdown-item" href="#" @click="redirect_page('profile')"><i class="fa fa-user"></i> Perfil</a>
                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-lock"></i> Cerrar sesión
                        </a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none">
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </div>
                </li>
            </ul>
        </header>

        <div class="app-body">
            <?php echo $__env->make('inc.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Contenido Principal -->
            <?php echo $__env->yieldContent('contenido'); ?>
            <!-- /Fin del contenido principal -->
        </div>
    </div>
    

    <footer class="app-footer">
        <span><a href="http://www.jjsolutions.com/">J&J Solutions</a> &copy; 2017</span>
        <span class="ml-auto">Desarrollado por <a href="http://www.jjsolutions.com/">J&J Solutions</a></span>
    </footer>
    <script type="application/javascript">
        var URL_PROJECT = '<?php echo e(URL::to('/')); ?>';
    </script>
    <!-- Bootstrap and necessary plugins -->
    <script src="<?php echo e(URL::asset('dist/js/functions.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('dist/js/app.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('dist/js/plantilla.min.js')); ?>"></script>
</body>

</html>