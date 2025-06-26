<?php

use App\Http\Controllers\Api\QrCodeApiController;

Route::post('/qrcode', [QrCodeApiController::class, 'generate']);
