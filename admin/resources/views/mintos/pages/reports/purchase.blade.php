@extends( 'mintos.main' )
@section( 'content' )
    @include( 'mintos.inc.inc-breadcrumb' )
    <div class="container" style="max-width: 1600px !important;">
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Reportes de compras</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input type="text" v-model="buscar" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success mb-2">
                                    <i class="fa fa-fw fa-lg fa-download"></i> Descargar Reporte
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper">
            <h6 class="hk-sec-title">Listado</h6>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table->responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                	<th>Tipo comprobante</th>
                                    <th>Comprobante</th>
                                    <th>Proveedor</th>
                                    <th>Nro Doc</th>
                                    <th>Fecha de compra</th>
                                    <th>Fecha de pago</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Factura</td>
                                    <td>FE-00154</td>
                                    <td>FABRICACION DE MUEBLES Y SERVICIOS FERNANDEZ EIRL - FAMYSERFE EIRL</td>
                                    <td>20131143584</td>
                                    <td>15/02/2020</td>
                                    <td>15/02/2020</td>
                                    <td>500</td>
                                    <td>Pagado</td>

                                </tr>
                                <tr>
                                    <td>Factura</td>
                                    <td>FE-00145</td>
                                    <td>FERREMAX S.A.C.</td>
                                    <td>20513122871</td>
                                    <td>15/02/2020</td>
                                    <td>15/02/2020</td>
                                    <td>300</td>
                                    <td>Pagado</td>

                                </tr>
                                <tr>
                                	<td>Factura</td>
                                    <td>FE-00136</td>
                                    <td>HERRAMIENTAS, FIERROS Y CARPINTERIA S.A.C. </td>
                                    <td>20502615140</td>
                                    <td>13/02/2020</td>
                                    <td>13/02/2020</td>
                                    <td>200</td>
                                    <td>Pagado</td>
                                </tr>
                                <tr>
                                    <td>Factura</td>
                                    <td>FE-00128</td>
                                    <td>IMK MADERAS S.A.C.</td>
                                    <td>20509413291</td>
                                    <td>12/02/2020</td>
                                    <td></td>
                                    <td>600</td>
                                    <td>Pendiente de pago</td>
                                </tr>
                                <tr>
                                    <td>Factura</td>
                                    <td>FE-00120</td>
                                    <td>PINTURAS INTERNATIONAL PERU SOCIEDAD ANONIMA CERRADA - PINTER PERU S.A.C.</td>
                                    <td>20501578143</td>
                                    <td>30/01/2020</td>
                                    <td>30/01/2020</td>
                                    <td>800</td>
                                    <td>Pagado</td>
                                </tr>
                                <tr>
                                    <td>Factura</td>
                                    <td>FE-00117</td>
                                    <td>MATERIALES EMPAQUETADURAS SEGURIDAD SRL - RUC</td>
                                    <td>20128320106</td>
                                    <td>25/01/2020</td>
                                    <td>27/01/2020</td>
                                    <td>400</td>
                                    <td>Pagado</td>
                                </tr>
                                <tr>
                                    <td>Factura</td>
                                    <td>FE-00110</td>
                                    <td>Polleria Lo De Juan</td>
                                    <td>20128320106</td>
                                    <td>20/01/2020</td>
                                    <td>25/01/2020</td>
                                    <td>200</td>
                                    <td>Pagado</td>
                                </tr>
                                <tr>
                                    <td>Factura</td>
                                    <td>FE-00105</td>
                                    <td>EQUIPOS Y HERRAMIENTAS S.A.</td>
									<td>20212334554</td>
                                    <td>20/01/2020</td>
                                    <td>20/01/2020</td>
                                    <td>700</td>
                                    <td>Pagado</td>
                                </tr>
                                <tr>
                                    <td>Factura</td>
                                    <td>FE-00100</td>
                                    <td>TIENDAS DEL MEJORAMIENTO DEL HOGAR S.A.</td>
                                    
                                    <td>20112273922</td>
                                    <td>15/01/2020</td>
                                    <td>16/01/2020</td>
                                    <td>300</td>
                                    <td>Pagado</td>
                                </tr>
                                <tr>
                                    <td>Boleta</td>
                                    <td>BE-00102</td>
                                    <td>Santos Amado Geronimo Villanueva</td>
                                     <td>18070930</td>
                                    <td>10/01/2020</td>
                                    <td>10/01/2020</td>
                                    <td>100</td>
                                    <td>Pagado</td>
                                </tr>
                                <tr>
                                    <td>Factura</td>
                                    <td>FE-00096</td>
                                    <td>FERREMAX S.A.C.</td>
                                    <td>20513122871</td>
                                    <td>03/01/2020</td>
                                    <td>05/01/2020</td>
                                    <td>200</td>
                                    <td>Pagado</td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" >Ant.</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Sig.</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
    </div>

@endsection
