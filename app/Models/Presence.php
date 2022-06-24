<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Presence extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function select_student_class($group, $class_level)
    {
        $query = DB::table('students')
                ->leftJoin('presences', 'students.id','=','presences.student_id')
                ->leftJoin('class_levels', 'students.class','=', 'class_levels.id')
                ->where('students.group',$group)
                ->where('students.class', $class_level)
                ->where('filled_date', )
                ->get(['presences.id','students.id as student_id','students.fullname','class_levels.id as level_id','class_levels.name as classname',
                    'presences.is_present', 'presences.is_permit', 'presences.is_absent','presences.permit_desc',
                    'presences.filled_by']);

        return $query;
    }
}
