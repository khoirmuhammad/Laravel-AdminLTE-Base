<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiMenuController;
use App\Http\Controllers\ApiRoleController;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiGroupController;
use App\Http\Controllers\ApiLevelController;
use App\Http\Controllers\ApiLessonController;
use App\Http\Controllers\ApiStudentController;
use App\Http\Controllers\ApiTeacherController;
use App\Http\Controllers\ApiVillageController;
use App\Http\Controllers\ApiPresenceController;
use App\Http\Controllers\ApiDashboardController;
use App\Http\Controllers\ApiEducationController;
use App\Http\Controllers\ApiClassLevelController;
use App\Http\Controllers\ApiRoleCategoriesController;
use App\Http\Controllers\ApiPresenceTeacherController;
use App\Http\Controllers\ApiPresenceDateConfigController;

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
Route::get('/generus/statistika-paudtk-kelompok/{groupId}', [ApiStudentController::class, 'get_group_statistic_paudtk']);
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

Route::get('/dashboard/get-teacher-total-by-status', [ApiDashboardController::class, 'get_total_teacher_group_by_status']);
Route::get('/dashboard/get-student-total-by-level', [ApiDashboardController::class, 'get_total_student_by_level']);
Route::get('/dashboard/get-student-total-by-class-gender', [ApiDashboardController::class, 'get_total_student_by_class_gender']);


Route::get('/group/group-info/{groupId}', [ApiGroupController::class, 'get_group_info']);
Route::get('/group/group-list', [ApiGroupController::class, 'get_group_list']);
Route::get('/group/group-list-by-village/{villageId}', [ApiGroupController::class, 'get_group_list_by_village']);


Route::get('/level/level-list', [ApiLevelController::class, 'get_levels']);


Route::get('/education/education-list', [ApiEducationController::class, 'get_education']);

Route::get('/class-level/class-level-list-by-level/{levelId}', [ApiClassLevelController::class, 'get_class_level_by_level']);
Route::get('/class-level/class-level-list/{groupId}/{levelId}', [ApiClassLevelController::class, 'get_class_level']);
Route::get('/class-level/class-level-list-by-group', [ApiClassLevelController::class, 'get_class_level_by_group']);
Route::get('/class-level/class-level-list-exist-in-group', [ApiClassLevelController::class, 'get_class_level_exist_in_group']);
Route::post('/class-level/post-save-classname',[ApiClassLevelController::class, 'post_save_classname']);
Route::get('/class-level/class-level-by-id/{id}', [ApiClassLevelController::class, 'get_class_level_by_id']);
Route::delete('/class-level/delete-class-level', [ApiClassLevelController::class, 'delete_classname']);


Route::get('/presence/get-students/{class_level}', [ApiPresenceController::class, 'select_student_class']);
Route::get('/presence/get-recap-presence', [ApiPresenceController::class, 'get_recap_presence']);
Route::get('/presence/get-analysis-presence', [ApiPresenceController::class, 'get_analysis_presence']);
Route::get('/presence/get-recap-presence-in-class', [ApiPresenceController::class, 'get_recap_presence_in_class']);
Route::post('/presence/post-student-presence',[ApiPresenceController::class, 'post_student_presence']);

Route::get('/presence-teacher/get-recap-presence', [ApiPresenceTeacherController::class, 'get_recap_precense_teacher']);
Route::get('/presence-teacher/get-history-presence', [ApiPresenceTeacherController::class, 'get_history_presence_teacher']);

Route::get('/teacher/get-teacher/{id}', [ApiTeacherController::class, 'get_teacher_by_id']);
Route::post('/teacher/post-save-teacher', [ApiTeacherController::class, 'post_save_teacher']);
Route::delete('/teacher/delete-teacher', [ApiTeacherController::class, 'delete_teacher']);

Route::post('/presence-teacher/post-clockinout',[ApiPresenceTeacherController::class, 'post_teacher_presence']);
Route::post('/presence-teacher/put-timein',[ApiPresenceTeacherController::class, 'put_teacher_presence_in']);
Route::post('/presence-teacher/post-request-presence',[ApiPresenceTeacherController::class, 'post_request_presence']);
Route::get('/presence-teacher/get-teacher-presence', [ApiPresenceTeacherController::class, 'get_current_presence_on_class']);
Route::get('/presence-teacher/presence-check', [ApiPresenceTeacherController::class, 'get_check_teacher_presence']);

Route::get('/role-categories', [ApiRoleCategoriesController::class, 'get_role_categories']);
Route::post('/role-categories/post-save', [ApiRoleCategoriesController::class, 'post_save_role']);
Route::get('/role-categories/role-category-by-id/{id}', [ApiRoleCategoriesController::class, 'get_role_category_by_id']);
Route::delete('/role-categories/delete-role-category', [ApiRoleCategoriesController::class, 'delete_role_category']);

Route::get('/menu/get-parent-menu', [ApiMenuController::class, 'get_parent_menu']);
Route::post('/menu/save-menu', [ApiMenuController::class, 'post_save_menu']);
Route::get('/menu/get-menu-roles/{id}', [ApiMenuController::class, 'get_menu_rith_roles']);
Route::delete('/menu/delete-menu', [ApiMenuController::class, 'delete_menu']);

Route::get('/user/get-user-by-username', [ApiUserController::class, 'get_user_info_by_username']);
Route::get('/user/get-user-roles-by-id/{id}', [ApiUserController::class, 'get_user_roles_by_id']);
Route::post('/user/insert-user', [ApiUserController::class, 'post_insert_user']);
Route::post('/user/update-user', [ApiUserController::class, 'post_update_user']);
Route::post('/user/update-user-profile', [ApiUserController::class, 'post_update_user_profile']);
Route::get('/user/get-check-old-password/{password}', [ApiUserController::class, 'get_check_old_password']);
Route::delete('/user/delete-user', [ApiUserController::class, 'delete_user']);

Route::get('/villages', [ApiVillageController::class, 'get_list_village']);

Route::get('/role/role-daerah', [ApiRoleController::class, 'get_role_daerah']);
Route::get('/role/role-desa/{village}', [ApiRoleController::class, 'get_role_desa']);
Route::get('/role/role-desa', [ApiRoleController::class, 'get_all_role_desa']);
Route::get('/role/role-kelompok/{group}', [ApiRoleController::class, 'get_role_kelompok']);
Route::get('/role/role-kelompok', [ApiRoleController::class, 'get_all_role_kelompok']);
Route::post('/role/post-save', [ApiRoleController::class, 'post_save_role']);
Route::delete('/role/delete-role', [ApiRoleController::class, 'delete_role']);

Route::get('/schedule/get-schedule-group', [ApiPresenceDateConfigController::class, 'get_schedule_by_group']);
Route::post('/schedule/post-insert', [ApiPresenceDateConfigController::class, 'post_insert_schedules']);
Route::put('/schedule/put-update', [ApiPresenceDateConfigController::class, 'put_update_schedule']);
Route::delete('/schedule/delete-schedule', [ApiPresenceDateConfigController::class, 'delete_schedule']);

Route::get('/lesson/get-all-lesson-name', [ApiLessonController::class, 'get_all_lessons_name']);
Route::post('/lesson/post-jurnal-history', [ApiLessonController::class, 'post_save_jurnal_history']);
