<?php

namespace App\Jobs;

use App\Models\Analytics;
use App\Models\Brand;
use App\Models\ColorScheme;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogAnalytics implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $loggedCurrent = new Analytics(
            [
                'total_sales' => 0, // TODO: add sales query
                'estimated_revenue' => 0,
                'user_count' => User::count(),
                'transactions_count' => 0,
                'brand_count' => Brand::count(),
                'color_count' => ColorScheme::count(),
                'completed_orders' => 0,
                'pending_orders' => 0,
                'total_products' => Product::count(),
            ]
        );

        $saved = $loggedCurrent->save();

        error_log('[ANALYTIC UTILITY] PULLED SNAPSHOT SUCCESS....');

        if (!$saved) {
            report(new Exception("Failed to log analytics atm..."));
        }
    }
}
