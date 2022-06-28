<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Log;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ApiRoleController extends Controller
{
    public function get_role_daerah()
    {
        $data = Role::where('village_code','=', null)->where('group_code','=',null)->get(['id']);

        return response()->json(['data' => $data]);
    }

    public function get_role_desa()
    {
        $data = Role::where('village_code','=', request()->route('village'))->where('group_code','=', null)->get(['id']);

        return response()->json(['data' => $data]);
    }

    public function get_all_role_desa()
    {
        $data = Role::where('village_code','<>', null)->where('group_code','=', null)->get(['id']);

        return response()->json(['data' => $data]);
    }

    public function get_role_kelompok()
    {
        $data = Role::where('village_code','<>', null)->where('group_code','=',request()->route('group'))->get(['id']);

        return response()->json(['data' => $data]);
    }

    public function get_all_role_kelompok()
    {
        $data = Role::where('village_code','<>', null)->where('group_code','<>',null)->get(['id']);

        return response()->json(['data' => $data]);
    }

    public function post_save_role()
    {
        try
        {
            $role = new Role();

            $role->id = request()->input('id');
            $role->category = request()->input('category');
            $role->village_code = request()->input('village');
            $role->group_code = request()->input('group');

            $role->save();
            return response()->json(['status' => true, 'data' => $role], 201);
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Menghapus Data", 'log_key' => $log_key], 500);
        }
    }

    public function delete_role(Request $request)
    {
        try
        {
            $role = UserRole::where('role_id', $request->input('id'))->first();

            if ($role != null)
            {
                return response()->json(['status' => false, 'error_message' => "Role Masih digunakan di table user role"], 200);
            }
            else
            {
                Role::find($request->input('id'))->delete();
                return response()->json(['status' => true], 204);
            }
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Menghapus Data", 'log_key' => $log_key], 500);
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
