<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table = 'holidays';
    protected $fillable = ['day', 'month', 'description', 'status'];

    public function scopeSelectList($query){
        $query->select(
            'id',
            'day',
            'month',
            'description',
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

    public function scopeSearch($query, $search){
        if(!empty($search)){
            if(is_array($search) and count($search)>0){
                $query->where($search[0], 'like', '%'.$search[1].'%');
            }
        }
    }
}
