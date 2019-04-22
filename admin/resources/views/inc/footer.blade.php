<script type="application/javascript">
    var URL_PROJECT = '{{ URL::to('/') }}';
</script>
<!-- Essential javascripts for application to work-->
<script src="{{ URL::asset( 'js/jquery-3.2.1.min.js' ) }}"></script>
<script src="{{ URL::asset( 'js/popper.min.js' ) }}"></script>
<script src="{{ URL::asset( 'js/bootstrap.min.js' ) }}"></script>
<script src="{{ URL::asset( 'js/main.min.js' ) }}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{{ URL::asset( 'js/plugins/pace.min.js' ) }}"></script>
<!-- Page specific javascripts-->
<script type="text/javascript" src="{{ URL::asset( 'js/plugins/chart.min.js' ) }}"></script>
<script type="text/javascript">
    var data = {
        labels: ["January", "February", "March", "April", "May"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [65, 59, 80, 81, 56]
            },
            {
                label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [28, 48, 40, 19, 86]
            }
        ]
    };
    var pdata = [
        {
            value: 300,
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Complete"
        },
        {
            value: 50,
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "In-Progress"
        }
    ]

    // var ctxl = $("#lineChartDemo").get(0).getContext("2d");
    // var lineChart = new Chart(ctxl).Line(data);

    // var ctxp = $("#pieChartDemo").get(0).getContext("2d");
    // var pieChart = new Chart(ctxp).Pie(pdata);
</script>
<script src="{{ mix( 'js/modules/manifest.js' ) }}"></script>
<script src="{{ mix( 'js/modules/vendor.js' ) }}"></script>
@if( $menu != 13 )
    @if( isset( $moduleDB ) )
        <script src="{{ mix( 'js/modules/'. $moduleDB . '.min.js' ) }}"></script>
    @else
    <script src="{{ mix( 'js/modules/dashboard.min.js' ) }}"></script>
    @endif
@else
    <script src="{{ mix( 'js/login-colaborator.min.js' ) }}"></script>
@endif
