<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string'
      ];

    protected $fillable = ['id','fullname','birth_date','gender','level','class','education','isPribumi','group',
                            'village','created_by','updated_by','created_at','updated_at'];

    public static function selectAll()
    {
        $result = DB::table('students')
                    ->leftJoin('levels', 'students.level', '=', 'levels.id')
                    ->leftJoin('class_levels','students.class', '=', 'class_levels.id')
                    ->leftJoin('education', 'students.education', '=', 'education.id')
                    ->leftJoin('groups','students.group', '=', 'groups.id')
                    ->leftJoin('villages','students.village', '=', 'villages.id')
                    ->select('students.id', 'students.fullname', 'students.gender', 'students.birth_date', 'students.isPribumi',
                    'levels.name as level','class_levels.name as class','education.name as education','groups.name as group','villages.name as village')
                    ->get();

        return $result;
    }

    public static function selectByVillage()
    {
        $result = DB::table('students')
                    ->leftJoin('levels', 'students.level', '=', 'levels.id')
                    ->leftJoin('class_levels','students.class', '=', 'class_levels.id')
                    ->leftJoin('education', 'students.education', '=', 'education.id')
                    ->leftJoin('groups','students.group', '=', 'groups.id')
                    ->leftJoin('villages','students.village', '=', 'villages.id')
                    ->where('village','=', session('village'))
                    ->select('students.id', 'students.fullname', 'students.gender', 'students.birth_date', 'students.isPribumi',
                    'levels.name as level','class_levels.name as class','education.name as education','groups.name as group','villages.name as village')
                    ->get();

        return $result;
    }

    public static function selectByGroup()
    {
        $result = DB::table('students')
                    ->leftJoin('levels', 'students.level', '=', 'levels.id')
                    ->leftJoin('class_levels','students.class', '=', 'class_levels.id')
                    ->leftJoin('education', 'students.education', '=', 'education.id')
                    ->leftJoin('groups','students.group', '=', 'groups.id')
                    ->leftJoin('villages','students.village', '=', 'villages.id')
                    ->where('group','=', session('group'))
                    ->select('students.id', 'students.fullname', 'students.gender', 'students.birth_date', 'students.isPribumi',
                    'levels.name as level','class_levels.name as class','education.name as education','groups.name as group','villages.name as village')
                    ->get();

        return $result;
    }

    public static function get_student_by_id($id)
    {
        return DB::table('students')->where('id','=',$id)->first();
    }

    #region Statistics

    public static function select_student_general_by_level_gender($group_id)
    {
        $result = DB::table('students')
                ->leftJoin('levels', 'students.level', '=', 'levels.id')
                ->where('students.group', '=', $group_id) //7079bef5-d75c-11ec-b5a0-5ce0c508bbb3
                ->orderBy('levels.order')
                ->groupBy(['students.level','levels.name','students.gender'])
                ->get(['levels.name','students.gender',DB::raw('count(*) as total')]);

        return $result;
    }

    public static function select_student_general_by_level($group_id)
    {
        $result = DB::table('students')
                ->leftJoin('levels', 'students.level', '=', 'levels.id')
                ->where('students.group', '=', $group_id) //7079bef5-d75c-11ec-b5a0-5ce0c508bbb3
                ->orderBy('levels.order')
                ->groupBy(['students.level','levels.name'])
                ->get(['levels.name',DB::raw('count(*) as total')]);

        return $result;
    }

    public static function select_student_general_by_class_gender($group_id)
    {
        $result = DB::table('students')
                ->leftJoin('class_levels', 'students.class', '=', 'class_levels.id')
                ->where('students.group', '=', $group_id) // 7079bef5-d75c-11ec-b5a0-5ce0c508bbb3
                ->orderBy('class_levels.name')
                ->groupBy(['students.class','class_levels.name','students.gender'])
                ->get(['class_levels.name','students.gender',DB::raw('count(*) as total')]);

        return $result;
    }

    public static function select_student_general_by_level_education($group_id)
    {
        $result = DB::table('students')
                ->leftJoin('education', 'students.education', '=', 'education.id')
                ->where('students.group', '=', $group_id) // 7079bef5-d75c-11ec-b5a0-5ce0c508bbb3
                ->orderBy('education.order')
                ->groupBy(['students.education','education.name','students.gender'])
                ->get(['education.name','students.gender',DB::raw('count(*) as total')]);

        return $result;
    }

    public static function select_student_by_class_and_gender($group_id, $level)
    {
        $result = DB::table('class_levels')
                ->leftJoin('students', 'students.class', '=', 'class_levels.id')
                ->where('students.group', '=', $group_id) //7079bef5-d75c-11ec-b5a0-5ce0c508bbb3
                ->where('students.level', '=', $level)
                ->orderBy('class_levels.name')
                ->groupBy(['students.class', 'class_levels.name', 'students.gender'])
                ->get(['students.class', 'class_levels.name','students.gender',DB::raw('count(students.class) as total')]);

        return $result;
    }

    public static function select_student_praremaja_by_gender($group_id)
    {
        $result = DB::table('students')
                ->where('group', '=', $group_id) // 7079bef5-d75c-11ec-b5a0-5ce0c508bbb3
                ->where('level', '=', '28ffe5ed-d75c-11ec-b5a0-5ce0c508bbb3')
                ->groupBy('gender')
                ->get(['gender', DB::raw('count(gender) as total')]);

        return $result;
    }


    public static function select_student_remaja_by_gender($group_id)
    {
        $result = DB::table('students')
                ->where('group', '=', $group_id) //7079bef5-d75c-11ec-b5a0-5ce0c508bbb3
                ->where('level', '=', '3110ea5d-d75c-11ec-b5a0-5ce0c508bbb3')
                ->groupBy('gender')
                ->get(['gender', DB::raw('count(gender) as total')]);

        return $result;
    }

    public static function select_student_unik_by_gender($group_id)
    {
        $result = DB::table('students')
                ->where('group', '=', $group_id) // 7079bef5-d75c-11ec-b5a0-5ce0c508bbb3
                ->where('level', '=', '3110c8d4-d75c-11ec-b5a0-5ce0c508bbb3')
                ->groupBy('gender')
                ->get(['gender', DB::raw('count(gender) as total')]);

        return $result;
    }

    public static function select_student_unik_by_education_and_gender($group_id)
    {
        $result = DB::table('students')
                ->leftJoin('education', 'students.education', '=', 'education.id')
                ->where('students.group', '=', $group_id) //'7079bef5-d75c-11ec-b5a0-5ce0c508bbb3'
                ->where('students.level', '=', '3110c8d4-d75c-11ec-b5a0-5ce0c508bbb3')
                ->groupBy(['students.education','education.name', 'students.gender'])
                ->get(['students.education', 'education.name','students.gender',DB::raw('count(students.gender) as total')]);

        return $result;
    }

    public static function select_student_unik_pribumi_status($group_id)
    {
        $result = DB::table('students')
                ->where('group', '=', $group_id) //7079bef5-d75c-11ec-b5a0-5ce0c508bbb3
                // ->where('level', '=', '3110c8d4-d75c-11ec-b5a0-5ce0c508bbb3')
                ->where('isPribumi', '=', 1)
                ->get([DB::raw('count(*) as total')]);

        return $result;
    }

    public static function select_student_unik_nonpribumi_status($group_id)
    {
        $result = DB::table('students')
                ->where('group', '=', $group_id) // 7079bef5-d75c-11ec-b5a0-5ce0c508bbb3
                // ->where('level', '=', '3110c8d4-d75c-11ec-b5a0-5ce0c508bbb3')
                ->where('isPribumi', '<>', 1)
                ->get([DB::raw('count(*) as total')]);

        return $result;
    }



    public static function select_student_village_by_group_level_gender()
    {
        $result = DB::table('students')
                ->leftJoin('groups', 'students.group', '=', 'groups.id')
                ->leftJoin('levels', 'students.level', '=', 'levels.id')
                ->where('students.village', '=', '3d7b8363-d75c-11ec-b5a0-5ce0c508bbb3')
                ->orderBy('groups.name')
                ->orderBy('levels.order')
                ->groupBy(['students.group', 'groups.name', 'students.level', 'levels.name', 'students.gender'])
                ->get(['groups.name as group','levels.name as level','students.gender',DB::raw('count(*) as total')]);

        return $result;
    }

    public static function select_student_village_by_group_education_gender()
    {
        $result = DB::table('students')
                ->leftJoin('groups', 'students.group', '=', 'groups.id')
                ->leftJoin('education', 'students.education', '=', 'education.id')
                ->where('students.village', '=', '3d7b8363-d75c-11ec-b5a0-5ce0c508bbb3')
                ->orderBy('groups.name')
                ->orderBy('education.order')
                ->groupBy(['students.group', 'groups.name', 'students.education', 'education.name', 'students.gender'])
                ->get(['groups.name as group','education.name as education','students.gender',DB::raw('count(*) as total')]);

        return $result;
    }

    #endregion
}
