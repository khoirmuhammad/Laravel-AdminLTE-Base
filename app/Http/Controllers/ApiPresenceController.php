<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Presence;
use App\Models\ClassLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ApiPresenceController extends Controller
{
    public function select_student_class(Request $request)
    {
        $class_level = request()->route('class_level');
        $group = session('group');

        $result_students_orig = Presence::select_students($group, $class_level); // select_student_class($group, $class_level);
        $result_students_presence = Presence::select_student_presence_class($group, $class_level);

        $result = [
            'students_orig' => $result_students_orig,
            'students_presence' => $result_students_presence
        ];

        return response()->json(['data' => $result]);
    }

    public function get_recap_presence(Request $request)
    {
        $months = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus','September','Oktober','November','Desember');

        $class_in_group = ClassLevel::class_exist_in_group();

        $current_month = $request->month == 0 ? (int)date('m') : $request->input('month');

        $presence_in_month = Presence::get_recap_presences_by_class($current_month);

        $result = array();

        foreach($class_in_group as $class_item)
        {
            $class_obj = $presence_in_month->where('classname',$class_item->classname)->first();

            if ($class_obj != null)
            {
                $result[] = [
                    'classid' => $class_obj->classid,
                    'class' => $class_obj->classname,
                    'present' => $class_obj->present,
                    'permit' => $class_obj->permit,
                    'absent' => $class_obj->absent,
                    'present_percent' => $class_obj->present_percent,
                    'permit_percent' => $class_obj->permit_percent,
                    'absent_percent' => $class_obj->absent_percent,
                    'total' => round($class_obj->present_percent + $class_obj->permit_percent + $class_obj->absent_percent),
                    'total_pertemuan' => count(Presence::get_total_meet_by_class($current_month, $class_obj->classname)),
                    'bulan' => $months[$current_month - 1]
                ];
            }
            else
            {
                $result[] = [
                    'classid' => $class_item->classid,
                    'class' => $class_item->classname,
                    'present' => 0,
                    'permit' => 0,
                    'absent' => 0,
                    'present_percent' => '0.00',
                    'permit_percent' => '0.00',
                    'absent_percent' => '0.00',
                    'total' => '0.00',
                    'total_pertemuan' => 0,
                    'bulan' => $months[$current_month - 1]
                ];
            }
        }

        return response()->json(['data' => $result]);
    }

    public function get_recap_presence_in_class(Request $request)
    {
        $current_month = $request->month == 0 ? (int)date('m') : $request->input('month');
        $class_level = $request->class_level;

        $result = Presence::get_recap_presences_by_student_in_class($current_month, $class_level);

        return response()->json(['data' => $result]);
    }

    public function get_analysis_presence()
    {
        $classes = ClassLevel::get_class_level_with_exist_student_by_group();
        $data_class = array();

        foreach($classes as $class)
        {
            array_push($data_class, $class->name);
        }

        return response()->json(['data_class' => $data_class]);
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
            $log->controller = 'ApiPresence';
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
