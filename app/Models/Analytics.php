<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    use HasFactory;

    /// will return raw json of results
    public function difference(Analytics $a)
    {
        return [
            'total_sales' => abs($this->total_sales - $a->total_sales),
            'estimated_revenue' => abs($this->estimated_revenue - $a->estimated_revenue),
            'user_count' => abs($this->user_count - $a->user_count),
            'transactions_count' => abs($this->transactions_count - $a->transactions_count),
            'brand_count' => abs($this->brand_count - $a->brand_count),
            'color_count' => abs($this->color_count - $a->color_count),
            'completed_orders' => abs($this->completed_orders - $a->completed_orders),
            'pending_orders' => abs($this->pending_orders - $a->pending_orders),
            'total_products' => abs($this->total_products - $a->total_products),
        ];
    }
}
