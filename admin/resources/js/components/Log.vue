<template>
    <div >

        <section class="hk-sec-wrapper">
            <h6 class="hk-sec-title">Listado</h6>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table id="table-log" class="table  mb-8">
                                <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Context</th>
                                    <th>Date</th>
                                    <th>Content</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="log in logs" :key="log.id">
                                    <td class="nowrap">
                                        <span class="fa" aria-hidden="true"></span>&nbsp;&nbsp;{{log.level}}
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
                logs: []
            }
        },
        methods: {
            mytable(){
                $jquery(function(){
                    $jquery('#table-log').DataTable({
                        "order": [[ 2, "desc" ]],
                        "stateSave": true,
                        "language": {
                            paginate: {
                                previous: "Ant.",
                                next: "Sig."
                            }
                        },
                        "stateSaveCallback": function (settings, data) {
                            window.localStorage.setItem("datatable", JSON.stringify(data));
                        },
                        "stateLoadCallback": function (settings) {
                            var data = JSON.parse(window.localStorage.getItem("datatable"));
                            if (data) data.start = 0;
                                return data;
                        }
                    });
                });
            },
            getLog(){
                var urlLog = "data"
                axios.get(urlLog).then(response=>{
                    this.logs = response.data.logs;
                    this.mytable()
                })
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
