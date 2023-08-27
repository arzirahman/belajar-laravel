<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ["username", "password", "name"];

    protected $hidden = ["password"];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'userId', 'id');
    }
}
