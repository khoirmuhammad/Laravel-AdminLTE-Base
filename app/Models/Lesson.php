<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string'
      ];

    protected $primaryKey = 'id';

    public static function get_all_lesson($class_level = null)
    {
        if ($class_level == null){
            return DB::table('lessons')
            ->join('class_levels', 'lessons.class_level', 'class_levels.id')
            ->get(['lessons.id','lessons.name', 'lessons.category_code','class_levels.name as classname', 'lessons.semester']);
        }

        $level_id = DB::table('class_levels')->where('id',$class_level)->first()->level_id;
        $class_levels = DB::table('class_levels')->where('level_id', $level_id)->get('id');

        $class_levels_arr = [];

        foreach($class_levels as $item)
        {
            array_push($class_levels_arr, $item->id);
        }

        $query = DB::table('lessons')
                ->join('class_levels', 'lessons.class_level', 'class_levels.id')
                ->whereIn('lessons.class_level',$class_levels_arr)->get(['lessons.id','lessons.name','lessons.category_code','class_levels.name as classname','lessons.semester']);

        return $query;
    }
}
