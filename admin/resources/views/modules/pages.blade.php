@extends('main')
@section('contenido')
    @switch( $menu )
        @case( $menu == 11)
            <unity></unity>
            @break
        @case( $menu == 15 )
            <providers></providers>
            @break
        @case( $menu == 16 )
            <customers></customers>
            @break
        @case( $menu == 17 )
            <stock></stock>
            @break
        @case( $menu == 18 )
            <purchase-request></purchase-request>
            @break
        @case( $menu == 19 )
            <quotation></quotation>
            @break
    @endswitch
@endsection