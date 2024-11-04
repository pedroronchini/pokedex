<?php

use App\Http\Controllers\PokedexController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PokedexController::class, 'index'])->name('pokedex.index');
Route::get('/pokedex/search', [PokedexController::class, 'search'])->name('pokedex.search');
