<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class ApiEducationController extends Controller
{
    public function get_education()
    {
        $result = Education::get_education();

        return response()->json(['data' => $result]);
    }
}
