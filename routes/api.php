<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/login", [AuthController::class, 'login']);
Route::post("/register", [AuthController::class, 'register']);

Route::middleware("auth:sanctum")->group(function () {
    Route::resource("/barang", BarangController::class);
    Route::get("/keranjang", [KeranjangController::class, "index"]);
    Route::post("/keranjang/{id}", [KeranjangController::class, "store"]);
    Route::resource("/transaksi", TransaksiController::class);
    Route::get("/transaksi-latest", [TransaksiController::class, "getLatest"]);
    Route::get("/user", [AuthController::class, "authProfile"]);
    Route::post("/logout", [AuthController::class, "logout"]);
});