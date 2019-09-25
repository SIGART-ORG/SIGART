<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SalesQuote extends Model
{
    
	public static function List_Type_Documents()
    {
    	$Resultado = DB::select("SELECT * FROM type_vouchers WHERE status = '1' ");
    	return $Resultado;
    }

    public static function List_Customers()
    {
    	$Resultado = DB::select("SELECT * FROM customers WHERE status = '1' ");
    	return $Resultado;
    }

    public static function Generate_Num_Serie()
    {
        $Resultado = DB::selectOne("
            SELECT val1 AS num_serie FROM parametros WHERE `status` = '1' AND `group` = 'SERIE' AND id = '8'
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


    public static function List_Dsctos()
    {
        $Resultado = DB::select("
            SELECT * FROM parametros P WHERE P.status = '1' AND P.group = 'DESCUENTO'
        ");
        return $Resultado;
    }

    public static function Data_IGV()
    {
        $Resultado = DB::selectOne("
            SELECT * FROM parametros P WHERE P.`status` = '1' AND P.`group` = 'IGV' AND P.id = '1'
        ");
        return $Resultado;
    }

    public static function Generate_ID_Cotizacion()
    {
        $Resultado = DB::selectOne("
            SELECT (IFNULL(Max(id),0)+1) as id_cotizacion FROM sales_quotations 
        ");
        return $Resultado;
    }


     public static function Registrar_Cotizacion_CAB($arrayCampos = [])
    {
        $Resultado = DB::insert("
            INSERT INTO tbl_ventas_cab (
                id,
                type_vouchers_id,
                date_emission,
                num_serie,
                num_doc,
                customers_id,
                tot_sale,
                porc_dscto,
                tot_dscto,
                subtot_sale,
                porc_igv,
                tot_igv,
                tot_gral,
                status,
                created_at,
                updated_at
            ) VALUES(
                :id,
                :type_vouchers_id,
                :date_emission,
                :num_serie,
                :num_doc,
                :customers_id,
                :tot_sale,
                :porc_dscto,
                :tot_dscto,
                :subtot_sale,
                :porc_igv,
                :tot_igv,
                :tot_gral,
                '1',
                NOW(),
                NOW()
            )
        ",$arrayCampos);

        return $Resultado;
    }





    


}
