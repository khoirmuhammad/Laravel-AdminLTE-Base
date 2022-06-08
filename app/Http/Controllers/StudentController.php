<?php

namespace App\Http\Controllers;

use App\Models\ClassLevel;
use App\Models\Education;
use App\Models\Student;
use App\Models\Group;
use App\Models\Level;
use App\Models\Log;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Carbon\Carbon;

class StudentController extends Controller
{
    public function index()
    {
        // Hash::make('Virtualcode')
        return view('students.index',[
            "title" => "Data Siswa",
            "data" => collect(Student::select())
        ]);
    }

    public function children_excel_import()
    {
        return view('students.childrenexcelimport',[
            "title" => "Import Excel"
        ]);
    }

    public function teens_excel_import()
    {
        return view('students.teensexcelimport',[
            "title" => "Import Excel"
        ]);
    }

    public function group_statistic()
    {
        return view('students.groupstatistic',[
            "title" => "Statistika"
        ]);
    }

    public function village_statistic()
    {
        return view('students.villagestatistic',[
            "title" => "Statistika"
        ]);
    }


    public function post_children_excel_import(Request $request)
    {
        try
        {
            $the_file = $request->file('excel-doc');

            $village_code = $this->get_village_code($the_file);


            $spreadsheet = IOFactory::load($the_file->getRealPath());        
            $sheets = $spreadsheet->getAllSheets();

            $male = array();
            $female = array();


            foreach($sheets as $sheet)
            {

                $db_sheet = $sheet->getTitle();

                if ($db_sheet != 'db_DESA')
                {
                    $group = Group::where('db_sheet_name',$db_sheet)->first();  

                    $start_row = 6;
                    $end_row = 55;
                    $rows_range = range( $start_row, $end_row );

                    foreach($rows_range as $row)
                    {
                        $fullname = $sheet->getCell( 'B' . $row )->getValue();

                        if($fullname != null && str_contains($fullname,'GENERUS') == false)
                        {
                            $male[] = [
                                'no' =>$sheet->getCell( 'A' . $row )->getValue(),
                                'fullname' => $sheet->getCell( 'B' . $row )->getValue(),
                                'class' => $sheet->getCell( 'C' . $row )->getValue(),
                                'group' => $group->name,
                                'group_id' => $group->id,
                                'village_id' => $village_code,
                            ];
                        }

                        

                        $fullname = $sheet->getCell( 'G' . $row )->getValue();

                        if($fullname != null && str_contains($fullname,'GENERUS') == false)
                        {
                            $female[] = [
                                'no' =>$sheet->getCell( 'F' . $row )->getValue(),
                                'fullname' => $sheet->getCell( 'G' . $row )->getValue(),
                                'class' => $sheet->getCell( 'H' . $row )->getValue(),
                                'group' => $group->name,
                                'group_id' => $group->id,
                                'village_id' => $village_code,
                            ];
                        }

                    }
                }

            }

            return response()->json(['status' => true, 'male_data' => collect($male), 'female_data' => collect($female)], 200);

        }
        catch(\Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper("superadmin" . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Memindai File Excel", 'log_key' => $log_key], 500);
        }
    }

    public function post_teens_excel_import(Request $request)
    {
        try
        {
            $the_file = $request->file('excel-doc');

            $village_code = $this->get_village_code($the_file);

            $spreadsheet = IOFactory::load($the_file->getRealPath());        
            $sheets = $spreadsheet->getAllSheets();

            $male = array();
            $female = array();

            foreach($sheets as $sheet)
            {
                $db_sheet = $sheet->getTitle();

                if ($db_sheet != 'db_Desa')
                {
                    $group = Group::where('db_sheet_name',$db_sheet)->first();

                    $start_row = 4;
                    $end_row = 52;
                    $rows_range = range( $start_row, $end_row );

                    foreach($rows_range as $row)
                    {
                        $fullname = $sheet->getCell( 'B' . $row )->getValue();

                        if($fullname != null && str_contains($fullname,'GENERUS') == false)
                        {
                            $male[] = [
                                'no' =>$sheet->getCell( 'A' . $row )->getValue(),
                                'fullname' => $sheet->getCell( 'B' . $row )->getValue(),
                                'level' => $sheet->getCell( 'C' . $row )->getValue(),
                                'education' => $sheet->getCell( 'D' . $row )->getValue(),
                                'status' => $sheet->getCell( 'E' . $row )->getValue(),
                                'group' => $group->name,
                                'group_id' => $group->id,
                                'village_id' => $village_code,
                            ];
                        }
                        
                        $fullname = $sheet->getCell( 'K' . $row )->getValue();

                        if($fullname != null && str_contains($fullname,'GENERUS') == false)
                        {
                            $female[] = [
                                'no' =>$sheet->getCell( 'J' . $row )->getValue(),
                                'fullname' => $sheet->getCell( 'K' . $row )->getValue(),
                                'level' => $sheet->getCell( 'L' . $row )->getValue(),
                                'education' => $sheet->getCell( 'M' . $row )->getValue(),
                                'status' => $sheet->getCell( 'N' . $row )->getValue(),
                                'group' => $group->name,
                                'group_id' => $group->id,
                                'village_id' => $village_code,
                            ];
                        }
                        
                    }
                }
            }

            return response()->json(['status' => true, 'male_data' => collect($male), 'female_data' => collect($female)], 200);
        }
        catch(\Exception  $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper("superadmin" . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Memindai File Excel", 'log_key' => $log_key], 500);
        }
    }

    public function post_children_excel_save(Request $request)
    {
        try
        {
            $db_students = Student::where('level','=',env('CABERAWIT_CODE'))->get();
            $db_class_levels = ClassLevel::all();  

            $excel_students = $request->all();

            $inserts = array();
            $updates = array();

            foreach($excel_students as $student)
            {
                $find_student = $db_students
                                ->where('fullname','=',$student['fullname'])
                                ->where('group', '=' ,$student['group_id'])
                                ->first();

                $class = $db_class_levels->where('name','=',$student['classes'])->first();

                if ($find_student == null)
                {              
                    $inserts[] = [
                        'id' => Str::uuid()->toString(),
                        'fullname' => $student['fullname'],
                        'birth_date' => null,
                        'gender' => $student['gender'],
                        'level' => env('CABERAWIT_CODE'),
                        'class' => $class != null ? $class->id : null,
                        'education' => env('SD_CODE'),
                        'isPribumi' => 1,
                        'group' => $student['group_id'],
                        'village' => $student['village_id'],
                        'created_by' => 'superadmin',
                        'updated_by' => 'superadmin',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];                    
                }
                else
                {
                    $updates[] = [
                        'id' => $find_student->id,
                        'fullname' => $find_student->fullname,
                        'birth_date' => $find_student->birth_date,
                        'gender' => $student['gender'],
                        'level' => $find_student->level,
                        'class' => $class == null ? $find_student->class : $class->id,
                        'education' => $find_student->education,
                        'isPribumi' => 1,
                        'group' => $find_student->group,
                        'village' => $find_student->village,
                        'created_by' => 'superadmin',
                        'updated_by' => 'superadmin',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }

            try
            {
                DB::beginTransaction();

                if (count($inserts) > 0) 
                    Student::insert($inserts);

                if (count($updates) > 0)
                {
                    foreach($updates as $update)
                    {
                        $student = Student::find($update['id']);
    
                        $student->gender = $update['gender'];
                        $student->level = $update['level'];
                        $student->education = $update['education'];
                        $student->isPribumi = $update['isPribumi'];
                        $student->updated_at = $update['updated_at'];
                        $student->updated_by = $update['updated_by'];
    
                        $student->update();
                    }
                }

                DB::commit();
            }
            catch(\PDOException $pdoEx)
            {
                DB::rollback();

                $error = $pdoEx->getMessage();
                $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
                $log_key = strtoupper("superadmin" . $this->get_random_string());

                $this->save_log($action, $error, $log_key);

                return response()->json(['status' => false, 'error_message' => "Terjadi Kesalaan Transaksi Database", 'log_key' => $log_key], 200);
            }

            return response()->json(['status' => true, 'data_insert' => $inserts, 'data_update' => $updates], 200);

        }
        catch(\Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper("superadmin" . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Menyimpan Data", 'log_key' => $log_key], 500);
        }

        
    }

    public function post_teens_excel_save(Request $request)
    {
        try
        {
            $db_students = Student::where('level','<>',env('CABERAWIT_CODE'))->get();
            $db_levels = Level::all();
            $db_educations = Education::all();    

            $excel_students = $request->all();

            $inserts = array();
            $updates = array();
            $deletes = array();

            foreach($excel_students as $student)
            {

                $find_student = $db_students
                                ->where('fullname','=',$student['fullname'])
                                ->where('group', '=' ,$student['group_id'])
                                ->first();

                $level = $db_levels->where('name', $student['level'])->first();
                $education = $db_educations->where('name',$student['education'])->first();

                if ($find_student == null)
                {              
                    if ($student['status'] != "PULANG")
                    {
                        $inserts[] = [
                            'id' => Str::uuid()->toString(),
                            'fullname' => $student['fullname'],
                            'birth_date' => null,
                            'gender' => $student['gender'],
                            'level' => $level == null ? null : $level->id,
                            'class' => null,
                            'education' => $education == null ? null : $education->id,
                            'isPribumi' => $student['status'] == "PRIBUMI" ? 1 : 0,
                            'group' => $student['group_id'],
                            'village' => $student['village_id'],
                            'created_by' => 'superadmin',
                            'updated_by' => 'superadmin',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }

                    
                }
                else 
                {
                    if ($student['status'] != "PULANG")
                    {
                        $updates[] = [
                            'id' => $find_student->id,
                            'fullname' => $find_student->fullname,
                            'birth_date' => $find_student->birth_date,
                            'gender' => $student['gender'],
                            'level' => $level == null ? $find_student->level : $level->id,
                            'class' => $find_student->class,
                            'education' => $education == null ? $find_student->education : $education->id,
                            'isPribumi' => $student['status'] == "PRIBUMI" ? 1 : 0,
                            'group' => $find_student->group,
                            'village' => $find_student->village,
                            'created_by' => 'superadmin',
                            'updated_by' => 'superadmin',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                    else
                    {
                        $deletes[] = [
                            'id' => $find_student->id
                        ];
                    }
                    
                }
            }

            try
            {
                DB::beginTransaction();

                if (count($inserts) > 0) 
                    Student::insert($inserts);

                if (count($updates) > 0)
                {
                    foreach($updates as $update)
                    {
                        $student = Student::find($update['id']);

                        $student->gender = $update['gender'];
                        $student->level = $update['level'];
                        $student->education = $update['education'];
                        $student->isPribumi = $update['isPribumi'];
                        $student->updated_at = $update['updated_at'];
                        $student->updated_by = $update['updated_by'];

                        $student->update();
                    }
                }

                if (count($deletes) > 0)
                {
                    foreach($deletes as $delete)
                    {
                        $student = Student::find($delete['id']);
                        $student->delete();
                    }
                }

                DB::commit();
            }
            catch(\PDOException $pdoEx)
            {
                DB::rollback();

                $error = $pdoEx->getMessage();
                $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
                $log_key = strtoupper("superadmin" . $this->get_random_string());

                $this->save_log($action, $error, $log_key);

                return response()->json(['status' => false, 'error_message' => "Terjadi Kesalaan Transaksi Database", 'log_key' => $log_key], 200);
            }
            
            return response()->json(['status' => true, 'data_insert' => $inserts, 'data_update' => $updates, 'data_delete' => $deletes], 200);                        
        }
        catch(\Exception $ex)
        {
            $error = $ex->getMessage();
            $action = explode('@',Route::getCurrentRoute()->getActionName())[1];
            $log_key = strtoupper("superadmin" . $this->get_random_string());

            $this->save_log($action, $error, $log_key);

            return response()->json(['status' => false, 'error_message' => "Terjadi Kesalahan Saat Menyimpan Data", 'log_key' => $log_key], 500);
        }
    }



    private function save_log($action, $error, $log_key)
    {
        try
        {
            $log = new Log();
            $log->controller = 'Student';
            $log->action = $action;
            $log->error_message = $error;
            $log->log_key = $log_key;
            
            $log->save();
        }
        catch(\Exception $ex)
        {
            $log = new Log();
            $log->controller = 'Student';
            $log->action = 'save_log';
            $log->error_message = $ex->getMessage();
            $log->log_key = $log_key;
            
            $log->save();
        }
    }

    private function get_village_code($the_file)
    {
        $filename = $the_file->getClientOriginalName();
        $filename_withoutx_ext = pathinfo($filename, PATHINFO_FILENAME);
        $village_code = null;

        if (str_contains($filename_withoutx_ext, "BERBAH"))
        {
            $village_code = env('BERBAH_CODE');
        }

        return $village_code;
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
