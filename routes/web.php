<?php

use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PackageController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('admin')->name("admin.")->group(function () {
        Route::resource('packages', PackageController::class);
        Route::resource('regions', RegionController::class);
        Route::resource('promos', PromoController::class);
        // Ruta adicional para eliminar imágenes de galería
        Route::delete('gallery-images/{galleryImage}', [PackageController::class, 'destroyGalleryImage'])->name('gallery-images.destroy');
    });

});

require __DIR__.'/auth.php';
