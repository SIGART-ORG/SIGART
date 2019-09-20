<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SalesQuote extends Model
{
    
	public static function List_Type_Documents()
    {
    	$Resultado = DB::select("SELECT * FROM type_vouchers where status = '1' ");
    	return $Resultado;
    }

    public static function List_Customers()
    {
    	$Resultado = DB::select("SELECT * FROM customers where status = '1' ");
    	return $Resultado;
    }

    public static function Generate_Num_Serie()
    {
        $Resultado = DB::selectOne("
            SELECT right(concat('00000',(IFNULL(Max(RIGHT(num_serie,5)),0)+1)),5) as num_serie  
            FROM sales_quotations 
        ");
        return $Resultado;
    }

    public static function Generate_Num_Document()
    {
        $Resultado = DB::selectOne("
            SELECT right(concat('000000000000',(IFNULL(Max(RIGHT(num_doc,10)),0)+1)),10) as num_doc  
            FROM sales_quotations 
        ");
        return $Resultado;
    }

    public static function List_Products()
    {
        $Resultado = DB::select("SELECT * FROM products WHERE status = '1' ");
        return $Resultado;
    }

    public static function List_Unitys()
    {
        $Resultado = DB::select("SELECT * FROM unity WHERE status = '1' ");
        return $Resultado;
    }


    public static function View_Data_Product_x_ID($arrayCampos = [])
    {
        $Resultado = DB::selectOne("
            SELECT * FROM presentation where `status` = '1' AND products_id = :products_id
        ", $arrayCampos);
        return $Resultado;
    }

    


}
