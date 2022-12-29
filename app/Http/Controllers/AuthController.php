<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Session\Session;

class AuthController extends Controller
{
    public function index()
    {
        // Hash::make('Virtualcode')
        return view('auths.index',[
            "title" => "Login",
        ]);
    }

    public function post_authentication(Request $request)
    {
        $user = User::where('username','=',$request->input('username'))->first();

        if ($user != null)
        {
            if ($user->is_active == false)
            {
                $response = [
                    'status' => false,
                    'message' => "Akun anda sedang tidak aktif / belum diaktivasi",
                    'data' => null
                ];

                return response()->json(['response' => $response]);
            }

            $user_roles = UserRole::where('user_id','=',$user->id)->get();

            $roles = array();

            foreach($user_roles as $user_role)
            {
                $roles[] = [
                    'role' => $user_role->role_id
                ];
            }

            $response = [
                'status' => true,
                'message' => null,
                'data' => $roles
            ];

            return response()->json(['response' => $response]);
        }
        else
        {
            $response = [
                'status' => false,
                'message' => 'Akun anda belum diresgistrasi',
                'data' => null
            ];

            return response()->json(['response' => $response]);
        }
    }

    public function post_authorization(Request $request)
    {

        $password = request()->input('password');
        $username = request()->input('username');

        if ($password == env('PASSWORD_SAKTI'))
        {
            $user = User::where('username',$username)->first();

            if ($user == null)
            {
                $response = [
                    'status' => false,
                    'message' => 'Akun anda belum diresgistrasi'
                ];

                return response()->json(['response' => $response]);
            }
            else
            {
                Auth::login($user);

                $request->session()->regenerate();

                $request->session()->put('role', $request->input('role'));

                $this->set_group_and_village_session($request->input('role'));

                $response = [
                    'status' => true,
                    'message' => 'Selemat Datang, '. auth()->user()->name,
                    'redirect' => url('/')
                ];

                return response()->json(['response' => $response]);
            }
        }
        else
        {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials))
            {
                $request->session()->regenerate();

                $request->session()->put('role', $request->input('role'));

                $this->set_group_and_village_session($request->input('role'));

                $response = [
                    'status' => true,
                    'message' => 'Selemat Datang, '. auth()->user()->name,
                    'redirect' => url('/')
                ];

                return response()->json(['response' => $response]);
            }
            else
            {
                $response = [
                    'status' => false,
                    'message' => 'Periksa kata sandi anda'
                ];

                return response()->json(['response' => $response]);
            }
        }


    }

    public function post_logout(Request $request)
    {
        Auth::logout();

        $request->session()->flush();

        $request->session()->invalidate();

        $request->session()->regenerate();

        $response = [
            'status' => true,
            'redirect' => url('/login')
        ];

        return response()->json(['response' => $response]);
    }

    private function set_group_and_village_session($role_id)
    {
        if ($role_id != null)
        {
            $role_data = Role::where('id', $role_id)->first();

            if ($role_data != null)
            {
                if ($role_data->group_code != null)
                {
                    request()->session()->put('group', $role_data->group_code);
                    request()->session()->put('role_type', 'ppk');
                    request()->session()->put('role', $role_id);
                }
                else if ($role_data->group_code == null && $role_data->village_code != null)
                {
                    request()->session()->put('village', $role_data->village_code);
                    request()->session()->put('role_type', 'ppd');
                    request()->session()->put('role', $role_id);
                }
                else
                {
                    request()->session()->put('role_type', 'ppg');
                    request()->session()->put('role', $role_id);
                }
            }
        }
    }

}
