$(document).ready(function(){var e=$(".btn-download-excel"),r=$("#load-table-service"),c=$("#load-table-customer"),a=$("#load-table-purchase"),t=window.location.search,o=new URLSearchParams(t).get("page");console.log(o);var s=function(e,r){if(e.length>0){var c="/report/service/";switch(r){case"customer":c="/report/customer/";break;case"purchase":c="/report/purchase/"}$.ajax({url:c,type:"GET",success:function(r){e.html(r)}})}};s(r,"service"),s(c,"customer"),s(a,"purchase"),e.on("click",function(e){e.preventDefault();var r=$(this).data("excel");if(r){var c=URL_PROJECT+"/report/exports/serviceExcel";switch(r){case"customer":c=URL_PROJECT+"/report/exports/customerExcel";break;case"purchase":c=URL_PROJECT+"/report/exports/purchaseExcel"}window.location=c}})});
