<template>
    <section class="hk-sec-wrapper">
        <h5 class="hk-sec-title">Solicitud de compra - Detalle</h5>
        <div class="row">
            <div class="col-sm">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" :class="navtab === 'req' ? 'active' : ''" href="#" @click="changeTab( 'req' )">Requerimientos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" :class="navtab === 'solc' ? 'active' : ''" href="#" @click="changeTab( 'solc' )">Solic. Enviadas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" :class="navtab === 'quo' ? 'active' : ''" href="#" @click="changeTab( 'quo' )">Cotizaciones</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row" v-if="navtab === 'req'">
            <div class="col-12">
                <div class="tile">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">Item</th>
                                <th class="text-center">Categoría</th>
                                <th class="text-center" colspan="2">Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Unidad</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="navtab === 'solc'">
            Solic enviadas
        </div>
        <div class="row" v-if="navtab === 'quo'">
            contizaciones
        </div>
    </section>
</template>

<script>
    export default {
        name: "pr-detail",
        data() {
            return {
                navtab: 'req',
            }
        },
        methods: {
            list() {

            },
            changeTab( tab ) {
                this.navtab = tab;
            }
        },
        mounted() {
            this.list();
        }
    }
</script>

<style scoped>

</style>
