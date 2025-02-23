<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get("/links", [LinkController::class, 'show']);
    Route::post("/links", [LinkController::class, 'create']);
    Route::put("/links", [LinkController::class, 'update']);
    Route::delete("/links/{id}", [LinkController::class, 'destroy']);

    Route::get("/profile", [ProfileController::class, 'show']);
    Route::put("/profile", [ProfileController::class, 'update']);
});

Route::get("/profile/{username}", [ProfileController::class, 'showPublicProfile']);
