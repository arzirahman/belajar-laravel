<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'userId', 'id');
    }
}
