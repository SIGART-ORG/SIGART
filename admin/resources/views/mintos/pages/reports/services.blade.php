@extends( 'mintos.main' )
@section( 'content' )
    @include( 'mintos.inc.inc-breadcrumb' )
    {{-- contenido de tu vista --}}
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
                                    <th>SERVICIO</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Cliente</th>
                                    <th>Monto Total (S/)</th>
                                    <th>Monto Pagado (S/)</th>
                                    <th>Tareas</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>SERV-68</td>
                                    <td>19/03/2020</td>
                                    <td>19/03/2020</td>
                                    <td>Ivan Huapaya</td>
                                    <td>200.00</td>
                                    <td>100.00</td>
                                    <td>0/1</td>
                                    <td><span class="badge badge-info">por iniciar</span></td>
                                </tr>
                                <tr>
                                    <td>SERV-67</td>
                                    <td>18/03/2020</td>
                                    <td>16/03/2020</td>
                                    <td>Mayra Huaman Flores</td>
                                    <td>500.00</td>
                                    <td>250.00</td>
                                    <td>0/3</td>
                                    <td><span class="badge badge-info">por iniciar</span></td>
                                </tr>
                                <tr>
                                    <td>SERV-66</td>
                                    <td>16/03/2020</td>
                                    <td>16/03/2020</td>
                                    <td>Avicola Marlene</td>
                                    <td>300.00</td>
                                    <td>0.00</td>
                                    <td>0/2</td>
                                    <td><span class="badge badge-warning">Falta adelanto</span></td>
                                </tr>
                                <tr>
                                    <td>SERV-65</td>
                                    <td>08/03/2020</td>
                                    <td>15/03/2020</td>
                                    <td>Mercado 1ro de Mayo</td>
                                    <td>1000.00</td>
                                    <td>550.00</td>
                                    <td>3/6</td>
                                    <td><span class="badge badge-success">en proceso</span></td>
                                </tr>
                                <tr>
                                    <td>SERV-64</td>
                                    <td>09/03/2020</td>
                                    <td>13/03/2020</td>
                                    <td>Colegio Cap. Enrique Openheimer</td>
                                    <td>700.00</td>
                                    <td>350.00</td>
                                    <td>1/5</td>
                                    <td><span class="badge badge-success">en proceso</span></td>
                                </tr>
                                <tr>
                                    <td>SERV-63</td>
                                    <td>11/03/2020</td>
                                    <td>12/03/2020</td>
                                    <td>Marilu Flores</td>
                                    <td>200.00</td>
                                    <td>100.00</td>
                                    <td>2/4</td>
                                    <td><span class="badge badge-success">en proceso</span></td>
                                </tr>
                                <tr>
                                    <td>SERV-62</td>
                                    <td>07/03/2020</td>
                                    <td>06/03/2020</td>
                                    <td>Polleria Lo De Juan</td>
                                    <td>200.00</td>
                                    <td>100.00</td>
                                    <td>1/1</td>
                                    <td><span class="badge badge-orange">Terminado</span></td>
                                </tr>
                                <tr>
                                    <td>SERV-61</td>
                                    <td>02/03/2020</td>
                                    <td>07/03/2020</td>
                                    <td>Centro de Podologia Integral</td>
                                    <td>800.00</td>
                                    <td>400.00</td>
                                    <td>5/5</td>
                                    <td><span class="badge badge-blue">finalizado</span></td>
                                </tr>
                                <tr>
                                    <td>SERV-60</td>
                                    <td>02/03/2020</td>
                                    <td>03/03/2020</td>
                                    <td>Luis Gustavo Geronimo Huaman</td>
                                    <td>300.00</td>
                                    <td>160.00</td>
                                    <td>3/3</td>
                                    <td><span class="badge badge-blue">finalizado</span></td>
                                </tr>
                                <tr>
                                    <td>SERV-59</td>
                                    <td>24/02/2020</td>
                                    <td>29/02/2020</td>
                                    <td>Santos Amado Geronimo Villanueva</td>
                                    <td>900.00</td>
                                    <td>900.00</td>
                                    <td>1/7</td>
                                    <td><span class="badge badge-primary">Pagado</span></td>
                                </tr>
                                <tr>
                                    <td>SERV-58</td>
                                    <td>27/02/2020</td>
                                    <td>27/02/2020</td>
                                    <td>Cristian jhonn ignacio castillo</td>
                                    <td>100.00</td>
                                    <td>100.00</td>
                                    <td>1/1</td>
                                    <td><span class="badge badge-primary">Pagado</span></td>
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
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
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
