@extends('main')
@section('contenido')
    @foreach ($sidebar as $modulo)
        @foreach ($modulo['pages'] as $pages)
<template v-if="menu=={{ $pages['id'] }}">
    <{{ $pages['url'] }} @actualizar_principal="actualizar_principal"></{{ $pages['url'] }}>
</template>
        @endforeach
    @endforeach
@endsection