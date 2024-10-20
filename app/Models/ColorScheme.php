<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ColorScheme extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'name_kr', 'color'];


    public function products(): HasMany
    {
        throw "";
    }
}
