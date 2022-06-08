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
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials))
        {
            $is_authenticated = true;
            $user = User::where('username','=',$request->input('username'))->first();
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
                'message' => 'Akun anda belum diresgistrasi'
            ];

            return response()->json(['response' => $response]);
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
                }
                else if ($role_data->group_code == null && $role_data->village_code != null)
                {
                    request()->session()->put('village', $role_data->village_code);
                }
                    
            }
        }
    }

}
