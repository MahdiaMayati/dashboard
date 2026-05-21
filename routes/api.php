<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ServiceCategoryController;
use App\Http\Controllers\Api\V1\ArtisanProfileController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\SupportTicketController;

/*
|--------------------------------------------------------------------------
| API Routes V1 - نظام الخدمات المنزلية الطارئة
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register/customer', [AuthController::class, 'registerCustomer']);

    Route::get('/categories', [ServiceCategoryController::class, 'index']);
    Route::get('/categories/{slug}', [ServiceCategoryController::class, 'show']);

    // 2. مسارات محمية (تتطلب Bearer Token للمصادقة عبر الـ App)
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        // حساب وإعدادات الحرفي
        Route::get('/artisan/me', [ArtisanProfileController::class, 'me']);
        Route::put('/artisan/update-status', [ArtisanProfileController::class, 'updateStatus']);

        // إدارة وتتبع الطلبات (العميل والحرفي)
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus']);

        // التقييمات والدعم الفني
        Route::post('/orders/{order}/review', [ReviewController::class, 'store']);
        Route::post('/support/tickets', [SupportTicketController::class, 'store']);
    });
});

//     // للحصول على بيانات المستخدم الحالي المسجل دخوله
// Route::get('/user', function (Request $request) {
//     return $request->user();
// });
// });
