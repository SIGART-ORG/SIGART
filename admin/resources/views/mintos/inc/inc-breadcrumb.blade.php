<!-- Breadcrumb -->
@if( count( $breadcrumb ) > 0 )
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        @foreach( $breadcrumb as $idx => $bc )
        <li class="breadcrumb-item @if( ( count( $breadcrumb ) - 1 ) == $idx ) active @endif"
            @if( ( count( $breadcrumb ) - 1 ) == $idx ) aria-current="page" @endif
        >
            @if( ( count( $breadcrumb ) - 1 ) == $idx )
                {{ $bc['name'] }}
            @else
                <a href="{{ $bc['url'] }}">{{ $bc['name'] }}</a>
            @endif
        </li>
        @endforeach
    </ol>
</nav>
@endif
<!-- /Breadcrumb -->
