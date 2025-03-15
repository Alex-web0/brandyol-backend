<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'banner_type',
        'section',
        'type',
        'brand_id',
        'product_id',
        'url'
    ];
}
