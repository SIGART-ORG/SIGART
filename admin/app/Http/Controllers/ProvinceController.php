<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    protected $table = 'province';
    protected $fillable = ['name', 'departament_id'];
}
