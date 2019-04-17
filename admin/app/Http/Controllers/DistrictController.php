<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistrictController extends Controller
{
    protected $table = 'departament';
    protected $fillable = ['name', 'departament_id', 'province_id'];
}
