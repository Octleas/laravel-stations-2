<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;

//Route::resource('admin/movies', MovieController::class);
//と同じ？

// Route::get('URL', [Controllerの名前::class, 'Controller内のfunction名']);
Route::get('/movies', [PracticeController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}',[PracticeController::class, 'detail'])->name('movies.detail');
Route::get('/sheets', [PracticeController::class, 'sheets'])->name('movies.sheet');

Route::get('/admin/movies', [PracticeController::class, 'admin'])->name('admin.movies'); // 管理者用のルート
Route::get('/admin/movies/create', [PracticeController::class, 'create'])->name('admin.movies.create'); //映画登録フォームのルート
Route::post('/admin/movies/store', [PracticeController::class, 'store'])->name('admin.movies.store'); // 映画の作成用ルート
Route::get('/admin/movies/{id}/edit', [PracticeController::class, 'edit'])->name('admin.movies.edit'); //映画編集フォームのルート
Route::match(['put', 'patch'], '/admin/movies/{id}/update', [PracticeController::class, 'update'])->name('admin.movies.update');
Route::delete('/admin/movies/{id}/destroy', [PracticeController::class, 'destroy'])->name('admin.movies.destroy');//映画削除