<template>
    <span class="badge" :class="general.class" v-text="general.text"></span>
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
                    case 'service-request':
                        switch ( this.status ) {
                            case 0:
                            case 2:
                                classBadgeText = 'badge-danger';
                                text = 'Anulado';
                                break;
                            case 1:
                                classBadgeText = 'badge-info';
                                text = 'Activo';
                                break;
                            case 3:
                                classBadgeText = 'badge-info';
                                text = 'Cotizando';
                                break;
                            case 4:
                                classBadgeText = 'badge-primary';
                                text = 'Cotizado';
                                break;
                        }
                        break;
                    case 'sale-quotation':
                        switch( this.status ) {
                            case 0:
                                classBadgeText = 'badge-danger';
                                text = 'Anulado';
                                break;
                            case 1:
                                classBadgeText = 'badge-info';
                                text = 'Generado';
                                break;
                            case 2:
                                classBadgeText = 'badge-danger';
                                text = 'Eliminado';
                                break;
                            case 3:
                                classBadgeText = 'badge-info';
                                text = 'Por aprobar ( Administración )';
                                break;
                            case 4:
                                classBadgeText = 'badge-info';
                                text = 'Por aprobar ( Gerencia )';
                                break;
                            case 5:
                                classBadgeText = 'badge-danger';
                                text = 'Anulado( Administración )';
                                break;
                            case 6:
                                classBadgeText = 'badge-info';
                                text = 'Por aprobar ( Cliente )';
                                break;
                            case 7:
                                classBadgeText = 'badge-danger';
                                text = 'Anulado ( Gerencia )';
                                break;
                            case 8:
                                classBadgeText = 'badge-primary';
                                text = 'Aprobado';
                                break;
                            case 9:
                                classBadgeText = 'badge-danger';
                                text = 'Anulado ( Cliente )';
                                break;
                            case 10:
                                classBadgeText = 'badge-danger';
                                text = 'Anulado ( solicitud de cliente )';
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
