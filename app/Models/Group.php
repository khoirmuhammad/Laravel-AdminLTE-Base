<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string'
      ];

    protected $primaryKey = 'id';

    public static function group_info($group_id)
    {
      $result = DB::table('groups')
                ->where('id','=',$group_id)
                ->get();

      return $result;
    }

    public static function group_list($village)
    {
      if ($village == "")
      {
        return DB::table('groups')->select(['id','name','kbm_name'])->get();
      }
      else
      {
        return DB::table('groups')->where('village_id',$village)->select(['id','name','kbm_name'])->get();
      }
    }
}
