<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Models\User;

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
Route::get("/map", function () {
    return view("map.index");
})->name("map.index");

Route::get("/profile/{id}", function ($id) {
    $user = User::findOrFail($id);

    return view("profile.show", compact("user"));
})
    ->name("profile")
    ->middleware("auth");
