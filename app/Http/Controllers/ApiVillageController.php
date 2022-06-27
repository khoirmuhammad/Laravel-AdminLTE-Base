<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Illuminate\Http\Request;

class ApiVillageController extends Controller
{
    public function get_list_village()
    {
        $result = Village::all(['id','name']);

        return response()->json(['data' => $result]);
    }
}
