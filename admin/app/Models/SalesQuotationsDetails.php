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
            3 => false
        ];

        $items = self::whereNotIn('status', [0, 2])
            ->where('sales_quotations_id', $quotation)
            ->get();

        foreach ($items as $item) {
            $verificateExistTypes[$item->type] = true;
        }

        foreach ($verificateExistTypes as $idx => $type) {
            if (!$type) {
                self::addItems($quotation, $idx);
            }
        }

        return true;
    }

    private static function addItems($quotation, $type)
    {

        $item = new SalesQuotationsDetails();
        $item->sales_quotations_id = $quotation;
        $item->description = self::nameItem($type);
        $item->type = $type;
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
