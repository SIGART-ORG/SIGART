@extends( 'mintos.main' )
@section( 'content' )
    @include( 'mintos.inc.inc-breadcrumb' )
    {{-- contenido de tu vista --}}
    <div class="container" style="max-width: 1600px !important;">
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Reportes de solicitudes aprobadas</h5>
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
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Cliente</th>
                                    <th>Nro Doc</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Fecha Derivación</th>
                                    <th>Servicio</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>SOL-SER-98</td>
                                    <td>Santos Amado Geronimo Villanueva</td>
                                    <td>18070930</td>
                                    <td>10/03/2020</td>
                                    <td>10/03/2020</td>
                                    <td>Servicio de carpintería</td>
                                    <td><label class="badge badge-success">Derivado</label></td>
                                </tr>
                                <tr>
                                    <td>SOL-SER-105</td>
                                    <td>Cristian Jhonn Ignacio Castillo</td>
                                    <td>47694685</td>
                                    <td>09/03/2020</td>
                                    <td>10/03/2020</td>
                                    <td>Servicio de pintura</td>
                                    <td><label class="badge badge-success">Derivado</label></td>
                                </tr>
                                <tr>
                                    <td>SOL-SER-97</td>
                                    <td>Carlos Alberto Moreno Guzman</td>
                                    <td>46684602</td>
                                    <td>07/03/2020</td>
                                    <td>09/03/2020</td>
                                    <td>Colocación de puerta</td>
                                    <td><label class="badge badge-info">Cotizando</label></td>
                                </tr>
                                <tr>
                                    <td>SOL-SER-96</td>
                                    <td>V & V BRAVO S.A.C.</td>
                                    <td>20478154284</td>
                                    <td>06/03/2020</td>
                                    <td>07/03/2020</td>
                                    <td>Recubrimiento tipo concreto</td>
                                    <td><label class="badge badge-info">Cotizando</label></td>
                                </tr>
                                <tr>
                                    <td>SOL-SER-95</td>
                                    <td>Lidia Paula Ramirez Fernandez</td>
                                    <td>47121539</td>
                                    <td>05/03/2020</td>
                                    <td>06/03/2020</td>
                                    <td>Servicio de pintura para puertas</td>
                                    <td><label class="badge badge-info">Cotizando</label></td>
                                </tr>
                                <tr>
                                    <td>SOL-SER-94</td>
                                    <td>V & V BRAVO S.A.C.</td>
                                    <td>20478154284</td>
                                    <td>05/03/2020</td>
                                    <td>06/03/2020</td>
                                    <td>Servicio de pintura</td>
                                    <td><label class="badge badge-info">Cotizando</label></td>
                                </tr>
                                <tr>
                                    <td>SOL-SER-90</td>
                                    <td>V & V BRAVO S.A.C.</td>
                                    <td>20478154284</td>
                                    <td>05/03/2020</td>
                                    <td>06/03/2020</td>
                                    <td>Microcemento texturado</td>
                                    <td><label class="badge badge-info">Cotizando</label></td>
                                </tr>
                                <tr>
                                    <td>SOL-SER-89</td>
                                    <td>V & V BRAVO S.A.C.</td>
                                    <td>20478154284</td>
                                    <td>05/03/2020</td>
                                    <td>06/03/2020</td>
                                    <td>Servicio de pintura - Obra Veramar</td>
                                    <td><label class="badge badge-info">Cotizando</label></td>
                                </tr>
                                <tr>
                                    <td>SOL-SER-86</td>
                                    <td>Leonela Vicenta Rupay Gutierrez</td>
                                    <td>46203289</td>
                                    <td>05/03/2020</td>
                                    <td>06/03/2020</td>
                                    <td>Servicio de mantenimiento de puertas</td>
                                    <td><label class="badge badge-info">Cotizando</label></td>
                                </tr>
                                <tr>
                                    <td>SOL-SER-83</td>
                                    <td>CENTRO DE PODOLOGIA A & K E.I.R.L.</td>
                                    <td>20548255521</td>
                                    <td>05/03/2020</td>
                                    <td>06/03/2020</td>
                                    <td>Servicio de pintura - fachada</td>
                                    <td><label class="badge badge-primary">Cotizado</label></td>
                                </tr>
                                <tr>
                                    <td>SOL-SER-80</td>
                                    <td>Cileny Yudy Zamudio Gonzalez</td>
                                    <td>46437143</td>
                                    <td>05/03/2020</td>
                                    <td>06/03/2020</td>
                                    <td>División con Drywall</td>
                                    <td><label class="badge badge-primary">Cotizado</label></td>
                                </tr>
                                <tr>
                                    <td>SOL-SER-79</td>
                                    <td>Ruth Berioska Ramirez Poma</td>
                                    <td>46879412</td>
                                    <td>05/03/2020</td>
                                    <td>06/03/2020</td>
                                    <td>Servicio de pintura</td>
                                    <td><label class="badge badge-primary">Cotizado</label></td>
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
