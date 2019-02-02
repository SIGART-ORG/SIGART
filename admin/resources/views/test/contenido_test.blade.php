@extends('test.main_test')
@section('contenido_test')
    <template v-if="menu==0">
        <h1>Contenido del menú 1</h1>
    </template>
    <template v-if="menu==1">
        <roles></roles>
    </template>
    <template v-if="menu==2">
        <users></users>
    </template>
@endsection