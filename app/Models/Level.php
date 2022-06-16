<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Level extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string'
      ];

      public static function get_levels()
      {
        $result = DB::table('levels')
                  ->orderBy('order')
                  ->get(['id','name']);

        return $result;
      }
}
