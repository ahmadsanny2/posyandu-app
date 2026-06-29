<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Elderly extends Model
{
    use HasFactory;

    protected $table = 'elderlies';

    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'medical_history',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function records()
    {
        return $this->hasMany(ElderlyRecord::class);
    }
}
