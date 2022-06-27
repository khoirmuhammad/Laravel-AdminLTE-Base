<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ApiUserController extends Controller
{
    public function get_user_info_by_username()
    {
        $result = User::where('username', auth()->user()->username)->first();

        return response()->json(['data' => $result]);
    }

    public function get_check_old_password()
    {
        $credential = [
            'username' => auth()->user()->username,
            'password' => request()->route('password')
        ];

        if (Auth::attempt($credential))
        {
            return response()->json(['data' => true]);
        }
        else
        {
            return response()->json(['data' => false]);
        }
    }

    public function post_update_user(Request $request)
    {
        try
        {
            $user = User::find($request->input('id'));

            $user->name = $request->input('fullname');
            $user->email = $request->input('email');

            if (request()->input('password_change'))
            {
                $user->password = bcrypt($request->input('password'));
            }

            $user->updated_at = Carbon::now('Asia/Jakarta');

            $user->save();

            return response()->json(['status' => true, 'data' => $user], 201);
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
            $log->controller = 'ApiUser';
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
