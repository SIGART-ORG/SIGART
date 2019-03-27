<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    protected $fillable = ['name', 'status'];

    public function module(){
        return $this->belongsTo('App\Module', 'module_id', 'id');
    }

    public function access(){
        return $this->hasMany('App\Access', 'page_id', 'id');
    }
}
