<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'name_kr'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    public function image(): ?FileAttachment
    {
        return FileAttachment::where(
            'owner_id',
            '=',
            $this->id
        )->where(
            'owner_type',
            '=',
            'brand'
        )->get()->first();
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($value) {
            $value->image()->destroyCompletely();
        });
    }
}
