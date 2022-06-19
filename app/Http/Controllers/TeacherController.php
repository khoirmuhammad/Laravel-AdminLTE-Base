<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function get_list_teachers()
    {
        $data = Teacher::where('group', session('group'))->get();
        
        return view('teachers.index',[
            "title" => "Data PJ Kelas",
            "data" => $data
        ]);
    }

    public function get_form_add_teacher()
    {
        return view('teachers.form-add',[
            "title" => "Tambah PJ Kelas"
        ]);
    }
}
