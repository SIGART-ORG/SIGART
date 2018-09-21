<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';
    protected $fillable = ['name', 'status'];

    public function pages(){
        return $this->hasMany('App\Page', 'module_id');
    }
}
