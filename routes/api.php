<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BazaarController;

Route::middleware(['throttle:bazaar-api', 'bazaar.api_key_auth'])->prefix('bazaar')->group(function () {
    Route::get('/listings', [BazaarController::class, 'listings']);
});
