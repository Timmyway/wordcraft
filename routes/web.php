<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\MindwallController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromptController;
use App\Http\Controllers\ThematicController;
use App\Http\Controllers\WordOrSentenceController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('storage/private/images/uploads/{filename}', [GalleryController::class, 'uploadedImage'])->name('private.image');
    Route::get('storage/private/images/uploads/thumbnails/{filename}', [GalleryController::class, 'thumbnailImage'])->name('private.thumbnail');

    Route::prefix('words')->name('word.')->group(function () {
        Route::get('', [WordOrSentenceController::class, 'indexPage'])->name('index');
        Route::post('/filter', [WordOrSentenceController::class, 'indexPage'])->name('filter');
        Route::get('/add', [WordOrSentenceController::class, 'addPage'])->name('add');
        Route::get('/{word?}/{mode?}', [WordOrSentenceController::class, 'formPage'])->name('detail');
        Route::post('', [WordOrSentenceController::class, 'store'])->name('store');
        Route::put('/{wordOrSentence}', [WordOrSentenceController::class, 'update'])->name('update');
    });
    Route::get('help', [HelpController::class, 'index'])->name('help');
});

require __DIR__.'/auth.php';
