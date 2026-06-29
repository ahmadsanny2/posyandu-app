<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToddlerMeasurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'toddler_id',
        'schedule_id',
        'weight_kg',
        'height_cm',
        'head_circumference_cm',
        'immunization_type',
    ];

    public function toddler()
    {
        return $this->belongsTo(Toddler::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
