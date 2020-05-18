<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{!! Str::upper( $title ) !!} - {{ env( 'NAME_COMMERCIAL_PROJECT' ) }}</title>
    <link rel="stylesheet" href="{{ asset('assets/pdf/css/pdf.min.css') }}" media="all" />
    <style>
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
        .content-detail.flex {
            display: flex;
            margin-top: 100px;
        }
        .middle-content {
            width: 50%;
            max-width: 50%;
            margin-left: 50px;
            margin-right: 50px;
            margin-top: 50px;
        }
        .content-detail.middle {
            max-width: 50%;
            right: 0;
        }
        .firm {
            border-top: 1px #000 solid;
            width: 100%;
        }
        table.firm2 {
            margin-top: 150px;
            align-content: center;
            padding: 0 50px;
            width: 100%;
        }
        table.firm2 th {
            text-align: center;
        }
    </style>
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="{{ URL::asset( 'images/marca_agua.png' ) }}" width="120" alt="{{ env('NAME_COMMERCIAL_PROJECT') }}">
    </div>
    <h1 class="title">{{ $title }}</h1>
    <h2 class="subtitle">0000{{ $reference->srDocumentNum }}-{{ date( 'Y' ) }}-DPINTART</h2>
</header>
<main>
    <table class="sr-header">
        <thead>
        <tr>
            <td class="title p-10">Periodo</td>
            <td class="p-10" colspan="2">{{ date( 'Y' ) }}</td>
        </tr>
        <tr>
            <td class="title p-10">N°</td>
            <td class="p-10" colspan="2">{{ $reference->srDocument }}-{{ $reference->srDocumentNum }}</td>
        </tr>
        <tr>
            <td class="title center">Día</td>
            <td class="title center">Mes</td>
            <td class="title center">Año</td>
        </tr>
        <tr>
            <td class="center">{{ $reference->dateSRApproved->day }}</td>
            <td class="center">{{ $reference->dateSRApproved->month }}</td>
            <td class="center">{{ $reference->dateSRApproved->year }}</td>
        </tr>
        </thead>
    </table>
    <table class="header">
        <thead>
        <tr>
            <td class="title">SOLICITANTE:</td>
            <td>{!! Str::upper( $reference->customer ) !!}</td>
        </tr>
        <tr>
            <td class="title">AREA RESPONSABLE:</td>
            <td>{!! ucfirst( Str::lower( $reference->area ) ) !!}</td>
        </tr>
        <tr>
            <td class="title">ACTIVIDAD:</td>
            <td>{!! ucfirst( Str::lower( $reference->activity ) ) !!}</td>
        </tr>
        <tr>
            <td class="title">MONEDA:</td>
            <td>Soles (S/)</td>
        </tr>
        <tr>
            <td class="title">TIEMPO ESTIMADO:</td>
            <td>{!! ucfirst( Str::lower( $reference->daysExecutionV2 ) ) !!}</td>
        </tr>
        </thead>
    </table>
    <table class="details">
        <thead>
        <tr>
            <th>N°</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Cantidad</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $reference->details as $idx => $detail )
            <tr>
                <td class="center">{{ $idx + 1 }}</td>
                <td class="center">{{ $reference->saleQuotation }}</td>
                <td>{!! ucfirst( Str::lower( $detail->description ) ) !!}</td>
                <td>{{ $detail->quantity }} Unidades</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>
@if( $reference->obervations )
<section class="container">
    <div class="container-subtitle">OBSERVACIONES</div>
    <div class="content-detail">
        <div class="first-item text-justify">{!! ucfirst( Str::lower( $reference->obervations ) ) !!}</div>
    </div>
</section>
@endif
<section class="container">
    <table class="firm2">
        <thead>
        <tr>
            <th>
                <div class="firm">
                    Administración
                    <br>
                    DPINTART S.A.
                </div>
            </th>
            <th>
                <div class="firm">
                    Gerencia General
                    <br>
                    DPINTART S.A.
                </div>
            </th>
        </tr>
        </thead>
    </table>
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
