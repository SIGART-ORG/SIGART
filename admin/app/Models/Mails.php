<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mails extends Model
{
    protected $table = 'mails';
    protected $fillable = ['from', 'to', 'subject', 'body', 'dateSend', 'status'];
}
