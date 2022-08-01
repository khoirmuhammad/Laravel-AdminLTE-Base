<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Lesson;
use App\Models\LessonHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery\Undefined;

class ApiLessonController extends Controller
{
    public function get_all_lessons_name(Request $request)
    {
        $class_level = $request->class_level == null ? null : $request->class_level;

        $result = Lesson::get_all_lesson($class_level);

        return response()->json(['data' => $result]);
    }

    public function post_save_jurnal_history(Request $request)
    {
        try
        {
            $data = array();

            foreach($request->all() as $item)
            {
                $data[] = [
                    'lesson_id' => $item['lesson_id'],
                    'percentage' => $item['percentage'],
                    'remark' => $item['remark'],
                    'group' => session('group'),
                    'teacher_presence_id' => $item['teacher_presence_id'],
                    'created_at' => Carbon::now('Asia/Jakarta')
                ];
            }

           // LessonHistory::insert($data);

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

    private function get_random_string() {
        $characters = env('RAND_STR_KEY');
        $randomString = '';

        for ($i = 0; $i < 20; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    private function save_log($action, $error, $log_key)
    {
        try
        {
            $log = new Log();
            $log->controller = 'ApiLesson';
            $log->action = $action;
            $log->error_message = $error;
            $log->log_key = $log_key;

            $log->save();
        }
        catch(\Exception $ex)
        {
            $log = new Log();
            $log->controller = 'ApiLesson';
            $log->action = 'save_log';
            $log->error_message = $ex->getMessage();
            $log->log_key = $log_key;

            $log->save();
        }
    }
}
