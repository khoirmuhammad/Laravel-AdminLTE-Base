<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiStudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/generus/statistika-general-kelompok-by-level', [ApiStudentController::class, 'get_group_statistic_general_by_level']);
Route::get('/generus/statistika-general-kelompok-by-education', [ApiStudentController::class, 'get_group_statistic_general_by_education']);
Route::get('/generus/statistika-caberawit-kelompok', [ApiStudentController::class, 'get_group_statistic_caberawit']);
Route::get('/generus/statistika-praremaja-kelompok', [ApiStudentController::class, 'get_group_statistic_praremaja']);
Route::get('/generus/statistika-remaja-kelompok', [ApiStudentController::class, 'get_group_statistic_remaja']);
Route::get('/generus/statistika-unik-kelompok', [ApiStudentController::class, 'get_group_statistic_unik']);
Route::get('/generus/statistika-unik-kelompok-by-pribumi-status', [ApiStudentController::class, 'get_group_statistic_unik_by_pribumi_status']);

Route::get('/generus/statistika-desa-by-group-level-gender', [ApiStudentController::class, 'get_village_statistic_by_group_level_gender']);
Route::get('/generus/statistika-desa-by-group-education-gender', [ApiStudentController::class, 'get_village_statistic_by_group_education_gender']);