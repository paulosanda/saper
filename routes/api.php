<?php

use App\Http\Controllers\AgendaController;
use Illuminate\Support\Facades\Route;

Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
Route::delete('/agenda/{id}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
Route::put('/agenda/{id}', [AgendaController::class, 'update'])->name('agenda.update');
Route::get('/agenda/nomes', [AgendaController::class, 'names'])->name('agenda.nomes');
