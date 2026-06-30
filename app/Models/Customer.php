<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'created_at',
        'updated_at',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}