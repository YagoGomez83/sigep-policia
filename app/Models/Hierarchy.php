<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hierarchy extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'rank_level',
    ];

    /**
     * Get the agents with this hierarchy.
     */
    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class);
    }

    /**
     * Scope para ordenar por nivel de autoridad.
     */
    public function scopeByAuthority($query)
    {
        return $query->orderBy('rank_level', 'asc');
    }
}
