<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\ClassLesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function get_form_jurnal_popup(){
        return view('lessons.form-jurnal-popup', [
            "title" => "Jurnal"
        ]);
    }

    public function get_form_jurnal(Request $request){
        $class = $request->kelas;

        $class_lesson = ClassLesson::where('class_level',$class)
                        ->where('is_active', true)->first();

        if ($class_lesson == null) {
            return view('lessons.prevent-jurnal', [
                "title" => "Jurnal"
            ]);
        }

        $lessons = Lesson::where('class_level', $class_lesson->class_level)
                    ->where('semester', $class_lesson->actual_semester)
                    ->orderBy('category_code')->get(['id','name','category_code']);

        return view('lessons.form-jurnal', [
            "title" => "Jurnal",
            "data" => $lessons
        ]);
    }
}
