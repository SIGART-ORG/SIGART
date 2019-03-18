<template>
   <main class="main">
    <div class="container-fluid">
        <table id="table-log" class="display table table-striped">
          <thead>
          <tr>
              <th>Level</th>
              <th>Context</th>
              <th>Date</th>
              <th>Content</th>
          </tr>
          </thead>
          <tbody>


            <tr v-for="log in logs" :key="log.id" >
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
    </main>
</template>
<script>
    import $jquery from 'jquery';
    import datables from 'datatables';

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
