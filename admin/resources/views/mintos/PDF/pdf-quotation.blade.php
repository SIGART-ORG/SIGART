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
    <div class="presentation">
        @if( $typePerson === 1 )
            <p class="remitente">Estimado sr {!! Str::upper( $provider ) !!}:</p>
        @else
            <p class="remitente">Estimado(s) sr(es) de {!! Str::upper( $provider ) !!}:</p>
        @endif
        <p>
            Nos es grato dirigirnos a usted a fin de solicitarle la prestación de una cotización para la provisión de
            <b>materiales de producción de productos de carpintería y pintura</b>. En la preparación de su cotización
            rogamos utilice y rellene el formulario adjunto como <b>Anexo 1</b>.
        </p>
        <p>
            Su cotización deberá ser enviada los más pronto posible al correo electronico:
            <a href="mailto:{{ env('MAIL_USERNAME') }}"><b>{{ env('MAIL_USERNAME') }}</b></a> mencionando en el asunto
            <b>OFERTA {!! Str::upper( $code ) !!}</b>
        </p>
        <p>
            Las cotizaciones presentadas por correo electrónico estarán limitadas a un máximo de 3 MB, en ficheros libres
            de virus y en un número de envios no superior a 4 (cuatro). Los ficheros estarás libres de cualquier tipo de
            virus o archivo dañado; de no ser así, serán rechazados.
        </p>
        <p>
            Será su responsabilidad asegurarse de que su cotización llega a la dirección antes mencionada. Si usted envía
            su cotización por correo electrónico, le rogamos se asegure de que está en formato pdf y libre de cualquier
            virus o archivo dañado.
        </p>
    </div>
</header>
<main>
    <div class="espc-tec">
        <h2 class="title">Anexo 1</h2>
        <p>Especificacione técnicas</p>
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
            <td class="subtotal">S/ ________</td>
            <td class="total">S/ ________</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4" class="grand total">TOTAL</td>
            <td class="grand total">S/ ________</td>
        </tr>
        </tbody>
    </table>
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
