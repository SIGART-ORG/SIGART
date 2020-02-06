<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesQuotationsDetails extends Model
{
    const TABLE_NAME = 'sales_quotations_details';

    protected $table = self::TABLE_NAME;

    public function quotationProducstDetails()
    {
        return $this->hasMany('App\QuotationProductsDetails', 'sales_quotations_details_id', 'id');
    }

    public static function generateItems($quotation)
    {
        $quotationId = $quotation->id;

        $details = $quotation->serviceRequest->serviceRequestDetails;
        foreach ( $details as $detail ) {
            $description = $detail->description_corrected ? $detail->description_corrected : $detail->description;
            self::addItems( $quotationId, $description, $detail->quantity );
        }

        return true;
    }

    private static function addItems($quotation, $description, $quantity = 0 )
    {
        $item = new SalesQuotationsDetails();
        $item->sales_quotations_id = $quotation;
        $item->description = $description;
        $item->type = 0;
        $item->quantity = $quantity;
        $item->save();

        return true;
    }

    public static function updateItems($items)
    {
        $totals = [
            'subtotal' => 0,
            'total' => 0,
            'discount' => 0,
            'discountPorc' => 0,
            'igv' => 0,
            'igvPorc' => 18,
        ];

        if( is_array( $items ) && count( $items ) > 0 ) {
            foreach( $items as $item ) {
                $detail  = self::where( 'id', $item['id'] )->where( 'status', 1 )->first();
                if( $detail ) {
                    $_sub_total = $item['workforce'] + ( $item['includesProducts'] ? $item['totalProducts'] : 0 );
                    $_igv = round( ( $totals['igvPorc'] / 100 ) * $_sub_total, 2 );
                    $_total = $_sub_total + $_igv;

                    $detail->quantity = $item['quantity'];
                    $detail->description = $item['description'];
                    $detail->sub_total = $_sub_total;
                    $detail->total_products = $item['includesProducts'] ? $item['totalProducts'] : 0;
                    $detail->workforce = $item['workforce'];
                    $detail->total = $_total;
                    $detail->includes_products = $item['includesProducts'] ? 1 : 0;
                    $detail->save();

                    $totals['subtotal'] += $_sub_total;
                    $totals['igv'] += $_igv;
                    $totals['total'] += $_total;
                }
            }
        }

        return $totals;
    }
}
