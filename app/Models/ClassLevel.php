<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassLevel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string'
      ];

      public $timestamps = false;

      public static function get_class_level($group, $level)
      {
        // remaja & unik
        if ($level == "3110ea5d-d75c-11ec-b5a0-5ce0c508bbb3" || $level == "3110c8d4-d75c-11ec-b5a0-5ce0c508bbb3")
        {
            $level = array('3110ea5d-d75c-11ec-b5a0-5ce0c508bbb3','3110c8d4-d75c-11ec-b5a0-5ce0c508bbb3');

            $query1 = DB::table('class_levels')
            ->where('group_id','=','')
            ->whereIn('level_id', $level);

            $query2 = DB::table('class_levels')
                        ->where('group_id','=',$group)
                        ->whereIn('level_id', $level)
                        ->union($query1)
                        ->get();

            return $query2;

        }
        else
        {
            $query1 = DB::table('class_levels')
            ->where('group_id','=','')
            ->where('level_id','=', $level);

            $query2 = DB::table('class_levels')
                        ->where('group_id','=',$group)
                        ->where('level_id','=', $level)
                        ->union($query1)
                        ->get();

            return $query2;
        }

      }

      public static function get_class_level_by_group()
      {
        // $query1 = DB::table('class_levels')
        //           ->where('group_id','=',session('group'));

        // $query2 = DB::table('class_levels')
        //           ->where('group_id','=', '')
        //           ->union($query1)
        //           ->get();

        $query = DB::table('class_levels')
                ->where('group_id','=',session('group'))
                ->orWhere('group_id','=', '')
                ->orderBy('name')
                ->get();

        return $query;
      }

      public static function get_class_level_with_exist_student_by_group()
      {
        $query = DB::table('class_levels')
                    ->join('students', 'class_levels.id','=','students.class')
                    ->where('students.group','=', session('group'))
                    ->orderBy('class_levels.name')
                    ->select(['class_levels.id','class_levels.name'])
                    ->distinct()
                    ->get();

        return $query;
      }

      public static function get_class_level_with_exist_student_by_group_and_level($level)
      {
        // remaja & unik
        if ($level == "3110ea5d-d75c-11ec-b5a0-5ce0c508bbb3" || $level == "3110c8d4-d75c-11ec-b5a0-5ce0c508bbb3")
        {
            $level = array('3110ea5d-d75c-11ec-b5a0-5ce0c508bbb3','3110c8d4-d75c-11ec-b5a0-5ce0c508bbb3');

            $query1 = DB::table('class_levels')
                    ->join('students', 'class_levels.id','=','students.class')
                    ->where('students.group','=', session('group'))
                    ->whereIn('class_levels.level_id', $level)
                    ->orderBy('class_levels.name')
                    ->select(['class_levels.id as id','class_levels.name as name'])
                    ->distinct()
                    ->get();

            return $query1;



        }
        else
        {
            $query2 = DB::table('class_levels')
                    ->join('students', 'class_levels.id','=','students.class')
                    ->where('students.group','=', session('group'))
                    ->where('class_levels.level_id', $level)
                    ->orderBy('class_levels.name')
                    ->select(['class_levels.id','class_levels.name'])
                    ->distinct()
                    ->get();

            return $query2;
        }
      }

      public static function get_class_level_by_group_join_level()
      {
        $query1 = DB::table('class_levels')
                    ->leftJoin('levels', 'levels.id','=','class_levels.level_id')
                  ->where('class_levels.group_id','=',session('group'))
                  ->orWhere('class_levels.group_id','=', '')
                  ->select(['class_levels.id as id','class_levels.name as classname','class_levels.group_id',
                  'class_levels.level_id as level_id','levels.name as levelname'])->orderBy('class_levels.name')->get();

        return $query1;
      }

      public static function get_class_leve_exists_by_group_join_level()
      {
        $query1 = DB::table('class_levels')
                    ->leftJoin('levels', 'levels.id','=','class_levels.level_id')
                  ->where('class_levels.group_id','=',session('group'))
                  ->orWhere('class_levels.group_id','=', '')
                  ->select(['class_levels.id as id','class_levels.name as classname','class_levels.group_id',
                  'class_levels.level_id as level_id','levels.name as levelname'])->orderBy('class_levels.name')->get();

        return $query1;
      }

      public static function get_class_level_join_level()
      {
        $query = DB::table('class_levels')
                    ->leftJoin('levels', 'levels.id','=','class_levels.level_id')
                  ->select(['class_levels.id as id','class_levels.name as classname','class_levels.group_id',
                  'class_levels.level_id as level_id','levels.name as levelname'])->get();

        return $query;
      }

      public static function class_exist_in_group()
      {
        $query = DB::table('class_levels')
                ->join('students', 'class_levels.id','=','students.class')
                ->where('students.group','=', session('group'))
                ->orderBy('class_levels.name')
                ->distinct()
                ->get(['class_levels.id as classid','class_levels.name as classname']);

        return $query;
      }
}
