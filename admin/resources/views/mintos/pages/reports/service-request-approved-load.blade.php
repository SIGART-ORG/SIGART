<section class="hk-sec-wrapper">
    <h6 class="hk-sec-title">Listado</h6>
    <div class="row">
        <div class="col-sm">
            <div class="table-wrap">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 table-report">
                        <thead>
                        <tr>
                            <th colspan="4" class="right bottom">Solicitud de servicio</th>
                            <th colspan="2" class="right bottom">Cliente</th>
                            <th colspan="6" class="right bottom">Cotización</th>
                            <th colspan="5" class="bottom">Servicio</th>
                        </tr>
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Envio</th>
                            <th class="right">Derivado</th>
                            <th>Cliente</th>
                            <th class="right">Nro Doc</th>
                            <th>N°</th>
                            <th>Registro</th>
                            <th>Ap Adm</th>
                            <th>Ap DG</th>
                            <th>Ap C</th>
                            <th class="right">Proceso<br>Cotización</th>
                            <th>N°</th>
                            <th>Total</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($serviceRequests as $serviceRequest)
                        <tr>
                            <td>{{ $serviceRequest->serviceRequest->document }}</td>
                            <td>{{ $serviceRequest->serviceRequest->name }}</td>
                            <td>{{ $serviceRequest->serviceRequest->send }}</td>
                            <td class="right">{{ $serviceRequest->serviceRequest->approved }}</td>
                            <td>@if( !empty($serviceRequest->customer) ) {{ $serviceRequest->customer->name }} @endif</td>
                            <td class="right">@if( !empty($serviceRequest->customer) ) {{ $serviceRequest->customer->document }} @endif</td>
                            <td>@if( !empty($serviceRequest->saleQuotation) ) {{ $serviceRequest->saleQuotation->document }} @endif</td>
                            <td>@if( !empty($serviceRequest->saleQuotation) ) {{ $serviceRequest->saleQuotation->created }} @endif</td>
                            <td>@if( !empty($serviceRequest->saleQuotation) ) {{ $serviceRequest->saleQuotation->approved_adm }} @endif</td>
                            <td>@if( !empty($serviceRequest->saleQuotation) ) {{ $serviceRequest->saleQuotation->approved_dg }} @endif</td>
                            <td>@if( !empty($serviceRequest->saleQuotation) ) {{ $serviceRequest->saleQuotation->approved_customer }} @endif</td>
                            <td class="right text-center">{{ $serviceRequest->dayDiffSR }}</td>
                            <td>@if( !empty($serviceRequest->service) ) {{ $serviceRequest->service->document }} @endif</td>
                            <td>@if( !empty($serviceRequest->service) ) {{ $serviceRequest->service->total }} @endif</td>
                            <td>@if( !empty($serviceRequest->service) ) {{ $serviceRequest->service->start }} @endif</td>
                            <td>@if( !empty($serviceRequest->service) ) {{ $serviceRequest->service->end }} @endif</td>
                            <td>@if( !empty($serviceRequest->service) ) {{ $serviceRequest->service->status }} @endif</td>
                        </tr>
                        @endforeach
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
                    <li class="page-item @if($paginate['current_page'] <= 1) disabled @endif ">
                        <a class="page-link" @if( $paginate['current_page'] > 1 ) href="?page={{ $paginate['current_page'] - 1 }}" @else href="javascript:;" @endif >Ant.</a>
                    </li>
                    @for($page = 1; $page<=$paginate['last_page']; $page++)
                        <li @if($paginate['current_page'] === $page)  class="page-item active " @else  class="page-item " @endif>
                            <a class="page-link" href="?page={{$page}}">{{$page}}</a>
                        </li>
                    @endfor

                    <li class="page-item @if( $paginate['last_page'] === 1 || $paginate['current_page'] === $paginate['last_page']) disabled @endif ">
                        <a class="page-link" @if( $paginate['last_page'] > 1 && $paginate['current_page'] < $paginate['last_page'] ) href="?page={{ $paginate['current_page'] + 1 }}" @else href="javascript:;" @endif >Sig.</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>
