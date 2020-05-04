<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Generar cotización</h5>
        </section>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Listado</h5>

            <div class="row">
                <div class="col-sm">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" :class="sidebar === 'information' ? 'active' : ''" href="#information" @click="changeSideBar( 'information' )">Información</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" :class="sidebar === 'summary' ? 'active' : ''" href="#resumen" @click="changeSideBar( 'summary' )">Resumen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" :class="sidebar === 'list-materials' ? 'active' : ''" href="#resumen" @click="changeSideBar( 'list-materials' )">Generar Listado</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><hr/></div>
            </div>
            <div class="row">
                <sr-information v-if="sidebar === 'information'" :service="service"></sr-information>
                <sr-summary v-if="sidebar === 'summary'" :service="service"></sr-summary>
                <sr-list-materials v-if="sidebar === 'list-materials'" :service="service"></sr-list-materials>
            </div>
        </section>
    </div>
</template>

<script>
    import srInformation from "./service_request/sr_information";
    import srSummary from "./service_request/sr_summary";
    import srListMaterials from "./service_request/sr_list-materials";

    export default {
        name: "list-material-services",
        props: ['service'],
        data() {
            return {
                sidebar: 'information',
            }
        },
        components: {
            srInformation,
            srSummary,
            srListMaterials
        },
        methods: {
            changeSideBar(newSideBar) {
                if (newSideBar !== this.sidebar) {
                    this.sidebar = newSideBar;
                }
            },
        },
    }
</script>

<style scoped>

</style>
