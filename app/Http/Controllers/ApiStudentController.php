<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ApiStudentController extends Controller
{

    #region student
    public function get_student_by_id(Request $request)
    {
        $id = request()->route('id');

        $result = Student::get_student_by_id($id);

        return response()->json(['data' => $result]);

    }

    public function post_save_student(Request $request)
    {
        try
        {
            if ($request->input('id') != null || $request->input('id') != '')
            {
                $student = Student::find($request->input('id'));

                $student->fullname = $request->input('name') == "" ? null : $request->input('name');
                $student->birth_date = $request->input('birthdate') == "" ? null : Carbon::createFromFormat('d/m/Y', $request->input('birthdate'))->format('Y-m-d H:i:s');
                $student->gender = $request->input('gender') == "" ? null : $request->input('gender');
                $student->level = $request->input('level') == "" ? null : $request->input('level');
                $student->class = $request->input('class_level') == "" ? null : $request->input('class_level');
                $student->education = $request->input('education') == "" ? null : $request->input('education');
                $student->isPribumi = $request->input('ispribumi') == "" ? null : $request->input('ispribumi');
                $student->address_source = $request->input('address_source') == "" ? null : $request->input('address_source');
                $student->parent = $request->input('parent') == "" ? null : $request->input('parent');
                $student->parent_phone = $request->input('parent_phone') == "" ? null : $request->input('parent_phone');
                $student->is_accel = $request->input('isaccel');
                $student->group = session('group');
                $student->village = Group::where('id',session('group'))->first()->village_id;
                $student->updated_by = auth()->user()->username;
                $student->updated_at = Carbon::now('Asia/Jakarta');

                $student->save();

                return response()->json(['status' => true, 'data' => $student], 201);
            }
            else
            {
                $student = new Student();

                $student->id = Str::uuid()->toString();
                $student->fullname = $request->input('name') == "" ? null : $request->input('name');
                $student->birth_date = $request->input('birthdate') == "" ? null : Carbon::createFromFormat('d/m/Y', $request->input('birthdate'))->format('Y-m-d H:i:s');
                $student->gender = $request->input('gender') == "" ? null : $request->input('gender');
                $student->level = $request->input('level') == "" ? null : $request->input('level');
                $student->class = $request->input('class_level') == "" ? null : $request->input('class_level');
                $student->education = $request->input('education') == "" ? null : $request->input('education');
                $student->isPribumi = $request->input('ispribumi') == "" ? null : $request->input('ispribumi');
                $student->address_source = $request->input('address_source') == "" ? null : $request->input('address_source');
                $student->parent = $request->input('parent') == "" ? null : $request->input('parent');
                $student->parent_phone = $request->input('parent_phone') == "" ? null : $request->input('parent_phone');
                $student->is_accel = $request->input('isaccel') == "" ? null : $request->input('isaccel');
                $student->group = session('group');
                $student->village = Group::where('id',session('group'))->first()->village_id;
                $student->created_by = auth()->user()->username;
                $student->created_at = Carbon::now('Asia/Jakarta');
                $student->updated_by = auth()->user()->username;
                $student->updated_at = Carbon::now('Asia/Jakarta');

                $student->save();

                return response()->json(['status' => true, 'data' => $student], 201);
            }




        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Menyimpan Data", 'log_key' => $log_key], 500);
        }
    }

    public function delete_student_by_id(Request $request)
    {
        try
        {
            $student = Student::find($request->input('id'));

            $student->forceDelete();

            return response()->json(['status' => true], 200);
        }
        catch(Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper(auth()->user()->username . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Menghapus Data", 'log_key' => $log_key], 500);
        }
    }
    #endregion

    #region statistics
    public function get_group_statistic_general_by_level(Request $request)
    {
        $group_id = $request->route('groupId') != "" ? $request->route('groupId') : session('group');

        $result = array();
        $level_name = null;
        $male_total = 0;
        $female_total = 0;

        $student_by_levels = Student::select_student_general_by_level_gender($group_id);

        $distinct_levels = $student_by_levels->unique('name')->pluck('name');

        foreach($distinct_levels as $levelname)
        {
            $student_level = $student_by_levels->where('name','=',$levelname);

            foreach($student_level as $item)
            {
                $level_name = $item->name;

                if ($item->gender == "Laki-laki")
                {
                    $male_total = $item->total;
                }

                if ($item->gender == "Perempuan")
                {
                    $female_total = $item->total;
                }
            }

            $result[] = [
                'level' => $level_name,
                'male' => $male_total,
                'female' => $female_total
            ];

            $male_total = 0;
            $female_total = 0;
        }

        return response()->json(['data' => $result]);
    }

    public function get_group_statistic_general_by_education(Request $request)
    {
        $group_id = $request->route('groupId') != "" ? $request->route('groupId') : session('group');

        $result = array();
        $edu_name = null;
        $male_total = 0;
        $female_total = 0;

        $student_by_education = Student::select_student_general_by_level_education($group_id);

        $distinct_education = $student_by_education->unique('name')->pluck('name');

        foreach($distinct_education as $eduname)
        {
            $student_education = $student_by_education->where('name','=',$eduname);

            foreach($student_education as $item)
            {
                $edu_name = $item->name;

                if ($item->gender == "Laki-laki")
                {
                    $male_total = $item->total;
                }

                if ($item->gender == "Perempuan")
                {
                    $female_total = $item->total;
                }
            }

            $result[] = [
                'education' => $edu_name,
                'male' => $male_total,
                'female' => $female_total
            ];

            $male_total = 0;
            $female_total = 0;
        }

        return response()->json(['data' => $result]);
    }

    public function get_group_statistic_caberawit(Request $request)
    {
        $group_id = $request->route('groupId') != "" ? $request->route('groupId') : session('group');
        $result = array();
        $class_name = null;
        $male_total = 0;
        $female_total = 0;

        $caberawit_class_gender = Student::select_student_caberawit_by_class_and_gender($group_id);

        $distinct_classnames = $caberawit_class_gender->unique('name')->pluck('name');

        foreach($distinct_classnames as $classname)
        {
            $caberawit_class = $caberawit_class_gender->where('name','=',$classname);

            foreach($caberawit_class as $item)
            {
                $class_name = $item->name;

                if ($item->gender == "Laki-laki")
                {
                    $male_total = $item->total;
                }

                if ($item->gender == "Perempuan")
                {
                    $female_total = $item->total;
                }
            }

            $result[] = [
                'class' => $class_name,
                'male' => $male_total,
                'female' => $female_total
            ];

            $male_total = 0;
            $female_total = 0;
        }

        return response()->json(['data' => $result]);
    }

    public function get_group_statistic_praremaja(Request $request)
    {
        $group_id = $request->route('groupId') != "" ? $request->route('groupId') : session('group');

        $praremaja_gender = Student::select_student_praremaja_by_gender($group_id);

        return response()->json(['data' => $praremaja_gender]);
    }

    public function get_group_statistic_remaja(Request $request)
    {
        $group_id = $request->route('groupId') != "" ? $request->route('groupId') : session('group');

        $remaja_gender = Student::select_student_remaja_by_gender($group_id);

        return response()->json(['data' => $remaja_gender]);
    }

    public function get_group_statistic_unik(Request $request)
    {
        $group_id = $request->route('groupId') != "" ? $request->route('groupId') : session('group');

        $result = array();
        $education = null;
        $male_total = 0;
        $female_total = 0;

        $unik_education_gender = Student::select_student_unik_by_education_and_gender($group_id);

        $distinct_eduname = $unik_education_gender->unique('name')->pluck('name');

        foreach($distinct_eduname as $eduname)
        {
            $unik_education = $unik_education_gender->where('name','=',$eduname);

            foreach($unik_education as $item)
            {
                $education = $item->name;

                if ($item->gender == "Laki-laki")
                {
                    $male_total = $item->total;
                }

                if ($item->gender == "Perempuan")
                {
                    $female_total = $item->total;
                }
            }

            $result[] = [
                'education' => $education,
                'male' => $male_total,
                'female' => $female_total
            ];

            $male_total = 0;
            $female_total = 0;
        }

        return response()->json(['data' => $result]);
    }

    public function get_group_statistic_unik_by_pribumi_status(Request $request)
    {
        $group_id = $request->route('groupId') != "" ? $request->route('groupId') : session('group');

        $total_pribumi = Student::select_student_unik_pribumi_status($group_id);
        $total_nonpribumi = Student::select_student_unik_nonpribumi_status($group_id);

        $result = array();

        $result[] = [
            'total_pribumi' => $total_pribumi,
            'total_nonpribumi' => $total_nonpribumi
        ];

        return response()->json(['data' => $result]);
    }



    public function get_village_statistic_by_group_level_gender()
    {
        $result = array();

        $source = Student::select_student_village_by_group_level_gender();

        $distinct_group = $source->unique('group')->pluck('group');
        $group_name = null;
        $level_name = null;
        $male_total = 0;
        $female_total = 0;

        foreach($distinct_group as $groupname)
        {
            $group_name = $groupname;

            $source_by_group = $source->where('group','=', $groupname);

            $distinct_level = $source_by_group->unique('level')->pluck('level');

            foreach($distinct_level as $levelname)
            {
                $level_name = $levelname;

                $source_by_level = $source_by_group->where('level','=', $levelname);

                foreach($source_by_level as $item)
                {
                    if ($item->gender == "Laki-laki")
                        $male_total = $item->total;

                    if ($item->gender == "Perempuan")
                        $female_total = $item->total;
                }

                $result[] = [
                    'group' => $group_name,
                    'level' => $level_name,
                    'male' => $male_total,
                    'female' => $female_total
                ];

                $level_name = null;
                $male_total = 0;
                $female_total = 0;
            }


        }


        return response()->json(['data' => $result]);
    }

    public function get_village_statistic_by_group_education_gender()
    {
        $result = array();

        $source = Student::select_student_village_by_group_education_gender();

        $distinct_group = $source->unique('group')->pluck('group');
        $group_name = null;
        $education_name = null;
        $male_total = 0;
        $female_total = 0;

        foreach($distinct_group as $groupname)
        {
            $group_name = $groupname;

            $source_by_group = $source->where('group','=', $groupname);

            $distinct_education = $source_by_group->unique('education')->pluck('education');

            foreach($distinct_education as $eduname)
            {
                $education_name = $eduname;

                $source_by_education = $source_by_group->where('education','=', $eduname);

                foreach($source_by_education as $item)
                {
                    if ($item->gender == "Laki-laki")
                        $male_total = $item->total;

                    if ($item->gender == "Perempuan")
                        $female_total = $item->total;
                }

                $result[] = [
                    'group' => $group_name,
                    'education' => $education_name,
                    'male' => $male_total,
                    'female' => $female_total
                ];

                $education_name = null;
                $male_total = 0;
                $female_total = 0;
            }


        }


        return response()->json(['data' => $result]);
    }

    #endregion


    private function save_log($action, $error, $log_key)
    {
        try
        {
            $log = new Log();
            $log->controller = 'ApiStudent';
            $log->action = $action;
            $log->error_message = $error;
            $log->log_key = $log_key;

            $log->save();
        }
        catch(\Exception $ex)
        {
            $log = new Log();
            $log->controller = 'ApiStudent';
            $log->action = 'save_log';
            $log->error_message = $ex->getMessage();
            $log->log_key = $log_key;

            $log->save();
        }
    }

    private function get_random_string() {
        $characters = env('RAND_STR_KEY');
        $randomString = '';

        for ($i = 0; $i < 20; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
