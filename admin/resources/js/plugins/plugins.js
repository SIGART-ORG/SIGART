$( document ).ready(function () {

    var btnDownload = $( '.btn-download-excel' );
    var loadService = $( '#load-table-service' );
    var loadCustomer = $( '#load-table-customer' );
    var loadPurchase = $( '#load-table-purchase' );
    var loadServiceRequest = $( '#load-table-service-request' );
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var page = urlParams.get('page');

    var loadReports = function( content, type ) {
        if( content.length > 0 ) {

            var url = '/report/service/';
            switch ( type ) {
                case 'customer':
                    url = '/report/customer/';
                    break
                case 'purchase':
                    url = '/report/purchase/';
                    break
                case 'service-request':
                    url = '/report/service-request/';
                    break;
            }

            $.ajax({
                url: url,
                type: "GET",
                success: function(rptaObjeto) {
                    content.html(rptaObjeto);
                }
            });
        }
    }

    loadReports( loadService, 'service' );
    loadReports( loadCustomer, 'customer' );
    loadReports( loadPurchase, 'purchase' );
    loadReports( loadServiceRequest, 'service-request' );

    btnDownload.on( 'click', function( e ) {
        e.preventDefault();
        var $this = $( this );
        var type = $this.data( 'excel' );

        if( type ) {
            var url = URL_PROJECT + '/report/exports/serviceExcel';

            switch ( type ) {
                case 'customer':
                    url = URL_PROJECT + '/report/exports/customerExcel';
                    break;
                case 'purchase':
                    url = URL_PROJECT + '/report/exports/purchaseExcel';
                    break;
                case 'service-request':
                    url = '/report/exports/serviceRequestExcel';
                    break;
            }

            window.location = url;
        }
    });

});
