$(document).ready(function(){
	$.ajax({
            url: "/report/customer/",
            type: "GET",
            success: function(rptaObjeto) {
                $("#load-table-customer").html(rptaObjeto);
            }

        });
})
