<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Dashboard | {{ env( 'NAME_PROJECT' ) }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset( 'assets/favicon.ico' ) }}">
    <link rel="icon" href="{{ asset( 'assets/favicon.ico' ) }}" type="image/x-icon">

    @if( !empty( $subMenu ) )
        @if( $subMenu == 'purchase-request-details' )
            <!-- jquery-steps css -->
            <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-steps/demo/css/jquery.steps.css') }}">
        @endif
    @endif
    <!-- Toggles CSS -->
    <link href="{{ asset('assets/vendors/jquery-toggles/css/toggles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/vendors/jquery-toggles/css/themes/toggles-light.css') }}" rel="stylesheet" type="text/css">

    <!-- Toastr CSS -->
    <link href="{{ asset('assets/vendors/jquery-toast-plugin/dist/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/dist/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/styles-admin.min.css') }}" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include( 'mintos.inc.inc-meta' )
</head>
