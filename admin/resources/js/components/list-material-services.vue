<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Generar cotización</h5>
        </section>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Listado</h5>

            <div class="row">
                <div class="col-md-3">
                    <div style="border: 1px solid #CFCFCF; padding: 10px;">
                        <h6 class="hk-sec-title">Operaciones</h6>
                        <div class="list-group">
                            <a href="#" class="list-group-item  list-group-item-action"
                               :class="sidebar === 'information' ? 'active': ''"
                               @click.prevent="changeSideBar( 'information' )">Información</a>
                            <a href="#" class="list-group-item  list-group-item-action"
                               :class="sidebar === 'summary' ? 'active': ''"
                               @click.prevent="changeSideBar( 'summary' )">Resumen</a>
                            <a href="#" class="list-group-item  list-group-item-action"
                               :class="sidebar === 'list-materials' ? 'active': ''"
                               @click.prevent="changeSideBar( 'list-materials' )">Generar Listado</a>
                        </div>
                    </div>
                </div>
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
