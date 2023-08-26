<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $timestamps = true;
    protected $incrementing = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'userId', 'id');
    }
}
