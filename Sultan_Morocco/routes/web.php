<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\MessageController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return view("welcome");
});

Route::middleware("guest")->group(function () {
    Route::get("/login", [AuthController::class, "showLogin"])->name("login");
    Route::post("/login", [AuthController::class, "login"]);

    Route::get("/signup", [AuthController::class, "showSignup"])->name(
        "signup",
    );
    Route::post("/signup", [AuthController::class, "signup"]);
});

Route::get("/logout", [AuthController::class, "logout"])
    ->name("logout")
    ->middleware("auth");
Route::post("/logout", [AuthController::class, "logout"])->middleware("auth");

Route::get("/hotels", [HotelController::class, "index"])->name("hotels.index");
Route::get("/api/hotels", [HotelController::class, "list"])->name(
    "hotels.list",
);
Route::post("/api/chat", [ChatController::class, "chat"])->name("chat");

Route::get("/map", function () {
    return view("map.index");
})->name("map.index");

Route::get("/profile/{id}", function ($id) {
    $user = User::findOrFail($id);

    return view("profile.show", compact("user"));
})
    ->name("profile")
    ->middleware("auth");

Route::middleware("auth")->group(function () {
    Route::get("/messages", [MessageController::class, "index"])->name(
        "messages.index",
    );
    Route::post("/messages/by-user-id", [
        MessageController::class,
        "openByUserId",
    ])->name("messages.by_user_id");
    Route::get("/messages/{user}", [MessageController::class, "show"])->name(
        "messages.show",
    );
    Route::post("/messages/{user}", [MessageController::class, "store"])->name(
        "messages.store",
    );
});
