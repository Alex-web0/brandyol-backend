<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingCampaign extends Model
{
    use HasFactory;

    protected $fillable = [

        'title',
        'body',
        'type',
        'from_date_joined',
        'to_date_joined',
        'gender',
        'from_total_orders',
        'to_total_orders',

        'sent',
        'failed',
        'image_url',
    ];
}
