<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PregnancyRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregnant_woman_id',
        'schedule_id',
        'weight_kg',
        'blood_pressure',
        'upper_arm_circumference_cm',
        'gestational_age_weeks',
        'fetal_heart_rate',
        'action_notes',
    ];

    public function pregnantWoman()
    {
        return $this->belongsTo(PregnantWoman::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
