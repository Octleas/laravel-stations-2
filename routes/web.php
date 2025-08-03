<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;

// Route::get('URL', [Controllerの名前::class, 'Controller内のfunction名']);
Route::get('/movies', [PracticeController::class, 'movies']);