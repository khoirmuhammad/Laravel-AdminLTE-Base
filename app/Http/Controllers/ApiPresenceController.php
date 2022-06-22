<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ApiPresenceController extends Controller
{
    public function select_student_class(Request $request)
    {
        $class_level = request()->route('class_level');
        $group = session('group');

        $result = Presence::select_student_class($group, $class_level);

        return response()->json(['data' => $result]);
    }

    public function post_student_presence(Request $request)
    {
        try
        {
            if ($request->input('id') != null || $request->input('id') != 0)
            {
                $presence = new Presence();

                $presence->student_id = $request->input('student_id');
                $presence->is_present = $request->input('is_present');
                $presence->is_permit = $request->input('is_permit');
                $presence->is_absent = $request->input('is_absent');
                $presence->permit_desc = $request->input('permit_desc');
                $presence->filled_date = Carbon::now('Asia/Jakarta')->format('Y-m-d');
                $presence->filled_time = Carbon::now('Asia/Jakarta')->format('H:i:s');
                $presence->filled_by = $request->input('filled_by');
                $presence->group_id = session('group');
                $presence->class_level_id = $request->input('class_level_id');

                $presence->save();

                return response()->json(['status' => true, 'data' => $presence], 201);
            }
            else
            {

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
            $log->controller = 'ApiPresence';
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
