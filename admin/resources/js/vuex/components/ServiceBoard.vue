<template>
    <section class="hk-sec-wrapper">
        <div class="row">
            <div clas="col-12">Tablerto 1</div>
        </div>
        <div class="row">
            <div class="col-3">
                <h3 clas="hk-sec-title">Por iniciar</h3>
                <draggable class="list-group" :list="list1" group="people" @change="log">
                    <div class="col-12"
                         v-for="(element, index) in list1"
                         :key="element.id"
                    >
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Tarea 1 {{ element.name }}</div>
                                <p><span class="badge badge-info">Etapa1</span></p>
                            </div>
                            <div class="card-footer">
                                <span class="badge badge-info">
                                    <i class="fa fa-hourglass"></i>&nbsp;09/01/2020 - 31/01/2019
                                </span>
                            </div>
                        </div>
                    </div>
                </draggable>
            </div>
            <div class="col-3">
                <h3 clas="hk-sec-title">En Proceso</h3>
                <draggable class="list-group" :list="list2" group="people" @change="log">
                    <div class="col-12"
                         v-for="(element, index) in list2"
                         :key="element.id"
                    >
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Tarea 1 {{ element.name }}</div>
                                <p><span class="badge badge-info">Etapa1</span></p>
                            </div>
                            <div class="card-footer">
                                <span class="badge badge-info">
                                    <i class="fa fa-hourglass"></i>&nbsp;09/01/2020 - 31/01/2019
                                </span>
                            </div>
                        </div>
                    </div>
                </draggable>
            </div>
            <div class="col-3">
                <h3 clas="hk-sec-title">Terminado</h3>
                <draggable class="list-group" :list="list3" group="people" @change="log">
                    <div class="col-12"
                         v-for="(element, index) in list3"
                         :key="element.id"
                    >
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Tarea 1 {{ element.name }}</div>
                                <p><span class="badge badge-info">Etapa1</span></p>
                            </div>
                            <div class="card-footer">
                                <span class="badge badge-info">
                                    <i class="fa fa-hourglass"></i>&nbsp;09/01/2020 - 31/01/2019
                                </span>
                            </div>
                        </div>
                    </div>
                </draggable>
            </div>
            <div class="col-3">
                <h3 clas="hk-sec-title">Observado</h3>
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

</style>
