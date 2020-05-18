@extends( 'mintos.PDF.main-default' )
@section( 'content' )
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title }} - {{ env( 'NAME_PROJECT' ) }}</title>
    <link rel="stylesheet" href="{{ asset('assets/pdf/css/pdf.min.css') }}" media="all" />
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="{{ URL::asset( 'images/marca_agua.png' ) }}" width="120" alt="{{ env('NAME_COMMERCIAL_PROJECT') }}">
    </div>
    <h1 class="title">{{ $title }}</h1>
</header>
<main>
    <table class="header">
        <thead>
        <tr>
            <td class="title">AREA RESPONSABLE:</td>
            <td>{{ $reference->area }}</td>
        </tr>
        <tr>
            <td class="title">ACTIVIDAD:</td>
            <td>{{ $reference->activity }}</td>
        </tr>
        <tr>
            <td class="title">CLIENTE:</td>
            <td>{{ $reference->customer }}</td>
        </tr>
        </thead>
    </table>
    <table class="ref-term-points">
        <tbody>
        <tr><td class="title">1. OBJETIVO DEL SERVICIO</td></tr>
        <tr><td class="description">{{ $reference->objective }}</td></tr>
        <tr><td class="title">2. AREA USUARIA Y/O ESPECIALIZADA</td></tr>
        <tr><td class="description">{{ $reference->specializedArea }}</td></tr>
        <tr><td class="title">3. DESCRIPCIÓN DETALLADA DEL SERVICIO</td></tr>
        <tr>
            <td class="description">
                @if( count( $reference->details ) > 0 )
                <ul>
                    @foreach( $reference->details as $detail )
                        <li>{{ $detail->description }} <strong>({{ $detail->quantity }} unds)</strong></li>
                    @endforeach
                </ul>
                @endif
            </td>
        </tr>
        <tr><td class="title">4. PLAZO DE EJECUCIÓN DEL SERVICIO</td></tr>
        <tr><td class="description">{{ $reference->daysExecution }}</td></tr>
        <tr><td class="title">5. LUGAR DE PRESTACIÓN DEL SERVICIO</td></tr>
        <tr>
            <td class="description">
                {{ $reference->executionAddress }}
                @if( $reference->addressReference )
                    <br/>
                    {{ $reference->addressReference }}
                @endif
            </td>
        </tr>
        <tr><td class="title">6. FORMA DE PAGO</td></tr>
        <tr><td class="description">{{ $reference->methodPayment }}</td></tr>
        <tr><td class="title">7. OTORGAMIENTO DE LA CONFORMIDAD DEL SERVICIO</td></tr>
        <tr><td class="description">{{ $reference->conformanceGrant }}</td></tr>
        <tr><td class="title">8. GARANTÍA DEL SERVICIO</td></tr>
        <tr><td class="description">{{ $reference->warranty }}</td></tr>
        <tr><td class="title">9. OBSERVACIONES</td></tr>
        <tr><td class="description">{{ $reference->obervations }}</td></tr>
        </tbody>
    </table>
    <div id="news">
        <div><strong>IMPORTANTE:</strong></div>
        <div class="notice">Documento generado el <strong>{{ date('d/m/Y h:i a') }}</strong></div>
    </div>
</main>
<footer>
    <strong>D' PINTART</strong> - Todos los derechos reservados&copy; {{ date('Y') }}
</footer>
</body>
</html>
@endsection
