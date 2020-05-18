<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{!! Str::upper( $title ) !!} - {{ env( 'NAME_COMMERCIAL_PROJECT' ) }}</title>
    <link rel="stylesheet" href="{{ asset('assets/pdf/css/pdf.min.css') }}" media="all" />
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
</header>
<main>
    <table class="sr-header">
        <thead>
        <tr>
            <td class="title p-10">N°</td>
            <td class="p-10">{{ $reference->soDocument }}-{{ $reference->soDocumentNum }}</td>
        </tr>
        <tr>
            <td class="title p-10">TOTAL</td>
            <td class="p-10">S/ {{ $reference->total }}</td>
        </tr>
        <tr>
            <td class="title p-10">FECHA</td>
            <td class="p-10">{{ $reference->dateSOApproved }}</td>
        </tr>
        </thead>
    </table>
    <table class="header">
        <thead>
        <tr>
            <td class="title">SOLICITANTE:</td>
            <td>{!! Str::upper( $reference->customerName ) !!}</td>
            <td class="title">EMAIL:</td>
            <td>{!! Str::upper( $reference->email ) !!}</td>
        </tr>
        <tr>
            <td class="title">DIRECCIÓN:</td>
            <td>{{ $reference->addressCustomer }}</td>
        </tr>
        <tr>
            <td class="title">ACTIVIDAD:</td>
            <td>
                {!! ucfirst( Str::lower( $reference->activity ) ) !!}
            </td>
        </tr>
        <tr>
            <td class="title">{{ $reference->typeDocument }}:</td>
            <td>{{ $reference->numero }}</td>
        </tr>
        <tr>
            <td class="title">PLAZO DE EJECUCIÓN:</td>
            <td>{!! ucfirst( Str::lower( $reference->daysExecutionV2 ) ) !!}</td>
            <td class="title">LUGAR DEL SERVICIO:</td>
            <td>
                {!! ucfirst( Str::lower( $reference->executionAddress ) ) !!}
                @if( $reference->addressReference )
                    {!! ucfirst( Str::lower( $reference->addressReference ) ) !!}
                @endif
            </td>
        </tr>
        </thead>
    </table>
    <table class="details">
        <thead>
        <tr>
            <th>N°</th>
            <th>Cot</th>
            <th>Req</th>
            <th>Cantidad</th>
            <th>Descripción</th>
            <th>Precio</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $reference->details as $idx => $detail )
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $reference->saleQuotation }}</td>
                <td>{{ $reference->srDocument }}-{{ $reference->srDocumentNum }}</td>
                <td>{{ $detail->quantity }} Und.</td>
                <td>{!! ucfirst( Str::lower( $detail->description ) ) !!}</td>
                <td class="right">{{ $detail->total }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td class="right" colspan="5">Sub Total (S/)</td>
            <td class="right">{{ $reference->subTotal }}</td>
        </tr>
        <tr>
            <td class="right" colspan="5">I.G.V. (18%)</td>
            <td class="right">{{ $reference->igv }}</td>
        </tr>
        <tr>
            <td class="right total" colspan="5">Total (S/)</td>
            <td class="right total">{{ $reference->total }}</td>
        </tr>
        </tfoot>
    </table>
    <table class="ref-term-points">
        <tbody>
        <tr><td class="title">OBJETIVO DEL SERVICIO:</td></tr>
        <tr><td class="description">{!! ucfirst( Str::lower( $reference->objective ) ) !!}</td></tr>
        <tr><td class="title">PAGO:</td></tr>
        <tr><td class="description">{!! ucfirst( Str::lower( $reference->methodPayment ) ) !!}</td></tr>
        <tr><td class="title">GARANTÍA:</td></tr>
        <tr><td class="description">{!! ucfirst( Str::lower( $reference->warranty ) ) !!}</td></tr>
        <tr><td class="title">OBSERVACIONES:</td></tr>
        <tr><td class="description">{!! ucfirst( Str::lower( $reference->obervations ) ) !!}</td></tr>
        </tbody>
    </table>
</main>
<section class="container">
    <table class="firm2">
        <thead>
        <tr>
            <th>
                <div class="firm">
                    Administración
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
