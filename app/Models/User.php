<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $fillable = ["username", "password", "name"];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'userId', 'id');
    }
}
