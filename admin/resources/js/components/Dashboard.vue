<template>
    <div>
        <d-admin v-if="dashboard === 'admin'"></d-admin>
        <d-operario v-if="dashboard === 'operario'"></d-operario>
    </div>
</template>

<script>
    import DAdmin from './dashboard/dashboard-admin';
    import DOperario from './dashboard/dashboard-operario';
    export default {
        name: "Dashboard",
        data() {
            return {
                dashboard: ''
            }
        },
        components: {
            DAdmin,
            DOperario
        },
        methods: {
            getInformation() {
                let me = this;
                let url = '/information/';
                axios.get( url ).then( function( response ) {
                    let result = response.data;
                    if( result.status ) {
                        me.dashboard = result.template;
                    }
                }).catch( function( errors ) {
                    console.log( errors )
                });
            }
        },
        mounted() {
            this.getInformation();
        }
    }
</script>

<style scoped>

</style>
