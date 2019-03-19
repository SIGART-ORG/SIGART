<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        @if(Auth::user()->img_profile != "")
        <img class="app-sidebar__user-avatar" src="{{ URL::asset( 'user/' . Auth::user()->id . '/' . Auth::user()->img_profile ) }}" width="48px" alt="User Image">
        @else
            <img class="app-sidebar__user-avatar" src="{{ URL::asset( 'images/user-default.jpg' ) }}" width="48px" alt="User Image">
        @endif
        <div>
            <p class="app-sidebar__user-name">{{ Auth::user()->name }}</p>
            <p class="app-sidebar__user-designation">{{ Auth::user()->last_name }}</p>
        </div>
    </div>
    <ul class="app-menu">
        <li>
            <a class="app-menu__item active" href="{{ route( 'main' ) }}">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        @foreach($sidebar as $modulo)
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa {{ $modulo['icon'] }}"></i>
                <span class="app-menu__label">{{ $modulo['name'] }}</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                @foreach($modulo['pages'] as $pages)
                    @if($pages['view_panel'] == 1)
                <li>
                    <a class="treeview-item" href="{{ url( $pages['url'] . '/dashboard' ) }}">
                        <i class="icon fa fa-circle-o"></i> {{ $pages['name'] }}
                    </a>
                </li>
                    @endif
                @endforeach
            </ul>
        </li>
        @endforeach
    </ul>
</aside>
