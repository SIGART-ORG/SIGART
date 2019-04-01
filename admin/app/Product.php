<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['category_id', 'unity_id', 'user_reg', 'name', 'description', 'pricetag', 'status'];
}
