@extends( 'mintos.main' )
@section( 'content' )
    @include( 'mintos.inc.inc-breadcrumb' )
    {{-- contenido de tu vista --}}
    <div class="container" style="max-width: 1600px !important;">
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Reportes de solicitudes de requerimientos</h5>
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
                                <button type="button" class="btn btn-success mb-2 btn-download-excel" data-excel="service-request">
                                    <i class="fa fa-fw fa-lg fa-download"></i> Descargar Reporte
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Leyenda</h5>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 table-report w-70">
                                <tbody>
                                <tr>
                                    <td><strong>Ap Adm:</strong></td>
                                    <td>Fecha de aprobación de cotización por parte del área Administración.</td>
                                </tr>
                                <tr>
                                    <td><strong>Ap DG:</strong></td>
                                    <td>Fecha de aprobación de cotización por parte del área Dirección General.</td>
                                </tr>
                                <tr>
                                    <td><strong>Ap C:</strong></td>
                                    <td>Fecha de aprobación de cotización por parte del Cliente.</td>
                                </tr>
                                <tr>
                                    <td><strong>Proceso Cotización:</strong></td>
                                    <td>Número de días que transcurrió, desde que el cliente envió su solicitud de cotización hasta que responde mediante una cotización.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div id="load-table-service-request"></div>
    </div>
@endsection
