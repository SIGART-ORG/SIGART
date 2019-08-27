@extends( 'mintos.main' )
@section( 'content' )
    @include( 'mintos.inc.inc-breadcrumb' )
    <div id="app" class="container">
        @if( empty( $subMenu ) || $subMenu == '' )
            @switch( $moduleDB )
                @case( 'user' )
                <users></users>
                @break
                @case( 'products' )
                <products></products>
                @break
                @case( 'presentation' )
                <Presentation :product="{{ $product }}"></Presentation>
                @break
                @case( 'customers' )
                <customers></customers>
                @break
            @endswitch
        @else
            @switch( $subMenu )
                @case( 'purchase-request-details' )
                <pr-detail></pr-detail>
                @break
            @endswitch
        @endif
    </div>
@endsection
