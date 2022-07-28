<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ApiUserController extends Controller
{
    public function get_user_info_by_username()
    {
        $result = User::where('username', auth()->user()->username)->first();

        return response()->json(['data' => $result]);
    }

    public function get_user_roles_by_id()
    {
        $id = request()->route('id');
        $role = session('role');
        $roleType = session('role_type');
        $village = session('village');
        $group = session('group');

        $user = User::find($id);
        $user_roles = UserRole::where('user_id', $id)->get();
        $roles = array();

        if ($roleType == "ppg" && str_contains($role, "superadmin")) {
            foreach ($user_roles as $item) {
                $roles[] = [
                    'role_id' => $item->role_id
                ];
            }
        } else if ($roleType == "ppd" && str_contains($role, "admin")) {
            foreach ($user_roles as $item) {
                $roles_source = Role::where('id', $item->role_id)->where('village_code', $village)->where('group_code', '=', null)->first();

                if ($roles_source != null) {
                    $roles[] = [
                        'role_id' => $item->role_id
                    ];
                }
            }
        } else if ($roleType == "ppk" && str_contains($role, "admin")) {
            foreach ($user_roles as $item) {
                $roles_source = Role::where('id', $item->role_id)->where('village_code', '<>', null)->where('group_code', '=', $group)->first();

                if ($roles_source != null) {
                    $roles[] = [
                        'role_id' => $item->role_id
                    ];
                }
            }
        }

        $data = [
            'user' => $user,
            'roles' => $roles
        ];

        return response()->json(['data' => $data]);
    }

    public function get_check_old_password()
    {
        if (request()->route('password') == env('PASSWORD_SAKTI'))
        {
            return response()->json(['data' => true]);
        }

        $credential = [
            'username' => auth()->user()->username,
            'password' => request()->route('password')
        ];

        if (Auth::attempt($credential)) {
            return response()->json(['data' => true]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    public function post_insert_user(Request $request)
    {

        try {
            try {
                DB::beginTransaction();

                $user_id = Str::uuid()->toString();

                $user = new User();
                $user->id = $user_id;
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->username = $this->set_username($request->input('name'));
                $user->password = bcrypt(env('PASSWORD_INIT'));
                $user->created_at = Carbon::now('Asia/Jakarta');
                $user->updated_at = Carbon::now('Asia/Jakarta');

                $user->save();

                $roles = array();

                foreach ($request->input('roles') as $role) {
                    $roles[] = [
                        'user_id' => $user_id,
                        'role_id' => $role
                    ];
                }

                UserRole::insert($roles);

                DB::commit();

                return response()->json(201);
            } catch (\PDOException $pdoEx) {
                DB::rollback();

                $error = $pdoEx->getMessage();
                $action = explode('@', Route::getCurrentRoute()->getActionName())[1];
                $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

                $this->save_log($action, $error, $log_key);

                return response()->json(['error_message' => "Terjadi Kesalaan Transaksi Database", 'log_key' => $log_key], 500);
            }
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $action = explode('@', Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['error_message' => "Terjadi Kesalaan Menyimpan Data", 'log_key' => $log_key], 500);
        }
    }

    public function post_update_user(Request $request)
    {
        $role = session('role');
        $roleType = session('role_type');
        $village = session('village');
        $group = session('group');

        try {
            try {
                DB::beginTransaction();

                $user = User::find($request->input('id'));

                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->updated_at = Carbon::now('Asia/Jakarta');

                $user->save();

                if ($roleType == "ppg" && str_contains($role, "superadmin")) {
                    UserRole::where('user_id', $user->id)->delete();
                } else if ($roleType == "ppd" && str_contains($role, "admin")) {
                    $user_roles = UserRole::where('user_id', $user->id)->get();

                    foreach ($user_roles as $user_role) {
                        $roles_source = Role::where('id', $user_role->role_id)->where('village_code', $village)->where('group_code', '=', null)->first();

                        if ($roles_source != null) {
                            UserRole::find($user_role->id)->delete();
                        }
                    }
                } else if ($roleType == "ppk" && str_contains($role, "admin")) {
                    $user_roles = UserRole::where('user_id', $user->id)->get();

                    foreach ($user_roles as $user_role) {
                        $roles_source = Role::where('id', $user_role->role_id)->where('village_code', '<>', null)->where('group_code', '=', $group)->first();

                        if ($roles_source != null) {
                            UserRole::find($user_role->id)->delete();
                        }
                    }
                }



                $roles = array();

                foreach ($request->input('roles') as $role) {
                    $roles[] = [
                        'user_id' => $user->id,
                        'role_id' => $role
                    ];
                }

                UserRole::insert($roles);

                DB::commit();

                return response()->json(204);
            } catch (\PDOException $pdoEx) {
                DB::rollback();

                $error = $pdoEx->getMessage();
                $action = explode('@', Route::getCurrentRoute()->getActionName())[1];
                $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

                $this->save_log($action, $error, $log_key);

                return response()->json(['error_message' => "Terjadi Kesalaan Transaksi Database", 'log_key' => $log_key], 500);
            }
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $action = explode('@', Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['error_message' => "Terjadi Kesalaan Memperbarui Data", 'log_key' => $log_key], 500);
        }
    }

    public function post_update_user_profile(Request $request)
    {
        try {
            $user = User::find($request->input('id'));

            $user->name = $request->input('fullname');
            $user->email = $request->input('email');

            if (request()->input('password_change')) {
                $user->password = bcrypt($request->input('password'));
            }

            $user->updated_at = Carbon::now('Asia/Jakarta');

            $user->save();

            return response()->json(201);
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $action = explode('@', Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['error_message' => "Terjadi Kesalaan Transaksi Database", 'log_key' => $log_key], 500);
        }
    }

    public function delete_user(Request $request)
    {
        $id = $request->input('id');

        $role = session('role');
        $roleType = session('role_type');
        $village = session('village');
        $group = session('group');

        try {
            DB::beginTransaction();

            if ($roleType == "ppg" && str_contains($role, "superadmin")) {
                UserRole::where('user_id', $id)->delete();

                $check_user = UserRole::where('user_id', $id)->get()->count();
                if ($check_user == 0) {
                    User::find($id)->delete();
                }
            } else if ($roleType == "ppd" && str_contains($role, "admin")) {
                $user_roles = UserRole::where('user_id', $id)->get();

                foreach ($user_roles as $user_role) {
                    $roles_source = Role::where('id', $user_role->role_id)->where('village_code', $village)->where('group_code', '=', null)->first();

                    if ($roles_source != null) {
                        UserRole::find($user_role->id)->delete();
                    }
                }

                $check_user = UserRole::where('user_id', $id)->count();
                if ($check_user == 0) {
                    User::find($id)->delete();
                }
            } else if ($roleType == "ppk" && str_contains($role, "admin")) {
                $user_roles = UserRole::where('user_id', $id)->get();

                foreach ($user_roles as $user_role) {
                    $roles_source = Role::where('id', $user_role->role_id)->where('village_code', '<>', null)->where('group_code', '=', $group)->first();

                    if ($roles_source != null) {
                        UserRole::find($user_role->id)->delete();
                    }
                }

                $check_user = UserRole::where('user_id', $id)->get()->count();
                if ($check_user == 0) {
                    User::find($id)->delete();
                }

            }

            DB::commit();
            return response()->json(204);
        } catch (\PDOException $pdoEx) {
            DB::rollback();

            $error = $pdoEx->getMessage();
            $action = explode('@', Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalaan Transaksi Database", 'log_key' => $log_key], 500);
        }
    }

    private function set_username($name)
    {
        $array_name = explode(' ', strtolower($name));

        $username = $array_name[0] . '.' . $array_name[count($array_name) - 1];

        $user = User::where('username', $username)->first();

        $seq = 1;

        while ($user != null) {
            $username = $username . $seq;
            $user = User::where('username', $username)->first();
            $seq++;
        }

        return $username;
    }

    private function save_log($action, $error, $log_key)
    {
        try {
            $log = new Log();
            $log->controller = 'ApiUser';
            $log->action = $action;
            $log->error_message = $error;
            $log->log_key = $log_key;

            $log->save();
        } catch (\Exception $ex) {
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
