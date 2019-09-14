<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SalesQuote extends Model
{
    
	public static function List_Type_Documents()
    {
    	$Resultado = DB::select("SELECT * FROM type_documents where status = '1' ");
    	return $Resultado;
    }

    public static function List_Customers()
    {
    	$Resultado = DB::select("SELECT * FROM customers where status = '1' ");
    	return $Resultado;
    }

}
