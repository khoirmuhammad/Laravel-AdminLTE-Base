<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $casts = [
        'id' => 'string'
      ];

      public $timestamps = false;

    public static function get_list_role()
    {
        $query = DB::table('roles')
                ->leftJoin('villages', 'roles.village_code', '=', 'villages.id')
                ->leftJoin('groups', 'roles.group_code', '=', 'groups.id')
                ->get(['roles.id as id', 'roles.category as category', 'villages.name as village', 'groups.name as group']);
        return $query;
    }
}
