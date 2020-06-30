<!-- All JS scripts -->
<script type="application/javascript">
    var URL_PROJECT = '{{ URL::to('/') }}';
    var URL_WEB = '{{ env( 'URL_WEB' ) }}';
    var API_URL = '{{ env( 'API_NOTIFICATION') }}';
</script>
<!-- jQuery -->
<script src="{{ asset( 'assets/vendors/jquery/dist/jquery.min.js' ) }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset( 'assets/vendors/popper.js/dist/umd/popper.min.js' ) }}"></script>
<script src="{{ asset( 'assets/vendors/bootstrap/dist/js/bootstrap.min.js' ) }}"></script>

<!-- Slimscroll JavaScript -->
<script src="{{ asset( 'assets/dist/js/jquery.slimscroll.js' ) }}"></script>

<!-- Fancy Dropdown JS -->
<script src="{{ asset( 'assets/dist/js/dropdown-bootstrap-extended.js' ) }}"></script>

<!-- FeatherIcons JavaScript -->
<script src="{{ asset( 'assets/dist/js/feather.min.js' ) }}"></script>

<!-- Toggles JavaScript -->
<script src="{{ asset( 'assets/vendors/jquery-toggles/toggles.min.js' ) }}"></script>
<script src="{{ asset( 'assets/dist/js/toggle-data.js' ) }}"></script>

<!-- Counter Animation JavaScript -->
<script src="{{ asset( 'assets/vendors/waypoints/lib/jquery.waypoints.min.js' ) }}"></script>
<script src="{{ asset( 'assets/vendors/jquery.counterup/jquery.counterup.min.js' ) }}"></script>

<!-- EChartJS JavaScript -->
<script src="{{ asset( 'assets/vendors/echarts/dist/echarts-en.min.js' ) }}"></script>

<!-- Owl JavaScript -->
<script src="{{ asset( 'assets/vendors/owl.carousel/dist/owl.carousel.min.js' ) }}"></script>

<!-- Toastr JS -->
<script src="{{ asset( 'assets/vendors/jquery-toast-plugin/dist/jquery.toast.min.js' ) }}"></script>

<!-- Init JavaScript -->
<script src="{{ asset( 'assets/dist/js/init.js' ) }}"></script>

@if( $moduleDB !== '' )
    <script src="{{ mix( 'js/modules/manifest.js' ) }}"></script>
    <script src="{{ mix( 'js/modules/vendor.js' ) }}"></script>
    <script src="{{ mix( 'js/modules/' . $moduleDB . '.min.js' )}}"></script>

@else
    <script src="{{ asset( 'assets/dist/js/dashboard4-data.js' ) }}"></script>
@endif
@if( $menu === 13 )
    <script src="{{ mix( 'js/login-colaborator.min.js' ) }}"></script>
@endif

<script src="{{ asset( 'notification/js/main.js' )}}"></script>
@if( $menu === 43 || $menu === 44 || $menu === 42 || $menu === 45 )
<script src="{{ asset( 'js/plugins/manifest.js' )}}"></script>
<script src="{{ asset( 'js/plugins/vendor.js' )}}"></script>
<script src="{{ asset( 'js/plugins/dpintart.js' )}}"></script>
@endif
