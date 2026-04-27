<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;



Route::get('/upload', [PhotoController::class, 'create']);
Route::post('/upload-single', [PhotoController::class, 'storeSingle'])->name('photos.store.single');
Route::post('/upload-multiple', [PhotoController::class, 'storeMultiple2'])->name('photos.store.multiple');
Route::delete('/photos/{photo}', [PhotoController::class, 'destroyImage'])->name('photos.destroy');
