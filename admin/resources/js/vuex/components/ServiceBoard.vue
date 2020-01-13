<template>
    <section class="hk-sec-wrapper">
        <div class="row">
            <div clas="col-12">
                <h2 class="hk-sec-title pl-15">Tablerto - SER1-1: Pintado de puertas</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <h3 clas="hk-sec-title">Por iniciar</h3>
                <draggable class="list-group mt-20" :list="list1" group="people" @change="log">
                    <div class="list-group-item" v-for="(element, index) in list1"
                        :key="element.id">
                        <h4 class="list-group-item-heading">
                            <small class="text-warning small-icon-short"><i class="fa fa-hourglass"></i></small>&nbsp;{{ element.name }}
                        </h4>
                        <p class="list-group-item-text"><span class="badge badge-warning">Etapa1</span></p>
                        <p class="list-group-item-text">Lorem Ipsum is simply dummy text of the printing and...</p>
                        <p class="list-group-item-text">
                            <span class="badge badge-warning">
                                <i class="fa fa-hourglass"></i>&nbsp;09/01/2020 - 31/01/2019
                            </span>
                        </p>
                        <p class="list-group-item-text">
                            <i class="fa fa-users"></i>&nbsp;5
                            &nbsp;|&nbsp;
                            <i class="fa fa-comment"></i>&nbsp;45
                        </p>
                    </div>
                </draggable>
            </div>
            <div class="col-3">
                <h3 clas="hk-sec-title">En Proceso</h3>
                <draggable class="list-group mt-20" :list="list2" group="people" @change="log">
                    <div class="list-group-item" v-for="(element, index) in list2"
                        :key="element.id">
                        <h4 class="list-group-item-heading">Tarea 1 {{ element.name }}</h4>
                        <p class="list-group-item-text"><span class="badge badge-info">Etapa1</span></p>
                        <p class="list-group-item-text">Lorem Ipsum is simply dummy text of the printing and...</p>
                        <p class="list-group-item-text">
                            <span class="badge badge-info">
                                <i class="fa fa-hourglass"></i>&nbsp;09/01/2020 - 31/01/2019
                            </span>
                        </p>
                        <p class="list-group-item-text">
                            <i class="fa fa-users"></i>&nbsp;5
                            &nbsp;|&nbsp;
                            <i class="fa fa-comment"></i>&nbsp;45
                        </p>
                    </div>
                </draggable>
            </div>
            <div class="col-3">
                <h3 clas="hk-sec-title">Finalizado</h3>
                <draggable class="list-group mt-20" :list="list3" group="people" @change="log">
                    <div class="list-group-item" v-for="(element, index) in list3"
                        :key="element.id">
                        <h4 class="list-group-item-heading">Tarea 1 {{ element.name }}</h4>
                        <p class="list-group-item-text"><span class="badge badge-primary">Etapa1</span></p>
                        <p class="list-group-item-text">Lorem Ipsum is simply dummy text of the printing and...</p>
                        <p class="list-group-item-text">
                            <span class="badge badge-primary">
                                <i class="fa fa-hourglass"></i>&nbsp;09/01/2020 - 31/01/2019
                            </span>
                        </p>
                        <p class="list-group-item-text">
                            <i class="fa fa-users"></i>&nbsp;5
                            &nbsp;|&nbsp;
                            <i class="fa fa-comment"></i>&nbsp;45
                        </p>
                    </div>
                </draggable>
            </div>
            <div class="col-3">
                <h3 clas="hk-sec-title">Observado</h3>
                <draggable class="list-group mt-20" :list="list4" group="people" @change="log">
                    <div class="list-group-item" v-for="(element, index) in list4"
                        :key="element.id">
                        <h4 class="list-group-item-heading">Tarea 1 {{ element.name }}</h4>
                        <p class="list-group-item-text"><span class="badge badge-danger">Etapa1</span></p>
                        <p class="list-group-item-text">Lorem Ipsum is simply dummy text of the printing and...</p>
                        <p class="list-group-item-text">
                            <span class="badge badge-danger">
                                <i class="fa fa-hourglass"></i>&nbsp;09/01/2020 - 31/01/2019
                            </span>
                        </p>
                        <p class="list-group-item-text">
                            <i class="fa fa-users"></i>&nbsp;5
                            &nbsp;|&nbsp;
                            <i class="fa fa-comment"></i>&nbsp;45
                        </p>
                    </div>
                </draggable>
            </div>
        </div>
    </section>
</template>

<script>
    import draggable from 'vuedraggable';

    export default {
        name: "ServiceBoard",
        data() {
            return {
                list1: [
                    { name: "John", id: 1 },
                    { name: "Joao", id: 2 },
                    { name: "Jean", id: 3 },
                    { name: "Gerard", id: 4 }
                ],
                list2: [
                    { name: "Juan", id: 5 },
                    { name: "Edgard", id: 6 },
                    { name: "Johnson", id: 7 }
                ],
                list3: [
                    { name: "Johnson", id: 8 }
                ],
                list4: [

                ]
            }
        },
        components: {
            draggable
        },
        methods: {
            add: function() {
                this.list.push({ name: "Juan" });
            },
            replace: function() {
                this.list = [{ name: "Edgard" }];
            },
            clone: function(el) {
                return {
                    name: el.name + " cloned"
                };
            },
            log: function(evt) {
                window.console.log(evt);
            }
        }
    }
</script>

<style scoped>
    .small-icon-short {
        font-size: 15px;
    }
</style>
