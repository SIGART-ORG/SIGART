@extends('main')
@section('contenido')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Colaboradores</h3>
                <div class="tile-body">
                    <form class="row">
                        <div class="form-group col-md-6">
                            <input class="form-control" id="buscar" value="{{ $buscar }}" type="text" placeholder="Buscar">
                        </div>
                        <div class="form-group col-md-3 align-self-end">
                            <button class="btn btn-primary" type="button" onclick="searchuser()">
                                <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Usuarios</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre(s) y Apellidos</th>
                            <th>DNI</th>
                            <th>Correo</th>
                            <th># Celular</th>
                            <th>Rol</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $data['records'] as $user )
                        <tr>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" onclick="loginUser( {{ $user->id }} )">
                                    <i class="fa fa-sign-in"></i>
                                </button>
                            </td>
                            <td>{{ $user->name }} {{ $user->last_name }}</td>
                            <td>{{ $user->document }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->role_name }}</td>
                            <td>
                                @if( $user->status == 1 )
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Desactivado</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{--<nav aria-label="Page navigation example">--}}
                    {{--<ul class="pagination">--}}
                        {{--<li class="page-item" v-if="pagination.current_page > 1">--}}
                            {{--<a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1, buscar)">Ant.</a>--}}
                        {{--</li>--}}
                        {{--<li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">--}}
                            {{--<a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar)" v-text="page"></a>--}}
                        {{--</li>--}}
                        {{--<li class="page-item" v-if="pagination.current_page < pagination.last_page">--}}
                            {{--<a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1, buscar)">Sig.</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</nav>--}}
            </div>
        </div>
    </div>
@endsection
