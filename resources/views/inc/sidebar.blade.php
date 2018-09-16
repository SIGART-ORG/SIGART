
<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="main.html"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
            <li class="nav-title">
                Mantenimiento
            </li>
            @foreach ($sidebar as $modulo)
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> {{ $modulo['name'] }}</a>
                <ul class="nav-dropdown-items">
                    @foreach ($modulo['pages'] as $pages)
                        @if($pages['view_panel'] == 1)
                    <li @click="menu={{ $pages['id'] }}" class="nav-item">
                        <a class="nav-link" href="#" :class="{'active': menu=={{ $pages['id'] }} }"><i class="icon-bag"></i> {{ $pages['name'] }}</a>
                    </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            @endforeach
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>