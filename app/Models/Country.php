<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable =  [
        'name'
    ];

    /**
     * Get the states that belong to country
     */
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
}
