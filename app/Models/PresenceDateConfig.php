<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PresenceDateConfig extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function select_schedules_by_group($level = null, $class_level = null)
    {
        $query = null;

        if ($level == null && $class_level == null) {
            $query = DB::table('presence_date_configs')
            ->leftJoin('levels', 'presence_date_configs.level','=','levels.id')
            ->leftJoin('class_levels', 'presence_date_configs.class_level','=','class_levels.id')
            ->where('presence_date_configs.group','=', session('group'))
            ->orderBy('class_levels.name')
            ->get(['presence_date_configs.id','levels.name as level','class_levels.name as class_level',
            'presence_date_configs.day','presence_date_configs.start_time','presence_date_configs.end_time']);
        } else if ($level != null && $class_level == null) {
            $query = DB::table('presence_date_configs')
            ->leftJoin('levels', 'presence_date_configs.level','=','levels.id')
            ->leftJoin('class_levels', 'presence_date_configs.class_level','=','class_levels.id')
            ->where('presence_date_configs.group','=', session('group'))
            ->where('presence_date_configs.level','=', $level)
            ->orderBy('class_levels.name')
            ->get(['presence_date_configs.id','levels.name as level','class_levels.name as class_level',
            'presence_date_configs.day','presence_date_configs.start_time','presence_date_configs.end_time']);
        } else if ($level != null && $class_level != null) {
            $query = DB::table('presence_date_configs')
            ->leftJoin('levels', 'presence_date_configs.level','=','levels.id')
            ->leftJoin('class_levels', 'presence_date_configs.class_level','=','class_levels.id')
            ->where('presence_date_configs.group','=', session('group'))
            ->where('presence_date_configs.class_level','=', $class_level)
            ->orderBy('class_levels.name')
            ->get(['presence_date_configs.id','levels.name as level','class_levels.name as class_level',
            'presence_date_configs.day','presence_date_configs.start_time','presence_date_configs.end_time']);
        }


        return $query;
    }
}
