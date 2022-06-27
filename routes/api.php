<?php

use App\Http\Controllers\ApiClassLevelController;
use App\Http\Controllers\ApiEducationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiGroupController;
use App\Http\Controllers\ApiLevelController;
use App\Http\Controllers\ApiMenuController;
use App\Http\Controllers\ApiStudentController;
use App\Http\Controllers\ApiTeacherController;
use App\Http\Controllers\ApiPresenceController;
use App\Http\Controllers\ApiPresenceTeacherController;
use App\Http\Controllers\ApiRoleCategoriesController;
use App\Http\Controllers\ApiUserController;

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
Route::post('/class-level/post-save-classname',[ApiClassLevelController::class, 'post_save_classname']);
Route::get('/class-level/class-level-by-id/{id}', [ApiClassLevelController::class, 'get_class_level_by_id']);
Route::delete('/class-level/delete-class-level', [ApiClassLevelController::class, 'delete_classname']);


Route::get('/presence/get-students/{class_level}', [ApiPresenceController::class, 'select_student_class']);
Route::post('/presence/post-student-presence',[ApiPresenceController::class, 'post_student_presence']);

Route::get('/teacher/get-teacher/{id}', [ApiTeacherController::class, 'get_teacher_by_id']);
Route::post('/teacher/post-save-teacher', [ApiTeacherController::class, 'post_save_teacher']);
Route::delete('/teacher/delete-teacher', [ApiTeacherController::class, 'delete_teacher']);

Route::post('/presence-teacher/post-clockinout',[ApiPresenceTeacherController::class, 'post_teacher_presence']);
Route::get('/presence-teacher/get-teacher-presence', [ApiPresenceTeacherController::class, 'get_current_presence_on_class']);

Route::get('/role-categories', [ApiRoleCategoriesController::class, 'get_role_categories']);


Route::get('/menu/get-parent-menu', [ApiMenuController::class, 'get_parent_menu']);
Route::post('/menu/save-menu', [ApiMenuController::class, 'post_save_menu']);
Route::get('/menu/get-menu-roles/{id}', [ApiMenuController::class, 'get_menu_rith_roles']);
Route::delete('/menu/delete-menu', [ApiMenuController::class, 'delete_menu']);

Route::get('/user/get-user-by-username', [ApiUserController::class, 'get_user_info_by_username']);
Route::post('/user/update-menu', [ApiUserController::class, 'post_update_user']);
Route::get('/user/get-check-old-password/{password}', [ApiUserController::class, 'get_check_old_password']);
