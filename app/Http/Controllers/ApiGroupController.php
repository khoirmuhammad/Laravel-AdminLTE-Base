<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class ApiGroupController extends Controller
{
    public function get_group_info(Request $request)
    {
        $group_id = $request->route('groupId') != "" ? $request->route('groupId') : session('group');

        $result = Group::group_info($group_id);

        return response()->json(['data' => $result]);
    }

    public function get_group_list(Request $request)
    {
        $result = Group::group_list("");

        return response()->json(['data' => $result]);
    }

    public function get_group_list_by_village(Request $request)
    {
        $result = Group::group_list($request->route('villageId'));

        return response()->json(['data' => $result]);
    }

}
