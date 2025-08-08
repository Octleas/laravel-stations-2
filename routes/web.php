<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;

// Route::get('URL', [Controllerの名前::class, 'Controller内のfunction名']);
Route::get('/movies', [PracticeController::class, 'movies']);
Route::get('/admin/movies', [PracticeController::class, 'admin'])->name('admin.movies'); // 管理者用のルート
Route::get('/admin/movies/create', [PracticeController::class, 'create'])->name('admin.movies.create'); //映画登録フォームのルート
Route::post('/admin/movies/store', [PracticeController::class, 'store'])->name('admin.movies.store'); // 映画の作成用ルート