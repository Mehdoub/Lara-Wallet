<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeIsActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    public function scopeHasKey(Builder $query, string $key) : void
    {
        $query->where('key', $key);
    }
}
