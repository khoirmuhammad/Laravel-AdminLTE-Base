<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Presence extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function select_students($group, $class_level)
    {
        $query = DB::table('students')
            ->where('group', $group)
            ->where('class', $class_level)
            ->get(['id as student_id', 'fullname']);

        return $query;
    }

    public static function select_student_presence_class($group, $class_level)
    {
        $current_date = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $query = DB::table('students')
            ->leftJoin('presences', 'students.id', '=', 'presences.student_id')
            ->leftJoin('class_levels', 'students.class', '=', 'class_levels.id')
            ->where('students.group', $group)
            ->where('students.class', $class_level)
            ->where('presences.filled_date', $current_date)
            ->get([
                'presences.id', 'students.id as student_id', 'students.fullname', 'class_levels.id as level_id', 'class_levels.name as classname',
                'presences.is_present', 'presences.is_permit', 'presences.is_absent', 'presences.permit_desc',
                'presences.filled_by'
            ]);

        return $query;
    }

    public static function get_recap_presences_by_class($month)
    {
        $current_year = (int)date('Y');

        $query = DB::select("SELECT
        class_levels.id as classid,
        class_levels.name as classname,
        sum(presences.is_present) as present,
        sum(presences.is_permit) as permit,
        sum(presences.is_absent) as absent ,
        sum(presences.is_present) + sum(presences.is_permit) + sum(presences.is_absent) as total,
        cast((sum(presences.is_present) * 100) / (sum(presences.is_present) + sum(presences.is_permit) + sum(presences.is_absent)) as DECIMAL(12,2)) as present_percent,
        cast((sum(presences.is_permit) * 100) / (sum(presences.is_present) + sum(presences.is_permit) + sum(presences.is_absent)) as DECIMAL(12,2)) as permit_percent,
        cast((sum(presences.is_absent) * 100) / (sum(presences.is_present) + sum(presences.is_permit) + sum(presences.is_absent)) as DECIMAL(12,2)) as absent_percent
        FROM `presences` JOIN class_levels on presences.class_level_id = class_levels.id
        WHERE presences.group_id = '" . session('group') . "'
        AND month(presences.filled_date) = " . $month . "
        AND year(presences.filled_date) = " . $current_year . "
        GROUP BY class_levels.id, class_levels.name");

        return collect($query);
    }

    public static function get_recap_presences_by_student_in_class($month, $class_level)
    {
        $current_year = (int)date('Y');

        $query = DB::select("
        SELECT st.fullname, cl.name as classname, sum(is_present) as present, sum(is_permit) as permit, sum(is_absent) as absent
        FROM students st
        left JOIN presences pr on st.id = pr.student_id
        JOIN class_levels cl on pr.class_level_id = cl.id WHERE cl.id = '". $class_level ."' and month(pr.filled_date) = ". $month ."
        and year(pr.filled_date) = ". $current_year ."
        GROUP by st.fullname, st.id, cl.name
        ORDER by SUM(is_present) DESC, SUM(is_permit) DESC, SUM(is_absent) ASC, st.fullname");

        return collect($query);
    }


    public static function get_total_meet_by_class($current_month, $classname)
    {
        $query = DB::select("SELECT class_levels.name as classname, presences.filled_date
        FROM `presences` JOIN class_levels on presences.class_level_id = class_levels.id
        where month(presences.filled_date) = " . $current_month . "
        and class_levels.name = '" . $classname . "'
        group by presences.filled_date, class_levels.name");

        return $query;
    }

    // public static function get_recap_presences($class_level = null, $current_month = null)
    // {
    //     $result = array();

    //     if ($class_level != null && $current_month != null) {
    //         $query = DB::select("SELECT students.fullname,
    //         sum(presences.is_present) as present,
    //         sum(presences.is_permit) as permit,
    //         sum(presences.is_absent) as absent
    //         FROM `presences` join students on students.id = presences.student_id
    //         where students.class = '" . $class_level . "'
    //         and month(presences.filled_date) = " . $current_month . "
    //         and presences.group_id = '" . session('group') . "'
    //         group by students.fullname");

    //         $result[] = [
    //             'data' => $query
    //         ];
    //     } else if ($class_level == null && $current_month != null) {
    //         $query = DB::select("SELECT students.fullname,
    //         sum(presences.is_present) as present,
    //         sum(presences.is_permit) as permit,
    //         sum(presences.is_absent) as absent
    //         FROM `presences` join students on students.id = presences.student_id
    //         where month(presences.filled_date) = " . $current_month . "
    //         and presences.group_id = '" . session('group') . "'
    //         group by students.fullname");

    //         $result[] = [
    //             'data' => $query
    //         ];
    //     } else if ($class_level != null && $current_month == null) {

    //         if ($current_month == null) {
    //             $current_month = (int)date('m');
    //         }

    //         for ($i = 1; $i <= $current_month; $i++) {
    //             $query = DB::select("SELECT students.fullname,
    //             sum(presences.is_present) as present,
    //             sum(presences.is_permit) as permit,
    //             sum(presences.is_absent) as absent
    //             FROM `presences` join students on students.id = presences.student_id
    //             where students.class = '" . $class_level . "'
    //             and month(presences.filled_date) = " . $i . "
    //             and presences.group_id = '" . session('group') . "'
    //             group by students.fullname");

    //             $result[] = [
    //                 'data' => $query
    //             ];
    //         }
    //     } else {

    //         if ($current_month == null) {
    //             $current_month = (int)date('m');
    //         }

    //         for ($i = 1; $i <= $current_month; $i++) {
    //             $query = DB::select("SELECT students.fullname,
    //             sum(presences.is_present) as present,
    //             sum(presences.is_permit) as permit,
    //             sum(presences.is_absent) as absent
    //             FROM `presences` join students on students.id = presences.student_id
    //             where month(presences.filled_date) = " . $i . "
    //             and presences.group_id = '" . session('group') . "'
    //             group by students.fullname");

    //             $result[] = [
    //                 'data' => $query
    //             ];
    //         }
    //     }

    //     return $result;
    // }
}
