<head>
    <title>Dashboard | {{ env( 'NAME_PROJECT' ) }}</title>

    @include('inc.meta')

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset( 'css/main.min.css' ) }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset( 'css/styles-admin.min.css' ) }}">
</head>
