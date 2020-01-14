<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesQuotationsDetails extends Model
{
    const TABLE_NAME = 'sales_quotations_details';

    protected $table = self::TABLE_NAME;

    public function quotationProducstDetails() {
        return $this->hasMany( 'App\QuotationProductsDetails', 'sales_quotations_details_id', 'id' );
    }
}
