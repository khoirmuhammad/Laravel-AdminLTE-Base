<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Exception;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\PresenceDateConfig;
use Illuminate\Support\Facades\Route;

class ApiPresenceDateConfigController extends Controller
{
    public function get_schedule_by_group()
    {
        // get query string
        $level = request()->level;
        $class_level = request()->class_level;

        $result = PresenceDateConfig::select_schedules_by_group($level, $class_level);

        return response()->json(['data' => $result]);
    }

    public function post_insert_schedules(Request $request)
    {
        try
        {
            $schedules = array();

            $village = Group::where('id',session('group'))->first()->village_id;

            foreach($request->all() as $item)
            {
                $config = PresenceDateConfig::where('class_level',$item['class_level'])->where('group', session('group'))->where('day', $item['day'])->first();

                if ($config == null) {
                    $schedules[] = [
                        'group' => session('group'),
                        'village' => $village,
                        'level' => $item['level'],
                        'class_level' => $item['class_level'],
                        'day' => $item['day'],
                        'start_time' => $item['start_time'],
                        'end_time' => $item['end_time']
                    ];
                }


            }

            if (count($schedules) > 0) {
                PresenceDateConfig::insert($schedules);
                return response()->json(201);
            } else {
                return response()->json(204);
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

    public function put_update_schedule(Request $request)
    {
        try
        {
            $config = PresenceDateConfig::find($request->input('id'));
            $config->start_time = $request->input('start_time');
            $config->end_time = $request->input('end_time');

            $config->save();

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

    public function delete_schedule(Request $request)
    {
        try
        {
            PresenceDateConfig::find($request->input('id'))->delete();

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

    private function save_log($action, $error, $log_key)
    {
        try
        {
            $log = new Log();
            $log->controller = 'ApiMenu';
            $log->action = $action;
            $log->error_message = $error;
            $log->log_key = $log_key;

            $log->save();
        }
        catch(\Exception $ex)
        {
            $log = new Log();
            $log->controller = 'ApiRole';
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
