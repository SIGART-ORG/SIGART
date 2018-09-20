@extends('main')
@section('contenido')
<template v-if="menu == 1">
    <modules @update_side_bar="update_side_bar"></modules>
</template>
<template v-if="menu == 2">
    <users></users>
</template>
<template v-if="menu == 3">
    <roles></roles>
</template>
<template v-if="menu == 4">
    <pages @update_side_bar="update_side_bar"></pages>
</template>
<template v-if="menu == 5">
    <access></access>
</template>
@endsection