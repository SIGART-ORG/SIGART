@extends('main')
@section('contenido')
<template v-if="menu == 1">
    <modules @update_side_bar="update_side_bar"></modules>
</template>
<template v-if="menu == 2">
    <users></users>
</template>
<template v-if="menu == 3">
    <roles @update_side_bar="update_side_bar"></roles>
</template>
<template v-if="menu == 4">
    <pages @update_side_bar="update_side_bar"></pages>
</template>
<template v-if="menu == 5">
    <access @update_side_bar="update_side_bar"></access>
</template>
<template v-if="menu == 6">
    <icons></icons>
</template>
<template v-if="menu == 7">
    <sites></sites>
</template>
<template v-if="menu == 8">
    <categories></categories>
</template>
<template v-if="menu == 9">
    <holidays></holidays>
</template>
<template v-if="menu == 10">
    <calendar></calendar>
</template>
@endsection