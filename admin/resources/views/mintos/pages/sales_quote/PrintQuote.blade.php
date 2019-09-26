<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>

<script type="text/javascript" src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>
<link href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/vendors/bootstrap/dist/css/EstiloImpresion.css') }}" rel="stylesheet" type="text/css">

<script type="text/javascript">


function imprSelec(area){
  var ficha=document.getElementById(area);
  var ventimp=window.open(' ','popimpr');
  ventimp.document.write('<div style="text-align: left;">');
  ventimp.document.write(ficha.innerHTML);
  ventimp.document.write('</div>');
  ventimp.document.close();
  ventimp.print();
  ventimp.close();
}


function PrintMe(DivID) {
var disp_setting="toolbar=yes,location=no,";
disp_setting+="directories=yes,menubar=yes,";
disp_setting+="scrollbars=yes,  left=0, top=25";
//disp_setting+="scrollbars=yes,width=650, height=600, left=100, top=25";
   var content_vlue = document.getElementById(DivID).innerHTML;
   var docprint=window.open("","", disp_setting);
   //docprint.document.open();
   docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
   docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
   docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
   docprint.document.write('<head>');
   docprint.document.write('<style type="text/css">body{ margin:0px;');
   docprint.document.write('font-family:verdana,Arial;color:#000;');
   docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
   docprint.document.write('a{color:#000;text-decoration:none;} </style>');
   docprint.document.write('</head><body onLoad="self.print()"><left>');
   docprint.document.write(content_vlue);
   docprint.document.write('</left></body></html>');
   docprint.document.close();
   docprint.focus();
}

</script>

<!--<body onload="print();">-->
<body>




<div style="width: 345px; float: left; padding: 10px 0px 0px 10px;">

  <div style="padding: 0px 0px 10px 0px;">

    <div style="padding: 0px 0px 10px 0px;">
      <a href="javascript:PrintMe('div_zona_impresion')" class="btn btn-default" >Imprimir Cotización</a>
      <a href="/salesquote/dashboard/" class="btn btn-default" target="_top" >Cerrar</a>
    </div>
  


    <div class="zona_impresion" id="div_zona_impresion" style="text-align: left; ">  


      @php
   
        $ArrayDatoEmpresa = $wDataVta['DatoEmpresa'];
        $ArrayDatoVtaCAB = $wDataVta['DatoCabQuote_CAB'];
        $ArrayDatoVtaDET = $wDataVta['DatoCabQuote_DET'];

      @endphp

      <br>
      <table border="0" align="center" width="300px">

        <tr>
          <td colspan="3" style="text-align: center;">
            <img src="/assets/dist/img/logo-light.png" style="max-width: 100%; height: auto;">
          </td>  
        </tr>

        <tr>
          <td align="center" colspan="3"><br></td>
        </tr>

        <tr>
              <td align="center" colspan="3">
              
              R.U.C.: {{$ArrayDatoEmpresa->RUC}}<br>

              {{$ArrayDatoEmpresa->DIRECCION}} <br> 

              {{$ArrayDatoEmpresa->DEPA}} - {{$ArrayDatoEmpresa->PROV}} - {{$ArrayDatoEmpresa->DIST}} <br>       

              Telef.: {{$ArrayDatoEmpresa->TELEF}} <br><br>

              <div style="font-size: 18px; font-weight: bold;"> {{$ArrayDatoVtaCAB->documento}} </div> 
              <div style="font-size: 15px; font-weight: bold;"> 
                {{$ArrayDatoVtaCAB->num_serie}} - {{$ArrayDatoVtaCAB->num_doc}} 
              </div> 


              </td>
          </tr>

          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>

          <tr>
              <td colspan="3">
                <div style="font-size: 13px; font-weight: bold; float: left;"> 
                  Fecha Emisión : {{$ArrayDatoVtaCAB->fecha_emis}}
                </div>
              </td>              
          </tr>




          <tr>
            <td colspan="3">
              <!-- <hr style="height: 1px; background-color: #000000; margin-top: 3px; margin-bottom: 3px;"> -->
              <hr style="border: 0; border-bottom: 1px dashed #ccc; background: #999; margin-bottom: 3px; margin-top: 3px;">
            </td>
          </tr>

          <tr>
              <td colspan="3">CLIENTE &nbsp;&nbsp;&nbsp;&nbsp;: {{$ArrayDatoVtaCAB->cliente}} </td>
          </tr>

          <tr>
            <td colspan="3">
              <!-- <hr style="height: 1px; background-color: #000000; margin-top: 3px; margin-bottom: 3px;"> -->
              <hr style="border: 0; border-bottom: 1px dashed #ccc; background: #999; margin-bottom: 3px; margin-top: 3px;">
            </td>
          </tr>
        
      </table>


      <table border="0" align="center" width="300px">
          <tr>
              <td>CANT.</td>
              <td>DESCRIPCIÓN</td>
              <td align="right" style="width: 85px;">IMPORTE</td>
          </tr>
          

          <tr>
            <td colspan="3">
              <!-- <hr style="height: 1px; background-color: #000000; margin-top: 3px; margin-bottom: 3px;"> -->
              <hr style="border: 0; border-bottom: 1px dashed #ccc; background: #999; margin-bottom: 3px; margin-top: 3px;">
            </td>
          </tr>
          
          @php

          $acumulador = 0;
          if($ArrayDatoVtaDET) foreach ($ArrayDatoVtaDET as $VtaDET):

              $acumulador=$acumulador+$VtaDET->quantity;
          @endphp

          <tr>
              <td>{{$VtaDET->quantity}}</td>
              <td>{{$VtaDET->producto}}. {{$VtaDET->coment}}</td>      
              <td align="right">S/ {{$VtaDET->total}}</td>
          </tr>

          @php
            endforeach;
    
          @endphp

          <tr>
            <td colspan="3">
              <!-- <hr style="height: 1px; background-color: #000000; margin-top: 3px; margin-bottom: 3px;"> -->
              <hr style="border: 0; border-bottom: 1px dashed #ccc; background: #999; margin-bottom: 3px; margin-top: 3px;">
            </td>
          </tr>


          <tr>
            <td>&nbsp;</td>
            <td align="right">DESCUENTO {{($ArrayDatoVtaCAB->porc_dscto)}} % :</td>
            <td align="right">S/ {{($ArrayDatoVtaCAB->tot_dscto)}} </td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td align="right">SUBTOTAL:</td>
            <td align="right">S/ {{$ArrayDatoVtaCAB->subtot_sale}} </td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td align="right">IGV {{$ArrayDatoVtaCAB->porc_igv}} %:</td>
            <td align="right">S/ {{$ArrayDatoVtaCAB->tot_igv}} </td>
          </tr>



          <tr>
            <td>&nbsp;</td>
            <td align="right"><b>TOTAL:</b></td>
            <td align="right"><b>S/ {{$ArrayDatoVtaCAB->tot_gral}} </b></td>
          </tr>

          <tr>
            <td align="left" colspan="3"><br>SON: {{$ArrayDatoVtaCAB->total_letter}} </td>
          </tr>


        
          <tr>
            <td colspan="3">
              <!-- <hr style="height: 1px; background-color: #000000; margin-top: 3px; margin-bottom: 3px;"> -->
              <hr style="border: 0; border-bottom: 1px dashed #ccc; background: #999; margin-bottom: 3px; margin-top: 3px;">
            </td>
          </tr>


          <tr>
            <td colspan="3">Nº de artículos: {{$acumulador}}</td>
          </tr>

          
      </table>



        <table border="0" align="center" width="300px">

          <tr>
            <td colspan="3">
              <!-- <hr style="height: 1px; background-color: #000000; margin-top: 3px; margin-bottom: 3px;"> -->
              <hr style="border: 0; border-bottom: 1px dashed #ccc; background: #999; margin-bottom: 3px; margin-top: 3px;">
            </td>
          </tr>

          <tr><td colspan="3" align="center">¡GRACIAS POR SU PREFERENCIA!</td></tr>
          <tr><td colspan="3" align="center">Visitanos a nuestra página web http://admin.dpintart.com</td></tr>

        </table>


    </div>

  </div>

</div>





</body>
</html>
