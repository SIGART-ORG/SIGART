<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'status'];

    public function products() {
        return $this->hasMany( 'App\Product', 'category_id' );
    }
}
