<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string'
      ];

    public static function get_teachers($group)
    {
      $query = DB::table('teachers')->where('group', $group)->get();

      return $query;
    }
}
