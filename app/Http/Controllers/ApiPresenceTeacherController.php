<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Presence;
use App\Models\PresenceDateConfig;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PresenceTeacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ApiPresenceTeacherController extends Controller
{
    public function get_current_presence_on_class()
    {
        $date = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $teacher = Teacher::where('username', auth()->user()->username)->first()->id;

        $result = PresenceTeacher::where('teacher_id', '=', $teacher)
            ->where('clock_in_date', '=', $date)->first();

        return response()->json(['data' => $result]);
    }

    public function get_check_teacher_presence()
    {
        $teacher = Teacher::where('username', request()->input('id'))->first();

        $data_presence = PresenceTeacher::where('teacher_id',$teacher->id)
            ->where('clock_in_date',request()->date)->get();

        return response()->json(['data' => count($data_presence)]);
    }

    public function get_recap_precense_teacher(Request $request)
    {
        $result = array();

        $current_month = $request->month == 0 ? (int)date('m') : $request->input('month');

        $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $hariHari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

        $teachers = Presenceteacher::get_recap_precense_teacher($current_month);

        foreach($teachers as $teacher)
        {
            $teacher_presents = PresenceTeacher::get_presence_teacher_in_month($current_month, $teacher->teacher_id);

            $total_pas = 0;
            $total_t1 = 0;
            $total_t2 = 0;

            foreach($teacher_presents as $tp)
            {
                $day = date('l', strtotime($tp->clock_in_date));
                $day_index = array_search($day, $days);
                $hari = $hariHari[$day_index];

                $presence_config = PresenceDateConfig::where('class_level', $tp->class_level_id)
                                ->where('day',$hari)->first();

                $start_time_in_day = $presence_config->start_time;
                $clock_in_time_in_day = $tp->clock_in_time;

                $dateTimeObject1 = strtotime($start_time_in_day);
                $dateTimeObject2 = strtotime($clock_in_time_in_day);

                $diff_minutes = abs(($dateTimeObject1 - $dateTimeObject2) / 60);

                if ($dateTimeObject2 <= $dateTimeObject1) {
                    $total_pas++;
                } else {
                    if ($diff_minutes <= env('t1')) {
                        $total_pas++;
                    } else if ($diff_minutes > env('t1') && $diff_minutes <= env('t2')) {
                        $total_t1++;
                    } else {
                        $total_t2++;
                    }
                }

            }

            $result[] = [
                'teacher_id' => $teacher->teacher_id,
                'name' => $teacher->name,
                'total_hadir' => $teacher->total_hadir,
                'total_pas' => $total_pas,
                'total_t1' => $total_t1,
                'total_t2' => $total_t2,
            ];

        }



        return response()->json(['data' => $result]);
    }

    public function get_recap_honour_teacher(Request $request)
    {
        $result = array();

        $current_month = $request->month == 0 ? (int)date('m') : $request->input('month');

        $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $hariHari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

        $teachers = Presenceteacher::get_recap_precense_teacher($current_month);
        $honours = PresenceTeacher::get_honour_teacher();

        foreach($teachers as $teacher)
        {
            $teacher_presents = PresenceTeacher::get_presence_teacher_in_month($current_month, $teacher->teacher_id);

            $total_pas = 0;
            $total_t1 = 0;
            $total_t2 = 0;

            foreach($teacher_presents as $tp)
            {
                $day = date('l', strtotime($tp->clock_in_date));
                $day_index = array_search($day, $days);
                $hari = $hariHari[$day_index];

                $presence_config = PresenceDateConfig::where('class_level', $tp->class_level_id)
                                ->where('day',$hari)->first();

                $start_time_in_day = $presence_config->start_time;
                $clock_in_time_in_day = $tp->clock_in_time;

                $dateTimeObject1 = strtotime($start_time_in_day);
                $dateTimeObject2 = strtotime($clock_in_time_in_day);

                $diff_minutes = abs(($dateTimeObject1 - $dateTimeObject2) / 60);

                if ($dateTimeObject2 <= $dateTimeObject1) {
                    $total_pas++;
                } else {
                    if ($diff_minutes <= env('t1')) {
                        $total_pas++;
                    } else if ($diff_minutes > env('t1') && $diff_minutes <= env('t2')) {
                        $total_t1++;
                    } else {
                        $total_t2++;
                    }
                }

            }

            $honour = $honours->where('teacher_id', $teacher->teacher_id)->first();
            $honour_pas = 0;
            $honour_t1 = 0;
            $honour_t2 = 0;

            if ($honour != null) {
                $honour_pas = $honour->ontime_rate * $total_pas;
                $honour_t1 = $honour->late1_rate * $total_t1;
                $honour_t2 = $honour->late2_rate * $total_t2;
            }



            $result[] = [
                'teacher_id' => $teacher->teacher_id,
                'name' => $teacher->name,
                'total_hadir' => $teacher->total_hadir,
                'total_pas' => $total_pas,
                'total_t1' => $total_t1,
                'total_t2' => $total_t2,
                'honour_pas' => $honour_pas,
                'honour_t1' => $honour_t1,
                'honour_t2' => $honour_t2
            ];

        }



        return response()->json(['data' => $result]);
    }

    public function get_history_presence_teacher(Request $request)
    {
        $current_month = $request->month == 0 ? (int)date('m') : $request->input('month');
        $tacher_id =  $request->input('teacher_id');

        $result = Presenceteacher::get_history_presence_teacher($current_month, $tacher_id);

        return response()->json(['data' => $result]);
    }

    public function post_teacher_presence(Request $request)
    {
        try {

            if ($request->input('id') == 0) {
                $teacher = Teacher::where('username', $request->input('user_id'))->first();

                if ($teacher == null) {
                    return response()->json(['status' => false, 'error_message' => 'Data Guru Tidak Ditemukan (Username ' . $request->input('user_id') . ''], 404);
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
            } else {
                $presenceOut = PresenceTeacher::find($request->input('id'));

                $presenceOut->clock_out_date = Carbon::now('Asia/Jakarta')->format('Y-m-d');
                $presenceOut->clock_out_time = Carbon::now('Asia/Jakarta')->format('H:i:s');

                $presenceOut->save();

                return response()->json(['status' => true, 'data' => $presenceOut], 201);
            }
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $action = explode('@', Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Presensi", 'log_key' => $log_key], 500);
        }
    }

    public function put_teacher_presence_in(Request $request)
    {
        try {
            if ($request->input('teacherId') != 0) {
                $presenceIn = PresenceTeacher::find($request->input('teacherId'));

                $presenceIn->clock_in_time = $request->input('timein');

                $presenceIn->save();

                return response()->json(['status' => true, 'data' => $presenceIn], 201);
            } else {
                return response()->json(['status' => false, 'error_message' => 'Data ID kosong'], 404);
            }
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $action = explode('@', Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Presensi", 'log_key' => $log_key], 500);
        }
    }

    public function post_request_presence(Request $request)
    {
        try {
            DB::beginTransaction();

            $teacher = Teacher::where('username', $request->input('user'))->first();

            $presenceIn = new PresenceTeacher();

            $presenceIn->teacher_id = $teacher->id;
            $presenceIn->class_level_id = $request->input('class-level');
            $presenceIn->clock_in_date = $request->input('date');
            $presenceIn->clock_out_date = null;
            $presenceIn->clock_in_time = $request->input('time');
            $presenceIn->clock_out_time = null;

            $presenceIn->save();

            $inserts = array();

            foreach($request->input('students') as $student)
            {
                if ($student != null) {
                    $inserts[] = [
                        'student_id' => $student['student_id'],
                        'is_present' => $student['is_present'],
                        'is_permit' => $student['is_permit'],
                        'is_absent' => $student['is_absent'],
                        'permit_desc' => null,
                        'filled_date' => $request->input('date'),
                        'filled_time' => $request->input('time'),
                        'filled_by' => $request->input('user'),
                        'group_id' => session('group'),
                        'class_level_id' => $request->input('class-level')
                    ];
                }
            }

            Presence::insert($inserts);

            DB::commit();

            return response()->json(['status' => true], 201);
        } catch (Exception $ex) {
            DB::rollback();

            $error = $ex->getMessage();
            $action = explode('@', Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalaan Transaksi Database", 'log_key' => $log_key], 500);
        }
    }

    private function save_log($action, $error, $log_key)
    {
        try {
            $log = new Log();
            $log->controller = 'ApiPresenceTeacher';
            $log->action = $action;
            $log->error_message = $error;
            $log->log_key = $log_key;

            $log->save();
        } catch (\Exception $ex) {
            $log = new Log();
            $log->controller = 'ApiPresenceTeacher';
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
