@extends('main')
@section('contenido')
<template v-if="menu==0">
    <h1>Contenido del menú 1</h1>
</template>
<template v-if="menu==1">
    <roles></roles>
</template>
<template v-if="menu==2">
    <users></users>
</template>
<template v-if="menu==3">
    <modules></modules>
</template>
@endsection