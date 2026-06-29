<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ElderlyRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'elderly_id',
        'schedule_id',
        'weight_kg',
        'blood_pressure',
        'blood_sugar',
        'cholesterol',
        'uric_acid',
    ];

    public function elderly()
    {
        return $this->belongsTo(Elderly::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
