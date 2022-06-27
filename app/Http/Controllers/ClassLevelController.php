<?php

namespace App\Http\Controllers;

use App\Models\ClassLevel;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassLevelController extends Controller
{
    public function index()
    {
        $data = ClassLevel::get_class_level_by_group_join_level();

        return view('classes.index', [
            'title' => 'Data Kelas',
            'data' => $data
        ]);
    }

    public function get_form_add()
    {
        return view('classes.form-add', [
            'title' => 'Tambah Kelas'
        ]);
    }

    public function get_form_edit()
    {
        return view('classes.form-edit', [
            'title' => 'Ubah Kelas'
        ]);
    }
}
