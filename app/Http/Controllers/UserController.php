<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $role = session('role');
        $roleType = session('role_type');
        $village = session('village');
        $group = session('group');

        $result = array();

        if ($roleType == "ppg" && str_contains($role, "superadmin"))
        {
            $result = User::get_users();
        }
        else if ($roleType == "ppd" && str_contains($role, "admin"))
        {
            $result = User::get_users_by_village();
        }
        else if ($roleType == "ppk" && str_contains($role, "admin"))
        {
            $result = User::get_users_by_group();
        }


        return view('users.index', [
            'title' => "Data Pengguna",
            'data' => $result
        ]);
    }

    public function get_form_add()
    {
        return view('users.form-add', [
            'title' => "Tambah Pengguna"
        ]);
    }

    public function get_form_edit()
    {
        return view('users.form-edit', [
            'title' => "Ubah Pengguna"
        ]);
    }
}
