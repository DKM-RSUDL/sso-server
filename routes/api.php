<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/oauth/revoke', function (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        return response()->json(['message' => 'Token revoked']);
    });
});
