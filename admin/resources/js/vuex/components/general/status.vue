<template>
    <span class="badge" :class="classBadge">{{ textSpan }}</span>
</template>

<script>
    export default {
        name: "status",
        props: [
            'section',
            'status'
        ],
        computed: {
            classBadge() {
                let classBadgeText = '';

                switch ( this.section ) {
                    case 'service':
                        switch ( this.status ) {
                            case 1:
                                classBadgeText = 'badge-info';
                                break;
                            case 2:
                                classBadgeText = 'badge-primary';
                                break;
                        }
                        break;
                }
                return classBadgeText;
            },
            textSpan() {
                let text = '';
                switch ( this.section ) {
                    case 'service':
                        switch ( this.status ) {
                            case 1:
                                text = 'Por aprobar';
                                break;
                            case 2:
                                text = 'Por iniciar'
                        }
                        break;
                }
                return text;
            }
        }
    }
</script>

<style scoped>

</style>
