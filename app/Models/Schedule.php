<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'target_type',
        'scheduled_at',
        'location',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
        ];
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function toddlerMeasurements()
    {
        return $this->hasMany(ToddlerMeasurement::class);
    }

    public function pregnancyRecords()
    {
        return $this->hasMany(PregnancyRecord::class);
    }

    public function elderlyRecords()
    {
        return $this->hasMany(ElderlyRecord::class);
    }
}
