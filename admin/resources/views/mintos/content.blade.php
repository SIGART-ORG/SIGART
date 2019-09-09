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
                @case( 'quotation' )
                <quotation></quotation>
                @break
                @case( 'purchase-order' )
                <purchase-order></purchase-order>
                @break
            @endswitch
        @else
            @switch( $subMenu )
                @case( 'purchase-request-details' )
                <pr-detail pr="{{ $prId }}"></pr-detail>
                @break
            @endswitch
        @endif
    </div>
@endsection
