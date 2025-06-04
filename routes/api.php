<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PackageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('all_info', [PackageController::class, 'allInfo']);
Route::get('package', [PackageController::class, 'packageDetail']);
Route::get('hotels', [PackageController::class, 'getHotelsFromAPI']);
Route::get('region-packages', [PackageController::class, 'regionPackages']);
Route::get('regions', [PackageController::class, 'getRegions']);