<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'name',
        'lastname',
        'business_name',
        'document',
        'type_document',
        'legal_representative',
        'document_lp',
        'type_document_lp',
        'email',
        'address',
        'district_id',
        'status'
    ];

    public function typeDocument() {
        return $this->belongsTo( 'App\TypeDocument', 'type_document', 'id' );
    }

    public function serviceRequests() {
        return $this->hasMany( 'App\Models\ServiceRequest', 'customers_id', 'id' );
    }

    public function customerLogins() {
        return $this->hasMany( 'App\Models\CustomerLogin', 'customers_id', 'id' );
    }

    public function scopeSearch($query, $search)
    {
        if( $search != "") {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('lastname', 'like', '%' . $search . '%')
                    ->orWhere('business_name', 'like', '%' . $search . '%')
                    ->orWhere('document', 'like', '%' . $search . '%')
                    ->orWhere('legal_representative', 'like', '%' . $search . '%');
            });
        }
    }
}
