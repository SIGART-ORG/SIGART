<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';
    protected $fillable = ['name', 'icon', 'status'];

    public function pages(){
        return $this->hasMany('App\Page', 'module_id');
    }

    public function scopeSelectList($query){
        $query->select(
            'id',
            'name',
            'icon',
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

    public function scopeOrderByModule($query, $order){
        if(!empty($order)){
            if(is_array($order) and count($order)>0){
                $query->orderBy($order[0], $order[1]);
            }
        }
    }

    public function scopeSearchModule($query, $search){
        if(!empty($search)){
            $query->where('name', 'like', '%'.$search.'%');
        }
    }
}
