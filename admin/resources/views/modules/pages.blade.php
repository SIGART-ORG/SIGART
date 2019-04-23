@extends('main')
@section('contenido')
    @if( $menu == 15 )
        <providers></providers>
    @endif
    @if( $menu == 16 )
        <customers></customers>
    @endif
@endsection