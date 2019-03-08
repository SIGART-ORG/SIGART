<!doctype html>
<html lang="{{ str_replace( '_', '-', app()->getLocale() ) }}" class="fixed">
<head>

    <!-- Basic -->
    <meta charset="UTF-8">
    <title>{{ env( 'NAME_PROJECT' ) }}</title>
    <meta name="keywords" content="HTML5 Admin Template" />
    <meta name="description" content="Porto Admin - Responsive HTML5 Template">
    <meta name="author" content="okler.net">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::asset( 'images/favicon.ico' ) }}">

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ URL::asset( 'css/bootstrap/bootstrap.min.css' ) }}" />
    <link rel="stylesheet" href="{{ URL::asset( 'css/font-awesome/style/font-awesome.min.css' ) }}" />
    <link rel="stylesheet" href="{{ URL::asset( 'css/magnific-popup/magnific-popup.min.css' ) }}" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ URL::asset( 'css/theme.min.css' ) }}" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{ URL::asset( 'css/skins/default.min.css' ) }}" />

</head>
<body>
<!-- start: page -->
<section class="body-sign">
    <div class="center-sign">
        <a href="/" class="logo pull-left">
            <img src="{{ URL::asset( 'images/logo.png' ) }}" height="54" alt="Porto Admin" />
        </a>

        <div class="panel panel-sign">
            <div class="panel-title-sign mt-xl text-right">
                <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
            </div>
            <div class="panel-body">
                <form action="{{ route('login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group mb-lg">
                        <label>E-Mail</label>
                        <div class="input-group input-group-icon">
                            <input name="email" id="email" type="email" class="form-control input-lg" placeholder="Correo." value="{{ old( 'email' ) }}"/>
                            <span class="input-group-addon">
                                <span class="icon icon-lg">
                                    <i class="fa fa-user"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group mb-lg">
                        <div class="clearfix">
                            <label class="pull-left">Password</label>
                            <a href="pages-recover-password.html" class="pull-right">Lost Password?</a>
                        </div>
                        <div class="input-group input-group-icon">
                            <input name="password" id="password" type="password" class="form-control input-lg" />
                            <span class="input-group-addon">
                                <span class="icon icon-lg">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                            <div class="checkbox-custom checkbox-default">
                                <input id="RememberMe" name="rememberme" type="checkbox"/>
                                <label for="RememberMe">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-sm-4 text-right">
                            <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                            <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign In</button>
                        </div>

                    </div>

                    <span class="mt-lg mb-lg line-thru text-center text-uppercase">
                        <span>Visitanos</span>
                    </span>
                    <div class="mb-xs text-center">
                        <a class="btn btn-primary mb-md ml-xs mr-xs" href="https://www.dpintart.com">{{ env( 'NAME_COMMERCIAL_PROJECT' ) }} <i class="fa fa-info-circle"></i></a>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center text-muted mt-md mb-md">&copy; Copyright {{ date('Y') }}. All Rights Reserved.</p>
    </div>
</section>
<!-- end: page -->
</body>
</html>
