<?php

namespace App\Http\Controllers;

use App\Models\ClassLevel;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PresenceDateConfig;
use Illuminate\Support\Facades\DB;

class PresenceController extends Controller
{
    public function get_form_presence_popup()
    {
        return view('presences.form-popup', [
            "title" => "Presensi"
        ]);
    }

    public function get_form_presence(Request $request)
    {
        $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');

        $currentDay = date('l');

        $indexOfDays = array_search($currentDay, $days);

        $dayInIndo =  $hari[$indexOfDays];

        $class = $request->kelas;

        $presence_config = PresenceDateConfig::where('group', session('group'))
            ->where('class_level', $class)
            ->where('day', $dayInIndo)->first();

        if ($presence_config != null) {
            $t1 = strtotime(Carbon::now('Asia/Jakarta')->format('g:i A'));
            $t2 = strtotime($presence_config->start_time);
            $diff_minutes = ($t2 - $t1) / 60;

            if ($diff_minutes > 15) {
                return view('presences.prevent-time', [
                    'title' => "Presensi",
                    'time' => $presence_config->start_time
                ]);
            } else {
                return view('presences.form-presence', [
                    "title" => "Formulir Presensi",
                    'start' => substr($presence_config->start_time, 0, 5),
                    'end' => substr($presence_config->end_time, 0, 5)
                ]);
            }

        } else {
            return view('presences.prevent-date', [
                'title' => "Presensi"
            ]);
        }





    }

    public function get_recap_presence()
    {
        return view('presences.recap-presence', [
            'title' => 'Rekap Presensi'
        ]);
    }
}
