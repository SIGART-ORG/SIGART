<section class="hk-sec-wrapper">
            <h6 class="hk-sec-title">Listado</h6>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
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
                                    @foreach($services as $service)
                                    <tr>
                                        <td>{{$service->document}}</td>
                                        <td>{{$service->start}}</td>
                                        <td>{{$service->end}}</td>
                                        <td>{{$service->customer->name}}</td>
                                        <td>{{$service->total}}</td>
                                        <td>{{$service->payment}}</td>
                                        <td>{{$service->tasks->total}}</td>
                                        <td>
                                            @if($service->status==3)
                                            <span class="badge badge-info">{{$service->statusName}}</span>
                                            @endif
                                        </td>
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

