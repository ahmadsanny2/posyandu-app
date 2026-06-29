<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role Checks
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKader(): bool
    {
        return $this->role === 'kader';
    }

    public function isParent(): bool
    {
        return $this->role === 'parent';
    }

    // Relationships
    public function toddlers()
    {
        return $this->hasMany(Toddler::class);
    }

    public function pregnantWomen()
    {
        return $this->hasMany(PregnantWoman::class);
    }

    public function elderlies()
    {
        return $this->hasMany(Elderly::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
