@extends( 'mintos.main' )
@section( 'content' )
    @include( 'mintos.inc.inc-breadcrumb' )
    <div class="container" style="max-width: 1600px !important;">
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Reportes de servicios</h5>
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
                                    <th>Correlativo</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Ruc</th>
                                    <th>Monto Total</th>
                                    <th>Monto Pagado</th>
                                    <th>Tareas</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>SERV-001</td>
                                    <td>2019-12-02</td>
                                    <td>FABRICACION DE MUEBLES Y SERVICIOS FERNANDEZ EIRL - FAMYSERFE EIRL</td>
                                    <td>20131143584</td>
                                    <td>500</td>
                                    <td>100</td>
                                    <td>1</td>
                                    <td>por iniciar</td>

                                </tr>
                                <tr>
                                    <td>SERV-002</td>
                                    <td>2019-12-02</td>
                                    <td>FERREMAX S.A.C.</td>
                                    <td>20513122871</td>
                                    <td>500</td>
                                    <td>150</td>
                                    <td>3</td>
                                    <td>por iniciar</td>

                                </tr>
                                <tr><td>SERV-003</td>
                                    <td>2019-12-03</td>
                                    <td>HERRAMIENTAS, FIERROS Y CARPINTERIA S.A.C. </td>
                                    <td>20502615140</td>
                                    <td>300</td>
                                    <td>0</td>
                                    <td>2</td>
                                    <td>en proceso</td></tr>
                                <tr>
                                    <td>SERV-004</td>
                                    <td>2019-12-03</td>
                                    <td>IMK MADERAS S.A.C.</td>
                                    <td>20509413291</td>
                                    <td>1000</td>
                                    <td>300</td>
                                    <td>1</td>
                                    <td>en proceso</td>
                                </tr>
                                <tr>
                                    <td>SERV-005</td>
                                    <td>2019-12-05</td>
                                    <td>PINTURAS INTERNATIONAL PERU SOCIEDAD ANONIMA CERRADA - PINTER PERU S.A.C.</td>
                                    <td>20501578143</td>
                                    <td>700</td>
                                    <td>200</td>
                                    <td>1</td>
                                    <td>en proceso</td>
                                </tr>
                                <tr>
                                    <td>SERV-006</td>
                                    <td>2019-01-04</td>
                                    <td>MATERIALES EMPAQUETADURAS SEGURIDAD SRL - RUC</td>
                                    <td>20128320106</td>
                                    <td>200</td>
                                    <td>100</td>
                                    <td>1</td>
                                    <td>en proceso</td>
                                </tr>
                                <tr>
                                    <td>SERV-007</td>
                                    <td>2019-01-05</td>
                                    <td>Polleria Lo De Juan</td>
                                    <td>20128320106</td>
                                    <td>200</td>
                                    <td>100</td>
                                    <td>1</td>
                                    <td>en proceso</td>
                                </tr>
                                <tr>
                                    <td>SERV-008</td>
                                    <td>2019-01-20</td>
                                    <td>EQUIPOS Y HERRAMIENTAS S.A.</td>
									<td>20212334554</td>
                                    <td>200</td>
                                    <td>100</td>
                                    <td>1</td>
                                    <td>en proceso</td>
                                </tr>
                                <tr>
                                    <td>SERV-009</td>
                                    <td>2019-12-02</td>
                                    <td>TIENDAS DEL MEJORAMIENTO DEL HOGAR S.A.</td>
                                    
                                    <td>20112273922</td>
                                    <td>300</td>
                                    <td>120</td>
                                    <td>1</td>
                                    <td>finalizado</td>
                                </tr>
                                <tr>
                                    <td>SERV-0010</td>
                                    <td>2019-02-02</td>
                                    <td>Santos Amado Geronimo Villanueva</td>
                                    <td>700</td>
                                    <td>100</td>
                                    <td>2</td>
                                    <td>terminado</td>
                                </tr>
                                <tr>
                                    <td>SERV-002</td>
                                    <td>2019-03-15</td>
                                    <td>FERREMAX S.A.C.</td>
                                    <td>20513122871</td>
                                    <td>100</td>
                                    <td>350</td>
                                    <td>3</td>
                                    <td>en proceso</td>

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
