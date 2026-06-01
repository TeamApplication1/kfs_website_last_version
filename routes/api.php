<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VoiceComplaintController;

Route::post('/voice-complaint', [VoiceComplaintController::class, 'store']);
Route::middleware('auth:sanctum')->post('/fcm-token', function (Request $request) {
    $request->validate(['token' => 'required|string']);
    $request->user()->update(['fcm_token' => $request->token]);
    return response()->json(['message' => 'Token saved']);
});