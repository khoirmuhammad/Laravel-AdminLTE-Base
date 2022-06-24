<?php

namespace App\Http\Controllers;

use App\Models\RoleCategory;
use Illuminate\Http\Request;

class ApiRoleCategoriesController extends Controller
{
    public function get_role_categories()
    {
        $result = RoleCategory::all();
        return response()->json(['data' => $result]);
    }
}
