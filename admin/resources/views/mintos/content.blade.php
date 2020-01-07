@extends( 'mintos.main' )
@section( 'content' )
    @if(Session::has('original-user'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <strong>CUIDADO!! @if(Session::has('original-name-user')) {{ Session::get('original-name-user') }},@endif</strong>
                    &nbsp;estas en viendo como <strong class="font-italic">{{ Auth::user()->name }}</strong>.
                    &nbsp;<a href="{{ url( 'reverse' ) }}" class="alert-link alert-heading">Cerrar vista</a>.
                </div>
            </div>
        </div>
    @endif
    @include( 'mintos.inc.inc-breadcrumb' )
    <div id="app" class="container" style="max-width:1600px !important;">
        @if( empty( $subMenu ) || $subMenu == '' )
            @switch( $moduleDB )
                @case( 'dashboard' )
                <dashboard></dashboard>
                @break
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
                <services_request tipo="{{$tipo}}"></services_request>
                @break
                @case( 'list-materials' )
                <list_materials_services service="{{$service_id}}"></list_materials_services>
                @break
                @case( 'vuex' )
                    @switch( $component )
                        @case( 'service' )
                        <servicevue></servicevue>
                        @break
                        @case( 'requerimiento' )
                        <service-details service="{{ $service }}"></service-details>
                        @break
                    @endswitch
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
