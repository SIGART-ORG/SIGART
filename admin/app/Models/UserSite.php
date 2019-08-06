<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSite extends Model
{
    protected $table = 'user_sites';
    protected $fillable = ['users_id', 'roles_id', 'sites_id', 'default', 'status'];
}
