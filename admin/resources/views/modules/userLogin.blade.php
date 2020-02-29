@extends('mintos.main')
@section('content')
    @include( 'mintos.inc.inc-breadcrumb' )
    <div id="app" class="container" style="max-width:1600px !important;">
    <section class="hk-sec-wrapper">
        <h5 class="hk-sec-title">Colaboradores</h5>
        <div class="row">
            <div class="col-sm">
                <form class="form-inline">
                    <div class="form-row align-items-left">
                        <div class="col-auto">
                            <input class="form-control" id="buscar" value="{{ $buscar }}" type="text" placeholder="Buscar">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-2" onclick="searchuser()">
                                <i class="fa fa-fw fa-lg fa-search"></i>Buscar
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
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
