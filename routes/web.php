<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;

// Home chama o controller para mostrar os repositórios
Route::get('/', [PortfolioController::class, 'index'])->name('home');

// Rota separada se quiser acessar só os repositórios
Route::get('/portfolio', [PortfolioController::class, 'index']);
