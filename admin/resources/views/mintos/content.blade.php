@extends( 'mintos.main' )
@section( 'content' )
    @include( 'mintos.inc.inc-breadcrumb' )
    <div id="app" class="container">
        @switch( $moduleDB )
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
    </div>
@endsection
