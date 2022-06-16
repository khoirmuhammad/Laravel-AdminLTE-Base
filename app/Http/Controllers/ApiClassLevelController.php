<?php

namespace App\Http\Controllers;

use App\Models\ClassLevel;
use Illuminate\Http\Request;

class ApiClassLevelController extends Controller
{
    public function get_class_level(Request $request)
    {
        $group = $request->route('groupId');
        $level = $request->route('levelId');

        $result = ClassLevel::get_class_level($group, $level);

        return response()->json(['data' => $result]);
    }

    public function get_class_level_by_group()
    {
        $result = ClassLevel::get_class_level_by_group();

        return response()->json(['data' => $result]);
    }
}
