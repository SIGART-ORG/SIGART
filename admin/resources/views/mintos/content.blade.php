@extends( 'mintos.main' )
@section( 'content' )
    @include( 'mintos.inc.inc-breadcrumb' )
    <div id="app" class="container" style="max-width:1600px !important;">
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
                <purchase-order asset="{{ $assetUrl }}"></purchase-order>
                @break
                @case( 'purchase' )
                <Purchase></Purchase>
                @break
                @case( 'input-order' )
                <inputorder></inputorder>
                @break
                @case( 'tool' )
                <tool></tool>
                @break
                @case( 'stock' )
                <stock page="{{ $menu }}"></stock>
                @break
                @case( 'services_request' )
                <services_request></services_request>
                @break
            @endswitch
        @else
            @switch( $subMenu )
                @case( 'purchase-request-details' )
                <pr-detail pr="{{ $prId }}"></pr-detail>
                @break
                @case( 'purchase-form' )
                <purchase-form purchase="{{ $purchase }}"></purchase-form>
                @break
                @case( 'inputorderdetail' )
                <inputorderdetail id="{{ $id }}"></inputorderdetail>
                @break
            @endswitch
        @endif
    </div>
@endsection
