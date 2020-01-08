<!-- Vertical Nav -->
<nav class="hk-nav hk-nav-dark">
    <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
    <div class="nicescroll-bar">
        <div class="navbar-nav-wrap">
            <ul class="navbar-nav flex-column">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route( 'main' ) }}">
                        <span class="feather-icon"><i data-feather="activity"></i></span>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>
                @foreach($sidebar as $modulo)
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#pages_{{ $modulo['id'] }}">
                            <span class="feather-icon"><i data-feather="file-text"></i></span>
                            <span class="nav-link-text">{{ $modulo['name'] }}</span>
                        </a>
                        <ul id="pages_{{ $modulo['id'] }}" class="nav flex-column collapse collapse-level-1 @if( $modulo['selected'] == 1 ) show @endif">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    @foreach($modulo['pages'] as $pages)
                                        @if( $pages['view_panel'] == 1 )
                                        <li class="nav-item @if( $pages['selected'] == 1 ) active @endif">
                                            <a class="nav-link" href="{{ url( $pages['url']) }}">{{ $pages['name'] }}</a>
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endforeach
            </ul>
            <hr class="nav-separator">
            <div class="nav-header">
                <span>Getting Started</span>
                <span>GS</span>
            </div>
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="documentation.html" >
                        <span class="feather-icon"><i data-feather="book"></i></span>
                        <span class="nav-link-text">Documentation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-with-badge" href="#">
                        <span class="feather-icon"><i data-feather="eye"></i></span>
                        <span class="nav-link-text">Changelog</span>
                        <span class="badge badge-sm badge-danger badge-pill">v 1.0</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="feather-icon"><i data-feather="headphones"></i></span>
                        <span class="nav-link-text">Support</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
<!-- /Vertical Nav -->
