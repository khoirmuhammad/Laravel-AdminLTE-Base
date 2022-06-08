<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Student;
use Illuminate\Contracts\Session\Session;

class ApiStudentController extends Controller
{

    #region statistics
    public function get_group_statistic_general_by_level()
    {   
        $result = array();
        $level_name = null;
        $male_total = 0;
        $female_total = 0;

        $student_by_levels = Student::select_student_general_by_level_gender();

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

    public function get_group_statistic_general_by_education()
    {
        $result = array();
        $edu_name = null;
        $male_total = 0;
        $female_total = 0;

        $student_by_education = Student::select_student_general_by_level_education();

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

    public function get_group_statistic_caberawit()
    {
        $result = array();
        $class_name = null;
        $male_total = 0;
        $female_total = 0;

        $caberawit_class_gender = Student::select_student_caberawit_by_class_and_gender();

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

    public function get_group_statistic_praremaja()
    {
        $praremaja_gender = Student::select_student_praremaja_by_gender();

        return response()->json(['data' => $praremaja_gender]);
    }

    public function get_group_statistic_remaja()
    {
        $remaja_gender = Student::select_student_remaja_by_gender();

        return response()->json(['data' => $remaja_gender]);
    }

    public function get_group_statistic_unik()
    {
        $result = array();
        $education = null;
        $male_total = 0;
        $female_total = 0;

        $unik_education_gender = Student::select_student_unik_by_education_and_gender(session('group'));

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

    public function get_group_statistic_unik_by_pribumi_status()
    {
        $total_pribumi = Student::select_student_unik_pribumi_status();
        $total_nonpribumi = Student::select_student_unik_nonpribumi_status();

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
}
