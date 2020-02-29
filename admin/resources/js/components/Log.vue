<template>
    <div >

        <section class="hk-sec-wrapper">
            <h6 class="hk-sec-title">Listado - <strong v-text="current"></strong></h6>
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group" id="list-tab" role="tablist">
                        <template v-for="file in files">
                            <a class="list-group-item list-group-item-action" :class="{'active text-white': file === current}" v-text="file" @click.prevent="changeFile( file )"></a>
                        </template>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table id="table-log" class="table table-striped mb-8">
                                <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Contexto</th>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="log in logs" :key="log.id">
                                    <td class="nowrap" :class="'text-' + log.level_class">
                                        <span class="fa" :class="'fa-' + log.level_img" aria-hidden="true"></span>&nbsp;&nbsp;{{log.level}}
                                    </td>
                                    <td class="text">{{log.context}}</td>
                                    <td class="date">{{log.date}}</td>
                                    <td class="text">
                                        {{log.text}}
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
    import $jquery from 'jquery';
    import datables from 'datatables';
    import datablesCss from 'datatables.net-bs4';

    export default {
        mounted() {
            this.getLog();
        },
        data() {
            return {
                current: '',
                files: [],
                logs: []
            }
        },
        props: ['filelog'],
        methods: {
            mytable(){
                $jquery(function(){
                    $jquery('#table-log').DataTable({
                        'order': [[ 2, 'desc' ]],
                        'stateSave': true,
                        'language': {
                            paginate: {
                                previous: 'Ant.',
                                next: 'Sig.'
                            }
                        },
                        'stateSaveCallback': function (settings, data) {
                            window.localStorage.setItem('datatable', JSON.stringify(data));
                        },
                        'stateLoadCallback': function (settings) {
                            var data = JSON.parse(window.localStorage.getItem('datatable'));
                            if (data) data.start = 0;
                                return data;
                        }
                    });
                });
            },
            getLog(){
                var urlLog = '/logs/data?l=' + this.filelog;
                axios.get(urlLog).then(response=>{
                    this.logs = response.data.logs;
                    this.files = response.data.files;
                    this.current = response.data.current_file;
                    this.mytable()
                })
            },
            changeFile( file ) {
                window.location = URL_PROJECT + '/logs/dashboard/' + file;
            }
        },
    }
</script>
<style>
    #table-log thead{
        background-color: #20a8d8;
        color: #FFF;
    }
</style>
