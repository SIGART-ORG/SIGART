<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationProductsDetails extends Model
{
    const TABLE_NAME = 'quotation_products_details';

    protected $table = self::TABLE_NAME;

    public function saleQuotationDetail() {
        return $this->belongsTo( 'App\Models\SalesQuotationsDetails', 'sales_quotations_details_id', 'id' );
    }

    public function presentation() {
        return $this->belongsTo( 'App\Presentation', 'presentation_id', 'id' );
    }
}
