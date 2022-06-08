<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// AUTH
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login/post-authentication', [AuthController::class, 'post_authentication']);
Route::post('/login/post-authorization', [AuthController::class, 'post_authorization']);
Route::post('/login/post-logout', [AuthController::class, 'post_logout']);

// STUDENT
Route::get('/generus', [StudentController::class, 'index'])->middleware('auth');

Route::get('/generus/impor-excel-remaja', [StudentController::class, 'teens_excel_import']);
Route::post('/generus/post-impor-excel-remaja', [StudentController::class, 'post_teens_excel_import']);
Route::post('/generus/post-simpan-impor-remaja', [StudentController::class, 'post_teens_excel_save']);

Route::get('/generus/impor-excel-caberawit', [StudentController::class, 'children_excel_import']);
Route::post('/generus/post-impor-excel-caberawit', [StudentController::class, 'post_children_excel_import']);
Route::post('/generus/post-simpan-impor-caberawit', [StudentController::class, 'post_children_excel_save']);

Route::get('/generus/statistika-ppk', [StudentController::class, 'group_statistic']);
Route::get('/generus/statistika-ppd', [StudentController::class, 'village_statistic']);