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

        $verificateExistTypes = [
            1 => false,
            2 => false,
        ];

        $quotationId = $quotation->id;

        $items = self::whereNotIn('status', [0, 2])
            ->where('sales_quotations_id', $quotationId)
            ->get();

        foreach ($items as $item) {
            $verificateExistTypes[$item->type] = true;
        }

        if( !$verificateExistTypes[2] ) {
            $verificateExistTypes[2] = true;
            $details = $quotation->serviceRequest->serviceRequestDetails;
            foreach ( $details as $detail ) {
                $description = $detail->description_corrected ? $detail->description_corrected : $detail->description;
                self::addItems( $quotationId, 2, $description, $detail->quantity );
            }
        }

        foreach ($verificateExistTypes as $idx => $type) {
            if (!$type) {
                self::addItems($quotationId, $idx);
            }
        }

        return true;
    }

    private static function addItems($quotation, $type, $description = '', $quantity = 0 )
    {
        $item = new SalesQuotationsDetails();
        $item->sales_quotations_id = $quotation;
        $item->description = $description === '' ? self::nameItem($type) : $description;
        $item->type = $type;
        $item->quantity = $quantity;
        $item->save();

        return true;
    }

    private static function nameItem($type)
    {
        switch ($type) {
            case 1:
                $name = 'Total de materiales a usar.';
                break;
            case 2:
                $name = 'Mano de obra.';
                break;
            case 3:
                $name = 'Otros.';
                break;
            default:
                $name = '';
        }

        return $name;
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
            'subTotal' => 0
        ];

        if( is_array( $items ) && count( $items ) > 0 ) {
            foreach( $items as $item ) {
                $detail  = self::where( 'id', $item['id'] )->where( 'status', 1 )->first();
                if( $detail ) {
                    $_total = $item['subTotal'] - $item['discount'];

                    $detail->quantity = $item['quantity'];
                    $detail->description = $item['description'];
                    $detail->sub_total = $item['subTotal'];
                    $detail->discount = $item['discount'];
                    $detail->total = $_total;
                    $detail->save();

                    $totals['subtotal'] += $item['subTotal'];
                    $totals['total'] += $_total;
                    $totals['discount'] += $item['discount'];
                }
            }
        }

        if( $totals['total'] > 0 ) {
            $porcDisc = round( ( $totals['discount'] / $totals['total'] ) * 100, 2 );
            $totals['discountPorc'] = $porcDisc;

            $igv = round( $totals['total'] - ( $totals['total'] / ( ( 100 + $totals['igvPorc'] ) / 100  ) ), 2 );
            $totals['igv'] = $igv;
        }

        return $totals;
    }
}
