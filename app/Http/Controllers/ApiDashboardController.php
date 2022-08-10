<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ApiDashboardController extends Controller
{
    public function get_total_teacher_group_by_status()
    {
        $result = Teacher::get_total_teacher_group_by_status(session('group'));

        return response()->json(['data' => $result]);
    }

    public function get_total_student_by_level()
    {
        $result = Student::select_student_general_by_level(session('group'));

        return response()->json(['data' => $result]);
    }

    public function get_total_student_by_class_gender()
    {
        $result = Student::select_student_general_by_class_gender(session('group'));

        return response()->json(['data' => $result]);
    }
}
