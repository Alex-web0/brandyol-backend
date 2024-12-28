<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    static public $ownerType = 'products';

    protected $fillable = [
        'id',
        'name',
        'name_kr',
        'description',
        'usage',


        'stock',
        'cost',
        'price',
        'discount',
        'file_attachment_id',
        'color_scheme_id',
        'user_id',
        'brand_id',
        'is_available'

    ];

    public function features(): HasMany
    {
        return $this->hasMany(ProductFeature::class);
    }
    public function colorScheme(): BelongsTo
    {
        return $this->belongsTo(ColorScheme::class);
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /// the user who created the product
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /// UNIFIED IMAGE COLLECTION METHOD
    public function images(): Collection
    {
        return FileAttachment::where('owner_id', '=', $this->id)
            ->where('owner_type', '=', $this::$ownerType)
            ->get();
    }

    /// THE IMAGE OF THIS PARTICULAR PRODUCT (THUMBNAIL)
    public function image(): HasOne
    {
        return $this->hasOne(FileAttachment::class, 'id', 'file_attachment_id');
    }

    /// I M P L E M E N T
    public function orders()
    {
        // TODO: Implement (return all orders RELATIONSHIP)
        return FileAttachment::where('id', '=', 1);
    }

    /// I M P L E M E N T
    public function sales()
    {
        // TODO: Implement (returns success orders)
        return FileAttachment::where('id', '=', 1);
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function likes(): HasManyThrough
    {
        return $this->hasManyThrough(Reaction::class, Review::class);
    }
}
