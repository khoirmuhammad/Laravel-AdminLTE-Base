<?php

use App\Http\Controllers\ApiClassLevelController;
use App\Http\Controllers\ApiEducationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiGroupController;
use App\Http\Controllers\ApiLevelController;
use App\Http\Controllers\ApiStudentController;
use App\Http\Controllers\ApiTeacherController;
use App\Http\Controllers\ApiPresenceController;
use App\Http\Controllers\ApiPresenceTeacherController;

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


Route::get('/generus/statistika-general-kelompok-by-level/{groupId}', [ApiStudentController::class, 'get_group_statistic_general_by_level']);
Route::get('/generus/statistika-general-kelompok-by-education/{groupId}', [ApiStudentController::class, 'get_group_statistic_general_by_education']);
Route::get('/generus/statistika-caberawit-kelompok/{groupId}', [ApiStudentController::class, 'get_group_statistic_caberawit']);
Route::get('/generus/statistika-praremaja-kelompok/{groupId}', [ApiStudentController::class, 'get_group_statistic_praremaja']);
Route::get('/generus/statistika-remaja-kelompok/{groupId}', [ApiStudentController::class, 'get_group_statistic_remaja']);
Route::get('/generus/statistika-unik-kelompok/{groupId}', [ApiStudentController::class, 'get_group_statistic_unik']);
Route::get('/generus/statistika-unik-kelompok-by-pribumi-status/{groupId}', [ApiStudentController::class, 'get_group_statistic_unik_by_pribumi_status']);

Route::get('/generus/statistika-desa-by-group-level-gender', [ApiStudentController::class, 'get_village_statistic_by_group_level_gender']);
Route::get('/generus/statistika-desa-by-group-education-gender', [ApiStudentController::class, 'get_village_statistic_by_group_education_gender']);

Route::get('/generus/get-student-by-id/{id}', [ApiStudentController::class, 'get_student_by_id']);
Route::post('/generus/post-save-student', [ApiStudentController::class, 'post_save_student']);
Route::delete('generus/delete-student-by-id', [ApiStudentController::class, 'delete_student_by_id']);



Route::get('/group/group-info/{groupId}', [ApiGroupController::class, 'get_group_info']);
Route::get('/group/group-list', [ApiGroupController::class, 'get_group_list']);
Route::get('/group/group-list-by-village/{villageId}', [ApiGroupController::class, 'get_group_list_by_village']);


Route::get('/level/level-list', [ApiLevelController::class, 'get_levels']);


Route::get('/education/education-list', [ApiEducationController::class, 'get_education']);

Route::get('/class-level/class-level-list/{groupId}/{levelId}', [ApiClassLevelController::class, 'get_class_level']);
Route::get('/class-level/class-level-list-by-group', [ApiClassLevelController::class, 'get_class_level_by_group']);


Route::get('/presence/get-students/{class_level}', [ApiPresenceController::class, 'select_student_class']);
Route::post('/presence/post-student-presence',[ApiPresenceController::class, 'post_student_presence']);

Route::post('/teacher/post-save-teacher', [ApiTeacherController::class, 'post_save_teacher']);

Route::post('/presence-teacher/post-clockinout',[ApiPresenceTeacherController::class, 'post_teacher_presence']);
Route::get('/presence-teacher/get-teacher-presence', [ApiPresenceTeacherController::class, 'get_current_presence_on_class']);
