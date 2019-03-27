<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'status'];

    public function users(){
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    public function access(){
        return $this->hasMany('App\Access', 'role_id', 'id');
    }
}
