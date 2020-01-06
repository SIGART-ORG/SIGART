<template>
    <span class="badge" :class="general.class">{{ general.text }}</span>
</template>

<script>
    export default {
        name: "status",
        props: [
            'section',
            'status'
        ],
        computed: {
            general() {
                let classBadgeText = '';
                let text = '';

                switch ( this.section ) {
                    case 'service':
                        switch ( this.status ) {
                            case 1:
                                classBadgeText = 'badge-info';
                                text = 'Por aprobar';
                                break;
                            case 3:
                                classBadgeText = 'badge-warning';
                                text = 'Por iniciar';
                                break;
                            case 4:
                                classBadgeText = 'badge-success';
                                text = 'En proceso';
                                break;
                            case 5:
                                classBadgeText = 'badge-danger';
                                text = 'Terminado';
                                break;
                            case 6:
                                classBadgeText = 'badge-primary';
                                text = 'Pagado';
                                break;
                        }
                        break;
                    case 'stage':
                        switch ( this.status ) {
                            case 0:
                                classBadgeText = 'badge-danger';
                                text = 'Desactivado';
                                break;
                            case 1:
                                classBadgeText = 'badge-info';
                                text = 'Por iniciar';
                                break;
                            case 2:
                                classBadgeText = 'badge-danger';
                                text = 'Eliminado';
                                break;
                        }
                        break;
                    case 'task':
                        switch ( this.status ) {
                            case 0:
                                classBadgeText = 'badge-danger';
                                text = 'Desactivado';
                                break;
                            case 1:
                                classBadgeText = 'badge-primary';
                                text = 'Por iniciar';
                                break;
                            case 2:
                                classBadgeText = 'badge-danger';
                                text = 'Eliminado';
                                break;
                            case 3:
                                classBadgeText = 'badge-info';
                                text = 'En proceso';
                                break;
                            case 4:
                                classBadgeText = 'badge-success';
                                text = 'Terminado';
                                break;
                            case 5:
                                classBadgeText = 'badge-warning';
                                text = 'Observado';
                                break;
                            case 6:
                                classBadgeText = 'badge-primary';
                                text = 'Cerrado';
                                break;
                        }
                        break;
                }
                return {
                    class: classBadgeText,
                    text: text
                };
            }
        }
    }
</script>

<style scoped>

</style>
