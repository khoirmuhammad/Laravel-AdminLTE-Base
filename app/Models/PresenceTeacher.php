<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PresenceTeacher extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function get_recap_precense_teacher($month)
    {
        $current_year = (int)date('Y');

        $query = DB::select("SELECT presence_teachers.teacher_id, teachers.name, count(*) as total_hadir
        FROM teachers left join presence_teachers
        on teachers.id = presence_teachers.teacher_id
        where (MONTH(presence_teachers.clock_in_date) = " . $month . " or MONTH(presence_teachers.clock_out_date) = " . $month . ")
        and (YEAR(presence_teachers.clock_in_date) = " . $current_year . " or YEAR(presence_teachers.clock_out_date) = " . $current_year . ")
        and teachers.is_teacher = 1
        GROUP by presence_teachers.teacher_id, teachers.name");

        return collect($query);
    }

    public static function get_presence_teacher_in_month($month, $teacher_id)
    {
        $current_year = (int)date('Y');

        $query = DB::select("SELECT teacher_id, class_level_id, clock_in_date, clock_in_time from presence_teachers
        where teacher_id  = '". $teacher_id ."' and MONTH(clock_in_date) = ".$month." and YEAR(clock_in_date) = ". $current_year ."");

        return $query;
    }

    public static function get_history_presence_teacher($month, $teacher_id)
    {
        $current_year = (int)date('Y');

        $query = DB::table('presence_teachers')
                    ->join('class_levels', 'presence_teachers.class_level_id','=','class_levels.id')
                    ->where('presence_teachers.teacher_id',$teacher_id)
                    ->whereMonth('presence_teachers.clock_in_date',$month)
                    ->whereYear('presence_teachers.clock_in_date', $current_year)
                    ->get(['class_levels.name','presence_teachers.clock_in_date','presence_teachers.clock_in_time']);

        return $query;
    }
}
