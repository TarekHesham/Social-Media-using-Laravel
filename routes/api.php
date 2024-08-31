<?php

use App\Http\Controllers\Api\PostController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/post', PostController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/post', PostController::class)->only(['store', 'update', 'destroy']);
});

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

// First token -> 1|1hPAak8lVz6QkM3HssrYM0XULIqzwYKhSbI83c9Yb4bcdcbc
// 2|vC1KRskorYnUhFrdBOaYcWWdtawIj5j1Au2IDkvI96c981af

route::post("/sanctum/logout", function () {
    $user = Auth::user();
    // @intelephense-ignore-next-line
    if ($user && $user->currentAccessToken()) {
        // @intelephense-ignore-next-line
        $user->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
    return response()->json(['message' => 'No active session found'], 400);
})->middleware('auth:sanctum');
