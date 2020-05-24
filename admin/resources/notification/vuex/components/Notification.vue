<template>
    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="feather-icon">
            <i data-feather="bell"></i>
        </span>
        <span v-if="lastsNotifications.length > 0" class="badge-wrap">
            <span class="badge badge-primary badge-indicator badge-indicator-sm badge-pill pulse"></span>
        </span>
    </a>
</template>

<script>
    import io from 'socket.io-client';
    const socket = io( API_URL );
    export default {
        name: "Notification",
        computed: {
            lastsNotifications: {
                get: function () {
                    return this.$store.state.Notification.lastsNotifications;
                }
            }
        },
        created() {
            this.changeAdmin( this.$userId );
            this.notificationServer();
        },
        methods: {
            notificationServer() {
                let me = this;
                socket.on( 'read-notification-admin', function( data ) {
                    if( data.id > 0 ) {
                        me.$store.dispatch('loadlastNotifications' );
                    }
                });
            },
            changeAdmin( admin ) {
                socket.emit( 'change_admin', {adminId: admin });
            }
        }
    }
</script>

<style scoped>

</style>
