@extends('mintos.main')
@section('content')
    @include( 'mintos.inc.inc-breadcrumb' )
    @php
      $ObjDocuments = $wData['DataTypeDocuments'];
      $ObjCustomers = $wData['DataCustomers'];
      $xFechaHoy 	= $wData['FechaHoy'];
    @endphp


<div id="app">
	<div >


	<div  class="row">
		<div  class="col-md-12">
			<div  class="tile">

				<h3  class="tile-title">Generar Cotización</h3>

				<div style="text-align: right;">

	            	<a href="/salesquote/dashboard" id="btn_agregarClientes" class="btn btn-success"><i  class="fa fa-fw fa-lg fa-plus"></i>Nueva Cotizaciónr</a>

	            	<button  type="button" class="btn btn-danger"><i class="fa fa-fw fa-save"></i> Registrar Cotización</button>
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
				                  <select name="cbo_TipDocumento" id="cbo_TipDocumento" class="form-control" disabled="">

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
				                  <input class="form-control" type="text" id="txt_fech_emis" value="{{$xFechaHoy}}" disabled="disabled">
				                </div>

				            </div>


				            <div class="row">

				                <div class="col-md-6  form-group">
				                  <label>Nro. Serie</label>
				                  <input placeholder="Fecha Emisión" class="form-control" type="text" id="txt_fech_emis" name="txt_fech_emis" value="13-09-2019" disabled="disabled">
				                </div>

				                <div class="col-md-6  form-group">
				                  <label>Nro. Documento</label>
				                  <input placeholder="Fecha Emisión" class="form-control" type="text" id="txt_fech_emis" name="txt_fech_emis" value="13-09-2019" disabled="disabled">
				                </div>

				            </div>


				            <div class="row">

				                <div class="col-md-9  form-group">
					                <label>Cliente</label>
					                <select id="cbo_Customers" class="form-control">
				                    	<option value="1">SELECCIONE</option>
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

				                <div class="col-md-4  form-group">
				                  <label>Producto</label>
				                  <select name="cbo_TipDocumento" id="cbo_TipDocumento" class="form-control" disabled="">
				                      <option value="1">NOTA DE PEDIDO</option>
				                      <option value="2">BOLETA</option>
				                      <option value="3">FACTURA</option>
									</select>
				                </div>

				                <div class="col-md-2 form-group">
				                  <label>Unid. Med.</label>
				                  <select name="cbo_TipDocumento" id="cbo_TipDocumento" class="form-control" disabled="">
				                      <option value="1">NOTA DE PEDIDO</option>
				                      <option value="2">BOLETA</option>
				                      <option value="3">FACTURA</option>
									</select>
				                </div>

				                <div class="col-md-2  form-group">
				                  <label>Precio</label>
				                  <input class="form-control" type="text" id="txt_fech_emis">
				                </div>

				                <div class="col-md-2  form-group">
				                  <label>Cant.</label>
				                  <input class="form-control" type="text" id="txt_fech_emis">
				                </div>

				                <div class="col-md-1" style="margin-top: 30px;">
				                  <a href="#" id="btn_agregarClientes" class="btn btn-info" onclick="Formulario_Reg_Cliente()">+</a>
				                </div>

				            </div>


			<div class="table-responsive">

	            <div class="row">
                	<div class="col-md-12">

                		<table class="table table-striped jambo_table bulk_action" id="detallesDocVta">
                            <thead>
                            <tr style="background: #3F5367; color: #ffffff; font-size: 11px;">
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
                                        <option value="15.00">1 %</option>
                                    </select>

                                  </th>
                              </tr>


                              <tr>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th colspan="2" style="font-size: 11px; text-align: right;">SUB TOTAL S/ </th>
                                  <th colspan="2"><input style="width: 100%;" type="text" name="txt_subtotalVta" id="txt_subtotalVta" value="0" disabled="disabled"></th>
                              </tr>

                              <tr>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th colspan="2" style="font-size: 11px; text-align: right;">IGV <label id="lbl_valIGV">18</label> % S/ <input type="hidden" name="txh_valIGV" id="txh_valIGV" value="18"></th>
                          <th colspan="2"><input style="width: 100%;" type="text" name="txt_igvVta" id="txt_igvVta" value="0" disabled="disabled"></th>
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



	            		</div>

	            	</div>
	            </div>

            </div>
        </div>
    </div>


</div>
</div>


@endsection
