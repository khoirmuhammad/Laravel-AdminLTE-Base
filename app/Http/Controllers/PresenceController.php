<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function get_form_presence_popup()
    {
        return view('presences.form-popup',[
            "title" => "Presensi"
        ]);
    }

    public function get_form_presence(Request $request)
    {
        return view('presences.form-presence',[
            "title" => "Formulir Presensi"
        ]);
    }
}
