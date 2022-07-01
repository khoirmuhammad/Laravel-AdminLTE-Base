<?php

use App\Http\Middleware\IsSuperadmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\ClassLevelController;
use App\Http\Controllers\RoleCategoriesController;
use App\Http\Controllers\PresenceDateConfigController;


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
})->middleware('auth');


// AUTH
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login/post-authentication', [AuthController::class, 'post_authentication']);
Route::post('/login/post-authorization', [AuthController::class, 'post_authorization']);
Route::post('/login/post-logout', [AuthController::class, 'post_logout']);

// STUDENT
Route::get('/generus', [StudentController::class, 'index'])->middleware('auth');
Route::get('/generus/tambah-generus', [StudentController::class, 'get_add_student'])->middleware('auth');
Route::get('/generus/ubah-generus', [StudentController::class, 'get_edit_student'])->middleware('auth');


Route::get('/generus/impor-excel-remaja', [StudentController::class, 'teens_excel_import'])->middleware('auth',IsSuperadmin::class);
Route::post('/generus/post-impor-excel-remaja', [StudentController::class, 'post_teens_excel_import'])->middleware('auth',IsSuperadmin::class);
Route::post('/generus/post-simpan-impor-remaja', [StudentController::class, 'post_teens_excel_save'])->middleware('auth',IsSuperadmin::class);

Route::get('/generus/impor-excel-caberawit', [StudentController::class, 'children_excel_import'])->middleware('auth',IsSuperadmin::class);
Route::post('/generus/post-impor-excel-caberawit', [StudentController::class, 'post_children_excel_import'])->middleware('auth',IsSuperadmin::class);
Route::post('/generus/post-simpan-impor-caberawit', [StudentController::class, 'post_children_excel_save'])->middleware('auth',IsSuperadmin::class);

Route::get('/generus/statistika-ppk', [StudentController::class, 'group_statistic'])->middleware('auth');
Route::get('/generus/statistika-ppd', [StudentController::class, 'village_statistic'])->middleware('auth');


Route::get('/menu', [MenuController::class, 'index'])->middleware('auth');
Route::get('/menu/tambah-menu', [MenuController::class, 'get_form_add'])->middleware('auth');
Route::get('/menu/ubah-menu', [MenuController::class, 'get_form_edit'])->middleware('auth');

Route::get('/presensi/popup', [PresenceController::class, 'get_form_presence_popup'])->middleware('auth');
Route::get('/presensi/formulir', [PresenceController::class, 'get_form_presence'])->middleware('auth');

Route::get('/pj-kelas', [TeacherController::class, 'get_list_teachers'])->middleware('auth');
Route::get('/pj-kelas/tambah-pjkelas', [TeacherController::class, 'get_form_add_teacher'])->middleware('auth');
Route::get('/pj-kelas/ubah-pjkelas', [TeacherController::class, 'get_form_edit_teacher'])->middleware('auth');

Route::get('/kelas', [ClassLevelController::class, 'index'])->middleware('auth');
Route::get('/kelas/tambah-kelas', [ClassLevelController::class, 'get_form_add'])->middleware('auth');
Route::get('/kelas/ubah-kelas', [ClassLevelController::class, 'get_form_edit'])->middleware('auth');

Route::get('/profilku', [MyProfileController::class, 'index'])->middleware('auth');

Route::get('/kategori-role', [RoleCategoriesController::class, 'index'])->middleware('auth');
Route::get('/kategori-role/tambah-role', [RoleCategoriesController::class, 'get_form_add'])->middleware('auth');
Route::get('/kategori-role/ubah-role', [RoleCategoriesController::class, 'get_form_edit'])->middleware('auth');

Route::get('/role', [RoleController::class, 'index'])->middleware('auth');
Route::get('/role/tambah-role', [RoleController::class, 'get_form_add'])->middleware('auth');
Route::get('/role/ubah-role', [RoleController::class, 'get_form_edit'])->middleware('auth');

Route::get('/pengguna', [UserController::class, 'index'])->middleware('auth');
Route::get('/pengguna/tambah-pengguna', [UserController::class, 'get_form_add'])->middleware('auth');
Route::get('/pengguna/ubah-pengguna', [UserController::class, 'get_form_edit'])->middleware('auth');

Route::get('/konfigurasi-presensi',[PresenceDateConfigController::class, 'get_form_add'])->middleware('auth');
