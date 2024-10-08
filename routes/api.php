<?php

use App\Http\Controllers\Api\WordOrSentenceApiController;
use App\Http\Controllers\ApiAiController;
use App\Http\Controllers\Auth\Api\UserController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ImageBankController;
use App\Http\Controllers\IrregularVerbController;
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

    Route::prefix('irregular-verbs')->group(function () {
        Route::get('/', [IrregularVerbController::class, 'list']);
        Route::post('/', [IrregularVerbController::class, 'store']);
        Route::get('/{irregularVerb}', [IrregularVerbController::class, 'show']);
        Route::put('/{irregularVerb}', [IrregularVerbController::class, 'update']);
        Route::delete('/{irregularVerb}', [IrregularVerbController::class, 'destroy']);
    });

    Route::prefix('words')->group(function () {
        Route::get('/', [WordOrSentenceApiController::class, 'index']);
        Route::post('/', [WordOrSentenceApiController::class, 'store']);
        Route::get('/search', [WordOrSentenceApiController::class, 'search'])->name('api.words.search');
        Route::get('/{id}', [WordOrSentenceApiController::class, 'show']);
    });
    Route::get('/logout', [UserController::class, 'logout'])->name('api.logout');
});

Route::post('/login', [UserController::class, 'login'])->name('api.login');
