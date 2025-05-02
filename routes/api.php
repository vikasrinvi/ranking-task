<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\RankingController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', function (Request $request) {
    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);
    return ['token' => $user->createToken('api-token')->plainTextToken];
});

Route::post('/login', function (Request $request) {
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
    return ['token' => Auth::user()->createToken('api-token')->plainTextToken];
});




Route::middleware('auth:sanctum')->group(function () {
    Route::get('/players', [PlayerController::class, 'index']);
    Route::post('/submit-rankings', [RankingController::class, 'submit']);
    Route::get('/my-rankings', [RankingController::class, 'myRankings']);
});
