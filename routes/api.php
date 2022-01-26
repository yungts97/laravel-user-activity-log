<?php
use Illuminate\Support\Facades\Route;
use Yungts97\LaravelUserActivityLog\Controllers\UserActivityLogController;

Route::prefix('api')->middleware(config('user-activity-log.middleware'))->group(function () {
    Route::prefix('logs')->group(function () {
        Route::get('/filter-options', [UserActivityLogController::class, 'getFilterOption']);
        Route::get('/', [UserActivityLogController::class, 'index']);
        Route::get('/{log}', [UserActivityLogController::class, 'show']);
        Route::delete('/', [UserActivityLogController::class, 'destroy']);
    });
});