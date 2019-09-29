<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ServiceRequest extends Model
{
    
	public static function List_Type_Documents()
    {
    	$Resultado = DB::select("SELECT * FROM type_vouchers WHERE status = '1' ");
    	return $Resultado;
    }

    public static function Generate_Num_Request()
    {
        $Resultado = DB::selectOne("
            SELECT right(concat('000000000000',(IFNULL(Max(RIGHT(num_request,10)),0)+1)),10) as num_request  
            FROM service_requests 
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


    public static function Generate_ID_Solic_Request()
    {
        $Resultado = DB::selectOne("
            SELECT (IFNULL(Max(id),0)+1) as codigo FROM service_requests 
        ");
        return $Resultado;
    }


    public static function Registrar_SolRequest_CAB($arrayCampos = [])
    {
        $Resultado = DB::insert("
            INSERT INTO service_requests (
                id,
                sites_id,
                type_vouchers_id,
                date_emission,
                num_request,
                customers_id,
                user_reg,
                user_aproved,
                date_reg,
                date_aproved,
                description,
                observation,
                status,
                created_at,
                updated_at

            ) VALUES(
                :id,
                :sites_id,
                :type_vouchers_id,
                :date_emission,
                :num_request,
                :customers_id,
                :user_reg,
                :user_aproved,
                NOW(),
                NOW(),
                :description,
                :observation,
                '1',
                NOW(),
                NOW()

                
            )
        ",$arrayCampos);

        return $Resultado;
    }




    public static function Generate_ID_Solic_Request_Details()
    {
        $Resultado = DB::selectOne("
            SELECT (IFNULL(Max(id),0)+1) as codigo FROM service_request_details 
        ");
        return $Resultado;
    }





    public static function Registrar_SolRequest_DET($arrayCampos = [])
    {
        $Resultado = DB::insert("
            INSERT INTO service_request_details (
                id,
                service_requests_id,
                name,
                quantity,
                description,
                assumed_customer,
                status,
                created_at,
                updated_at
            ) VALUES(
                :id,
                :service_requests_id,
                :name,
                :quantity,
                :description,
                :assumed_customer,
                '1',
                NOW(),
                NOW()
            )
        ",$arrayCampos);

        return $Resultado;
    }






    public static function Data_Empresa()
    {
        $Resultado = DB::selectOne("
        SELECT 
        (SELECT val1 FROM parametros WHERE `status` = '1' AND `group` = 'EMPRESA' AND id = '15' ) AS RUC,
        (SELECT val1 FROM parametros WHERE `status` = '1' AND `group` = 'EMPRESA' AND id = '16' ) AS NOM_EMPRESA,
        (SELECT val1 FROM parametros WHERE `status` = '1' AND `group` = 'EMPRESA' AND id = '17' ) AS NOM_COMERCIAL,
        (SELECT val1 FROM parametros WHERE `status` = '1' AND `group` = 'EMPRESA' AND id = '18' ) AS DIRECCION,
        (SELECT val1 FROM parametros WHERE `status` = '1' AND `group` = 'EMPRESA' AND id = '19' ) AS DEPA,
        (SELECT val1 FROM parametros WHERE `status` = '1' AND `group` = 'EMPRESA' AND id = '20' ) AS PROV,
        (SELECT val1 FROM parametros WHERE `status` = '1' AND `group` = 'EMPRESA' AND id = '21' ) AS DIST,
        (SELECT val1 FROM parametros WHERE `status` = '1' AND `group` = 'EMPRESA' AND id = '22' ) AS TELEF 
        ");
        return $Resultado;
    }



    public static function Data_sales_quotations_x_ID_CAB($arrayCampos = [])
    {
        $Resultado = DB::selectOne("            
            SELECT 
            sq.id,
            sq.type_vouchers_id,
            tv.`name` as documento,
            DATE_FORMAT(sq.date_emission, '%d/%m/%Y') as fecha_emis,
            sq.num_request,
            sq.customers_id,
            concat(c.`name`, '', c.lastname ) as cliente,
            sq.tot_sale,
            sq.porc_dscto,
            sq.tot_dscto,
            sq.subtot_sale,
            sq.porc_igv,
            sq.tot_igv,
            sq.tot_gral,
            sq.total_letter,
            sq.observation
            FROM service_requests sq 
            LEFT JOIN type_vouchers tv ON (tv.id = sq.type_vouchers_id)
            LEFT JOIN customers c ON (c.id = sq.customers_id)
            WHERE sq.id = :id_cab
        ",$arrayCampos);
        return $Resultado;
    }






    public static function Data_sales_quotations_x_ID_DET($arrayCampos = [])
    {
        $Resultado = DB::select("            
            SELECT
            SQD.id,
            SQD.sales_quotations_id,
            SQD.quantity,
            SQD.unity_id,
            U.`name` as Unidad,
            SQD.products_id,
            P.`name` as producto,
            SQD.coment,
            SQD.unit_price,
            SQD.total
            FROM sales_quotations_details SQD 
            LEFT JOIN products P ON (P.id = SQD.products_id)
            LEFT JOIN unity U ON (U.id = SQD.unity_id)
            WHERE SQD.sales_quotations_id = :id_cab
            AND SQD.`status` = '1'
        ",$arrayCampos);
        return $Resultado;
    }

    


}
