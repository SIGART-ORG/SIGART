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
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" >Ant.</a>
                            </li>
                            @for($page = $paginate['from']; $page<=$paginate['to']; $page++)
                            <li class="page-item active">
                                <a class="page-link" href="#">{{$page}}</a>
                            </li>
                            @endfor
                            
                            <li class="page-item">
                                <a class="page-link" href="#">Sig.</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>

