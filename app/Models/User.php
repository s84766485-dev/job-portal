<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin(): bool     { return $this->role === 'admin'; }
    public function isEmployer(): bool  { return $this->role === 'employer'; }
    public function isCandidate(): bool { return $this->role === 'candidate'; }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
