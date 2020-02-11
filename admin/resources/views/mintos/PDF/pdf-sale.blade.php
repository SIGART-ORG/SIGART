<!DOCTYPE html>
<html>
    <head>
        <style>
            @import url('https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800&display=swap');
            body {
                color: #6f7a7f;
                font-family: 'Montserrat', sans-serif;
            }
            section {
                margin: 0;
            }
            h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
                color: #273238;
                font-family: inherit;
                font-weight: 500;
                line-height: 1.2;
                margin: 0;
                padding: 0;
                border: 0;
            }
            h6 {
                font-size: 1rem;
                font-weight: 700;
                line-height: 1.4;
            }
            h4 {
                font-size: 1.5rem;
            }
            h5 {
                font-size: 1.25rem;
            }
            hr {
                margin-top: 20px;
                margin-bottom: 20px;
                border-top: 1px solid
                #e0e3e4;
            }
            ul, li, tbody, tfoot, thead, tr, th, td {
                margin: 0;
                border: 0;
                font: inherit;
                vertical-align: baseline;
            }
            address {
                margin: 0;
                padding: 0;
                border: 0;
                font: inherit;
            }
            .container {
                max-width: 100%;
            }
            .hk-pg-wrapper .hk-pg-header {
                display: flex;
                -webkit-box-align: center;
                align-items: center;
                -webkit-justify-content: space-between;
                flex-wrap: wrap;
            }
            .row {
                display: flex;
                flex-wrap: wrap;
            }
            .col-xl-12 {
                flex: 0 0 100%;
                max-width: 100%;
                position: relative;
                width: 100%;
            }
            .hk-sec-wrapper {
                background: #fff;
                padding: 1.5rem;
                border: 1px solid  #e2e2e2;
                border-radius: .25rem;
                box-shadow: 0 0px 18px
                rgba(0, 0, 0, 0.1);
                margin-bottom: 14px;
            }
            .py-60 {
                padding-top: 60px !important;
                padding-bottom: 60px !important;
            }
            .pl-10 {
                padding-left: 10px !important;
            }
            .pa-35 {
                padding: 35px !important;
            }
            .pb-20 {
                padding-bottom: 20px !important;
            }
            .mt-0 {
                margin-top: 0px !important;
            }
            .mt-20 {
                margin-top: 20px !important;
            }
            .mb-5 {
                margin-bottom: 5px !important;
            }
            .mb-20 {
                margin-bottom: 20px !important;
            }
            .mb-30 {
                margin-bottom: 30px !important;
            }
            .mb-35 {
                margin-bottom: 35px !important;
            }
            .col-md-7 {
                flex: 0 0 58.333333%;
                max-width: 58.333333%;
            }
            .col-md-5 {
                flex: 0 0 41.666667%;
                max-width: 41.666667%;
            }
            .d-block {
                display: block !important;
            }
            .img-fluid {
                max-width: 100%;
                height: auto;
            }
            .d-inline-block {
                display: inline-block !important;
            }
            .hk-invoice-wrap .invoice-from-wrap > .row div:last-child,
            .hk-invoice-wrap .invoice-to-wrap > .row div:last-child {
                text-align: right;
            }
            .font-weight-600 {
                font-weight: 600 !important;
            }
            .font-13 {
                font-size: 13px !important;
            }
            .font-14 {
                font-size: 14px !important;
            }
            .font-18 {
                font-size: 18px !important;
            }
            .text-right {
                text-align: right !important;
            }
            .text-dark {
                color: #324148 !important;
            }
            .text-light {
                color: #848d91 !important;
            }
            .text-uppercase {
                text-transform: uppercase !important;
            }
            .table {
                width: 100%;
                color: #212529;
                border-collapse: collapse;
            }
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
            }

            .table th {
                font-weight: 500;
                color: #324148;
                font-size: 14px;
                text-transform: capitalize;
            }
            .table td {
                border-top: 1px solid #e0e3e4;
                vertical-align: middle;
                padding: .75rem 1.25rem;
            }
            .table td, .table th {
                border-top: 1px solid #e0e3e4;
                vertical-align: middle;
                padding: .75rem 1.25rem;
            }
            .table thead th, .table thead td {
                border-top: none;
                border-bottom: none;
                vertical-align: middle;
            }

            .w-70 {
                width: 70% !important;
            }
            .table.table-hover tbody tr:hover,
            .table.table-striped tbody tr:nth-of-type(2n+1) {
                background-color:
                    #f5f5f6;
            }
            .table-striped tbody tr:nth-of-type(2n+1) {
                background-color: rgba(0,0,0,.05);
            }
            .bg-transparent {
                background-color: transparent !important;
            }
            .border-bottom {
                border-bottom: 1px solid
                #e0e3e4 !important;
            }
            ul.list-ul {
                list-style: none;
                counter-reset: li;
            }
            ul.list-ul > li::before {
                content: '\2022';
                display: inline-block;
                height: 20px;
                width: 20px;
                text-align: center;
                font-size: 26px;
                margin-left: -20px;
                position: relative;
                left: -10px;
                padding-top: 1px;
                top: 5px;
                line-height: 12px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper hk-invoice-wrap pa-35">
                        <div class="invoice-from-wrap">
                            <div class="row">
                                <div class="col-md-7 mb-20">
                                    <img class="img-fluid invoice-brand-img d-block mb-20" src="{{ URL::asset( 'images/marca_agua.png' ) }}" width="120" alt="{{ env('NAME_COMMERCIAL_PROJECT') }}">
                                    <h6 class="mb-5">Hencework Inc</h6>
                                    <address>
                                        <span class="d-block">4747, Pearl Street</span>
                                        <span class="d-block">Rainy Day Drive, Washington</span>
                                        <span class="d-block">Mintos@hencework.com</span>
                                    </address>
                                </div>
                                <div class="col-md-5 mb-20">
                                    <h4 class="mb-35 font-weight-600">Invoice / Receipt</h4>
                                    <span class="d-block">Date:<span class="pl-10 text-dark">Nov 17,2017 11:23 AM</span></span>
                                    <span class="d-block">Invoice / Receipt #<span class="pl-10 text-dark">21321434</span></span>
                                    <span class="d-block">Customer #<span class="pl-10 text-dark">321434</span></span>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-0">
                        <div class="invoice-to-wrap pb-20">
                            <div class="row">
                                <div class="col-md-7 mb-30">
                                    <span class="d-block text-uppercase mb-5 font-13">billing to</span>
                                    <h6 class="mb-5">Supersonic Co.</h6>
                                    <address>
                                        <span class="d-block">Sycamore Street</span>
                                        <span class="d-block">San Antonio Valley, CA 34668</span>
                                        <span class="d-block">thompson_peter@super.co</span>
                                        <span class="d-block">ABC:325487</span>
                                    </address>
                                </div>
                                <div class="col-md-5 mb-30">
                                    <span class="d-block text-uppercase mb-5 font-13">Payment info</span>
                                    <span class="d-block">Scott L Thompson</span>
                                    <span class="d-block">MasterCard#########1234</span>
                                    <span class="d-block">Customer #<span class="text-dark">324148</span></span>
                                    <span class="d-block text-uppercase mt-20 mb-5 font-13">amount due</span>
                                    <span class="d-block text-dark font-18 font-weight-600">$22,010</span>
                                </div>
                            </div>
                        </div>
                        <h5>Items</h5>
                        <hr>
                        <div class="invoice-details">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table table-striped table-border mb-0">
                                        <thead>
                                        <tr>
                                            <th class="w-70">Items</th>
                                            <th class="text-right">Number</th>
                                            <th class="text-right">Unit Cost</th>
                                            <th class="text-right">Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="w-70">Design Service</td>
                                            <td class="text-right">2</td>
                                            <td class="text-right">$1500</td>
                                            <td class="text-right">$3000</td>
                                        </tr>
                                        <tr>
                                            <td class="w-70">Website Development</td>
                                            <td class="text-right">1</td>
                                            <td class="text-right">$7500</td>
                                            <td class="text-right">$7500</td>
                                        </tr>
                                        <tr>
                                            <td class="w-70">Social Media Services</td>
                                            <td class="text-right">15</td>
                                            <td class="text-right">$180</td>
                                            <td class="text-right">$9000</td>
                                        </tr>
                                        <tr class="bg-transparent">
                                            <td colspan="3" class="text-right text-light">Subtotals</td>
                                            <td class="text-right">$19,500</td>
                                        </tr>
                                        <tr class="bg-transparent">
                                            <td colspan="3" class="text-right text-light border-top-0">Tax</td>
                                            <td class="text-right border-top-0">$3510</td>
                                        </tr>
                                        <tr class="bg-transparent">
                                            <td colspan="3" class="text-right text-light border-top-0">Discount</td>
                                            <td class="text-right border-top-0">$1000</td>
                                        </tr>
                                        </tbody>
                                        <tfoot class="border-bottom border-1">
                                        <tr>
                                            <th colspan="3" class="text-right font-weight-600">total</th>
                                            <th class="text-right font-weight-600">$22,010</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="invoice-sign-wrap text-right py-60">
                                <img class="img-fluid d-inline-block" src="dist/img/signature.png" alt="sign" />
                                <span class="d-block text-light font-14">Digital Signature</span>
                            </div>
                        </div>
                        <hr>
                        <ul class="invoice-terms-wrap font-14 list-ul">
                            <li>A buyer must settle his or her account within 30 days of the date listed on the invoice.</li>
                            <li>The conditions under which a seller will complete a sale. Typically, these terms specify the period allowed to a buyer to pay off the amount due.</li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
