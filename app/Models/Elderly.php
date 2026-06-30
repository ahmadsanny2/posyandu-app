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
        'address',
        'medical_history',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function records()
    {
        return $this->hasMany(ElderlyRecord::class);
    }
}
