<?php

use App\Http\Controllers\BarterController;
use App\Http\Controllers\BazaarController;
use App\Http\Controllers\CharacterCompareController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CharacterMoverController;
use App\Http\Controllers\GuildController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LdonController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SpellController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// global search
Route::get('/search/suggest', [SearchController::class, 'suggest']);
Route::get('/search', [SearchController::class, 'index'])->name('search.results');

Route::get('/guild/{guild}', [GuildController::class, 'show'])->name('guild.show');
Route::get('/character/compare', [CharacterCompareController::class, 'index'])->name('character.compare');
Route::post('/character/{character}/move', [CharacterController::class, 'move'])->name('character.move');
Route::get('/char-mover', [CharacterMoverController::class, 'index'])->name('char.mover.index');
Route::post('/char-mover', [CharacterMoverController::class, 'store'])->name('char.mover.store');
Route::get('/character/{character}', [CharacterController::class, 'show'])->name('character.show');
Route::get('/bazaar', [BazaarController::class, 'index'])->name('bazaar.index');
Route::get('/barter', [BarterController::class, 'index'])->name('barter.index');
Route::get('/ldon', [LdonController::class, 'index'])->name('ldon.index');

Route::get('/items/popup/{item}', [ItemController::class, 'popup'])->name('items.popup');
Route::get('/spells/popup/{spell}', [SpellController::class, 'popup'])->name('spells.popup');
