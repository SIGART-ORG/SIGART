<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{!! Str::upper( $title ) !!} - {{ env( 'NAME_COMMERCIAL_PROJECT' ) }}</title>
    <link rel="stylesheet" href="{{ asset('assets/pdf/css/style.min.css') }}" media="all" />
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="{{ URL::asset( 'images/marca_agua.png' ) }}" width="120" alt="{{ env('NAME_COMMERCIAL_PROJECT') }}">
    </div>
    <h1>{!! Str::upper( $title ) !!}</h1>
</header>
<main>
    <div class="espc-tec">
        <h2 class="title">Información</h2>
    </div>
    <table>
        <thead>
        <tr>
            <th>Comprobante</th>
            <th>Fecha de emisión</th>
            <th>Proveedor</th>
            <th>N° Documento</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $code }}</td>
            <td>{{ $dateIssue }}</td>
            <td>{{ $provider }}</td>
            <td>{{ $document }}</td>
        </tr>
        </tbody>
    </table>
    <div class="espc-tec">
        <h2 class="title">Detalle</h2>
    </div>
    <table>
        <thead>
        <tr>
            <th>Item</th>
            <th class="service">Producto</th>
            <th class="desc">Cantidad</th>
            <th class="desc">Precio unitario</th>
            <th>Sub-total</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $details as $idx => $detail )
            <tr>
                <td class="desc">{{ $idx + 1 }}</td>
                <td class="service">{{ $detail->category }} {{ $detail->product }} {{ $detail->description }}</td>
                <td class="desc">{{ $detail->quantity }} {{ $detail->unity }}</td>
                <td class="subtotal">S/ {{ $detail->price_unit }}</td>
                <td class="total">S/ {{ $detail->total }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" class="grand total">TOTAL</td>
            <td class="grand total">S/ {{ $total }}</td>
        </tr>
        </tbody>
    </table>
    @if( $image !== '' )
    <div class="espc-tec">
        <h2 class="title">Adjunto</h2>
        <img src="{{ $image }}" alt="{{ $code }}">
    </div>
    @endif
    <div id="notices">
        <div><i class="fa fa-info"></i> IMPORTANTE:</div>
        <div class="notice">El precio debe incluir I.G.V</div>
        <div class="notice">Documento impreso el {{ date('d/m/Y h:i a') }}</div>
    </div>
</main>
<footer>
    D' PINTART - Todos los derechos reservados&copy; {{ date('Y') }}
</footer>
</body>
</html>
