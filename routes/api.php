<?php

use App\Http\Controllers\ApiAiController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ImageBankController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('images', [GalleryController::class, 'index']);
    Route::post('images', [GalleryController::class, 'store']);
    Route::post('images/delete/{id}', [GalleryController::class, 'delete']);

    Route::post('/ai/freestyle', [ApiAiController::class, 'askToAi'])->name('ai.freestyle');
    Route::prefix('/image')->name('freepik.')->group(function() {
        Route::post('/', [ImageBankController::class, 'search'])->name('search');
    });
    Route::post('/tags', [TagController::class, 'search'])->name('api.tags.search');
    Route::post('/tags/word-or-sentence/attach', [TagController::class, 'addToWord'])->name('api.tags.add-to-word');
    Route::post('tags/word-or-sentence/remove', [TagController::class, 'removeFromWord'])->name('api.tags.remove-to-word');
});