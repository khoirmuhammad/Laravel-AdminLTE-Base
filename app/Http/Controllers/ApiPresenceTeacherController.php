<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PresenceTeacher;
use Illuminate\Support\Facades\Route;

class ApiPresenceTeacherController extends Controller
{
    public function get_current_presence_on_class()
    {
        $date = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $teacher = Teacher::where('username',auth()->user()->username)->first()->id;

        $result = PresenceTeacher::where('teacher_id','=',$teacher)
        ->where('clock_in_date','=',$date)->first();

        return response()->json(['data' => $result]);
    }

    public function post_teacher_presence(Request $request)
    {
        try
        {

            if ($request->input('id') == 0)
            {
                $teacher = Teacher::where('username',$request->input('user_id'))->first();

                if ($teacher == null)
                {
                    return response()->json(['status' => false, 'error_message' => 'Data Guru Tidak Ditemukan (Username ' .$request->input('user_id'). ''], 404);
                }

                $teacher_id = $teacher->id;

                $presenceIn = new PresenceTeacher();

                $presenceIn->teacher_id = $teacher_id;
                $presenceIn->class_level_id = $request->input('class_level_id');
                $presenceIn->clock_in_date = Carbon::now('Asia/Jakarta')->format('Y-m-d');
                $presenceIn->clock_out_date = null;
                $presenceIn->clock_in_time = Carbon::now('Asia/Jakarta')->format('H:i:s');
                $presenceIn->clock_out_time = null;

                $presenceIn->save();

                return response()->json(['status' => true, 'data' => $presenceIn], 201);
            }
            else
            {
                $presenceOut = PresenceTeacher::find($request->input('id'));

                $presenceOut->clock_out_date = Carbon::now('Asia/Jakarta')->format('Y-m-d');
                $presenceOut->clock_out_time = Carbon::now('Asia/Jakarta')->format('H:i:s');

                $presenceOut->save();

                return response()->json(['status' => true, 'data' => $presenceOut], 201);
            }
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Presensi", 'log_key' => $log_key], 500);
        }
    }

    private function save_log($action, $error, $log_key)
    {
        try
        {
            $log = new Log();
            $log->controller = 'ApiPresenceTeacher';
            $log->action = $action;
            $log->error_message = $error;
            $log->log_key = $log_key;

            $log->save();
        }
        catch(\Exception $ex)
        {
            $log = new Log();
            $log->controller = 'ApiStudent';
            $log->action = 'save_log';
            $log->error_message = $ex->getMessage();
            $log->log_key = $log_key;

            $log->save();
        }
    }

    private function get_random_string()
    {
        $characters = env('RAND_STR_KEY');
        $randomString = '';

        for ($i = 0; $i < 20; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
