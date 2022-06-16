<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class ApiLevelController extends Controller
{
    public function get_levels()
    {
        $result = Level::get_levels();

        return response()->json(['data' => $result]);
    }
}
