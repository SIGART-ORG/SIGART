<template>
    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
        <h6 class="dropdown-header">
            Notificationes&nbsp;&nbsp;<strong v-if="lastsNotifications.length > 0">({{ lastsNotifications.length }})</strong>
            <a href="/notifications/dashboard" class="">Ver todas</a>
        </h6>
        <div class="notifications-nicescroll-bar">
            <template v-for="not in lastsNotifications">
                <a :href="not.readLink" class="dropdown-item">
                    <div class="media">
                        <div class="media-img-wrap">
                            <div class="avatar avatar-sm">
                            <span class="avatar-text avatar-text-success rounded-circle">
                                <span class="initial-wrap">
                                    <span>{{ not.customerFrom.name.substring(2, 0) }}</span>
                                </span>
                            </span>
                            </div>
                        </div>
                        <div class="media-body">
                            <div>
                                <div class="notifications-text">
                                    {{ not.message }}
                                </div>
                                <div class="notifications-time">{{ not.diff }}</div>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NotificationList",
        created() {
            this.$store.dispatch('loadlastNotifications' );
        },
        computed: {
            lastsNotifications: {
                get: function () {
                    return this.$store.state.Notification.lastsNotifications;
                }
            }
        }
    }
</script>

<style scoped>

</style>
