<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - #123</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .invoice table {
            margin: 15px;
        }
        .invoice h3 {
            margin-left: 15px;
        }
        .information {
            background-color: #60A7A6;
            color: #FFF;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 10px;
        }
    </style>

</head>
<body>

<div class="information">
    <table width="100%">
        <tr>
            <td colspan="3" align="center">
                <h2>{{ $provider->name }}</h2>
            </td>
        </tr>
        <tr>
            <td align="left" style="width: 40%;">
                <h3>{{ $typeDocument[$provider->type_document] }} {{ $provider->document }}</h3>
                @if( $provider->email != null )
                <span>{{ $provider->email }}</span><br />
                @endif
                <span>{{ $provider->address }}</span><br />
                <span style="font-weight: bold">{{ $ubigeo }}</span>
            </td>
            <td align="center">
                <img src="{{ URL::asset( 'images/marca_agua.png' ) }}" alt="Logo" width="120" class="logo"/>
            </td>
            <td align="right" style="width: 40%;">
                @if( $provider->type_person == 2)
                    @if( $provider->business_name != null )
                <h3>{{ $provider->business_name }}</h3>
                    @endif
                    @if( $provider->legal_representative != null )
                <span>{{ $provider->legal_representative }}</span><br />
                    @endif
                    @if( $provider->legal_representative != null )
                <span>{{ $typeDocument[$provider->type_document_lp] }} {{ $provider->document_lp }}</span>
                    @endif
                @endif
            </td>
        </tr>
    </table>
</div>
<br/>
<div class="invoice">
    <h3>Pedidos</h3>
    <table width="100%">
        <thead>
        <tr>
            <th>Item</th>
            <th># Comprobante</th>
            <th>F. Emisión</th>
            <th>Sub-total</th>
            <th>IGV</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>FE-001</td>
            <td>2019/03/01</td>
            <td align="right">S/ 82.00</td>
            <td align="right">S/ 18.00</td>
            <td align="right">S/ 100.00</td>
        </tr>
        <tr>
            <td>2/td>
            <td>BE-001</td>
            <td>2019/03/01</td>
            <td align="right">S/ 164.00</td>
            <td align="right">S/ 36.00</td>
            <td align="right">S/ 200.00</td>
        </tr>
        <tr>
            <td>3</td>
            <td>FE-001</td>
            <td>2019/03/01</td>
            <td align="right">S/ 82.00</td>
            <td align="right">S/ 18.00</td>
            <td align="right">S/ 100.00</td>
        </tr>
        <tr>
            <td>4</td>
            <td>BE-001</td>
            <td>2019/03/01</td>
            <td align="right">S/ 164.00</td>
            <td align="right">S/ 36.00</td>
            <td align="right">S/ 200.00</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>

        <tfoot>
        <tr>
            <td colspan="2"></td>
            <td align="right" class="gray">S/ 492.00</td>
            <td align="right" class="gray">S/ 108.00</td>
            <td align="right" class="gray">S/ 600.00</td>
        </tr>
        </tfoot>
    </table>
</div>

<div class="information" style="position: absolute; bottom: 0;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 50%;">
                &copy; {{ date('Y') }} {{ env('NAME_COMMERCIAL_PROJECT') }} - Todos los derechos reservados.
            </td>
            <td align="right" style="width: 50%;">
                Company Slogan
            </td>
        </tr>

    </table>
</div>
</body>
</html>