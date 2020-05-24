<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Notificaciones</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input type="text" v-model="search" @keyup="list( 1 )" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="list( 1 )">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper">
            <h6 class="hk-sec-title">Listado</h6>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Notificación</th>
                                    <th>F. Envio</th>
                                    <th>F. Leído</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in notifications" :key="item.id">
                                        <td v-text="item.customerFrom.name"></td>
                                        <td v-text="item.message"></td>
                                        <td><code v-text="item.dateDelivery"></code></td>
                                        <td><code v-if="item.dateSeen !== '---'" v-text="item.dateSeen"></code></td>
                                        <td>
                                            <span v-if="item.dateSeen !== '---'" class="badge badge-primary">Leído</span>
                                            <span v-else class="badge badge-secondary">Sin Leer</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import {mapMutations} from 'vuex';
    import Notification from "../modules/notification";
    export default {
        name: "Notification",
        computed: {
            search: {
                get: function() {
                    return this.$store.state.Notification.search;
                },
                set: function ( newSearch ) {
                    this.$store.state.Notification.search = newSearch;
                }
            },
            notifications: {
                get: function() {
                    return this.$store.state.Notification.notifications;
                },
                set: function ( newData ) {
                    this.$store.state.Notification.notifications = newData;
                }
            }
        },
        methods: {
            ...mapMutations(['LOAD_NOTIFICATION_LIST']),
            list: function( page = 1 ) {
                this.$store.dispatch( 'loadNotifications' );
            }
        },
        created() {
            this.list();
        }
    }
</script>

<style scoped>

</style>
