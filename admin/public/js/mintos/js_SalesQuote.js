function Mostrar_Datos_Producto(id_prod){

    var s_cantidad = $("#txt_Cant_ADD").val();

    s_cantidad = (s_cantidad == '' || s_cantidad<0) ? '1' : s_cantidad;

    var s_total = 0;
    var s_prevUnit = 0;

    $.ajax({
        url: "/salesquote/searchProduct/",
        data: { x_codigo: id_prod },
        type: "GET",
        dataType: "json",
        success: function(response) {
            
            console.log(response);

            if(id_prod != ''){

                s_prevUnit  = response.vProducto.pricetag_purchase;

                s_total     = s_prevUnit * s_cantidad;
                s_total     = s_total.toFixed(2);

                $("#cbo_Unid_ADD").val(response.vProducto.unity_id);
                $("#txt_PUnit_ADD").val(s_prevUnit);
                $("#txt_Cant_ADD").val(s_cantidad);
                $("#txt_Total_ADD").val(s_total);
                $("#txt_Cant_ADD").focus();    
            }else{
                $("#cbo_Unid_ADD").val('');
                $("#txt_PUnit_ADD").val('');
                $("#txt_Cant_ADD").val('');
                $("#txt_Total_ADD").val('');
            }
            
        }
        
    });

}





function AgregarProducto(){

    var xUltimoItem = $("#txt_tot_det").val();

    var xCodProducto = $("#cbo_Productos_ADD").val();
    var xNomProducto = $("#cbo_Productos_ADD option:selected").text();

    var xCodUnidMed = $("#cbo_Unid_ADD").val();
    var xNomUnidMed = $("#cbo_Unid_ADD option:selected").text();

    var xPreUnit    = $("#txt_PUnit_ADD").val();
    var xCantidad   = $("#txt_Cant_ADD").val();
    var xTotal      = parseFloat($("#txt_Total_ADD").val());

    var xFila = '';

    if(xCodProducto==''){
        alert('Seleccione Producto');
        $("#cbo_Productos_ADD").focus();

    }else if(xCantidad==''){
        alert('Ingrese cantidad');
        $("#txt_Cant_ADD").focus();

    }else{

        xUltimoItem = parseInt(xUltimoItem)+1;

        xFila = xFila+'<tr id="tr_'+xUltimoItem+'">';
        
        xFila = xFila+'<td style="padding: 2px 2px;">';
        xFila = xFila+'<input class="form-control" id="txt_det_cod_'+xUltimoItem+'" type="text" disabled="disabled" value="'+xCodProducto+'">';
        xFila = xFila+'</td>';

        xFila = xFila+'<td style="padding: 2px 2px;">';
        xFila = xFila+'<input class="form-control" id="txt_det_cant_'+xUltimoItem+'" type="text" onkeyup="Calcular_fila(\''+xUltimoItem+'\')" value="'+xCantidad+'" >';
        xFila = xFila+'</td>';

        xFila = xFila+'<td style="padding: 2px 2px;">';
        xFila = xFila+'<select id="cbo_det_unid_'+xUltimoItem+'" class="form-control" disabled="disabled" >';    
        xFila = xFila+'<option value="'+xCodUnidMed+'">'+xNomUnidMed+'</option>';
        xFila = xFila+'</select>';
        xFila = xFila+'</td>';

        xFila = xFila+'<td style="padding: 2px 2px;">';
        xFila = xFila+'<select id="cbo_productos_'+xUltimoItem+'" class="form-control" disabled="disabled" >';    
        xFila = xFila+'<option value="'+xCodProducto+'">'+xNomProducto+'</option>';
        xFila = xFila+'</select>';
        xFila = xFila+'</td>';

        xFila = xFila+'<td style="padding: 2px 2px;">';
        xFila = xFila+'<input class="form-control" id="txt_det_coment_'+xUltimoItem+'" type="text">';
        xFila = xFila+'</td>';


        xFila = xFila+'<td style="padding: 2px 2px;">';
        xFila = xFila+'<input class="form-control" id="txt_det_pv_'+xUltimoItem+'" type="text" disabled="disabled" value="'+xPreUnit+'" >';
        xFila = xFila+'</td>';

        xFila = xFila+'<td style="padding: 2px 2px;">';
        xFila = xFila+'<input class="form-control" id="txt_det_tot_'+xUltimoItem+'" type="text" disabled="disabled" value="'+xTotal+'">';
        xFila = xFila+'</td>';

        xFila = xFila+'<td style="padding: 2px 2px;">';
        xFila = xFila+'<a href="#" id="btn_borrar_'+xUltimoItem+'" class="btn btn-dark" onclick="btn_Limpiar(\''+xUltimoItem+'\')" ><i class="fa fa-trash-o"></i></a>';
        xFila = xFila+'</td>';

        xFila = xFila+'</tr>';

        $("#detallesDocVta > tbody").append(xFila);
        $("#txt_tot_det").val(xUltimoItem);

        //==== limpiar
        $("#cbo_Productos_ADD").val('');
        //$("#cbo_Productos_ADD").selectpicker('refresh');
        //$("#cbo_Productos_ADD").selectpicker('val', '');
        $("#cbo_Unid_ADD").val('');
        $("#txt_PUnit_ADD").val('');
        $("#txt_Cant_ADD").val('');
        $("#txt_Total_ADD").val('');

        sumar_totales();

    }


}



function btn_Limpiar(item){

    $("#tr_"+item).remove();
    sumar_totales();

}



function sumar_totales(){

    var suma_total  = 0;
    var xtotal      = 0;   

    var ItemMax     = parseInt($("#txt_tot_det").val());     

    for(var f=0; f<=ItemMax; f++){
        xtotal = ($("#txt_det_tot_"+f).val()) ? $("#txt_det_tot_"+f).val() : 0;
        xtotal = (xtotal=='') ? 0:xtotal;
        suma_total = suma_total+parseFloat(xtotal);
    }

    var cbo_descuento   = $("#cbo_descuento").val();
    var igv             = $("#txh_valIGV").val();

    var ValDescuento    = (parseFloat(suma_total)*parseFloat(cbo_descuento));

    var new_suma_total  = parseFloat(suma_total)-parseFloat(ValDescuento);
            
    var xSubtotal       = (parseFloat(new_suma_total) / (1+(parseFloat(igv)/100))).toFixed(2);        
    var xIGV            = (parseFloat(new_suma_total) - parseFloat(xSubtotal)).toFixed(2);
    
    new_suma_total      = new_suma_total.toFixed(2);

    $("#txt_subtotalVta").val(xSubtotal);
    $("#txt_igvVta").val(xIGV);
    $("#txt_totalVta").val(new_suma_total);

    $("#txt_tot_a_pagar").val(new_suma_total);
    Mostrar_valor_en_letras(new_suma_total);

}


function Mostrar_valor_en_letras(valor){

    $.ajax({
        url: "/salesquote/ViewTotalLetters/",
        type: 'GET',
        data:{valor: valor},
        success:function (valor_letras) {
            $("#txt_total_letras").val(valor_letras);
        }
    });

}