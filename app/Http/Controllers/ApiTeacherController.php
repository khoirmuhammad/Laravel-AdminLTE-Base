<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\ClassLevel;
use App\Models\Log;
use App\Models\User;
use App\Models\Teacher;
use App\Models\UserRole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ApiTeacherController extends Controller
{
    public function get_teacher_by_id(Request $request)
    {
        $teacher_id = $request->route('id');

        $result = Teacher::find($teacher_id);

        return response()->json(['data' => $result]);
    }

    public function post_save_teacher(Request $request)
    {
        try
        {
            if ($request->input('id') != null || $request->input('id') != '')
            {
                return $this->update_teacher($request);
            }
            else
            {
                return $this->insert_teacher($request);
            }
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Menyimpan Data", 'log_key' => $log_key], 500);
        }
    }

    public function delete_teacher(Request $request)
    {
        try
        {
            try
            {
                DB::beginTransaction();

                $teacher = Teacher::find($request->input('id'));
                $username = $teacher->username;

                $user = User::where('username','=', $username)->first();
                $user_id = $user->id;

                $teacher->delete();

                $user->delete();

                UserRole::where('user_id','=', $user_id)->delete();

                DB::commit();

                return response()->json(['status' => $username], 201);
            }
            catch(\PDOException $pdoEx)
            {
                DB::rollback();

                $error = $pdoEx->getMessage();
                $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
                $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

                $this->save_log($action, $error, $log_key);

                return response()->json(['status' => false, 'error_message' => "Terjadi Kesalaan Transaksi Database", 'log_key' => $log_key], 500);
            }
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Menghapus Data".$error, 'log_key' => $log_key], 500);
        }
    }

    private function update_teacher($request)
    {
        try
        {
            $teacher = Teacher::find($request->input('id'));

            $teacher->name = $request->input('name');
            $teacher->gender = $request->input('gender');
            $teacher->status = $request->input('status');
            $teacher->is_teacher = $request->input('isTeacher');
            $teacher->is_admin_class = $request->input('isAdminClass');
            $teacher->is_student = $request->input('isStudent');
            $teacher->class_level = $request->input('classString');
            $teacher->group = session('group');
            $teacher->updated_at = Carbon::now('Asia/Jakarta');

            $teacher->save();

            return response()->json(['status' => true], 204);
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalaan Transaksi Database", 'log_key' => $log_key], 500);
        }
    }

    private function insert_teacher($request)
    {
        try
        {
            $has_account = $request->input('hasAccount');
            $username = $request->input('username');

            if (!$has_account)
            {
                $username = $this->set_username($request->input('name'));
            }

            DB::beginTransaction();

            $teacher = new Teacher();

            $teacher->id = Str::uuid()->toString();
            $teacher->name = $request->input('name');
            $teacher->username = $username;
            $teacher->gender = $request->input('gender');
            $teacher->status = $request->input('status');
            $teacher->is_teacher = $request->input('isTeacher');
            $teacher->is_admin_class = $request->input('isAdminClass');
            $teacher->is_student = $request->input('isStudent');
            $teacher->class_level = $request->input('classString');
            $teacher->group = session('group');
            $teacher->created_at = Carbon::now('Asia/Jakarta');
            $teacher->updated_at = Carbon::now('Asia/Jakarta');

            $teacher->save();

            $user_id = Str::uuid()->toString();

            if (!$has_account)
            {
                $user = new User();
                $user->id = $user_id;
                $user->name = $request->input('name');
                $user->username = $username;
                $user->password = bcrypt(env('PASSWORD_INIT'));
                $user->created_at = Carbon::now('Asia/Jakarta');
                $user->updated_at = Carbon::now('Asia/Jakarta');

                $user->save();
            }
            else
            {
                $user_id = User::where('username',$username)->first()->id;
            }

            $user_role = new UserRole();
            $user_role->user_id = $user_id;
            $user_role->role_id = env('ROLE_GURU_KBM_BB_KTG');

            $user_role->save();

            DB::commit();

            return response()->json(['status' => true, 'data' => $teacher], 201);
        }
        catch(\PDOException $pdoEx)
        {
            DB::rollback();

            $error = $pdoEx->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalaan Transaksi Database", 'log_key' => $log_key], 500);
        }
    }

    private function set_username($name)
    {
        $array_name = explode(' ', strtolower($name));

        $username = $array_name[0].'.'.$array_name[count($array_name)-1];

        $user = User::where('username',$username)->first();

        $seq = 1;

        while($user != null)
        {
            $username = $username.$seq;
            $user = User::where('username',$username)->first();
            $seq++;
        }

        return $username;
    }

    private function save_log($action, $error, $log_key)
    {
        try
        {
            $log = new Log();
            $log->controller = 'ApiTeacher';
            $log->action = $action;
            $log->error_message = $error;
            $log->log_key = $log_key;

            $log->save();
        }
        catch(\Exception $ex)
        {
            $log = new Log();
            $log->controller = 'ApiTeacher';
            $log->action = 'save_log';
            $log->error_message = $ex->getMessage();
            $log->log_key = $log_key;

            $log->save();
        }
    }

    private function get_random_string() {
        $characters = env('RAND_STR_KEY');
        $randomString = '';

        for ($i = 0; $i < 20; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
