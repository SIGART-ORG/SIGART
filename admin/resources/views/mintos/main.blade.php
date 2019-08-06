<!DOCTYPE html>
<html lang="{{ str_replace( '_', '-', app()->getLocale() ) }}">

@include( 'mintos.inc.inc-head' )

<body>
<!-- Preloader -->
<div class="preloader-it">
    <div class="loader-pendulums"></div>
</div>
<!-- /Preloader -->

<!-- HK Wrapper -->
<div class="hk-wrapper hk-vertical-nav">

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-xl navbar-light fixed-top hk-navbar">
        <a id="navbar_toggle_btn" class="navbar-toggle-btn nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="menu"></i></span></a>
        <a class="navbar-brand" href="dashboard1.html">
            <img class="brand-img d-inline-block" src="{{ asset( 'assets/dist/img/logo-light.png' ) }}" alt="User" />
        </a>
        <ul class="navbar-nav hk-navbar-content">
            <li class="nav-item dropdown">
                <a id="settings_sites_btn" class="nav-link nav-link-hover" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="feather-icon"><i data-feather="briefcase"></i></span>
                </a>
            </li>
            <li class="nav-item">
                <a id="navbar_search_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="search"></i></span></a>
            </li>
            <li class="nav-item">
                <a id="settings_toggle_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="settings"></i></span></a>
            </li>
            <li class="nav-item dropdown dropdown-notifications">
                <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="feather-icon"><i data-feather="bell"></i></span><span class="badge-wrap"><span class="badge badge-primary badge-indicator badge-indicator-sm badge-pill pulse"></span></span></a>
                <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                    <h6 class="dropdown-header">Notifications <a href="javascript:void(0);" class="">View all</a></h6>
                    <div class="notifications-nicescroll-bar">
                        <a href="javascript:void(0);" class="dropdown-item">
                            <div class="media">
                                <div class="media-img-wrap">
                                    <div class="avatar avatar-sm">
                                        <img src="{{ asset( 'assets/dist/img/avatar1.jpg' ) }}" alt="user" class="avatar-img rounded-circle">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div>
                                        <div class="notifications-text"><span class="text-dark text-capitalize">Evie Ono</span> accepted your invitation to join the team</div>
                                        <div class="notifications-time">12m</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <div class="media">
                                <div class="media-img-wrap">
                                    <div class="avatar avatar-sm">
                                        <img src="{{ asset( 'assets/dist/img/avatar2.jpg' ) }}" alt="user" class="avatar-img rounded-circle">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div>
                                        <div class="notifications-text">New message received from <span class="text-dark text-capitalize">Misuko Heid</span></div>
                                        <div class="notifications-time">1h</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <div class="media">
                                <div class="media-img-wrap">
                                    <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-primary rounded-circle">
													<span class="initial-wrap"><span><i class="zmdi zmdi-account font-18"></i></span></span>
                                            </span>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div>
                                        <div class="notifications-text">You have a follow up with<span class="text-dark text-capitalize"> Mintos head</span> on <span class="text-dark text-capitalize">friday, dec 19</span> at <span class="text-dark">10.00 am</span></div>
                                        <div class="notifications-time">2d</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <div class="media">
                                <div class="media-img-wrap">
                                    <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-success rounded-circle">
													<span class="initial-wrap"><span>A</span></span>
                                            </span>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div>
                                        <div class="notifications-text">Application of <span class="text-dark text-capitalize">Sarah Williams</span> is waiting for your approval</div>
                                        <div class="notifications-time">1w</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <div class="media">
                                <div class="media-img-wrap">
                                    <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-warning rounded-circle">
													<span class="initial-wrap"><span><i class="zmdi zmdi-notifications font-18"></i></span></span>
                                            </span>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div>
                                        <div class="notifications-text">Last 2 days left for the project</div>
                                        <div class="notifications-time">15d</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown dropdown-authentication">
                <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media">
                        <div class="media-img-wrap">
                            <div class="avatar">
                                <img src="{{ asset( 'assets/dist/img/avatar12.jpg' ) }}" alt="user" class="avatar-img rounded-circle">
                            </div>
                            <span class="badge badge-success badge-indicator"></span>
                        </div>
                        <div class="media-body">
                            <span>{{ Auth::user()->name }} {{ Auth::user()->last_name }}<i class="zmdi zmdi-chevron-down"></i></span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                    <a class="dropdown-item" href="{{ url( 'profile' ) }}">
                        <i class="dropdown-icon zmdi zmdi-account"></i><span>Perfil</span>
                    </a>
                    <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-card"></i><span>My balance</span></a>
                    <a class="dropdown-item" href="inbox.html"><i class="dropdown-icon zmdi zmdi-email"></i><span>Inbox</span></a>
                    <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-settings"></i><span>Settings</span></a>
                    <div class="dropdown-divider"></div>
                    <div class="sub-dropdown-menu show-on-hover">
                        <a href="#" class="dropdown-toggle dropdown-item no-caret"><i class="zmdi zmdi-check text-success"></i>Online</a>
                        <div class="dropdown-menu open-left-side">
                            <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-check text-success"></i><span>Online</span></a>
                            <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-circle-o text-warning"></i><span>Busy</span></a>
                            <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-minus-circle-outline text-danger"></i><span>Offline</span></a>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="dropdown-icon zmdi zmdi-power"></i><span>Cerrar Sesión</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <form role="search" class="navbar-search">
        <div class="position-relative">
            <a href="javascript:void(0);" class="navbar-search-icon"><span class="feather-icon"><i data-feather="search"></i></span></a>
            <input type="text" name="example-input1-group2" class="form-control" placeholder="Type here to Search">
            <a id="navbar_search_close" class="navbar-search-close" href="#"><span class="feather-icon"><i data-feather="x"></i></span></a>
        </div>
    </form>
    <!-- /Top Navbar -->

@include( 'mintos.inc.inc-sidebar' )

<!-- Setting Panel -->
    <div class="hk-settings-panel">
        <div class="nicescroll-bar position-relative">
            <div class="settings-panel-wrap">
                <div class="settings-panel-head">
                    <img class="brand-img d-inline-block align-top" src="{{ asset( 'assets/dist/img/logo-light.png' ) }}" alt="brand" />
                    <a href="javascript:void(0);" id="settings_panel_close" class="settings-panel-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
                </div>
                <hr>
                <h6 class="mb-5">Layout</h6>
                <p class="font-14">Choose your preferred layout</p>
                <div class="layout-img-wrap">
                    <div class="row">
                        <a href="dashboard1.html" class="col-6 mb-30">
                            <img class="rounded opacity-70" src="{{ asset( 'assets/dist/img/layout1.png' ) }}" alt="layout">
                            <i class="zmdi zmdi-check"></i>
                        </a>
                        <a href="dashboard2.html" class="col-6 mb-30">
                            <img class="rounded opacity-70" src="{{ asset( 'assets/dist/img/layout2.png' ) }}" alt="layout">
                            <i class="zmdi zmdi-check"></i>
                        </a>
                        <a href="dashboard3.html" class="col-6 mb-30">
                            <img class="rounded opacity-70" src="{{ asset( 'assets/dist/img/layout3.png' ) }}" alt="layout">
                            <i class="zmdi zmdi-check"></i>
                        </a>
                        <a href="javascript:void(0);" class="col-6 mb-30 active">
                            <img class="rounded opacity-70" src="{{ asset( 'assets/dist/img/layout4.png' ) }}" alt="layout">
                            <i class="zmdi zmdi-check"></i>
                        </a>
                        <a href="dashboard5.html" class="col-6">
                            <img class="rounded opacity-70" src="{{ asset( 'assets/dist/img/layout5.png' ) }}" alt="layout">
                            <i class="zmdi zmdi-check"></i>
                        </a>
                    </div>
                </div>
                <hr>
                <h6 class="mb-5">Navigation</h6>
                <p class="font-14">Menu comes in two modes: dark & light</p>
                <div class="button-list hk-nav-select mb-10">
                    <button type="button" id="nav_light_select" class="btn btn-outline-light btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-sun-o"></i> </span><span class="btn-text">Light Mode</span></button>
                    <button type="button" id="nav_dark_select" class="btn btn-outline-primary btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-moon-o"></i> </span><span class="btn-text">Dark Mode</span></button>
                </div>
                <hr>
                <h6 class="mb-5">Top Nav</h6>
                <p class="font-14">Choose your liked color mode</p>
                <div class="button-list hk-navbar-select mb-10">
                    <button type="button" id="navtop_light_select" class="btn btn-outline-primary btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-sun-o"></i> </span><span class="btn-text">Light Mode</span></button>
                    <button type="button" id="navtop_dark_select" class="btn btn-outline-light btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-moon-o"></i> </span><span class="btn-text">Dark Mode</span></button>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Scrollable Header</h6>
                    <div class="toggle toggle-sm toggle-simple toggle-light toggle-bg-primary scroll-nav-switch"></div>
                </div>
                <button id="reset_settings" class="btn btn-primary btn-block btn-reset mt-30">Reset</button>
            </div>
        </div>
        <img class="d-none" src="{{ asset( 'assets/dist/img/logo-light.png' ) }}" alt="brand" />
        <img class="d-none" src="{{ asset( 'assets/dist/img/logo-dark.png' ) }}" alt="brand" />
    </div>
    <!-- /Setting Panel -->

    <!-- Main Content -->

    <div class="hk-pg-wrapper">
        <!-- Container -->
    @yield('content')
    <!-- /Container -->

        <!-- Footer -->
        <div class="hk-footer-wrap container">
            <footer class="footer">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <p>Pampered by<a href="https://hencework.com/" class="text-dark" target="_blank">Hencework</a> © 2019</p>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <p class="d-inline-block">Follow us</p>
                        <a href="#" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span class="btn-icon-wrap"><i class="fa fa-facebook"></i></span></a>
                        <a href="#" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span class="btn-icon-wrap"><i class="fa fa-twitter"></i></span></a>
                        <a href="#" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span class="btn-icon-wrap"><i class="fa fa-google-plus"></i></span></a>
                    </div>
                </div>
            </footer>
        </div>
        <!-- /Footer -->
    </div>
    <!-- /Main Content -->

</div>
<!-- /HK Wrapper -->
@include( 'mintos.inc.inc-footer' )
</body>
</html>
