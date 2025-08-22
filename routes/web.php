<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;

// Route::get('URL', [Controllerの名前::class, 'Controller内のfunction名']);
//映画関係
Route::get('/movies', [PracticeController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}',[PracticeController::class, 'detail'])->name('movies.detail');

//映画管理関係(Route::resource('admin/movies', MovieController::class);)
Route::get('/admin/movies', [PracticeController::class, 'admin'])->name('admin.movies'); // 管理者用のルート
Route::get('/admin/movies/create', [PracticeController::class, 'create'])->name('admin.movies.create'); //映画登録フォームのルート
Route::post('/admin/movies/store', [PracticeController::class, 'store'])->name('admin.movies.store'); // 映画の作成用ルート
Route::get('/admin/movies/{id}', [PracticeController::class, 'adminMovieDetail'])->name('admin.movies.detail'); //管理者用映画詳細ページ
Route::get('/admin/movies/{id}/edit', [PracticeController::class, 'edit'])->name('admin.movies.edit'); //映画編集フォームのルート
Route::match(['put', 'patch'], '/admin/movies/{id}/update', [PracticeController::class, 'update'])->name('admin.movies.update');
Route::delete('/admin/movies/{id}/destroy', [PracticeController::class, 'destroy'])->name('admin.movies.destroy'); // 映画削除

//座席関係
Route::get('/sheets', [PracticeController::class, 'sheets'])->name('movies.sheet');

//スケジュール管理関係
Route::get('/admin/schedules', [PracticeController::class, 'schedules'])->name('admin.schedules'); //映画スケジュール一覧
Route::get('/admin/schedules/{id}', [PracticeController::class, 'scheduleDetail'])->name('admin.schedules.detail'); //映画スケジュール詳細
Route::get('/admin/movies/{id}/schedules/create', [PracticeController::class, 'scheduleCreate'])->name('admin.schedules.create'); //映画スケジュール作成画面
Route::get('/admin/schedules/{id}/edit', [PracticeController::class, 'scheduleEdit'])->name('admin.schedules.edit'); //映画スケジュール編集画面
Route::post('/admin/movies/{id}/schedules/store', [PracticeController::class, 'scheduleStore'])->name('admin.schedules.store'); //映画スケジュール作成ルート
Route::match(['put', 'patch'], '/admin/schedules/{id}/update', [PracticeController::class, 'scheduleUpdate'])->name('admin.schedules.update'); //映画スケジュール編集ルート
Route::delete('/admin/schedules/{id}/destroy', [PracticeController::class, 'scheduleDestroy'])->name('admin.schedules.destroy'); //映画スケジュール削除ルート