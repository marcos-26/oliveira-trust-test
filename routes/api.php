<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/', function () {
    return response()->json(['sucess' => '200'], 200);
});

Route::middleware('api.key')->group(function () {
    Route::post('/upload', [ApiController::class, 'upload']);
    Route::get('/history', [ApiController::class, 'history']);
    Route::get('/search', [ApiController::class, 'search']);
});


