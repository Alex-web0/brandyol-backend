<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AppSection extends Model
{
    use HasFactory;

    static string $ownerType = "AppSection";

    protected $fillable = [
        'id',
        'name',
        'banner_type',
        'section',
        'type',
        'brand_id',
        'product_id',
        'url',
    ];

    public function image(): ?FileAttachment
    {
        return FileAttachment::where(
            'owner_id',
            '=',
            $this->id
        )->where(
            'owner_type',
            '=',
            AppSection::$ownerType
        )->get()->first();
    }
}
