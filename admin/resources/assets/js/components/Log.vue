<template>
    <main class="main">
    <table class="table" id="tblLog">
            <thead>
                <tr>
                    <th>Level</th>
                    <th>date</th>
                    <th>content</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for = "log in logs">
                    <td>{{log.level}}</td>
                    <td>{{log.date}}</td>
                    <td>{{log.text}}</td>
                </tr>
            </tbody>
    </table>
    </main>
</template>
<script>
    import datables from 'datatables'

    export default {
        mounted() {
            this.getLog();
                console.log('holaa')
        },
        data() {
            return {
                logs: []
            }
        },
        methods: {
            mytable(){
                $(function(){
                    $('#tblLog').DataTable();
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
