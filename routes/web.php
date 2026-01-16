<?php

use App\Filament\Pages\Inscricao;
use Illuminate\Support\Facades\Route;

Route::get('/inscricao', Inscricao::class)->name('inscricao');

Route::view('/success', 'success')->name('success');

Route::view('/', 'index')->name('index');