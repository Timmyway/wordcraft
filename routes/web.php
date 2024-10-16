<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\IrregularVerbController;
use App\Http\Controllers\MindwallController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromptController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ThematicController;
use App\Http\Controllers\WordOrSentenceController;
use App\Models\IrregularVerb;
use App\Models\Tag;
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

Route::get('words', [WordOrSentenceController::class, 'indexPage'])->name('word.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('storage/private/images/uploads/{filename}', [GalleryController::class, 'uploadedImage'])->name('private.image');
    Route::get('storage/private/images/uploads/thumbnails/{filename}', [GalleryController::class, 'thumbnailImage'])->name('private.thumbnail');

    Route::prefix('words')->name('word.')->group(function () {
        // Route::get('', [WordOrSentenceController::class, 'indexPage'])->name('index');
        Route::get('/filter', [WordOrSentenceController::class, 'indexPage']);
        Route::post('/filter', [WordOrSentenceController::class, 'indexPage'])->name('filter');
        Route::get('/add', [WordOrSentenceController::class, 'addPage'])->name('add');
        Route::get('/{word?}/{mode?}', [WordOrSentenceController::class, 'formPage'])->name('detail');
        Route::post('', [WordOrSentenceController::class, 'store'])->name('store');
        Route::put('/{wordOrSentence}', [WordOrSentenceController::class, 'update'])->name('update');
        Route::post('/{word}/comment', [WordOrSentenceController::class, 'addComment'])->name('comment.add');
    });
    Route::prefix('tags')->name('tag.')->group(function () {
        Route::get('', [TagController::class, 'indexPage'])->name('index');
        Route::get('/add', [TagController::class, 'addPage'])->name('add');
        Route::get('/{tag?}/{mode?}', [TagController::class, 'formPage'])->name('detail');
        Route::post('', [TagController::class, 'store'])->name('store');
        Route::get('/filter', [TagController::class, 'indexPage'])->name('filter');
        Route::put('/{tag}', [TagController::class, 'update'])->name('update');
        Route::post('/filter', [TagController::class, 'indexPage'])->name('filter.apply');
        Route::delete('{tag}', [TagController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('playlists')->name('playlist.')->group(function () {
        Route::get('', [PlaylistController::class, 'indexPage'])->name('index');
        Route::get('/add', [PlaylistController::class, 'addPage'])->name('add');
        Route::post('', [PlaylistController::class, 'store'])->name('store');
        Route::get('{playlist}', [PlaylistController::class, 'explorePage'])->name('explore');
        Route::get('/{playlist?}/{mode?}', [PlaylistController::class, 'formPage'])->name('detail');
        Route::delete('{playlistId}', [PlaylistController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('irregular-verbs')->name('irregular-verb.')->group(function () {
        Route::get('/', [IrregularVerbController::class, 'indexPage'])->name('index');
        Route::get('/filter', [IrregularVerbController::class, 'indexPage'])->name('filter');
        Route::post('/filter', [IrregularVerbController::class, 'indexPage'])->name('filter.apply');
    });
    Route::get('help', [HelpController::class, 'index'])->name('help');
});

require __DIR__.'/auth.php';
