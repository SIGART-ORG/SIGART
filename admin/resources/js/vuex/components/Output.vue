<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Ordenes de Salida</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
<!--                            <div class="col-auto">-->
<!--                                <label class="sr-only" for="searchForm"></label>-->
<!--                                <input type="text" id="searchForm" class="form-control mb-2" placeholder="Buscar"-->
<!--                                       v-model="search" @keyup="list( 1, search )">-->
<!--                            </div>-->
<!--                            <div class="col-auto">-->
<!--                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="list( 1, search )">-->
<!--                                    <i class="fa fa-fw fa-lg fa-search"></i> Buscar-->
<!--                                </button>-->
<!--                            </div>-->
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper">
            <div class="row mb-20">
                <div class="col-sm">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" :class="navtab === 'output-order' ? 'active' : ''" href="#output-order" @click="changeTabv2( 'output-order' )">Ordenes de Salida</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" :class="navtab === 'service-requirement' ? 'active' : ''" href="#service-requirement" @click="changeTabv2( 'service-requirement' )">Solicitudes de requerimientos</a>
                        </li>
                    </ul>
                </div>
            </div>
            <output-order-list v-if="navtab === 'output-order'"></output-order-list>
            <output-order-requirement v-if="navtab === 'service-requirement'"></output-order-requirement>
        </section>
    </div>
</template>

<script>
    import OutputOrderList from './output-order/output-order-list';
    import OutputOrderRequirement from './output-order/output-order-requirement';
    export default {
        name: "Output",
        data() {
            return {
                navtab: 'output-order'
            }
        },
        components: {
            OutputOrderList,
            OutputOrderRequirement
        },
        methods: {
            changeTabv2( newtab ) {
                this.navtab = newtab;
            },
        }
    }
</script>

<style scoped>

</style>
