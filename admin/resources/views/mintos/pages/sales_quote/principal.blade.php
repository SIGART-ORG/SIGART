@extends('mintos.main')
@section('content')
    @include( 'mintos.inc.inc-breadcrumb' )


<script src="{{ asset( 'js/mintos/js_SalesQuote.js' ) }}"></script>

<style type="text/css">
.form-control:disabled, .dd-handle:disabled {	
	background-color: #EAEBEE;
	color: #525455c2;
}

.table thead > tr > th {	
	background-color: #CFD9E2;
	font-size: 12px;
}

label {	
	font-size: 13px;
	font-weight: bold;
}

hr {	
	margin-top: 5px;
}


.table tfoot > tr > th {	
	background-color: #ffff;
	font-size: 13px;
	padding: 5px 5px 5px 5px;
}


</style>

@php
  $ObjDocuments = $wData['DataTypeDocuments'];
  $ObjCustomers = $wData['DataCustomers'];
  $xFechaHoy 	= $wData['FechaHoy'];

  //===================================================================
  
  $ObjNumSerie 		= $wData['DataNumSerie'];
  $ObjNumDocument 	= $wData['DataNumDocument'];

  $ObjIGV 			= $wData['DataIGV'];

  $xNumSerie	=	($ObjNumSerie)? $ObjNumSerie->num_serie : '';
  $xNumDocument	=	($ObjNumDocument)? $ObjNumDocument->num_doc : '';

  $ValIGV 		=   ($ObjIGV)? $ObjIGV->val1 : '0';

  //====================================================================

  $ObjProducts 	= $wData['DataProducts'];
  $ObjUnities 	= $wData['DataUnities'];
  $ObjDsctos	= $wData['DataListDsctos'];
  

@endphp


<div id="app" class="container">
	

<section class="hk-sec-wrapper">
	


	<div  class="row">
		<div  class="col-md-12">
			<div  class="tile">				

			<div id="div_cuerpo_ventas">

				<h3  class="tile-title">Generar Cotización</h3>		

			<form name="frm_reg_vtas" id="frm_reg_vtas" method="POST">

      			<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">		

	            <div class="row">
	            	<div class="form-group col-md-6">	            		
	            	</div> 
            		<div class="form-group col-md-6 align-self-end" style="text-align: right;">
            			<a href="/salesquote/dashboard" id="btn_agregarClientes" class="btn btn-success">
	            		<i  class="fa fa-fw fa-lg fa-plus"></i>Nueva Cotización</a>
	            		<button  type="button" class="btn btn-danger" onclick="Registrar_Comprobante()"><i class="fa fa-fw fa-save"></i> Registrar Cotización</button>
                    </div> 
            
                </div>

	            <div  class="row">
	            	<div  class="col-md-12">
	            		<hr>
	            	</div>
	            </div>

	            <div  class="row">
	            	<div  class="col-md-4">

	            		<div style="border: 1px solid #CFCFCF; padding: 10px;">

		            		<div class="row">

				                <div class="col-md-6  form-group">
				                  <label>Tipo Documento</label>
				                  <select name="cbo_TipDocumento" id="cbo_TipDocumento" class="form-control" disabled="disabled" >

				                @php

				                if($ObjDocuments):

				                  	foreach ($ObjDocuments as $typeDoc):

				                  	$IDTypeDoc 		= $typeDoc->id;
				                  	$NameTypeDoc 	= $typeDoc->name;

				                  	$SelectCotizacion = ($IDTypeDoc == '1') ? 'selected="selected"' : '';


				                @endphp

				                      <option value="{{$IDTypeDoc}}" {{$SelectCotizacion}} >{{$NameTypeDoc}}</option>

				                @php

									endforeach;
								endif;

				                @endphp
									</select>
				                </div>

				                <div class="col-md-6  form-group">
				                  <label>Fecha Emisión</label>
				                  <input class="form-control" type="text" name="txt_fech_emis" id="txt_fech_emis" value="{{$xFechaHoy}}" disabled="disabled">
				                </div>

				            </div>


				            <div class="row">

				                <div class="col-md-6  form-group">
				                  <label>Nro. Serie</label>
				                  <input class="form-control" type="text" name="txt_num_serie" id="txt_num_serie" value="{{$xNumSerie}}" disabled="disabled">
				                </div>

				                <div class="col-md-6  form-group">
				                  <label>Nro. Documento</label>
				                  <input class="form-control" type="text" name="txt_num_document" id="txt_num_document" value="{{$xNumDocument}}" disabled="disabled">
				                </div>

				            </div>


				            <div class="row">

				                <div class="col-md-9  form-group">
					                <label>Cliente</label>
					                <select id="cbo_Customers" name="cbo_Customers" class="form-control">
				                    	<option value="" selected="selected">SELECCIONE</option>
				            @php

				                if($ObjCustomers):

				                  	foreach ($ObjCustomers as $Clientes):

				                  	$IDCliente 		= $Clientes->id;
				                  	$NameCliente 	= $Clientes->lastname.' '.$Clientes->name;

				            @endphp

				                      <option value="{{$IDCliente}}" >{{$NameCliente}}</option>

				            @php

									endforeach;
								endif;

				            @endphp
									</select>
				            	</div>

				                <div class="col-md-1  form-group" style="margin-top: 30px;">
				           			<a href="#" id="btn_agregarClientes" class="btn btn-dark" onclick="Formulario_Reg_Cliente()">...</a>
				                </div>

				            </div>


				            <div class="row">

				                <div class="col-md-6  form-group">
				                  <label>Total a Pagar</label>
				                  <input class="form-control" id="txt_tot_a_pagar" name="txt_tot_a_pagar" type="text" disabled="disabled" style="color: #FD2F58; background-color: #FFE88C; font-weight: bold; font-size: 16px;">
				                </div>

				            </div>


			            </div>


	            	</div>

	            	<div  class="col-md-8">

	            		<div style="border: 1px solid #CFCFCF; padding: 10px;">

	            			<div class="row">

				                <div class="col-md-6  form-group">
				                  	<label>Producto</label>
				                  	<select id="cbo_Productos_ADD" class="form-control" onchange="Mostrar_Datos_Producto(this.value)" >
				                      <option value="">Seleccione</option>
				                      	@php

							                if($ObjProducts):

							                  	foreach ($ObjProducts as $Productos):

							                  	$IDProducto		= $Productos->id;
							                  	$NameProducto 	= $Productos->name;

							            @endphp

							                      <option value="{{$IDProducto}}" >{{$NameProducto}}</option>

							            @php

												endforeach;
											endif;

							            @endphp
									</select>
				                </div>

				                <div class="col-md-3 form-group">
				                  <label>Unid. Med.</label>
				                  <select name="cbo_Unid_ADD" id="cbo_Unid_ADD" class="form-control">
				                      <option value="">seleccione</option>
				                      @php

							                if($ObjUnities):

							                  	foreach ($ObjUnities as $Unities):

							                  	$IDUnities		= $Unities->id;
							                  	$NameUnities 	= $Unities->name;

							            @endphp

							                      <option value="{{$IDUnities}}" >{{$NameUnities}}</option>

							            @php

												endforeach;
											endif;

							            @endphp
									</select>
				                </div>

				                <div class="col-md-3  form-group">
				                  <label>Precio Unitario</label>
				                  <input class="form-control" type="text" id="txt_PUnit_ADD" disabled="disabled">
				                </div>				                

				            </div>



				            <div class="row">

				            	<div class="col-md-3  form-group">
				                  <label>Cant.</label>
				                  <input class="form-control" type="text" id="txt_Cant_ADD" onkeyup="Calcular_Total_ADD()">
				                </div>

				                <div class="col-md-3  form-group">
				                  <label>Total</label>
				                  <input class="form-control" type="text" id="txt_Total_ADD" disabled="disabled">
				                </div>

				                <div class="col-md-2" style="margin-top: 30px;">
				                  <a href="#" id="btn_agregarClientes" class="btn btn-info" onclick="AgregarProducto()">+</a>
				                </div>

				            </div>


			<div class="table-responsive">

	            <div class="row">
                	<div class="col-md-12">

                		<table class="table table-striped jambo_table bulk_action" id="detallesDocVta">
                            <thead>
                            <tr>
                                <th style="width: 5%; padding: 5px; text-align: center;">Código</th>
                                <th style="width: 9%; padding: 5px; text-align: center;">Cant.</th>
                                <th style="width: 15%; padding: 5px; text-align: center;">Unidad</th>
                                <th style="width: 25%; padding: 5px; text-align: center;">Producto</th>
                                <th style="width: 16%; padding: 5px; text-align: center;">Comentario</th>
                                <th style="width: 10%; padding: 5px; text-align: center;">Precio Unit.</th>
                                <th style="width: 10%; padding: 5px; text-align: center;">Total</th>
                                <th style="width: 5%; padding: 5px; text-align: center;">Acción</th>
                            </tr>
                            </thead>

                            <tbody style="font-size: 12px;" id="tbody_detallesDocVta"></tbody>

                            <input class="form-control" id="txt_tot_det" type="hidden" value="0" style="width: 100px;">

                            <tfoot>

                              <tr>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th colspan="2" style="font-size: 11px; text-align: right;">DESCUENTO S/ </th>
                                  <th colspan="2">
                                  	<select name="cbo_descuento" id="cbo_descuento" style="width: 100%; padding: 0px 0px 0px 0px;" class="form" onchange="sumar_totales()">
                                        <option value="0.00">0 %</option>
                                        @php

							                if($ObjDsctos):

							                  	foreach ($ObjDsctos as $Dscto):

							                  	$ValDscto		= $Dscto->val1;
							                  	$description 	= $Dscto->description;

							            @endphp

							                      <option value="{{$ValDscto}}" >{{$description}}</option>

							            @php

												endforeach;
											endif;

							            @endphp
                                    </select>
                                  </th>
                              </tr>

                              <tr>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th colspan="2" style="font-size: 11px; text-align: right;">SUB TOTAL S/ </th>
                                  <th colspan="2">
                                  	<input style="width: 100%;" type="text" name="txt_subtotalVta" id="txt_subtotalVta" value="0" disabled="disabled">
                                  </th>
                              </tr>

                              <tr>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th colspan="2" style="font-size: 11px; text-align: right;">IGV 
                                  	<label id="lbl_valIGV">{{$ValIGV}}</label> % S/ 
                                  	<input type="hidden" name="txh_valIGV" id="txh_valIGV" value="{{$ValIGV}}">
                                  </th>
                          		  <th colspan="2">
                          		  	<input style="width: 100%;" type="text" name="txt_igvVta" id="txt_igvVta" value="0" disabled="disabled">
                          		  </th>
                              </tr>

                              <tr>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th colspan="2" style="font-size: 11px; text-align: right;">TOTAL S/ </th>
                                  <th colspan="2"><input style="width: 100%;" type="text" name="txt_totalVta" id="txt_totalVta" value="0" disabled="disabled"></th>
                              </tr>
                            </tfoot>

                        </table>


                	</div>
                </div>

            </div>




            <div class="row" style="padding: 5px 10px 5px 10px;">

            	<div class="col-sm-12">
                	<div class="input-group">
                  	<span class="input-group-addon">Son : </span>
                  	<input class="form-control" type="text" id="txt_total_letras" name="txt_total_letras" disabled="disabled">
                	</div>                
              	</div>

         	</div>




	            		</div>

	            	</div>
	            </div>

            </div>
        </div>


    </form>

	</div>


    </div>

</section>


</div>


@endsection
