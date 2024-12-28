<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'likes',
        'did_buy',
        'content',

        // relations keys
        'user_id',
        'product_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    public function didBuy(): HasMany
    {
        // TODO: change to order
        // return $this->hasMany(Order::class)
        //     ->where('status', 'success')
        //     ->where('product_id', '=', $this->product_id); // Match the product being reviewed
        return $this->hasMany(Reaction::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    public function replies(): HasMany
    {
        //  TODO: make it so it returns replies relationship
        throw '';
    }
}
