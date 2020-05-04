<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{!! Str::upper( $title ) !!} - {{ env( 'NAME_COMMERCIAL_PROJECT' ) }}</title>
    <link rel="stylesheet" href="{{ asset('assets/pdf/css/style.min.css') }}" media="all" />
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800&display=swap');
        body{
            font-family: 'Montserrat', sans-serif;
            font-size: 12px;
        }
        h1 {
            text-transform: uppercase;
            text-align: center;
            color: #ACACAC;
            border-bottom: #ACACAC 3px solid;
            font-size: 20px;
        }
        .content-title {
            padding: 0 30px;
        }
        .reference-logo {
            width: 93px;
            height: auto;
            object-fit: cover;
        }
        .container {
            padding: 0 30px;
        }

        .content-detail {
            border: #ACACAC 2px solid;
        }
        .first-item {
            padding: 10px 15px;
            min-height: 100px;
        }
        .first-item.text-justify {
            text-align: justify;
        }

        .container-subtitle {
            padding-left: 15px;
            margin-top: 30px;
            margin-bottom: 5px;
            font-weight: 700;
        }
        footer {
            position: fixed;
            left: 0;
            right: 0;
            color: #aaa;
            font-size: 0.9em;
            bottom: 0;
            border-top: 0.1pt solid #aaa;
            height: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img class="reference-logo" src="{{ URL::asset( 'images/marca_agua.png' ) }}" width="120" alt="{{ env('NAME_COMMERCIAL_PROJECT') }}">
    </div>
    <div class="content-title">
        <h1>{!! Str::upper( $title ) !!}</h1>
    </div>
</header>
<section class="container">
    <div class="content-detail">
        <div class="first-item"><strong>ÁREA RESPONSABLE:</strong> {!! ucfirst( Str::lower( $reference->area ) ) !!}</div>
        <div class="first-item"><strong>ACTIVIDAD:</strong> {!! ucfirst( Str::lower( $reference->activity ) ) !!}</div>
        <div class="first-item"><strong>CLIENTE:</strong> {!! Str::upper( $reference->customer ) !!}</div>
    </div>
    <div class="container-subtitle">1. OBJETIVO DEL SERVICIO</div>
    <div class="content-detail">
        <div class="first-item text-justify">{!! ucfirst( Str::lower( $reference->objective ) ) !!}</div>
    </div>
    <div class="container-subtitle">2. AREA USUARIA Y/O ESPECIALIZADA</div>
    <div class="content-detail">
        <div class="first-item text-justify">{!! ucfirst( Str::lower( $reference->specializedArea ) ) !!}</div>
    </div>
    <div class="container-subtitle">3. DESCRIPCIÓN DETALLADA DEL SERVICIO</div>
    <div class="content-detail">
        @foreach( $reference->details as $idx => $detail )
        <div class="first-item">{{ $idx + 1 }}.- {!! ucfirst( Str::lower( $detail->description ) ) !!} ({{ $detail->quantity }} Unidades)</div>
        @endforeach
    </div>
    <div class="container-subtitle">4. PLAZO DE EJECUCIÓN DEL SERVICIO</div>
    <div class="content-detail">
        <div class="first-item text-justify">{!! ucfirst( Str::lower( $reference->daysExecution ) ) !!}</div>
    </div>
    <div class="container-subtitle">5. LUGAR DE PRESTACIÓN DEL SERVICIO</div>
    <div class="content-detail">
        <div class="first-item text-justify">{!! ucfirst( Str::lower(  $reference->executionAddress ) ) !!} - {{ $reference->ubigeo }}</div>
        @if( $reference->addressReference && $reference->addressReference !== '' )
        <div class="first-item text-justify"><strong>Referencia:</strong> {!! ucfirst( Str::lower( $reference->addressReference ) ) !!}</div>
        @endif
    </div>
    <div class="container-subtitle">6. FORMA DE PAGO</div>
    <div class="content-detail">
        <div class="first-item text-justify">{!! ucfirst( Str::lower( $reference->methodPayment ) ) !!}</div>
    </div>
    <div class="container-subtitle">7. OTORGAMIENTO DE LA CONFORMIDAD DEL SERVICIO</div>
    <div class="content-detail">
        <div class="first-item text-justify">{!! ucfirst( Str::lower( $reference->conformanceGrant ) ) !!}</div>
    </div>
    <div class="container-subtitle">8. GARANTÍA DEL SERVICIO</div>
    <div class="content-detail">
        <div class="first-item text-justify">{!! ucfirst( Str::lower( $reference->warranty ) ) !!}</div>
    </div>
    <div class="container-subtitle">9. OBSERVACIONES</div>
    <div class="content-detail">
        <div class="first-item text-justify">{!! ucfirst( Str::lower( $reference->obervations ) ) !!}</div>
    </div>
</section>
<footer>
    D' PINTART - Todos los derechos reservados&copy; {{ date('Y') }} | Generado: {{ date('d/m/Y h:i:s a') }}
</footer>
<script type="text/php">
    if (isset($pdf)) {
        $text = "página {PAGE_NUM} / {PAGE_COUNT}";
        $size = 10;
        $font = $fontMetrics->getFont("Verdana");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width) / 2;
        $y = $pdf->get_height() - 35;
        $pdf->page_text($x, $y, $text, $font, $size);
    }
</script>
</body>
</html>
