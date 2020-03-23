<section class="hk-sec-wrapper">
            <h6 class="hk-sec-title">Listado</h6>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                	<th>Nombre y Apellidos</th>
                                    <th>Tipo. Doc</th>
                                    <th>Nro. Doc</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $customer)
                                <tr>
                                    <td>{{$customer->name}} {{$customer->lastname}}</td>
                                    <td>{{$customer->typeDocument}}</td>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->email}}</td>

                                    <td>

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
                    @for($page = 1; $page<=$paginate['last_page']; $page++)
                    <li @if($paginate['current_page'] == $page)  class="page-item active " @else  class="page-item " @endif>
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
