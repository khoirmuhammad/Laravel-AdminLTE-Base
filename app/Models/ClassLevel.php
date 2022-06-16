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

      public static function get_class_level($group, $level)
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

      public static function get_class_level_by_group()
      {
        $query1 = DB::table('class_levels')
                  ->where('group_id','=',session('group'));

        $query2 = DB::table('class_levels')
                  ->where('group_id','=', '')
                  ->union($query1)
                  ->get();

        return $query2;
      }
}
