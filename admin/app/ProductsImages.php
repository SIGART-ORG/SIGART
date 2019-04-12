<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsImages extends Model
{
    protected $table = 'products_images';
    protected $fillable = ['products_id', 'image_original', 'image_galery', 'image_admin', 'image_facebook', 'status'];
}
