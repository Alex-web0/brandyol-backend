<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ApiHealthController;
use App\Http\Controllers\AppSectionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FileAttachmentController;
use App\Http\Controllers\MarketingCampaignController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFeatureController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewLikingController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserBanController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\CheckRole;
use App\Models\Analytics;
use App\Models\ColorScheme;
use App\Models\MarketingCampaign;
use Illuminate\Support\Facades\Route;


/* =======================  Health  ======================= */

Route::get('health', [ApiHealthController::class, 'index']);

/* =======================  V1 API  ======================= */

Route::prefix('v1')->group(function () {

    /* =======================  AUTH  ======================= */
    Route::prefix('auth')->group(function () {
        Route::post('otp-login', [AuthController::class, 'otpLogin']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::get('logout', [AuthController::class, 'logout']);
            Route::get('user', [AuthController::class, 'user']);
        });
        // Route::get('/user', function (Request $request) {
        //     return $request->user();
        // })->middleware('auth:sanctum');
    });


    /* =======================  USERS  ======================= */
    Route::prefix('users')->middleware('auth:sanctum')->group(
        function () {

            Route::patch('update-notification-token', [UsersController::class, 'updateNotificationToken']);
            Route::get('notifications', [UsersController::class, 'notifications']);

            /// Staff Only
            Route::middleware([CheckRole::class . ':admin,manager'])->group(function () {
                Route::get('/', [UsersController::class, 'index']);
            });
            Route::middleware([CheckRole::class . ':admin'])->group(
                function () {
                    Route::post('/create', [UsersController::class, 'store']);
                    Route::put('/{id}', [UsersController::class, 'update']);
                    Route::post('/admin-password-reset', [UsersController::class, 'adminPasswordReset']);
                    Route::get('/user-statistics/{id}', [UsersController::class, 'getUserStatistics']);
                }
            );
        }
    );

    /* =======================  USERS BANS  ======================= */
    Route::prefix('user-bans')->middleware(['auth:sanctum', CheckRole::class . ':admin'])->group(
        function () {

            Route::post('/{id}/ban', [UserBanController::class, 'banUser']);
            Route::delete('/{id}', [UserBanController::class, 'liftBan']);
            Route::post('/{id}/shadow-ban', [UserBanController::class, 'changeShadowBanStatus']);
        }
    );



    /* =======================  FILE ATTACHMENTS  ======================= */
    Route::prefix('file-attachment')->middleware('auth:sanctum')->group(
        function () {
            Route::get('/', [FileAttachmentController::class, 'index']);
            Route::post('/upload', [FileAttachmentController::class, 'store']);
            Route::post('/update/{id}', [FileAttachmentController::class, 'update']);
            Route::delete('/delete/{id}', [FileAttachmentController::class, 'destroy']);
        }
    );


    /* =======================  ANALYTICS  ======================= */
    Route::prefix('analytics')->middleware('auth:sanctum')->group(
        function () {
            Route::get('/', [AnalyticsController::class, 'index']);
        }
    );


    /* =======================  COUNTRIES  ======================= */
    Route::prefix('countries')->group(
        function () {
            Route::get('/', [CountryController::class, 'index']);
        }
    );

    /* =======================  STATES  ======================= */
    Route::prefix('states')->group(
        function () {
            Route::get('/', [StateController::class, 'index']);
        }
    );


    /* =======================  BRANDS  ======================= */
    Route::prefix('brands')->middleware('auth:sanctum')->group(
        function () {
            Route::get('/', [BrandController::class, 'index']);
            Route::post('/', [BrandController::class, 'store']);
            Route::put('/{id}', [BrandController::class, 'update']);
            Route::delete('/{id}', [BrandController::class, 'destroy']);
        }
    );

    /* =======================  COLOR SCHEMES  ======================= */
    Route::prefix('color-schemes')->middleware('auth:sanctum')->group(
        function () {
            Route::get('/', [ColorSchemeController::class, 'index']);
            Route::post('/', [ColorSchemeController::class, 'store']);
            Route::put('/{id}', [ColorSchemeController::class, 'update']);
            Route::delete('/{id}', [ColorSchemeController::class, 'destroy']);
        }
    );



    /* =======================  PRODUCT FEATURES  ======================= */
    Route::prefix('product-features')->middleware('auth:sanctum')->group(
        function () {
            Route::get('/', [ProductFeatureController::class, 'index']);
            Route::post('/', [ProductFeatureController::class, 'store']);
            Route::put('/{id}', [ProductFeatureController::class, 'update']);
            Route::delete('/{id}', [ProductFeatureController::class, 'destroy']);
        }
    );


    /* =======================  PRODUCTS  ======================= */
    Route::prefix('products')->middleware('auth:sanctum')->group(
        function () {
            // gets all the products 
            Route::get('/', [ProductController::class, 'index']);

            // role checked
            Route::middleware([CheckRole::class . ':admin'])->group(
                function () {
                    Route::post('/', [ProductController::class, 'store']);
                    Route::put('/{id}', [ProductController::class, 'update']);
                    Route::delete('/{id}', [ProductController::class, 'destroy']);
                }
            );
        }
    );

    /* =======================  REVIEWS  ======================= */
    Route::prefix('reviews')->middleware('auth:sanctum')->group(
        function () {
            // gets all the products 
            Route::get('/', [ReviewController::class, 'index']);
            Route::get('/user-listing', [ReviewController::class, 'userListing']);

            Route::post('/', [ReviewController::class, 'store']);
            Route::put('/{id}', [ReviewController::class, 'update']);
            Route::delete('/{id}', [ReviewController::class, 'destroy']);



            // role checked
            Route::middleware([CheckRole::class . ':admin'])->group(
                function () {}
            );
        }
    );


    /* =======================  REACTIONS & LIKES  ======================= */
    Route::prefix('reactions/reviews')->middleware('auth:sanctum')->group(
        function () {
            Route::post('/{id}', [ReviewLikingController::class, 'likeReview']);
            Route::delete('/{id}', [ReviewLikingController::class, 'unlikeReview']);
        }
    );

    /* =======================  APP SECTIONS MANAGEMENT  ======================= */
    Route::prefix('app_sections')->middleware('auth:sanctum')->group(
        function () {
            Route::get('/', [AppSectionController::class, 'index']);
            Route::post('/', [AppSectionController::class, 'store']);
            Route::delete('/{id}', [AppSectionController::class, 'destroy']);
        }
    );


    /* =======================  MARKETING CAMPAIGNS  ======================= */
    Route::prefix('campaigns')->middleware('auth:sanctum')->group(
        function () {
            Route::post('/', [MarketingCampaignController::class, 'store']);
            Route::get('/', [MarketingCampaignController::class, 'index']);
            Route::get('/extract-user-data', [MarketingCampaignController::class, 'extractUserData']);
        }
    );
});
