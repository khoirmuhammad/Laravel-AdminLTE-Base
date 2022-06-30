<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PresenceDateConfigController extends Controller
{
    public function get_form_add()
    {
        return view ('presencedateconfigs.form-add', [
            'title' => "Tambah Konfigurasi Presensi"
        ]);
    }
}
