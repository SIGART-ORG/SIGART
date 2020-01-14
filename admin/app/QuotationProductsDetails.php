<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationProductsDetails extends Model
{
    const TABLE_NAME = 'sales_quotations_details';

    protected $table = self::TABLE_NAME;

    public function saleQuotationDetail() {
        return $this->belongsTo( 'App\Models\SalesQuotationsDetails', 'sales_quotations_details_id', 'id' );
    }
}
