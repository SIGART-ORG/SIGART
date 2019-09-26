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

    var TotalFilas = $('#detallesDocVta >tbody >tr').length;

    if(TotalFilas == 0){
        $("#txt_tot_det").val('0');
    }

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

    //alert(suma_total+'---'+cbo_descuento+'---'+igv);

    var ValDescuento    = (parseFloat(suma_total)*parseFloat(cbo_descuento)/100);

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


function Calcular_Total_ADD(){

    var cant    = $("#txt_Cant_ADD").val();
    var pre_vta = $("#txt_PUnit_ADD").val();
    var z_total = 0;

    cant    = parseFloat(cant);
    pre_vta = parseFloat(pre_vta);

    if(pre_vta == '' || pre_vta == '0'){
        $("#txt_Cant_ADD").val('');
        alert('Seleccione un producto');
        $("#cbo_Productos_ADD").focus();     
    }else{
        z_total = cant * pre_vta;
        z_total = z_total.toFixed(2);
        z_total = rendondeo(z_total);
        $("#txt_Total_ADD").val(z_total);
    }

}



function rendondeo(valor){

    var numero = valor.split(".");

    var entero = parseInt(numero[0]);
    var decimal = parseInt(numero[1]);

    console.log('#################################');

    console.log('entero->'+entero);
    console.log('decimal->'+decimal);

    var nValor = 0;

    if(decimal >= 95){
       nValor = (entero+1)+'.'+'00';

       console.log('nValor>95->'+nValor);

    }else if(decimal >= 10 && decimal < 95){

        var cadDecimal = decimal.toString();

        var valor1  =   parseInt(cadDecimal.substring(0,1));
        var valor2  =   parseInt(cadDecimal.substring(1,2));  

        console.log('valor1->'+valor1);
        console.log('valor2->'+valor2);

        var nDecimal = '0';

        if(valor2 >= 5){
            if(valor1+1>=10){
                nValor = (entero+1)+'.00';
            }else{
                nDecimal = (valor1+1)+''+'0';    
                nValor = entero+'.'+nDecimal;
            }
            
        }else{
            nDecimal = valor1+''+'0'; 
            nValor = entero+'.'+nDecimal;
        }        

        console.log('nValor>10->'+nValor);

    }else if(decimal >= 0 && decimal < 10){

        var nDecimal = '0';

        if(decimal >= 5){
            nDecimal = '00';
            nValor = (entero+1)+'.'+nDecimal;
        }else{
            nDecimal = '00'; 
            nValor = entero+'.'+''+nDecimal;
        }

        

        console.log('nValor<10->'+nValor);

    }

    return parseFloat(nValor).toFixed(2);

}


function Calcular_fila(item){

    var cant = $("#txt_det_cant_"+item).val();
    var pre_vta = $("#txt_det_pv_"+item).val();
    var z_total = 0;

    cant    = parseFloat(cant);
    pre_vta = parseFloat(pre_vta);

    if(pre_vta ==''){
        $("#txt_det_cant_"+item).val('');
        alert('Seleccione un producto');
        $("#cbo_productos_"+item).focus();     
    }else{
        z_total = cant * pre_vta;
        //z_total = Math.round(z_total).toFixed(2);
        z_total = z_total.toFixed(2);
        z_total = rendondeo(z_total);
        $("#txt_det_tot_"+item).val(z_total);
    }
    sumar_totales();

}




function Registrar_Comprobante(){

    var cbo_TipDocumento      = $("#cbo_TipDocumento").val();
    var txt_fech_emis         = $("#txt_fech_emis").val();
    var txt_num_serie         = $("#txt_num_serie").val();
    var txt_num_document      = $("#txt_num_document").val();
    var cbo_Customers         = $("#cbo_Customers").val();   
    var txt_tot_a_pagar       = parseFloat($("#txt_tot_a_pagar").val()*1);
    var txt_tot_det           = parseFloat($("#txt_tot_det").val()*1);   

    if(cbo_Customers == ''){
        alert('Seleccione Cliente');      
        $("#cbo_Customers").focus();

    }else if(txt_tot_det == 0 ){
        alert('No ha registrado ningun producto');
           
    }else{      
        


        if(confirm('¿Confirma registrar este comprobante?')){

            var codigo_xyz          = '';
            var s_comentario        = '';


            var Array_Cantidad      = [];
            var Array_UnitMed       = [];
            var Array_Productos     = [];
            var Array_Comentario    = [];
            var Array_PrecUnit      = [];
            var Array_Total         = [];

            var cbo_TipDocumento    = $("#cbo_TipDocumento").val();
            var txt_tot_a_pagar     = $("#txt_tot_a_pagar").val()*1;
            var ItemProd            = $("#txt_tot_det").val();

            for(var j=1; j<=ItemProd; j++){

                if($("#txt_det_cod_"+j).val()){

                    codigo_xyz = $("#txt_det_cod_"+j).val();

                    s_comentario = $("#txt_det_coment_"+j).val().replace(",", ";");                  
                    Array_Cantidad.push($("#txt_det_cant_"+j).val()); 
                    Array_UnitMed.push($("#cbo_det_unid_"+j).val()); 
                    Array_Productos.push($("#cbo_productos_"+j).val()); 
                    Array_Comentario.push(s_comentario);
                    Array_PrecUnit.push($("#txt_det_pv_"+j).val());
                    Array_Total.push($("#txt_det_tot_"+j).val());
                }

            }

            var parametros = { 

                "cbo_TipDocumento"  : $("#cbo_TipDocumento").val(),
                "txt_fech_emis"     : $("#txt_fech_emis").val(),
                "txt_num_serie"     : $("#txt_num_serie").val(),
                "txt_num_document"  : $("#txt_num_document").val(),                
                "cbo_Customers"       : $("#cbo_Customers option:selected").val(),
                "txt_tot_a_pagar"       : $("#txt_tot_a_pagar").val(),  

                "cbo_descuento"         : $("#cbo_descuento").val(),
                "txt_subtotalVta"       : $("#txt_subtotalVta").val(),
                "txh_valIGV"            : $("#txh_valIGV").val(),
                "txt_igvVta"            : $("#txt_igvVta").val(),                
                "txt_totalVta"          : $("#txt_totalVta").val(),
                "txt_total_letras"      : $("#txt_total_letras").val(),                

                "Array_Cantidad"        : Array_Cantidad.toString(),
                "Array_UnitMed"         : Array_UnitMed.toString(),
                "Array_Productos"       : Array_Productos.toString(),
                "Array_Comentario"      : Array_Comentario.toString(),
                "Array_PrecUnit"        : Array_PrecUnit.toString(),
                "Array_Total"           : Array_Total.toString()
            };

            var token = $("#token").val();
         
            $.ajax({
                url: '/salesquote/RegisterSales/',
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: parametros,
                success:function (data) {

                    //alert("1-OK->"+data);

                    var codCotiza = parseInt(data);
                    
                    if(codCotiza > 0 ){
                        Imprimir_dVTA(codCotiza);    
                    }else{
                        alert("1-Error:"+data);
                    }
                },
                error:function (msj) {
                    console.log(msj);
                    alert('2-Error:'+msj);
                }
            });

        }           
    }

}



function Imprimir_dVTA(sidventa){
    $("#div_cuerpo_ventas").html('<iframe id="iframePrint" src="/salesquote/PrintQuotations/'+sidventa+'" style="width:100%; height:700px;" border=0></iframe>');

  }

