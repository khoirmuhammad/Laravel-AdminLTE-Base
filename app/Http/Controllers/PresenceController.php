<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function get_form_presence_popup()
    {
        return view('presences.form-popup',[
            "title" => "Formulir Presensi"
        ]);
    }
}
