<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Log;
use App\Models\Role;
use App\Models\RoleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ApiRoleCategoriesController extends Controller
{
    public function get_role_categories()
    {
        $result = RoleCategory::all();
        return response()->json(['data' => $result]);
    }

    public function get_role_category_by_id()
    {
        $id = request()->route('id');

        $result = RoleCategory::find($id);

        return response()->json(['data' => $result]);
    }

    public function post_save_role()
    {
        try
        {
            $exist_role = RoleCategory::find(request()->input('id'));

            if ($exist_role)
            {
                $exist_role->name = request()->input('name');

                $exist_role->save();

                return response()->json(204);
            }
            else
            {
                $new_role = new RoleCategory();

                $new_role->id = request()->input('id');
                $new_role->name = request()->input('name');

                $new_role->save();

                return response()->json(201);
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

    public function delete_role_category(Request $request)
    {
        try
        {
            $roles = Role::where('category', $request->input('id'))->first();

            if ($roles != null)
            {
                return response()->json(['error_message' => "Role Kategori Masih digunakan di table role"], 409);
            }
            else
            {
                RoleCategory::find($request->input('id'))->delete();

                return response()->json(204);
            }
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
            $log->controller = 'ApiRoleCategories';
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
