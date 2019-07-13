@extends( 'mintos.main' )
@section( 'content' )
    @include( 'mintos.inc.inc-breadcrumb' )
    <div id="app" class="container">
        @switch( $moduleDB )
            @case( 'products' )
            <products></products>
            @break
        @endswitch
    </div>
@endsection
