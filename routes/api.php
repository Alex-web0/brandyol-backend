<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FileAttachmentController;
use App\Http\Controllers\MarketingCampaignController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserBanController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\CheckRole;
use App\Models\ColorScheme;
use App\Models\MarketingCampaign;
use Illuminate\Support\Facades\Route;


/* =======================  Health  ======================= */

// Route::get('health', [ApiHealthController::class, 'index']);

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
            Route::middleware([CheckRole::class . 'admin,manager'])->group(function () {
                Route::get('/', [UsersController::class, 'index']);
            });
            Route::middleware([CheckRole::class . 'admin'])->group(
                function () {
                    Route::post('/create', [UsersController::class, 'store']);
                    Route::put('/{id}', [UsersController::class, 'update']);
                    Route::post('/admin-password-reset', [UsersController::class, 'adminPasswordReset']);
                }
            );
        }
    );

    /* =======================  USERS BANS  ======================= */
    Route::prefix('user-bans')->middleware(['auth:sanctum', CheckRole::class . 'admin'])->group(
        function () {

            Route::post('/{id}/ban', [UserBanController::class, 'banUser']);
            Route::delete('/{id}', [UserBanController::class, 'liftBan']);
        }
    );



    /* =======================  FILE ATTACHMENTS  ======================= */
    Route::prefix('file-attachment')->middleware('auth:sanctum')->group(
        function () {
            Route::get('/', [FileAttachmentController::class, 'index']);
            Route::post('/upload', [FileAttachmentController::class, 'store']);
            Route::delete('/delete/{id}', [FileAttachmentController::class, 'destroy']);
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



    /* =======================  MARKETING CAMPAIGNS  ======================= */
    Route::prefix('campaigns')->group(
        function () {
            Route::post('/', [MarketingCampaignController::class, 'store']);
        }
    );
});
