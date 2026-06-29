<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PregnantWoman extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'pregnancy_age_weeks',
        'estimated_delivery_date',
        'address',
        'medical_history',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function records()
    {
        return $this->hasMany(PregnancyRecord::class);
    }
}
