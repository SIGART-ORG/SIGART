<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'sites';
    protected $fillable = ['name', 'address', 'status'];

    public function scopeSelectList($query){
        $query->select(
            'id',
            'name',
            'address',
            'status'
        );
    }

    public function scopeFilterNotStatus($query, $status){
        if(!empty($status)){
            if(is_integer($status)){
                $query->where('status', '<>', $status);
            }
        }
    }

    public function scopeOrderBySite($query, $order){
        if(!empty($order)){
            if(is_array($order) and count($order)>0){
                $query->orderBy($order[0], $order[1]);
            }
        }
    }

    public function scopeSearchSite($query, $search){
        if(!empty($search)){
            if(is_array($search) and count($search)>0){
                $query->where($search[0], 'like', '%'.$search[1].'%');
            }
        }
    }
}
