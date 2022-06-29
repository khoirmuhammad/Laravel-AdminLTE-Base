<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Log;
use App\Models\Teacher;
use App\Models\ClassLevel;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ApiClassLevelController extends Controller
{
    public function get_class_level(Request $request)
    {
        $group = $request->route('groupId');
        $level = $request->route('levelId');

        $result = ClassLevel::get_class_level($group, $level);

        return response()->json(['data' => $result]);
    }

    public function get_class_level_by_group()
    {
        $result = ClassLevel::get_class_level_by_group();

        return response()->json(['data' => $result]);
    }

    public function get_class_level_by_id()
    {
        $result = ClassLevel::find(request()->route('id'));
        return response()->json(['data' => $result]);
    }


    public function post_save_classname(Request $request)
    {
        try
        {
            if ($request->input('id') != null || $request->input('id') != '')
            {
                return $this->update_class_name($request);
            }
            else
            {
                return $this->insert_class_name($request);
            }
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['error_message' => "Terjadi Kesalahan Saat Menyimpan Data", 'log_key' => $log_key], 500);
        }
    }

    public function delete_classname()
    {
        try
        {
            $id = request()->input('id');

            $teacher = Teacher::where('class_level', 'like', '%' . $id . '%')->first();

            if ($teacher != null)
            {
                return response()->json(['error_message' => 'Kelas masih digunakan. Ubah data guru dari kelas ini'], 409);
            }

            $student = Student::where('class','=', $id)->first();

            if ($student != null)
            {
                return response()->json(['error_message' => 'Kelas masih digunakan. Ubah data generus dari kelas ini'], 409);
            }

            ClassLevel::find($id)->delete();

            return response()->json(204);
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['error_message' => "Terjadi Kesalahan Saat Menghapus Data", 'log_key' => $log_key], 500);
        }
    }

    private function update_class_name($request)
    {
        try
        {
            $class_level = ClassLevel::find(request()->input('id'));

            $class_level->name = $request->input('classname');
            $class_level->level_id = $request->input('level');

            $class_level->save();

            return response()->json(204);
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['error_message' => "Terjadi Kesalahan Saat Menyimpan Data", 'log_key' => $log_key], 500);
        }
    }

    private function insert_class_name($request)
    {
        try
        {
            $class_level = new ClassLevel();

            $class_level->id = Str::uuid()->toString();
            $class_level->name = $request->input('classname');
            $class_level->group_id = session('group') == null ? "" : session('group');
            $class_level->level_id = $request->input('level');

            $class_level->save();

            return response()->json(201);
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['error_message' => "Terjadi Kesalahan Saat Menyimpan Data", 'log_key' => $log_key], 500);
        }
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
            $log->controller = 'ApiClassLevel';
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
