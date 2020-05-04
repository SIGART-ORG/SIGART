$(document).ready(function(){
	$.ajax({
            url: "/report/purchase/",
            type: "GET",
            success: function(rptaObjeto) {
                $("#load-table-purchase").html(rptaObjeto);
            }
            
        });
})