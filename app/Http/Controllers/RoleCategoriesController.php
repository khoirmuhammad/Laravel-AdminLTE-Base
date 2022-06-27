<?php

namespace App\Http\Controllers;

use App\Models\RoleCategory;
use Illuminate\Http\Request;

class RoleCategoriesController extends Controller
{
    public function index()
    {
        $result = RoleCategory::all();

        return view ('rolecategories.index', [
            'title' => "Data Kategori Role",
            'data' => $result
        ]);
    }

    public function get_form_add()
    {
        return view('rolecategories.form-add', [
            'title' => "Tambah Data"
        ]);
    }

    public function get_form_edit()
    {
        return view('rolecategories.form-edit', [
            'title' => "Ubah Data"
        ]);
    }
}
