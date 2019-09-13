<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SalesQuote extends Model
{
    
	public static function Listar_Documentos()
    {
    	$Resultado = DB::select("SELECT * FROM products_type where id_state = '1' ");
    	return $Resultado;
    }
}
