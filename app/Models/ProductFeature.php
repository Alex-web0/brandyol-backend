<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'title',
        'value'
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
