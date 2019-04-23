<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';
    protected $fillable = [
        'name',
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

    public function scopeSearch($query, $search)
    {
        if( $search != "") {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('business_name', 'like', '%' . $search . '%')
                    ->orWhere('document', 'like', '%' . $search . '%')
                    ->orWhere('legal_representative', 'like', '%' . $search . '%');
            });
        }
    }
}
