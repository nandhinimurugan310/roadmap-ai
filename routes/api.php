<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ChatController;

Route::get('/ping', function () {
    return response()->json(['status' => 'API OK']);
});

Route::post('/chat', [ChatController::class, 'handle']);
