$(document).ready(function(){
	$.ajax({
            url: "/report/service/",
            type: "GET",
            success: function(rptaObjeto) {
                $("#load-table-service").html(rptaObjeto);
            }
            
        });
})