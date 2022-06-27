<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\ClassLevel;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function get_list_teachers()
    {
        $data = $this->get_teachers(); //Teacher::where('group', session('group'))->get();

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

    public function get_form_edit_teacher()
    {
        return view ('teachers.form-edit', [
            'title' => "Ubah PJ Kelas"
        ]);
    }

    private function get_teachers()
    {
        $group = session('group');

        $data = Teacher::get_teachers($group);

        $class_level_master = ClassLevel::get_class_level_by_group();

        $result = array();

        foreach($data as $item)
        {
            if ($item->class_level != "" || $item->class_level != null)
            {
                $class_level_orig = $item->class_level;
                $class_levels = explode(',', $class_level_orig);

                $class_level_array = array();

                foreach($class_levels as $class_level)
                {
                    $class_level_obj = $class_level_master->where('id', $class_level)->first();
                    if ($class_level_obj != null)
                    {
                        $class_level_array[] = [
                            'class_level' => $class_level_obj->name
                        ];
                    }

                }

                $result[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'gender' => $item->gender,
                    'status' => $item->status,
                    'is_teacher' => $item->is_teacher,
                    'is_admin_class' => $item->is_admin_class,
                    'is_student' => $item->is_student,
                    'class_levels' => $class_level_array,
                    'group' => $item->group
                ];
            }
        }

        return $result;
    }
}
