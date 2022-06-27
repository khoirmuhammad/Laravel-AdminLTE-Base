<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $result = Role::get_list_role();

        return view('roles.index', [
            'title' => "Data Role",
            'data' => $result
        ]);
    }

    public function get_form_add()
    {
        return view('roles.form-add', [
            'title' => "Tambah Role"
        ]);
    }

    public function get_form_edit()
    {
        return view('roles.form-edit', [
            'title' => "Edit Role"
        ]);
    }
}
