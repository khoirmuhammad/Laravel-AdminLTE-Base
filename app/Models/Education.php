<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Education extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string'
      ];

      public static function get_education()
      {
        $result = DB::table('education')
                  ->orderBy('order')
                  ->get(['id','name']);

        return $result;
      }
}
