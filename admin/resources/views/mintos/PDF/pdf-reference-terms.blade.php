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


        </tbody>
    </table>
</main>
<footer>
    D' PINTART - Todos los derechos reservados&copy; {{ date('Y') }} | Generado: {{ date('d/m/Y h:i:s a') }}
</footer>
</body>
</html>
