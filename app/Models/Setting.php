<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'posyandu_name',
        'address',
        'phone',
        'email',
        'leader_name',
    ];
}
