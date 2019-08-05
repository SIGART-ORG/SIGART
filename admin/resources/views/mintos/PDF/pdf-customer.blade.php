@extends( 'mintos.PDF.main-default' )
@section( 'content' )
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $data['name'] }} - {{ env( 'NAME_PROJECT' ) }}</title>
    <link rel="stylesheet" href="{{ asset('assets/pdf/css/style.min.css') }}" media="all" />
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="{{ URL::asset( 'images/marca_agua.png' ) }}" width="120" alt="{{ env('NAME_COMMERCIAL_PROJECT') }}">
    </div>
    <h1>Reporte de Cliente</h1>
    <div id="company" class="clearfix">
        <div>{{ $data['name'] }}</div>
        <div>(602) 519-0450</div>
        @if( $data['email'] !== '' )
        <div><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></div>
        @endif
    </div>
    <div class="project @if( $data['type'] == 2 ) person-legal @endif ">
        <div><span> @if( $data['type'] == 1 )NOMBRE @else RAZÓN SOCIAL @endif </span> {{ $data['name'] }}</div>
        @if( $data['type'] == 2 )
        <div><span>NOMBRE COMERCIAL</span> {{ $data['businessName'] }}</div>
        @endif
        <div><span>DIRECCIÓN</span> {{ $data['address'] }}</div>
        <div><span></span> {{ $data['ubigeo'] }}</div>
        <div><span>DUE DATE</span> September 17, 2015</div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th class="service">SERVICE</th>
            <th class="desc">DESCRIPTION</th>
            <th class="desc">COMPROBANTE</th>
            <th class="desc">Fecha</th>
            <th>TOTAL</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="service">Pintura de tejado</td>
            <td class="desc">Creating a recognizable design solution based on the company's existing visual identity</td>
            <td class="desc">B001-0001</td>
            <td class="desc">18/06/2019<br>05/07/2019</td>
            <td class="total">S/ 150.00</td>
        </tr>
        <tr>
            <td class="service">Pintura de tejado2</td>
            <td class="desc">Creating a recognizable design solution based on the company's existing visual identity</td>
            <td class="desc">B001-0002</td>
            <td class="desc">18/06/2019<br>05/07/2019</td>
            <td class="total">S/ 125.00</td>
        </tr>
        <tr>
            <td class="service">Pintura de tejado</td>
            <td class="desc">Creating a recognizable design solution based on the company's existing visual identity</td>
            <td class="desc">B001-0001</td>
            <td class="desc">18/06/2019<br>05/07/2019</td>
            <td class="total">S/ 150.00</td>
        </tr>
        <tr>
            <td class="service">Pintura de tejado2</td>
            <td class="desc">Creating a recognizable design solution based on the company's existing visual identity</td>
            <td class="desc">B001-0002</td>
            <td class="desc">18/06/2019<br>05/07/2019</td>
            <td class="total">S/ 125.00</td>
        </tr>
        <tr>
            <td class="service">Pintura de tejado</td>
            <td class="desc">Creating a recognizable design solution based on the company's existing visual identity</td>
            <td class="desc">B001-0001</td>
            <td class="desc">18/06/2019<br>05/07/2019</td>
            <td class="total">S/ 150.00</td>
        </tr>
        <tr>
            <td class="service">Pintura de tejado2</td>
            <td class="desc">Creating a recognizable design solution based on the company's existing visual identity</td>
            <td class="desc">B001-0002</td>
            <td class="desc">18/06/2019<br>05/07/2019</td>
            <td class="total">S/ 125.00</td>
        </tr>
        <tr>
            <td class="service">Pintura de tejado</td>
            <td class="desc">Creating a recognizable design solution based on the company's existing visual identity</td>
            <td class="desc">B001-0001</td>
            <td class="desc">18/06/2019<br>05/07/2019</td>
            <td class="total">S/ 150.00</td>
        </tr>
        <tr>
            <td class="service">Pintura de tejado2</td>
            <td class="desc">Creating a recognizable design solution based on the company's existing visual identity</td>
            <td class="desc">B001-0002</td>
            <td class="desc">18/06/2019<br>05/07/2019</td>
            <td class="total">S/ 125.00</td>
        </tr>
        <tr>
            <td colspan="4" class="grand total">TOTAL</td>
            <td class="grand total">S/ 1,100.00</td>
        </tr>
        </tbody>
    </table>
    <div id="notices">
        <div><i class="fa fa-info"></i> IMPORTANTE:</div>
        <div class="notice">Documento impreso el {{ date('d/m/Y h:i a') }}</div>
    </div>
</main>
<footer>
    D' PINTART - Todos los derechos reservados&copy; {{ date('Y') }}
</footer>
</body>
</html>
@endsection
