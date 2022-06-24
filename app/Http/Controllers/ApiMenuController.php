<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Log;
use App\Models\Menu;
use App\Models\MenuRoleCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ApiMenuController extends Controller
{
    public function get_parent_menu()
    {
        $result = Menu::where('parent_id', '=', null)->orderBy('order')->get();

        return response()->json(['data' => $result]);
    }

    public function get_menu_rith_roles(Request $request)
    {
        $result_menu = Menu::where('id','=',$request->route('id'))->first();
        $result_roles = MenuRoleCategory::where('menu_id','=', $request->route('id'))->get();

        $result = [
            'menu' => $result_menu,
            'roles' => $result_roles
        ];

        return response()->json(['data' => $result]);
    }

    public function post_save_menu(Request $request)
    {
        try
        {
            if ($request->input('id') != null || $request->input('id') != '')
            {
                return $this->update_menu_roles($request);
            }
            else
            {
                return $this->insert_menu_roles($request);
            }
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Menyimpan Data", 'log_key' => $log_key], 500);
        }
    }

    public function delete_menu(Request $request)
    {
        try
        {
            try
            {
                DB::beginTransaction();

                Menu::find($request->input('id'))->delete();

                MenuRoleCategory::where('menu_id','=', $request->input('id'))->delete();

                DB::commit();

                return response()->json(['status' => true], 204);
            }
            catch(\PDOException $pdoEx)
            {
                DB::rollback();

                $error = $pdoEx->getMessage();
                $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
                $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

                $this->save_log($action, $error, $log_key);

                return response()->json(['status' => false, 'error_message' => "Terjadi Kesalaan Transaksi Database", 'log_key' => $log_key], 500);
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

    private function insert_menu_roles($request)
    {
        try
        {
            DB::beginTransaction();

            $menu = new Menu();

            $menuid = Str::uuid()->toString();

            $menu->id = $menuid;
            $menu->title = $request->input('title');
            $menu->order = $request->input('order');
            $menu->route = $request->input('route');
            $menu->parent_id = $request->input('parent_id');
            $menu->icon = $request->input('icon');

            $menu->save();

            $menu_roles = array();

            $roles = explode(',', $request->input('roles'));

            foreach($roles as $role)
            {
                $menu_roles[] = [
                    'menu_id' => $menuid,
                    'role_category_id' => $role
                ];
            }

            MenuRoleCategory::insert($menu_roles);

            DB::commit();

            return response()->json(['status' => true, 'data' => $menu], 201);
        }
        catch(\PDOException $pdoEx)
        {
            DB::rollback();

            $error = $pdoEx->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalaan Transaksi Database", 'log_key' => $log_key], 500);
        }
    }

    private function update_menu_roles($request)
    {
        try
        {
            DB::beginTransaction();

            $menu = Menu::find($request->input('id'));

            $menu->title = $request->input('title');
            $menu->order = $request->input('order');
            $menu->route = $request->input('route');
            $menu->parent_id = $request->input('parent_id');
            $menu->icon = $request->input('icon');

            $menu->save();

            MenuRoleCategory::where('menu_id','=', $request->input('id'))->delete();

            $menu_roles = array();

            $roles = explode(',', $request->input('roles'));

            foreach($roles as $role)
            {
                $menu_roles[] = [
                    'menu_id' => $request->input('id'),
                    'role_category_id' => $role
                ];
            }

            MenuRoleCategory::insert($menu_roles);

            DB::commit();

            return response()->json(['status' => true, 'data' => $menu], 204);
        }
        catch(\PDOException $pdoEx)
        {
            DB::rollback();

            $error = $pdoEx->getMessage();
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
            $log->controller = 'ApiTeacher';
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
