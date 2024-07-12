<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

use Redirect;
use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Sms_class;
use App\Sms_setting;
use App\Sms_qualification;
use App\Sms_role;
use App\Sms_school;
use App\Class_school;
use App\Sms_user;
use App\Sms_holiday;
use App\Sms_role_user;
use App\Holiday_school;
use App\Sms_student;
use App\Sms_class_student;
use App\Sms_class_role_user;
use App\Sms_school_role_user;
use App\Sms_attendance;

  

class SuperAdminController extends Controller
{    
    public function __construct()
	{
		$this->middleware("superAdminMiddleware");
	}
    
    /*Dashboard*/
    public function dashboard()
    {   
    
        $current_date = date("Y-m-d");
        $attendance_record = array();
        $schools = Sms_school::all()->toArray();
        $school_weekend = Sms_setting::where('key','Weekend')->get()->toArray();
        if(!empty($school_weekend))
        {
            $school_weekend = $school_weekend[0]['value'];
        }

        $count_holidays=0;
        $all_schools_holiday=false;    
        foreach ($schools as $school) 
        {
            
                $school_id = (int)$school['id'];
                $current_date = date("Y-m-d");
                
                $school_holiday  = Holiday_school::get_holiday_by_school_id($school_id,$current_date);
                $total_teachers  = Sms_school_role_user::get_teachers_by_school_id($school_id);
                $total_students  = Sms_class_student::count_total_students_by_school_id($school_id);
                $total_presents  = Sms_attendance::get_attendance_by_school_id($school_id,1,$current_date);
                $total_absents   = Sms_attendance::get_attendance_by_school_id($school_id,0,$current_date);
                $school_classes  = Class_school::view_school_classes($school_id);
           

               $attendance_record[$school_id] = array(
                "school"            =>$school['school'],
                "school_holiday"    =>$school_holiday,
                "total_teachers"    =>$total_teachers,
                "total_students"    =>$total_students,
                "total_presents"    =>$total_presents,
                "total_absents"     =>$total_absents,
                "school_classes"    =>$school_classes,
               );
        
               if(!empty($school_holiday))
               {
                    $count_holidays++;
               }
        }

        if($count_holidays==count($schools))
        {
            $all_schools_holiday=true;
        }
        
        return view('super-admin/dashboard',['attendance_record'=>$attendance_record,"all_schools_holiday"=>$all_schools_holiday,"school_weekend"=>$school_weekend,"current_date"=>$current_date]);
    }
    
    /*Profile*/
    public function view_profile()
    {
        return view('super-admin/view_profile');
    }

    /*Chnage Password*/
    public function change_password(){
        return view('super-admin/change_password');
    }

    /*Chnage Password*/
    public function change_password_process(Request $request){

        $controls  = $request->all();
        
        /*server side validition*/
        $rules = array(
            "old_password"                  => "required|min:8|max:20",
            "new_password"                  => "required|min:8|max:20",
            "conform_password"              => "required|same:new_password",
        );

        $messages = [
            'old_password.required'                => 'Please select :attribute',
            'new_password.required'                => 'Please enter :attribute',
            'confirm_password.required'            => 'Please enter :attribute',
            'old_password.min'                     => 'Minimum length of :attribute is 8',
            'old_password.max'                     => 'Maximum length of :attribute is 20',
            'new_password.min'                     => 'Minimum length of :attribute is 8',
            'new_password.max'                     => 'Maximum length of :attribute is 20',
            'conform_password.same'                => 'Conform password must match with password',
        ];

        $validator  = Validator::make($controls, $rules,$messages);
        if($validator->fails())
        {
            return redirect("/super_admin/change_password")->withInput($request->all())->withErrors($validator);
        }
        else
        {
            /*This function check your input old password and database saved password*/
            $update = Sms_user::reset_user_password($controls['old_password'],$controls['new_password']);
            if($update)
            {
                 return redirect("/super_admin/change_password")->with("success_message","Your Password Has Been Successfully Changed!...");
            }
            else{
                return redirect("/super_admin/change_password")->with("error_message","Your old password doesn't match!...");
            }
        }
    }

    /*Check password using ajax function */
    public function check_old_password_super_admin_function(Request $request){

        $user = Sms_user::find(Auth::user()->id);
       
       if(Hash::check($request->old_password,$user->password)) {
            return 1;
        }else{
            return 0;
        }
    }
    
    
    /*Add Super Admins*/
    public function add_super_admin()
    {
        return view('super-admin/add_super_admin');
    }
    
    /*View Super Admins*/
    public function view_super_admins()
    {
        return view('super-admin/view_super_admins');
    }
    
    
    /*Add School Admin*/
    public function add_school_admin()
    {
        return view('super-admin/add_school_admin');
    }
    
    /*View School Admins*/
    public function view_schools_admins()
    {
        return view('super-admin/view_schools_admins');
    }
    
    /*Add Teacher*/
    public function add_teacher()
    {
        return view('super-admin/add_teacher');
    }
    
    /*View Teachers*/
    public function view_teachers()
    {
        return  view('super-admin/view_teachers');
    }
    
   
    /*Add Student*/
    public function add_student()
    {
         /*Get All Schools*/
        $schools = Sms_school::all()->toArray();
        $all_school_classes = array(''=>"-- Select School --");
        
        $all_classes_students = array();
        $class_students=null;
      
        if(isset($schools))
        {
            foreach($schools as $school)
            {
                /*Get School-Classes By School ID*/
                $school_classes = Class_School::view_school_classes($school['id']);
                
                if(isset($school_classes))
                {
                    foreach($school_classes as $school_class)
                    {
                       
                        /*Storing School Name, Class ID & Class Name In New Array*/
                        $all_school_classes[$school_class->sms_school_id] = $school['school'];
                    }
                }
            }
        }
        return view('super-admin/add_student',['schools'=>$all_school_classes]);
    }
    
    /*Add Student Process*/
    public function add_student_process(Request $request)
    {

            $controls  = $request->all();
            /*serve side validtion of student add form*/
                $rules = array(
                    "first_name"                     => "required",
                    "last_name"                      => "required",
                    "gaurdian_name"                  => "required",
                    "gaurdian_contact_number"        => "required",
                    "date_of_brith"                  => "required",
                    "gender"                         => "required",
                    "address"                        => "required",
                    "student_status"                 => "required",
                    "school_classes"                 => "required",
                    "school_id"                      => "required",
                    "student_image"                  => "required|image|mimes:jpeg,png,jpg,gif",

                );
                
                $messages = [
                    'first_name.required'               => 'Please select :attribute',
                    'last_name.required'                => 'Please enter :attribute',
                    'gaurdian_name.required'            => 'Please enter :attribute',
                    'gaurdian_contact_number.required'  => 'Please enter :attribute',
                    'date_of_brith.required'            => 'Please enter :attribute',
                    'gender.required'                   => 'Please enter :attribute',
                    'address.required'                  => 'Please enter :attribute',
                    'student_status.required'           => 'Please enter :attribute',
                    'school_classes.required'           => 'Please enter :attribute',
                    'school_id.required'                => 'Please enter school',
                    'student_imag.required'             => 'Please upload :attribute',
                    'student_imag.mimes'                => 'Please valid upload type of image :attribute',
                ];
        
                $validator  = Validator::make($controls, $rules,$messages);
                if($validator->fails())
                {
                    return redirect("/super_admin/add_student")->withInput($request->all())->withErrors($validator);
                }
                else
                {
                    $get_sms_role_user_id = Sms_user::get_current_user_logined_sms_role_user_id();
                    $data = array(
                        "sms_role_user_id"          =>$get_sms_role_user_id,
                        "first_name"                =>$controls['first_name'],
                        "middle_name"               =>$controls['middle_name'],
                        "last_name"                 =>$controls['last_name'],
                        "gaurdian_name"             =>$controls['gaurdian_name'],
                        "gaurdian_contact_number"   =>$controls['gaurdian_contact_number'],
                        "gender"                    =>$controls['gender'],
                        "address"                   =>$controls['address'],
                        "date_of_birth"             =>$controls['date_of_brith'],
                        "status"                    =>$controls['student_status'],
                    );


                    $insert = Sms_student::create($data);
                    if($insert){

                        
                        $mimetype = $request->file("student_image")->getClientOriginalExtension();
                        if(isset($controls['middle_name']) && $controls['middle_name'] != "")
                        {
                            $img_name = strtolower($insert->id."_".$controls['first_name']."_".$controls['middle_name']."_".$controls['last_name'].".".$mimetype);
                        }
                        else
                        {
                            $img_name = strtolower($insert->id."_".$controls['first_name']."_".$controls['last_name'].".".$mimetype);
                            
                        }


                        $result2 = Sms_class_student::create_student_recored($controls['school_classes'],$insert->id,$img_name);
                       
                    
                        if($result2){


                        /*Get class name , school id and school name for checking directory and student create a folder for save image by class_school_id*/
                        $school_folder = Class_school::get_school_id_school_name_and_class_name_by_class_school_id($controls['school_classes']);

                        

                        /*Get school name with school id  in small alphabets for create a school folder name */
                        $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($school_folder[0]->school_id,$school_folder[0]->school);
                        $class_name = Sms_class::get_class_name_to_make_student_images_folder($school_folder[0]->class);
                        
                        /*create dynamic directory of school name folder*/
                        if(!File::exists("public/schools/".$schools_name_with_id."/".strtolower($class_name)."/".date('Y')."/")) {
                            Storage::makeDirectory("public/schools/".$schools_name_with_id."/".strtolower($class_name)."/".date('Y')."/");
                        }
                        Storage::putFileAs("public/schools/".$schools_name_with_id."/".strtolower($class_name)."/".date('Y')."/", $request->file("student_image"), $img_name);

                       

                        return Redirect::back()->with('add_student_success_message','New Student: '.ucfirst($controls['first_name']).' Has Been Added Successfully!...');
                            
                        }else{
                        return Redirect::back()->with('add_student_success_message','New Student: '.ucfirst($controls['first_name']).' Has Not Been Added Successfully!...');

                        }

                        return Redirect::back()->with('add_student_success_message','New Student: '.ucfirst($controls['first_name']).' Has Been Added Successfully!...');
                    }else{
                        return Redirect::back()->with('add_student_success_message','New Student: '.ucfirst($controls['first_name']).' Has Not Been Added Successfully!...');
                    }    
                    
                }

    }
    
    
    
   /*View Students*/
    public function view_students()
    {   
        /*Get all students for super admin*/
        $get_students = (array) Sms_student::get_all_students();
        
        foreach ($get_students as $key => $value) {

            /*get student updated recored year*/
             $year = substr($value->class_student_date,0,4);

            /*Get school name with school id  in small alphabets for create a school folder name */
            $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($get_students[$key]->school_id,$get_students[$key]->school);
            $class_name = Sms_class::get_class_name_to_make_student_images_folder($value->class);
            $get_students[$key]->student_image_path = "storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".$year."/".$get_students[$key]->student_image;            
        }

        return  view('super-admin/view_students',['students'=>$get_students]);



    }

    /*View Student Detail*/
    public function view_student_detail($id){

        /*Get student detail by student id for super admin side view student detail*/
        $get_student = Sms_student::get_student_datail_by_student_id($id);
        /*Get school name with school id  in small alphabets for create a school folder name */
        
        $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($get_student[0]->school_id,$get_student[0]->school);
        $class_name = Sms_class::get_class_name_to_make_student_images_folder($get_student[0]->class);

        /*get student updated recored year*/
        $year = substr($get_student[0]->class_student_date,0,4);

        $student_image_path = array(
            'student_image_path'=>"storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".$year."/".$get_student[0]->student_image
        );
        return  view('super-admin/view_student_detail',['student'=>$get_student,'student_image_path'=>$student_image_path,"student_image"=>$get_student[0]->student_image]);
    
    }

    /*Edit Student*/
    public function edit_student($id){
       
        $result_schools = Sms_school::get_all_schools();
        $result = array(""=>"-- Select School --");
        foreach($result_schools as $result_school){
           $result[$result_school->id] = $result_school->school;
        }
        /*Get student detail by student id for super admin side edit student*/
        $get_student = Sms_student::get_student_datail_by_student_id($id);
      
        $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($get_student[0]->school_id,$get_student[0]->school);
        $class_name = Sms_class::get_class_name_to_make_student_images_folder($get_student[0]->class);

        /*get student updated recored year*/
        $year = substr($get_student[0]->class_student_date,0,4);

        $student_image_path = array(
            'student_image_path'=>"storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".$year."/".$get_student[0]->student_image
        );
        return view("/super-admin/edit_student",['student'=>$get_student,'schools'=>$result,'student_image_path'=>$student_image_path]);

    }
    /*Edit Student Process*/
    public function edit_student_process(Request $request){
        $controls = $request->all();
      
        /*serve side validtion of student add form*/
                $rules = array(
                    "first_name"                     => "required",
                    "last_name"                      => "required",
                    "gaurdian_name"                  => "required",
                    "gaurdian_contact_number"        => "required",
                    "date_of_brith"                  => "required",
                    "gender"                         => "required",
                    "address"                        => "required",
                    "student_status"                 => "required",

                );
                
                $messages = [
                    'first_name.required'               => 'Please select :attribute',
                    'last_name.required'                => 'Please enter :attribute',
                    'gaurdian_name.required'            => 'Please enter :attribute',
                    'gaurdian_contact_number.required'  => 'Please enter :attribute',
                    'date_of_brith.required'            => 'Please enter :attribute',
                    'gender.required'                   => 'Please enter :attribute',
                    'address.required'                  => 'Please enter :attribute',
                    'student_status.required'           => 'Please enter :attribute',
                ];
        
                $validator  = Validator::make($controls, $rules,$messages);
                if($validator->fails())
                {
                    
                    return Redirect::back()->withInput($request->all())->withErrors($validator);
                    
                }
                else
                {
                    $data = array(
                        "first_name"                =>$controls['first_name'],
                        "middle_name"               =>$controls['middle_name'],
                        "last_name"                 =>$controls['last_name'],
                        "gaurdian_name"             =>$controls['gaurdian_name'],
                        "gaurdian_contact_number"   =>$controls['gaurdian_contact_number'],
                        "gender"                    =>$controls['gender'],
                        "address"                   =>$controls['address'],
                        "date_of_birth"             =>$controls['date_of_brith'],
                        "status"                    =>$controls['student_status'],
                    );

                    $updated = Sms_student::where('id','=',$controls['student_id'])->update($data);

                    if($updated){

                        /*Check If Path Exists*/
                        if(File::exists($controls['edit_student_image_path'])) 
                        {

                            $str =  $controls['edit_student_image_path'];
                            for($i=0; isset($str[$i]); $i++){
                                if($str[$i] == '/'){
                                    
                                    $index = $i;
                                    
                                }
                                if($str[$i] == '.'){
                                    $index2 = $i;
                                }
                            }
                            $path = substr($controls['edit_student_image_path'],0,$index+1);    

                        $school_folder = Class_school::get_school_id_school_name_and_class_name_by_class_school_id($controls['class_school_id']);

                    
                        /*Get school name with school id  in small alphabets for create a school folder name */
                        $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($school_folder[0]->school_id,$school_folder[0]->school);
                        $class_name = Sms_class::get_class_name_to_make_student_images_folder($school_folder[0]->class);
                        

                        $mimetype = substr($controls['edit_student_image_path'],$index2,6);
                        if(isset($controls['middle_name']) && $controls['middle_name'] != "")
                        {
                            $img_name = strtolower($controls['student_id']."_".$controls['first_name']."_".$controls['middle_name']."_".$controls['last_name'].".".$mimetype);
                        }
                        else
                        {
                            $img_name = strtolower($controls['student_id']."_".$controls['first_name']."_".$controls['last_name'].".".$mimetype);
                            
                        }
                        $str = "";
                        for($i=0; isset($img_name[$i]); $i++){
                            if($img_name[$i] == " "){
                                $str.= "_";
                            }else{
                                $str.= $img_name[$i];
                            }

                        }

                        $status = rename($controls['edit_student_image_path'],$path."".$str);
                        if($status){
                           
                           $update =  DB::table('sms_class_student')->where('id',$controls['class_student_id'])->where('status',1)->update(['student_image'=>$str]);
                           
                        }
                        
                        }
                        /*end code*/
                     return redirect("/super_admin/view_students")->with('edit_student_success_message','Student: '.ucfirst($controls['first_name']).' Has Been Updated Successfully!...');
                    }else{
                        return Redirect::back()->with('edit_student_error_message','Student: '.ucfirst($controls['first_name']).' Has Not Been Updated Successfully!...');
                    }    
                    
                }

    }

    /*get school classes for add student using ajax*/
    public function get_classes_for_student_form(Request $request){
        
        $controls = $request->all();
        $result = Class_school::get_school_classes_for_student_add($controls['school_id']);
        return view('super-admin/ajax_pages/get_school_classes',['school_classes'=>$result]);
    }


    /*get school classes for edit student using ajax*/
    public function get_classes_for_student_edit_form(Request $request){
       
        $controls = $request->all();
        
        $result = Class_school::get_school_classes_for_student_add($controls['school_id']);
        $class_school_id = array("class_school"=>$controls['class_school']);
        return view('super-admin/ajax_pages/get_school_classes_for_edit',['school_classes'=>$result,"school_class_id"=>$class_school_id]);
    }

    /*student image update uisng ajax reponse*/
     function update_student_image_function(Request $request){

        $validation = Validator::make($request->all(), [
          'id-input-file-2' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
         if($validation->passes())
         {

            /*Get school name with school id  in small alphabets for create a school folder name */
            $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($request['school_id'],$request['school_name']);
            $class_name = Sms_class::get_class_name_to_make_student_images_folder($request['class_name']);
  
            /*check path if exits then save in image*/
            if(!File::exists("storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".date('Y')."/")) {

                  Storage::makeDirectory("storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".date('Y')."/");
            }
            
            $mimetype = $request->file('id-input-file-2')->getClientOriginalExtension();
            
            if(isset($request['middle_name']) && $request['middle_name'] != ""){
                
                $img_name = strtolower($request['student_id']."_".$request['first_name']."_".$request['middle_name']."_".$request['last_name'].".".$mimetype);
            }
            else{
             
             $img_name = strtolower($request['student_id']."_".$request['first_name']."_".$request['last_name'].".".$mimetype);
                    
            }
            
            /*update student image*/

            $student_id         = (int)$request->student_id;
            $class_school_id    = (int)$request->class_school;
            $update = Sms_class_student::student_image_update($img_name,$student_id,$class_school_id);



            /*old file romve from folder*/
            if(File::exists("storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".date('Y')."/".$request['student_old_image']))
            { 
                
               $file =  unlink("storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".date('Y')."/".$request['student_old_image']);
            
            } 

            $path = Storage::putFileAs("public/schools/".$schools_name_with_id."/".strtolower($class_name)."/".date('Y')."/", $request->file("id-input-file-2"), $img_name);


           return response()->json([
                'message'   => 'success',
                "result" =>"Image Has Been Changed Successfully!...",
                
            ]);

         }else{
          return response()->json([
            'message'   => "fail",
            "result"=>"Please Choose Image!...",
          ]);
         
         }
    }

  



    /*Take Attendance*/
    public function take_attendance()
    {
        $schools = Sms_school::all()->toArray();
        $role_user_id = Sms_user::get_current_user_logined_sms_role_user_id();
        $week_end_name = null;

        /*Get Weekend Full Name*/
        $result_week_end = Sms_setting::where('key',"Weekend")->where('status',1)->get()->toArray();
       
       
         if(!empty($result_week_end))
        {
              $week_end_name = date('l',strtotime($result_week_end[0]['value']));

        }

        return view('super-admin/take_attendance',['schools'=>$schools,'week_end_name'=>$week_end_name,"role_user_id"=>$role_user_id]);
    }
  
    /*Check Cureent Date Attendance*/
    public function check_current_date_attendance(Request $request)
    {
        /*Get Data From Ajax Request*/ 
        $role_user_id    = (int)$request->role_user_id;
        $class_school_id = (int)$request->class_school_id;
        $attendance_date = date('Y-m-d',strtotime($request->attendance_date));
        $school_id       = (int)$request->school_id;
        $school_name     = $request->school_name;
        $class_name      = $request->class_name;
        



        /*Get Folder Name With School Name like:(house_of_knowledge_(hok-1))*/
        $school_folder_name     = Sms_school::get_school_name_to_make_school_name_folder($school_id,$school_name);
        
        /*Get Folder Name With Class Name like:(class_1))*/
        $class_folder_name      = Sms_class::get_class_name_to_make_student_images_folder($request->class_name);
      
        /*Make Students Image Path With School Name,Class Name And Current Year*/
        $students_image_path = $school_folder_name."/".$class_folder_name."/".date("Y");
        
         /*Check If Current Date Attendance Already Exists*/
        $attendance_exists = Sms_attendance::check_current_date_attendance($class_school_id,$attendance_date);
        $result_attendance_added_by= null;    
        
         /*Get User Info By role_user_id*/
        if(!empty($attendance_exists))
        {
            $result_attendance_added_by = Sms_user::get_user_information_with_role_type_by_role_user_id($attendance_exists[0]->sms_role_user_id);
            $attendance_added_by_role_type =$result_attendance_added_by[0]->role_type;
            $user_total_roles = count(session('user_roles'));
            $attendance_added_by = "you";

            if($result_attendance_added_by[0]->id !=Auth::user()->id)
            {
                $attendance_added_by = $result_attendance_added_by[0]->first_name." ".$result_attendance_added_by[0]->last_name." (".$result_attendance_added_by[0]->role_type.")";  
            }
       }
           
        /*Get Students By Class School ID*/
        $students = Sms_class_role_user::get_students_by_class_school_id($class_school_id);
        
        /*Check If Current Date Exits Between In Any School Holiday Dates*/
        $check_school_holiday = Holiday_school::get_holiday_by_school_id($school_id,$attendance_date);
        
        

        /*Get Attendance Allowed Days*/
        $result_attendance_allowed_days = Sms_setting::where('key',"Attendance Allowed Days")->where('status',1)->get()->toArray();
        /*Convert Attendance Allowed Days To Integer*/
        $days = (int)$result_attendance_allowed_days[0]['value'];
        
        /*Get Attendance Limit Date After Substracting Attendance Allowed Days (like: 2019-01-15 - 3 = 2019-01-12)*/
        $attendance_limit_date = date('Y-m-d',strtotime(Carbon::now()->subDays($days)));
        
        /*Get Weekend Full Name*/
        $result_week_end = Sms_setting::where('key',"Weekend")->where('status',1)->get()->toArray();
       
        $week_end_name = $result_week_end[0]['value'];
        
        
         /*
        Note For Class Attendance Image Path:
        (Complete Path Is = $school_folder_name."/".$class_folder_name."/class_attendance/dynamic month [august]/" })
        We will add month name in half path when attendance will be submited.
        */
        /*Make Half Class Attendance Image Path*/
        $class_attendance_image_path = $school_folder_name."/".$class_folder_name; 
        
        
        /*Get Students Attendance To Modify When User Action Name Is modify_attendance*/
            $all_students_attendance = array();
            $reason =null;
            $attendance_detail_id=0;
            
            /*Get All Students Attendance By Selected Attendance Date*/
            $students_attendance_to_modify = Sms_attendance::get_students_attendance_by_class_school_id($class_school_id,$attendance_date);
        
        
            if(!empty($students_attendance_to_modify))
            {
                /*Get Class Attedance Image*/   
                $class_attendance_image = $students_attendance_to_modify[0]->class_image;
                
                foreach($students_attendance_to_modify as $student)
                {
                        /*Get Absent Attendance Reason By Attendance ID If Exists*/    
                        $attendance_reason = Sms_attendance::get_attendance_reason_by_attendance_id($student->attendance_id);

                        if(!empty($attendance_reason))
                        {                        
                            foreach($attendance_reason as $attendance_detail)
                            {

                                $attendance_detail_id =  $attendance_detail->id;
                                $reason               =  $attendance_detail->reason;
                            }
                        }

                        $all_students_attendance[$student->student_id] = array(
                        "attendance_class_id"   =>  $student->attendance_class_id,
                        "attendance_id"         =>  $student->attendance_id,
                        "attendance_detail_id"  =>  $attendance_detail_id,
                        "student_id"            =>  $student->student_id,  
                        "full_name"             =>  $student->first_name.' '.$student->middle_name.' '.$student->last_name,
                        "gender"                =>  $student->gender,
                        "student_image"         =>  $student->student_image,
                        "status"                =>  $student->status,
                        "reason"                =>  $reason
                      );
                }
            }
        
        /*Check If Selected Date Is Equel To The Date Of School Weekend Day*/
        if($week_end_name ==date('l',strtotime($attendance_date)))
        {
           return response()->json(['message'   => "school_weekend_day",
                                    'weekend_day'      =>$week_end_name,
                                    ]); 
        }
        
        /*Check If Selected Date Equels Or Exists Between In (Start & End Date) Of School Holiday*/
        else if(!empty($check_school_holiday))
        {
           return response()->json(['message'   => "school_holiday_exists",
                                    'date'      => date('d F Y',strtotime($request->attendance_date)),
                                    //'holiday_title'=>$check_school_holiday[0]->title,
                                    //'holiday_decription'=>$check_school_holiday[0]->description,
                                    'holidays'=>$check_school_holiday
                                ]

                                );          
        }
        
        /*Check If Selected Date Is Greater Than Current Date*/
                            /*OR*/
        /*Check If Selected Date Is Less Than Attendance Allowed Days(date)*/
        else if($attendance_date > date("Y-m-d") ||  $attendance_date < $attendance_limit_date)
        {
          return response()->json(['message'   => "date_is_not_allowed",
                                    'date'      => date('d F Y',strtotime($request->attendance_date))
                                    ]);              
        }
    
        else if($request->user_action_name=='add_new_attendance')
        {
            
                /*Check If Current Date Attendance Already Exists*/
                if(!empty($attendance_exists))
                {
 
                     return response()->json([ 'message'   => "attendance_already_exists",
                                            'date'      => date('d F Y',strtotime($request->attendance_date)),
                                            'attendance_added_by' => $attendance_added_by,
                                            'attendance_added_by_role_type'=>$attendance_added_by_role_type,
                                            'user_total_roles'=>$user_total_roles]);
                    
                    
                }
        
                /*Check If Class School Has No Students*/
                else if(empty($students))
                {
                   return response()->json([ 'message'   => "class_school_has_no_students",
                                              'class_name'      => $request->class_name]);
                }

                /*Check If Class School HasStudents*/
                else if(!empty($students))
                {
                  return view("super-admin/ajax_pages/get_students_for_attendance",['students'=>$students,"students_image_path"=>$students_image_path]);  
                }
            
        }
        else if($request->user_action_name=='modify_attendance')
        {
        
            if(empty($all_students_attendance))
            {
               
            
                return response()->json([ 'message'   => "attendance_is_not_added",
                                            'class_name'      => $request->class_name,
                                            "date"=>date('d F Y',strtotime($request->attendance_date))]);
              
            }
            else if(!empty($all_students_attendance))
            {
                return view("super-admin/ajax_pages/get_students_attendance_to_modify",['students_attendance_to_modify'=>$all_students_attendance,"students_image_path"=>$students_image_path,'class_attendance_image_path'=>$class_attendance_image_path,"role_user_id"=>$role_user_id,"class_school_id"=>$class_school_id,"attendance_date"=>$attendance_date,'class_attendance_image'=>$class_attendance_image]); 
            }
            
            
        }
        
        
        
    }
  
    /*Set Students Attendance In Session*/
    public function get_un_submitted_students_attendance(Request $request)
    {
        
        $data = array();
        
        /*Get Folder Name With School Name like:(house_of_knowledge_(hok-1))*/
        $school_folder_name     = Sms_school::get_school_name_to_make_school_name_folder($request->school_id,$request->school_name
);
        
        /*Get Folder Name With Class Name like:(class_1))*/
        $class_folder_name      = Sms_class::get_class_name_to_make_student_images_folder($request->class_name);
        
        /*Make Students Image Path With School Name,Class Name And Current Year*/
        $students_image_path = $school_folder_name."/".$class_folder_name."/".date("Y");
        
         /*
        Note For Class Attendance Image Path:
        (Complete Path Is = $school_folder_name."/".$class_folder_name."/class_attendance/dynamic month [august]/" })
        We will add month name in half path when attendance will be submited.
        */
        /*Make Half Class Attendance Image Path*/
        $class_attendance_image_path = $school_folder_name."/".$class_folder_name; 
        
        
        for($i=0; $i<=isset($request->id[$i]);$i++)
        {
           
                $data[$request->id[$i]]=array(
                "id"          =>$request->id[$i],
                "image"       =>$request->image[$i],
                "full_name"   =>$request->full_name[$i],
                "gender"      =>$request->gender[$i],
                "status"      =>$request->status[$i],
            );   
        }
    
        return view("super-admin/ajax_pages/get_un_submitted_students_attendance",['un_submitted_attendance'=>$data,"class_school_id"=>$request->class_school_id,"role_user_id"=>$request->role_user_id,"attendance_date"=>$request->attendance_date,"students_image_path"=>$students_image_path,'class_attendance_image_path'=>$class_attendance_image_path]) ;   
    
    
    }
    
    
    /*Submit Student Attendance*/
    public function submit_students_attendance(Request $request)
    {
        $class_school_id = $request['class_school_id'];
        $role_user_id    = $request['role_user_id'];
        $attendance_date = date('Y-m-d',strtotime($request['attendance_date']));
        
        $flag_success           = null;
        $flag_fail              = null;
        $flag_attendance_added  = false;
     
 
       
        $class_attendance_image_path = "schools/".$request["class_attendance_image_path"]."/".date("Y",strtotime($attendance_date))."/class_attendance/".strtolower(date("F",strtotime($attendance_date)));
          
        /*Make Folders For Path If Not Exist*/
        if(!File::exists($class_attendance_image_path)) 
        {
         Storage::makeDirectory('public/'.$class_attendance_image_path);
        }
        

        /*Check If Action Is To Add New Attendance*/
        if($request['user_action_name']=='add_new_attendance')
        {
            
            $img = $_POST['img_url']; 

            if(!empty($img))
            {
                    $folderPath =  storage_path('app/public/').$class_attendance_image_path;
                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $extension = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    
                    $new_name = strtolower(date('d_F_Y',strtotime($request['attendance_date']))) . '.jpg';
                    $file = $folderPath ."/". $new_name;
                   
                    $uploaded=file_put_contents($file, $image_base64);

                    /*Check If Image File Is Uploaded In Folder*/
                    if($uploaded)
                    {
                        $flag_success=true;
                        /*Add (class_school_id,role_user_id,class_image) In First Table (sms_attendance_class)*/
                        $get_attendance_class_id = Sms_attendance::insert_class_attendance_image($class_school_id,$role_user_id,$new_name,$attendance_date);    

                            /*Check If Class Attendance Image Is Added In First Table(sms_attendance_class)*/
                            if($get_attendance_class_id)
                            {       $flag_success=true;
                                    for($i=1; $i<=isset($request['student_id'.$i]);$i++)
                                    {      
                                        $data = array(
                                            "sms_student_id"           => $request['student_id'.$i],
                                            "sms_attendance_class_id"  => $get_attendance_class_id,
                                            "status"                   => $request['student_attendance_status'.$i]   
                                        );

                                        /*Add Student Attendance In Second Table(sms_attendances)*/
                                        $attendance_id = Sms_attendance::create($data);

                                        /*Check If Attendance Is Added*/
                                        if($attendance_id->id)
                                        {
                                            $flag_attendance_added=true;
                                                
                                                /*Check If Student Is Absent Then Add His Reason In Third Table(sms_student_attendance_detail)*/
                                                if($request['student_attendance_status_reason'.$i])
                                                {
                                                    $reason = $request['student_attendance_status_reason'.$i];
                                                    $add_attendance_detail = Sms_attendance::insert_class_attendance_detail($attendance_id->id,$reason);
                                                }
                                        }
                                        /*Else If Attendance Is Not Added*/
                                        else
                                        {
                                            $flag_attendance_added=false;
                                        }
                                    }//Loop
                            }
                            else
                            {
                                $flag_success=false;
                            }
                    } 
                    else
                    {
                       $flag_success=false;
                    }     
            
                    if($flag_success==true && $flag_attendance_added==true)
                    {
                        $flag_success .= "<br />Attendance Has Been Added For Date : ".date('d F Y',strtotime($request['attendance_date']))." Successfully!...";
                        
                       
                        return response()->json([
                    'message'       => 'success',
                    'result'        => "Attendance Has Been Added For Date : ".date('d F Y',strtotime($request['attendance_date']))." Successfully!...",
                    ]);
                        
                    }
                    else  if($flag_success==false && $flag_attendance_added==false)
                    {
                        $flag_fail .= "<br />Attendance Has Been Added For Date : ".date('d F Y',strtotime($request['attendance_date']))." Successfully!...";    
                    
                     return response()->json([
                    'message'       => 'fail',
                    'result'     =>"Attendance Has Not Been Added For Date : ".date('d F Y',strtotime($request['attendance_date']))." !...",
                    
                    ]);
                 
                    } 
                 
                }
            else
            {
              return response()->json([
                'message'   => 'fail',
                'result'    =>"Please Take Whole Class Picture And Submit It Along With Your Attendance For The Verification!...",
              ]);
            }
                 
        }
        /*Check If Action Is To Modify Attendance*/              
        else if($request['user_action_name']=='modify_attendance')
        {
            $attendance_class_id = (int)$request['attendance_class_id1'];
            
         
             if(isset($_POST['img_url']))
             {
                $img = $_POST['img_url'];
             }
            
            
            $new_present_status =   0;
            $new_absent_status  =   0;

            /*Get Old Attendance Status To Check If It Is Updated Or Not*/
            $old_present_status = $request['old_present_status'];
            $old_absent_status  = $request['old_absent_status'];
            
            /*Get All New Attendance Status To Compare With Old Status*/
            for($i=1; $i<=isset($request['student_attendance_status'.$i]);$i++)
            {
               if($request['student_attendance_status'.$i]==1)
               {
                    $new_present_status++;
               } 
               else if($request['student_attendance_status'.$i]==0)
               {
                    $new_absent_status++; 
               }
            }

            
            /*Check If Status Is Updated BUT Image File Is Not Uploaded*/
            if(($old_present_status != $new_present_status || $old_absent_status !=$new_absent_status) && empty($img))
            {
                return response()->json([
                'message'   => 'fail',
                'result'=>"Please Take Whole Class Picture And Submit It Along With Your Attendance For The Verification!..."
                ]);
            }
            else
            {
               
                /*Check If Status Is Updated And Image File Is Uploaded*/
                if(($old_present_status != $new_present_status || $old_absent_status !=$new_absent_status) && !empty($img))
                {
                     
                    /*$new_image_name = strtolower(date('d_F_Y',strtotime($request['attendance_date']))) . '.' . $image->getClientOriginalExtension();
                    $uploaded = $image->move(public_path($class_attendance_image_path), $new_image_name);   */ 

                    /*Update Image*/
                    $folderPath =  storage_path('app/public/').$class_attendance_image_path;
                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $extension = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    
                    $new_image_name = strtolower(date('d_F_Y',strtotime($request['attendance_date']))). '.jpg';
                    $file = $folderPath ."/". $new_image_name;
                   
                    $uploaded=file_put_contents($file, $image_base64);    
                    
                    /*Update Image*/
                    
                    
                    /*Check If Image File Is Uploaded In Folder*/
                    if($uploaded)
                    {
                        /*Check If Old Image Extension Is Not Equal To New Image Extension Then Delete Old Image From Folder*/
                        if($new_image_name!=$request['class_attendance_image'])
                        {
                            /*Check If Image Exists In Folder Then Delete It*/
                            if(File::exists($class_attendance_image_path.'/'.$request['class_attendance_image']))
                            {
                             unlink($class_attendance_image_path.'/'.$request['class_attendance_image']);   
                            }
                        }
                        
                    }
                     

                    $attendance_class_data=array(
                    "class_image"        =>$new_image_name,  
                    "updated_date" =>date('Y-m-d'),
                    "updated_time" =>date('h:i:s'),
                    "updated_at" =>date('Y-m-d h:i:s')
                    );

                }

                /*Check If Status Is Not Updated AND Reason Is Updated OR Nothing Was Updated*/
                else if($old_present_status == $new_present_status && $old_absent_status ==$new_absent_status)
                {
                    $attendance_class_data = array(
                    "updated_date" => date('Y-m-d'),
                    "updated_time" => date('h:i:s'),
                    "updated_at"   => date('Y-m-d h:i:s')
                    );
}

                /*Update Attendance Class Table*/
                $get_update_attendance_class_id = Sms_attendance::update_attendance_class_image($attendance_class_id,$attendance_class_data);    

                //Check If Class Attendance Image Is Updated In First Table(sms_attendance_class)*/
                if($get_update_attendance_class_id)
                {   
                    $flag_success=true;
                            for($i=1; $i<=isset($request['attendance_id'.$i]);$i++)
                            {      
                                $data = array(
                                    "status"        => $request['student_attendance_status'.$i],
                                    "updated_at"    => date("Y-m-d h:i:s")
                                );

                                $attendance_id = (int)$request['attendance_id'.$i];

                                /*Update Student Attendance In Second Table(sms_attendances)*/
                                $get_updated_attendance_id = Sms_attendance::update_attendance($attendance_id,$data);


                                /*Check If Attendance Is Updated*/
                                if($get_updated_attendance_id)
                                {   $flag_attendance_added=true;
                                    /*Check If Selected Status Is Present Then Delete Previous Reason*/
                                    if( $request['old_student_attendance_status'.$i]==0 && $request['student_attendance_status'.$i]==1)
                                    {
                                        $attendance_detail_id = (int)$request['attendance_detail_id'.$i];
                                        Sms_attendance::delete_attendance_reason_by($attendance_detail_id);        
                                        $flag_attendance_added=true;
                                    }
                                    /*Check If Selected Status Is Absent Then Add New Reason*/
                                    if($request['old_student_attendance_status'.$i]==1 && $request['student_attendance_status'.$i]==0)
                                    {

                                        if(!empty($request['student_attendance_status_reason'.$i]))
                                        {
                                           $new_reason = $request['student_attendance_status_reason'.$i];

                                            //Add New Reason
                                            $add_new_reason = Sms_attendance::insert_class_attendance_detail($attendance_id,$new_reason);   
                                            $flag_attendance_added=true;
                                        }
                                    }
                                }
                                /*Else If Attendance Is Not Updated*/
                                else
                                {
                                    $flag_attendance_added=false;
                                }

                                /*Check If Status Is Not Changed Then Update Reason*/
                                if($request['student_attendance_status'.$i]==0 && $request['old_student_attendance_status'.$i]==0)
                                {
                                    /*Check If Reason Comes Empty From Database */
                                    if(empty($request['old_student_attendance_status_reason'.$i]))
                                    {

                                        $new_reason = $request['student_attendance_status_reason'.$i];

                                        /*Insert New Reason In Database From Input Field*/
                                        $add_new_reason = Sms_attendance::insert_class_attendance_detail($attendance_id,$new_reason);   
                                        $flag_attendance_added=true;
                                    }
                                    /*Check If Reason Does Not Come Empty From Database */
                                    else if(!empty($request['old_student_attendance_status_reason'.$i]))
                                    {
                                        $attendance_detail_id = (int)$request['attendance_detail_id'.$i];

                                        $data = array(
                                        "reason"=>$request['student_attendance_status_reason'.$i],
                                        "updated_at"=>date("Y-m-d h:i:s"),    
                                        );
                                        /*Update Reason To New One In Database From Input Field*/
                                        $get_updated_attendance_detail_id = Sms_attendance::update_attendance_detail($attendance_detail_id,$data); 

                                        $flag_attendance_added=true;   
                                    }
                               }         
                            }//Loop
                }
                else
                {
                    $flag_success=false;
                }


                if($flag_success==true && $flag_attendance_added=true)
                {
                    return response()->json([
                    'message'   => 'success',
                    'result'=>"Attendance Has Been Updated For Date : ".date('d F Y',strtotime($request['attendance_date']))." Successfully!...",
                   
                    ]);
                }

                else if($flag_success==false && $flag_attendance_added=false)
                {
                    return response()->json([
                    'message'   => 'fail',
                    'result'=>"Attendance Has Not Been Updated For Date : ".date('d F Y',strtotime($request['attendance_date']))."!..."
                    ]);
                }     
            }                    
        }
    }
    /*Submit Student Attendance*/

 
    
    /*Modify Attendance*/   
    public function modify_attendance()
    {
        $schools = Sms_school::all()->toArray();
        $role_user_id = Sms_user::get_current_user_logined_sms_role_user_id();
        
        /*Get Weekend Full Name*/
        $result_week_end = Sms_setting::where('key',"Weekend")->where('status',1)->get()->toArray();
        $week_end_name = date('l',strtotime($result_week_end[0]['value']));
       
        return view('super-admin/modify_attendance',['schools'=> $schools,'week_end_name'=>$week_end_name,"role_user_id"=>$role_user_id]);
    }
 
    



    
    /*View Attendance*/
    public function view_attendance()
    {

       /*Get Current School weekend Name*/
       $school_weekend = Sms_setting::where('key','weekend')->where('status',1)->get()->toArray();
       $weekend_day_name = null;

        if(!empty($school_weekend))
        {
               $weekend_day_name = $school_weekend[0]['value'];
        }
       
        $schools = Sms_school::where("status",1)->get()->toArray();

        $data = array(
            "schools"=>  $schools,
            "weekend_day_name"=>$weekend_day_name, 
        );

        return view('super-admin/view_attendance',$data);
    }

    public function get_daily_attendance_for_reporting(Request $request)
    {
        $year = date('Y',strtotime($request->daily_date));
        
        $class_id = $request->class_id;

        $school_name = $request->school_name;

        $class_name = $request->class_name;

        $school_id = (int)$request->school_id;
        
        $sms_class_school_id = $request->class_school_id;

        $reason = null;
        
        /*Getting Image Path*/
        $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($school_id,$school_name);
        
        $class_name = Sms_class::get_class_name_to_make_student_images_folder($class_name);

        $image_path = "storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".$year."/";
                    
        /*Get All Assigned Class Teachers*/
        $class_teachers =  Sms_class_role_user::get_all_class_school_teachers_by_class_school_id($sms_class_school_id);
        
        $daily_attendance_date = date('Y-m-d',strtotime($request->daily_date));
        
        $day_name = date('l',strtotime($daily_attendance_date));
       
        /*Check Is There Any Holiday Assigned In This Date*/
        $check_school_holiday = Holiday_school::get_holiday_by_school_id($school_id,$daily_attendance_date);
        
        /* Attendance Report In This Date */
        $daily_attendance_report = Sms_attendance::get_daily_attendance_report($sms_class_school_id,$daily_attendance_date);
        
        /*Getting All Class Student*/
        $all_students = Sms_attendance::get_students_attendance_by_class_school_id($sms_class_school_id,$daily_attendance_date);
           
        
        
        /*29 July 2019*/
         $class_attendance_picture_path= $schools_name_with_id."/".strtolower($class_name)."/".$year."/class_attendance/".strtolower(date("F",strtotime($daily_attendance_date)));
        /*29 July 2019*/
        
        
        
        /*Getting Absent Student Reason*/
        foreach ($all_students as $key => $value) 
        {
            $reason = Sms_attendance::get_attendance_reason_by_attendance_id($value->attendance_id);
            if(!empty($reason))
            {
                $all_students[$key]->reason = $reason[0]->reason;
            }        
        }

        if(!empty($daily_attendance_report))
        {
            $attendance_taken_by = Sms_class_role_user::get_teacher_of_taken_by_attendance_by($daily_attendance_report[0]->id);

             $attendance_taken_teacher_name = $attendance_taken_by[0]->teacher_name.' '.$attendance_taken_by[0]->last_name;   
        }
            /*Getting Present Students*/
             $present_students = Sms_attendance::get_all_student_attendance_status_by_class_school_id($sms_class_school_id,$daily_attendance_date,1);
           
             $present_students = count($present_students);

                                     /*Getting Absent Students*/
             $absent_students = Sms_attendance::get_all_student_attendance_status_by_class_school_id($sms_class_school_id,$daily_attendance_date,0);
       
             $absent_students = count($absent_students);
                                    /*Getting Weekend Day Name*/
             $school_weekend = Sms_setting::where('key','weekend')->where('status',1)->get()->toArray();
      
             $weekend_day_name = $school_weekend[0]['value'];
            /*If Holiday Date Exists*/
            if(!empty($check_school_holiday))
            {
                return response()->json(['message'=>'holiday_school_exists','daily_attendance_date'=>$request->daily_date,'holiday_title'=>$check_school_holiday[0]->title,'holiday_description'=>$check_school_holiday[0]->description]);  
            }
            /*If Weekend Date Exists*/
            elseif($day_name == $weekend_day_name)
            {
                return response()->json(['message'=>'weekend_day_exist','weekend_day_name'=>$weekend_day_name]);
            }
            /*If Attendance Not Taken*/
            else if(!$daily_attendance_report)
            {
                return response()->json(['message'=>'attendance_not_exist','daily_attendance_date'=>$request->daily_date]);
            }
            else
            {
                return view('super-admin/ajax_pages/get_attendance_daily_report',['daily_attendance_report'=>$daily_attendance_report,'school_name'=>$school_name,'class_name'=>$request->class_name,'all_students'=>$all_students,'present_students'=>$present_students,'absent_students'=>$absent_students,'daily_attendance_date'=>$request->daily_date,'class_teachers'=>$class_teachers,'image_path'=>$image_path,'attendance_taken_teacher_name'=>$attendance_taken_teacher_name,"class_attendance_picture_path"=>$class_attendance_picture_path]); 
            }   
        }

    public function get_daily_attendance_report(Request $request)
    {
       
        $school_name = $request->school_name;
        
        $class_name = $request->class_name;
        
        $all_students = $request->all_students;
        
        $class_teachers = $request->all_teachers_full_name;
        
        $attendance_taken_by = $request->daily_attendance_report_taken_by;

        $present_students = $request->present_students;
        
        $absent_students = $request->absent_students;
        
        $attendance_day = $request->attendance_day;
        
        /* Assigning All Arrays Into A Single Array */
        $all_student_data = array();
        for($i=1; $i<=isset($request['students_full_name'.$i]);$i++)
        {
            $all_student_data[$i] = array("full_name"=>$request['students_full_name'.$i],"status"=>$request['attendance_status'.$i],"gender"=>$request['gender'.$i],"absent_reason"=>$request['absent_reason'.$i]);
        }
        
         return view('super-admin/report/generate_daily_attendance_report',['school_name'=>$school_name,'class_name'=>$class_name,'class_teachers'=> $class_teachers,'attendance_taken_by'=>$attendance_taken_by,'present_students'=>$present_students,'absent_students'=>$absent_students,'attendance_day'=>$attendance_day,'all_students'=>$all_students,'all_student_data'=>$all_student_data]);
    }

    /*Generate Monthly Combine Report*/
    public function generate_monthly_combine_report(Request $request)
    {
       
        $folder_school_name = Sms_school::get_school_name_to_make_school_name_folder($request->school_id,$request->school_name);

        $folder_class_name = Sms_class::get_class_name_to_make_student_images_folder($request->class_name);

        $month = substr($request->month,0,2);
        $year = substr($request->month,3,6);
        $year_and_month = '%'.$year.'-'.$month.'%';
        
        $class_school_id = (int)$request->class_school_id;
        $school_id = (int)$request->school_id;

        $attendance = Sms_attendance::get_monthly_combine_attendance($class_school_id,$year_and_month); 

        $total_days_of_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
        
        $result_school_weekend = Sms_setting::get_school_holiday_by_school_id($school_id);

        $school_weekend = $result_school_weekend[0]->value;


        
         /*29 July 2019*/
         $class_attendance_picture_path= $folder_school_name."/".strtolower($folder_class_name)."/".$year."/class_attendance/".strtolower(date("F",strtotime($month)));
        /*29 July 2019*/
        
        
        $calendar_dates = array();

        for($i=1; $i<=$total_days_of_month; $i++)
        {
            $calendar_dates[date("Y-m-d",strtotime($i."-".$month."-".$year))] = "";
        }

        foreach ($calendar_dates as $key_holiday => $value_holiday) 
        {
            $result = Holiday_school::get_holiday_by_school_id($request->school_id,$key_holiday);

            if($result)
            {
                $calendar_dates[$key_holiday] = array('title'=>$result[0]->title,'description'=>$result[0]->description);
            }
        }

        foreach ($calendar_dates as $key_weekend => $value_weekend) 
        {
            $day =  date("l",strtotime($key_weekend));
            
            if($school_weekend == $day)
            {
                $calendar_dates[$key_weekend] = $school_weekend;
            }
        }

        $myattendance = array();
        $class_attendance_pictures=array();

        foreach ($attendance as $key => $value) 
        {
            $myattendance[$value->id]['profile_picture'] = 'storage/schools/'.$folder_school_name.'/'.$folder_class_name.'/'.$year."/".$value->student_image;
            $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name.' ( '.$value->gender.' )';
            $myattendance[$value->id]['student_attendance'] = $calendar_dates;
        }

        foreach ($attendance as $key => $value) 
        {
            $myattendance[$value->id]['profile_picture'] = 'storage/schools/'.$folder_school_name.'/'.$folder_class_name.'/'.$year."/".$value->student_image;
            $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name.' ( '.$value->gender.' )';
            $myattendance[$value->id]['student_combine_image'] = $value->student_image;

            $myattendance[$value->id]['student_attendance'][$value->created_date] = $value->status;
            $class_attendance_pictures[$value->created_date]=$value->class_image;
        }

        $teachers = Sms_class_role_user::get_all_class_school_teachers_by_class_school_id($request->class_school_id);

        $students = Sms_class_role_user::get_students_by_class_school_id($request->class_school_id);

        $total_students  = count($students);

        if(empty($attendance))
        {
            
            return response()->json([
                "message"   =>"fail",
            ]);
        }
        else
        {
            return view('super-admin/report/get_attendance_for_monthy_combine_report',[
                'school_name'       =>  $request->school_name,
                'class_name'        =>  $request->class_name,
                'month_name'        =>  $request->month_name,
                'school_id'         =>  $request->school_id,
                'class_school_id'   =>  $request->class_school_id,
                'class_id'          =>  $request->class_id,
                'total_students'    =>  $total_students,
                'teachers'          =>  $teachers,
                'attendance'        =>  $myattendance,
                "total_month_days"  =>  $total_days_of_month,
                "year"              =>  $year,
                "month"             =>  $month,
                "class_attendance_pictures"=>$class_attendance_pictures,
                "class_attendance_picture_path"=>$class_attendance_picture_path
            ]);
        }
    }

    public function generate_excel_monthly_combine_report(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $class_school_id = (int)$request->class_school_id;
        $school_id = (int)$request->school_id;

        $teachers = Sms_class_role_user::get_all_class_school_teachers_by_class_school_id($class_school_id);

        $year_and_month = '%'.$year.'-'.$month.'%';
        
        

        $attendance = Sms_attendance::get_monthly_combine_attendance($class_school_id,$year_and_month);

        $result_school_weekend = Sms_setting::get_school_holiday_by_school_id($school_id);

        $school_weekend = $result_school_weekend[0]->value;

        $total_days_of_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);

        $calendar_dates = array();

        for($i=1; $i<=$total_days_of_month; $i++)
        {
            $calendar_dates[date("Y-m-d",strtotime($i."-".$month."-".$year))] = "";
        }

        foreach ($calendar_dates as $key_holiday => $value_holiday) 
        {
            $result = Holiday_school::get_holiday_by_school_id($request->school_id,$key_holiday);

            if($result)
            {
                $calendar_dates[$key_holiday] = $result[0]->title;
            }
        }

        foreach ($calendar_dates as $key_weekend => $value_weekend) 
        {
            $day =  date("l",strtotime($key_weekend));
            
            if($school_weekend == $day)
            {
                $calendar_dates[$key_weekend] = $school_weekend;
            }
        }

        $myattendance = array();

        foreach ($attendance as $key => $value) 
        {
            $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name.' ( '.$value->gender.' )';
            $myattendance[$value->id]['gender'] = $value->gender;
            $myattendance[$value->id]['student_attendance'] = $calendar_dates;
        }

        foreach ($attendance as $key => $value) 
        {
            $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name;
            $myattendance[$value->id]['gender'] = $value->gender;
            $myattendance[$value->id]['student_attendance'][$value->created_date] = $value->status;
        }

        return view('super-admin/report/generate_excel_for_monthy_combine_report',[
            'school_name'       =>  $request->school_name,
            'class_name'        =>  $request->class_name,
            'month_name'        =>  $request->month_name,
            'total_students'    =>  $request->total_students,
            'teachers'          =>  $teachers,
            'attendance'        =>  $myattendance,
            "total_month_days"  =>  $total_days_of_month,
            "year"              =>  $year,
            "month"             =>  $month
        ]);
    }

	/*Show Date Range Combine Report*/
    public function show_date_range_combine_report(Request $request)
    {
        $class_school_id = (int)$request->class_school_id;
        $school_id = (int)$request->school_id;
        $class_id = (int)$request->class_id;

        $teachers = Sms_class_role_user::get_all_class_school_teachers_by_class_school_id($class_school_id);

        $students = Sms_class_role_user::get_students_by_class_school_id($class_school_id);

        $total_students  = count($students);

        $date_from = date("Y-m-d",strtotime($request->date_from));

        $date_to = date("Y-m-d",strtotime($request->date_to));

        $year = date("Y",strtotime($request->date_to));

        $dates = array(); 

        $folder_school_name = Sms_school::get_school_name_to_make_school_name_folder($school_id,$request->school_name);

        $folder_class_name = Sms_class::get_class_name_to_make_student_images_folder($request->class_name);

        $from = strtotime($request->date_from);
        $to = strtotime($request->date_to);

        for ($i = $from; $i <= $to; $i += (86400))
        {                                       
            $dates[date('Y-m-d', $i)] = "";
        }

        $total_days = count($dates);

        $result_school_weekend = Sms_setting::get_school_holiday_by_school_id($school_id);

        $school_weekend = $result_school_weekend[0]->value;

        /*29 July 2019*/
         $class_attendance_picture_path= $folder_school_name."/".strtolower($folder_class_name);
        /*29 July 2019*/
        
        foreach ($dates as $key_holiday => $value_holiday) 
        {
            $result = Holiday_school::get_holiday_by_school_id($request->school_id,$key_holiday);

            if($result)
            {
                $dates[$key_holiday] = array('title'=>$result[0]->title,'description'=>$result[0]->description);
            }
        }

        foreach ($dates as $key_weekend => $value_weekend) 
        {
            $day =  date("l",strtotime($key_weekend));
            
            if($school_weekend == $day)
            {
                $dates[$key_weekend] = $school_weekend;
            }
        }

        $attendance = Sms_attendance::get_date_range_combine_attendance($class_school_id,$date_from,$date_to); 

        $myattendance = array();
        $class_attendance_pictures=array();
        $class_attendance_pictures_paths=array();
        
        foreach ($attendance as $key => $value) 
        {
            $myattendance[$value->id]['profile_picture'] = 'storage/schools/'.$folder_school_name.'/'.$folder_class_name.'/'.$year."/".$value->student_image;
            $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name.' ( '.$value->gender.' )';
            $myattendance[$value->id]['student_attendance'] = $dates;
        }

        foreach ($attendance as $key => $value) 
        {
            $myattendance[$value->id]['profile_picture'] = 'storage/schools/'.$folder_school_name.'/'.$folder_class_name.'/'.$year."/".$value->student_image;
            $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name.' ( '.$value->gender.' )';

            $myattendance[$value->id]['student_attendance'][$value->created_date] = $value->status;
            $class_attendance_pictures[$value->created_date]=$value->class_image;
        }

        if(!empty($attendance))
        {
            return view('super-admin/report/view_date_range_combine_report',[
                'school_name'       =>  $request->school_name,
                'class_name'        =>  $request->class_name,
                'total_students'    =>  $total_students,
                'teachers'          =>  $teachers,
                'date_from'         =>  $request->date_from,
                'date_to'           =>  $request->date_to,
                'attendance'        =>  $myattendance,
                'total_days'        =>  $total_days,
                'dates'             =>  $dates,
                'class_school_id'   =>  $class_school_id,
                'school_id'         =>  $school_id,
                'class_id'          =>  $class_id,
                "class_attendance_pictures"=>$class_attendance_pictures,
                "class_attendance_picture_path"=>$class_attendance_picture_path
                
                

            ]);   
        }
        else
        {
            return response()->json([
                "message"   =>"fail",
            ]);
        }
    }

    /*Generate Report of Date Range Combine Report*/
    public function generate_excel_date_range_combine_report(Request $request)
    {
        $class_school_id = (int)$request->class_school_id;
        $school_id = (int)$request->school_id;
        $class_id = (int)$request->class_id;

        $teachers = Sms_class_role_user::get_all_class_school_teachers_by_class_school_id($class_school_id);

        $date_from = date("Y-m-d",strtotime($request->date_from));

        $date_to = date("Y-m-d",strtotime($request->date_to));

        $year = date("Y",strtotime($request->date_to));

        $dates = array(); 

        $from = strtotime($request->date_from);
        $to = strtotime($request->date_to);

        for ($i = $from; $i <= $to; $i += (86400))
        {                                       
            $dates[date('Y-m-d', $i)] = "";
        }

        $total_days = count($dates);

        $result_school_weekend = Sms_setting::get_school_holiday_by_school_id($school_id);

        $school_weekend = $result_school_weekend[0]->value;

        foreach ($dates as $key_holiday => $value_holiday) 
        {
            $result = Holiday_school::get_holiday_by_school_id($school_id,$key_holiday);

            if($result)
            {
                $dates[$key_holiday] = $result[0]->title;

            }
        }

        foreach ($dates as $key_weekend => $value_weekend) 
        {
            $day =  date("l",strtotime($key_weekend));
            
            if($school_weekend == $day)
            {
                $dates[$key_weekend] = $school_weekend;
            }
        }

        $attendance = Sms_attendance::get_date_range_combine_attendance($class_school_id,$date_from,$date_to); 

        $myattendance = array();
        
        foreach ($attendance as $key => $value) 
        {
            $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name;
            $myattendance[$value->id]['gender'] = $value->gender;
            $myattendance[$value->id]['student_attendance'] = $dates;
        }

        foreach ($attendance as $key => $value) 
        {
            $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name;
            $myattendance[$value->id]['gender'] = $value->gender;
            $myattendance[$value->id]['student_attendance'][$value->created_date] = $value->status;
        }

        
        return view('super-admin/report/generate_excel_date_range_combine_report',[
            'school_name'       =>  $request->school_name,
            'class_name'        =>  $request->class_name,
            'total_students'    =>  $request->total_students,
            'teachers'          =>  $teachers,
            'date_from'         =>  $request->date_from,
            'date_to'           =>  $request->date_to,
            'attendance'        =>  $myattendance,
            'total_days'        =>  $total_days,
            'dates'             =>  $dates
        ]);
    }

    /*Get Students By School Id and Class Id For Students Dropdown in Student Report*/
    public function get_students_by_school_id_and_class_id(Request $request)
    {
        $students = Sms_class_student::get_class_students_by_school_id_class_id($request->school_id,$request->class_id);

        if(!empty($students))
        {
        ?>
                <option value="">-- Select Student --</option>
            <?php 
                foreach($students as $student)
                {
                ?>
                    <option value="<?php echo $student->id;?>">
                    <?php echo $student->first_name.' '.$student->last_name;?>
                <?php     
                }   
        }
        else
        {
            return response()->json([
                "message"   =>"noStudents",
            ]);
        }
	}

    /*Show Date Range Student Report*/
    public function show_date_range_student_report(Request $request)
    {
        $class_school_id    =   (int)$request->class_school_id;
        $school_id          =   (int)$request->school_id;
        $class_id           =   (int)$request->class_id;
        $student_id         =   (int)$request->student_id;

        $teachers = Sms_class_role_user::get_all_class_school_teachers_by_class_school_id($class_school_id);

        /*Get student detail by student id*/
        $get_student = Sms_student::get_student_datail_by_student_id($student_id);

        $students = Sms_class_role_user::get_students_by_class_school_id($class_school_id);

        $total_students  = count($students);

        $student_name = '';
        $gaurdian_name = '';
        $gender = '';
        $date_of_birth = '';
        $address = '';
        $gaurdian_contact_number = '';
        if(!empty($get_student))
        {
            $student_name = $get_student[0]->first_name.' '.$get_student[0]->middle_name.' '.$get_student[0]->last_name;
            $gaurdian_name = $get_student[0]->gaurdian_name;
            $gender = $get_student[0]->gender;
            $date_of_birth = $get_student[0]->date_of_birth;
            $address = $get_student[0]->address;
            $gaurdian_contact_number = $get_student[0]->gaurdian_contact_number;
        }

        $date_from = date("Y-m-d",strtotime($request->date_from));

        $date_to = date("Y-m-d",strtotime($request->date_to));

        $year = date("Y",strtotime($request->date_to));

        $dates = array(); 

        $folder_school_name = Sms_school::get_school_name_to_make_school_name_folder($school_id,$request->school_name);

        $folder_class_name = Sms_class::get_class_name_to_make_student_images_folder($request->class_name);

        $from = strtotime($request->date_from);
        $to = strtotime($request->date_to);

        for ($i = $from; $i <= $to; $i += (86400))
        {                                       
            $dates[date('Y-m-d', $i)] = "";
        }

        $total_days = count($dates);

        $result_school_weekend = Sms_setting::get_school_holiday_by_school_id($school_id);

        $school_weekend = $result_school_weekend[0]->value;

        foreach ($dates as $key_holiday => $value_holiday) 
        {
            $result = Holiday_school::get_holiday_by_school_id($request->school_id,$key_holiday);

            if($result)
            {
                $dates[$key_holiday] = array('title'=>$result[0]->title,'description'=>$result[0]->description);
            }
        }

        foreach ($dates as $key_weekend => $value_weekend) 
        {
            $day =  date("l",strtotime($key_weekend));
            
            if($school_weekend == $day)
            {
                $dates[$key_weekend] = $school_weekend;
            }
        }

        $attendance = Sms_attendance::get_date_range_student_attendance($class_school_id,$student_id,$date_from,$date_to); 

        $myattendance = array();
        
        foreach ($attendance as $key => $value) 
        {
            $myattendance[$value->id]['profile_picture'] = 'storage/schools/'.$folder_school_name.'/'.$folder_class_name.'/'.$year."/".$value->student_image;
            $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name.' ( '.$value->gender.' )';
            $myattendance[$value->id]['student_attendance'] = $dates;
        }

        foreach ($attendance as $key => $value) 
        {
            $myattendance[$value->id]['profile_picture'] = 'storage/schools/'.$folder_school_name.'/'.$folder_class_name.'/'.$year."/".$value->student_image;
            $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name.' ( '.$value->gender.' )';

            $myattendance[$value->id]['student_attendance'][$value->created_date] = $value->status;
        }

        if(!empty($attendance)){

                return view('super-admin/report/view_date_range_student_report',[
                    'school_name'               =>  $request->school_name,
                    'class_name'                =>  $request->class_name,
                    'total_students'            =>  $total_students,
                    'teachers'                  =>  $teachers,
                    'date_from'                 =>  $request->date_from,
                    'date_to'                   =>  $request->date_to,
                    'student_name'              =>  $student_name,
                    'gaurdian_name'             =>  $gaurdian_name,
                    'gender'                    =>  $gender,
                    'date_of_birth'             =>  $date_of_birth,
                    'address'                   =>  $address,
                    'gaurdian_contact_number'   =>  $gaurdian_contact_number,
                    'attendance'                =>  $myattendance,
                    'total_days'                =>  $total_days,
                    'dates'                     =>  $dates,
                    'class_school_id'           =>  $class_school_id,
                    'school_id'                 =>  $school_id,
                    'class_id'                  =>  $class_id,
                    'student_id'                =>  $student_id,
                ]);
            }
            else
            {
                return response()->json(['message'=>'fail']);
            }       
    }

    /*Generate Student Report*/
    public function generate_excel_date_range_student_report(Request $request)
    {
        $teachers = Sms_class_role_user::get_all_class_school_teachers_by_class_school_id($request->class_school_id);

        $date_from = date("Y-m-d",strtotime($request->date_from));

        $date_to = date("Y-m-d",strtotime($request->date_to));

        $dates = array(); 

        $from = strtotime($request->date_from);
        $to = strtotime($request->date_to);

        for ($i = $from; $i <= $to; $i += (86400))
        {                                       
            $dates[date('Y-m-d', $i)] = "";
        }

        $total_days = count($dates);

        $result_school_weekend = Sms_setting::get_school_holiday_by_school_id($request->school_id);

        $school_weekend = $result_school_weekend[0]->value;

        foreach ($dates as $key_holiday => $value_holiday) 
        {
            $result = Holiday_school::get_holiday_by_school_id($request->school_id,$key_holiday);

            if($result)
            {
                $dates[$key_holiday] = $result[0]->title;
            }
        }

        foreach ($dates as $key_weekend => $value_weekend) 
        {
            $day =  date("l",strtotime($key_weekend));
            
            if($school_weekend == $day)
            {
                $dates[$key_weekend] = $school_weekend;
            }
        }

        $attendance = Sms_attendance::get_date_range_student_attendance($request->class_school_id,$request->student_id,$date_from,$date_to); 


        $myattendance = array();
        
        foreach ($attendance as $key => $value) 
        {
            $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name;
            $myattendance[$value->id]['gender'] = $value->gender;
            $myattendance[$value->id]['student_attendance'] = $dates;
        }

        foreach ($attendance as $key => $value) 
        {
            $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name;
            $myattendance[$value->id]['gender'] = $value->gender;
            $myattendance[$value->id]['student_attendance'][$value->created_date] = $value->status;
        }

        return view('super-admin/report/generate_excel_date_range_student_report',[
            'school_name'               =>  $request->school_name,
            'class_name'                =>  $request->class_name,
            'total_students'            =>  $request->total_students,
            'teachers'                  =>  $teachers,
            'date_from'                 =>  $request->date_from,
            'date_to'                   =>  $request->date_to,
            'student_name'              =>  $request->student_name,
            'gaurdian_name'             =>  $request->gaurdian_name,
            'gender'                    =>  $request->gender,
            'date_of_birth'             =>  $request->date_of_birth,
            'address'                   =>  $request->address,
            'gaurdian_contact_number'   =>  $request->gaurdian_contact_number,
            'attendance'                =>  $myattendance,
            'total_days'                =>  $total_days,
            'dates'                     =>  $dates,
        ]);   
    }

    /*Get Classes By School Id To Show Class for attence view section*/
    public function get_clases_by_school_id_for_attendace_view(Request $request)
    {
       
        /*Get School Name By School ID*/
        $school_name = Sms_school::find($request->school_id)->toArray();
        
        
        /*Get School-Classes By School ID*/
        $school_classes = Class_School::view_school_classes($request->school_id);

        
        /*Check If School Has Classes*/
        if(!empty($school_classes))
        {
            ?>
                <option value="">-- Select Class --</option>
            <?php 
                foreach($school_classes as $class)
                {
                ?>
                    <option value="<?php echo $class->id; ?>">
                        <?php echo $class->class;?>
                    </option>
                <?php     
                }   
         }
        else
        {
            /*(Note:)Do Not Change This Let It Be As It Is*/
            echo 'no classes';
        }
     
    }


	/*Get recoreds of students attendance individual by class_school_id and date range */ 
	public function generate_individual_attendance_report_by_class_school_id_date_range(Request $request)
    {
		
		/*Get monthly attendance recored day by day by class_school_id and date range*/
		$get_class_attendance = Sms_attendance::get_attendance_recoreds_date_range_attendance_info_by_class_school_id($request['class_school_id'],$request['date_from'],$request['date_to']);
		
		$class_school_id = $request['class_school_id'];
		/*This condion check for if this attendance takened the get recoreds*/
        if( isset($get_class_attendance[0]->id) && $get_class_attendance[0]->id > 0 )
        {
			
			$from_date = date('Y-m-d',strtotime($request['date_from']));
			$to_date = date('Y-m-d',strtotime($request['date_to']));
			
			// Iterate over the period
			$period = CarbonPeriod::create($from_date,$to_date);
			$get_all_dates = array();
			foreach ($period as $date) 
            {
				 $get_all_dates[] = $date->format('Y-m-d');
			}
	
			/*Get school name and class  name by school class id */
            $get_class_school_names = Class_school::get_school_name_and_class_name_by_class_school_id($class_school_id);
			
			/*Get class school teachers by class_school_id for view attendance*/
            $get_school_class_teachers = Sms_class_role_user::get_school_class_teachers_by_class_school_id($class_school_id);
        	
            /*Get count total students in school class by class_school_id*/
            $get_total_students = Sms_student::get_count_total_students_by_class_school_id($class_school_id);  
			                   	   
            /*Get holiday information for view attendance by school id and by date range */    
            $get_holiday = Sms_holiday::get_holiday_information_for_view_attendance_by_school_id_and_date_range($request->school_id,$request['date_from'],$request['date_to']);

            /*Get weekend value */
            $weekend = Sms_setting::where('status', '=', 1)
                                ->where('key', '=', 'Weekend')
                                ->get(['value'])->toArray();
								
			/*Code for get attendance detail*/
			$get_attendance_detail_array = array();
            foreach ($get_class_attendance as $key => $get_attendance) 
            {
				
				/*Get attendance taken by teacher by attendance id */
                $get_taken_by_teachers = Sms_class_role_user::get_teacher_of_taken_by_attendance_by($get_attendance->id);
				
                /*Get get present students by attendance id*/
                $get_present_students = Sms_attendance::get_present_students_by_attendacne_id($get_attendance->id);
				
                /*Get get absent students by attendance id*/
                $get_absent_students  = Sms_attendance::get_absent_students_by_attendacne_id($get_attendance->id);
				
				/*Get all students  by attendance id */
                $get_all_students = Sms_student::get_all_students_by_attendance_id($get_attendance->id);

				
                     $total_count_student = 0;
                     foreach ($get_all_students as $key => $value) 
                     {

                        $total_count_student++;
                        if($value->attendance_status == 0)
                        {
                            
                            $get_absent_resion =  DB::select("SELECT `sms_student_attendance_detail`.`reason`
                                    FROM `sms_attendances` ,`sms_student_attendance_detail`             
                                    WHERE `sms_attendances`.`status` = 0
                                    AND `sms_student_attendance_detail`.`sms_attendance_id` =".$value->id." ");
                            $get_all_students[$key]->resion = $get_absent_resion[0]->reason;

                        }

                        /*Get school name with school id  in small alphabets for create a school folder name */
                        $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($get_class_school_names[0]->school_id,$get_class_school_names[0]->school);
                        $class_name = Sms_class::get_class_name_to_make_student_images_folder($get_class_school_names[0]->class);
                         
                        /*code for get student image path with every year */  
                        $image =  $get_all_students[$key]->student_image;
                        
                         $get_all_students[$key]->student_image = "/storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".substr($value->created_at,0,4)."/".$image;
                        $get_all_students[$key]->student_individual_image = $image; 
                         
                         
                      
                        /*29 July 2019*/
                         $class_attendance_picture_path= $schools_name_with_id."/".strtolower($class_name)."/".substr($value->created_at,0,4)."/class_attendance/".strtolower(date("F",strtotime($get_attendance->created_date)));
                         
                         
                         $class_attendance_picture=strtolower($get_attendance->class_image);
                        /*29 July 2019*/  
                         
                         
                    
                     }
                
                /*store all attendance recored of one day store in get_attendance_detail_array array */  
                $array[$key]['date'] =  $get_attendance->created_date;
                $array[$key]["class_attendance_picture_path"]=$class_attendance_picture_path;
                $array[$key]['class_attendance_picture']=$class_attendance_picture;
                $array[$key]['attendance_taken_by'] = $get_taken_by_teachers[0]->teacher_name." ".$get_taken_by_teachers[0]->last_name;
                $array[$key]['class_total_students'] = $total_count_student;
                $array[$key]['present_students'] = $get_present_students[0]->present_students;
                $array[$key]['absent_students'] = $get_absent_students[0]->absent_students;
                $array[$key]['students_info'] = (array) $get_all_students;
                $total_count_student = 0;
                $get_attendance_detail_array[] = $array;
				
			}
			
			/*store monthly recored day by day in Attendance_summery array */
               $attendance_summery = array(

                "school_name"           => $get_class_school_names[0]->school,
                "class_name"            => $get_class_school_names[0]->class,
                "teachers"              => $get_school_class_teachers,
                "total_students"        => $get_total_students[0]->total_students,
                "date_range"            => "From: ".$request['date_from']." To: ".$request['date_to'],
                "holiday_recored"       => $get_holiday,
                'weekend'               => $weekend[0]['value'],
                "attendance_detail"     => $get_attendance_detail_array,
                "total_range_days"      => $get_all_dates,  

              );
			  	
		}
        else{
			
			 $Attendance_summery = array();
             return response()->json(['message'=>'fail']);
			
		}
		
		$data = array(
			'class_school_id' =>$class_school_id,
			'date_from'		  =>$request['date_from'],
			'date_to'		  =>$request['date_to'],
			
		);
		
		return view("super-admin/ajax_pages/get_date_range_individual_report_for_view_attendance",['attendance'=>$attendance_summery,'date_range_class_school_id'=>$data]);
		
		
	}

	/*Get recoreds of students attendance date range wise individual */
	public function get_report_date_range_individual(Request $request){
		
	  /*Get monthly attendance recored day by day by class_school_id and date range*/
		$get_class_attendance = Sms_attendance::get_attendance_recoreds_date_range_attendance_info_by_class_school_id($request['class_school_id'],$request['date_from'],$request['date_to']);
		
		$class_school_id = $request['class_school_id'];
		/*This condion check for if this attendance takened the get recoreds*/
        if( isset($get_class_attendance[0]->id) && $get_class_attendance[0]->id > 0 ){
			
			$from_date = date('Y-m-d',strtotime($request['date_from']));
			$to_date = date('Y-m-d',strtotime($request['date_to']));
			
			// Iterate over the period
			$period = CarbonPeriod::create($from_date,$to_date);
			$get_all_dates = array();
			foreach ($period as $date) {
				 $get_all_dates[] = $date->format('Y-m-d');
			}
			
			
			
			/*Get school name and class  name by school class id */
            $get_class_school_names = Class_school::get_school_name_and_class_name_by_class_school_id($class_school_id);
			
			/*Get class school teachers by class_school_id for view attendance*/
            $get_school_class_teachers = Sms_class_role_user::get_school_class_teachers_by_class_school_id($class_school_id);
        	
            /*Get count total students in school class by class_school_id*/
            $get_total_students = Sms_student::get_count_total_students_by_class_school_id($class_school_id);  
			
			
                   	   
            /*Get holiday information for view attendance by school id and by date range */    
            $get_holiday = Sms_holiday::get_holiday_information_for_view_attendance_by_school_id_and_date_range($request->school_id,$request['date_from'],$request['date_to']);

            /*Get weekend value */
            $weekend = Sms_setting::where('status', '=', 1)
                                ->where('key', '=', 'Weekend')
                                ->get(['value'])->toArray();
								
			/*Code for get attendance detail*/
			$get_attendance_detail_array = array();
            foreach ($get_class_attendance as $key => $get_attendance) {
				
				/*Get attendance taken by teacher by attendance id */
                $get_taken_by_teachers = Sms_class_role_user::get_teacher_of_taken_by_attendance_by($get_attendance->id);
				
                /*Get get present students by attendance id*/
                $get_present_students = Sms_attendance::get_present_students_by_attendacne_id($get_attendance->id);
				
                /*Get get absent students by attendance id*/
                $get_absent_students  = Sms_attendance::get_absent_students_by_attendacne_id($get_attendance->id);
				
				/*Get all students  by attendance id */
                $get_all_students = Sms_student::get_all_students_by_attendance_id($get_attendance->id);

				
                     $total_count_student = 0;
                     foreach ($get_all_students as $key => $value) {

                        $total_count_student++;
                        if($value->attendance_status == 0){
                            
                            $get_absent_resion =  DB::select("SELECT `sms_student_attendance_detail`.`reason`
                                    FROM `sms_attendances` ,`sms_student_attendance_detail`             
                                    WHERE `sms_attendances`.`status` = 0
                                    AND `sms_student_attendance_detail`.`sms_attendance_id` =".$value->id." ");
                            $get_all_students[$key]->resion = $get_absent_resion[0]->reason;

                        }



                        /*Get school name with school id  in small alphabets for create a school folder name */
                        $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($get_class_school_names[0]->school_id,$get_class_school_names[0]->school);
                        $class_name = Sms_class::get_class_name_to_make_student_images_folder($get_class_school_names[0]->class);
                         
                        /*code for get student image path with every year */  
                        $image =  $get_all_students[$key]->student_image;
                        $get_all_students[$key]->student_image = "/storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".substr($value->created_at,0,4)."/".$image;
                        $get_all_students[$key]->student_individual_image = $image; 
                    
                     }


                /*store all attendance recored of one day store in get_attendance_detail_array array */  
                $array[$key]['date'] =  $get_attendance->created_date;
                $array[$key]['attendance_taken_by'] = $get_taken_by_teachers[0]->teacher_name." ".$get_taken_by_teachers[0]->last_name;
                $array[$key]['class_total_students'] = $total_count_student;
                $array[$key]['present_students'] = $get_present_students[0]->present_students;
                $array[$key]['absent_students'] = $get_absent_students[0]->absent_students;
                $array[$key]['students_info'] = (array) $get_all_students;
                $total_count_student = 0;
                $get_attendance_detail_array[] = $array;
				
			}
			
			/*store monthly recored day by day in Attendance_summery array */
               $attendance_summery = array(

                "school_name"           => $get_class_school_names[0]->school,
                "class_name"            => $get_class_school_names[0]->class,
                "teachers"              => $get_school_class_teachers,
                "total_students"        => $get_total_students[0]->total_students,
                "date_range"            => "From: ".$request['date_from']." To: ".$request['date_to'],
                "holiday_recored"       => $get_holiday,
                'weekend'               => $weekend[0]['value'],
                "attendance_detail"     => $get_attendance_detail_array,
                "total_range_days"      => $get_all_dates,  

              );
			  
			  
			
		}else{
			
			 $attendance_summery = array();
             return response()->json(['message'=>'fail']);
			
		}
		
		$data = array(
			'class_school_id' =>$class_school_id,
			'date_from'		  =>$request['date_from'],
			'date_to'		  =>$request['date_to'],
			
		);		
		
	  return view("super-admin/report/report_date_range_individual",['attendance'=>$attendance_summery,'date_from'=>$request['date_from'],'date_to'=>$request['date_to']]);

		
	}


  /*Get recoreds of students attendance monthly wise day by day */
    public function monthly_individual_function(Request $request){
      

        /*this code for set month and year for get attendance recoreds*/             
        $month_year     = substr($request['month_year'],3,5);
        $month_year[4]  = "-";
        $month_year     .=  substr($request['month_year'],0,2);
        $class_school_id =  $request['class_school_id'];


        

        $data =  array(
            "month_year"            => $request['month_year'],
            "class_school_id"      => $request['class_school_id'],

        );

        $holiday_recored = array();
        $month_total_days = array();

        $month = substr($month_year,5,2);
        $year = substr($month_year,0,4);
        $number = cal_days_in_month(CAL_GREGORIAN,$month,$year); // 31
        for($d=1; $d<=$number; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);          
            if (date('m', $time)==$month)       
                $month_total_days[]=date('Y-m-d', $time);
        }



    
        /*Get monthly attendance recored day by day by class_school_id and month and year*/
        $get_class_attendance = Sms_attendance::get_attendance_recoreds_monthly_per_day_attendance_info_by_class_school_id($request['class_school_id'],$month_year);
        

        /*This condion check for if this attendance takened the get recoreds*/
        if( isset($get_class_attendance[0]->id) && $get_class_attendance[0]->id > 0 )
        {

            /*Get school name and class  name by school class id */
            $get_class_school_names = Class_school::get_school_name_and_class_name_by_class_school_id($class_school_id);

            /*Get class school teachers by class_school_id for view attendance*/
            $get_school_class_teachers = Sms_class_role_user::get_school_class_teachers_by_class_school_id($class_school_id);
        
            /*Get count total students in school class by class_school_id*/
            $get_total_students = Sms_student::get_count_total_students_by_class_school_id($class_school_id,$month_year);  
                   
            /*Get holiday information for view attendance by school id and attendance id */    
             $get_holiday = Sms_holiday::get_holiday_information_for_view_attendance_by_school_id_and_class_attendance_date($request->school_id,$get_class_attendance[0]->created_date);

            /*Get weekend value */
            $weekend = Sms_setting::where('status', '=', 1)
                                ->where('key', '=', 'Weekend')
                                ->get(['value'])->toArray();

            /*Code for get attendance detail*/
            foreach ($get_class_attendance as $key => $get_attendance) {

                /*Get attendance taken by teacher by attendance id */
                $get_taken_by_teachers = Sms_class_role_user::get_teacher_of_taken_by_attendance_by($get_attendance->id);

                /*Get get present students by attendance id*/
                $get_present_students = Sms_attendance::get_present_students_by_attendacne_id($get_attendance->id);

                /*Get get absent students by attendance id*/
                $get_absent_students  = Sms_attendance::get_absent_students_by_attendacne_id($get_attendance->id);

                /*Get all students  by attendance id */
                $get_all_students = Sms_student::get_all_students_by_attendance_id($get_attendance->id);


                     $total_count_student = 0;
                     foreach ($get_all_students as $key => $value) {

                        $total_count_student++;
                        if($value->attendance_status == 0){
                            
                            $get_absent_resion =  DB::select("SELECT `sms_student_attendance_detail`.`reason`
                                    FROM `sms_attendances` ,`sms_student_attendance_detail`             
                                    WHERE `sms_attendances`.`status` = 0
                                    AND `sms_student_attendance_detail`.`sms_attendance_id` =".$value->id." ");
                            $get_all_students[$key]->resion = $get_absent_resion[0]->reason;

                        }


                        /*Get school name with school id  in small alphabets for create a school folder name */
                        $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($get_class_school_names[0]->school_id,$get_class_school_names[0]->school);
                        $class_name = Sms_class::get_class_name_to_make_student_images_folder($get_class_school_names[0]->class);
                         
                        /*code for get student image path with every year */  
                        $image =  $get_all_students[$key]->student_image;
                        $get_all_students[$key]->student_image = "/storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".substr($month_year,0,4)."/".$image;
                        $get_all_students[$key]->student_individual_image = $image; 
                    
                         
                        
                         
                         /*29 July 2019*/
                         $class_attendance_picture_path= $schools_name_with_id."/".strtolower($class_name)."/".substr($month_year,0,4)."/class_attendance/".strtolower(date("F",strtotime($get_attendance->created_date)));
                        
                         $class_attendance_picture=strtolower($get_attendance->class_image);
                         /*29 July 2019*/ 
                         
                         
                     }

                /*store all attendance recored of one day store in get_attendance_detail_array array */  
                $array[$key]['date'] =  $get_attendance->created_date;
                $array[$key]['class_attendance_picture_path']=$class_attendance_picture_path;
                $array[$key]['class_attendance_picture']=$class_attendance_picture;
                $array[$key]['attendance_taken_by'] = $get_taken_by_teachers[0]->teacher_name." ".$get_taken_by_teachers[0]->last_name;
                $array[$key]['class_total_students'] = $total_count_student;
                $array[$key]['present_students'] = $get_present_students[0]->present_students;
                $array[$key]['absent_students'] = $get_absent_students[0]->absent_students;
                $array[$key]['students_info'] = (array) $get_all_students;
                
                $total_count_student = 0;
                $get_attendance_detail_array[] = $array;                
            }

           
            $Month_array = array(
                "01"   =>'January', 
                "02"   =>'February', 
                "03"   =>'March', 
                "04"   =>'April', 
                "05"   =>'May', 
                "06"   =>'June', 
                "07"   =>'July', 
                "08"   =>'August', 
                "09"   =>'September', 
                "10"  =>'October', 
                "11"  =>'November', 
                "12"  =>'December',
            );
            //get month 
            $month_no = substr($month_year,5,2); 
            
                /*store monthly recored day by day in Attendance_summery array */
                $Attendance_summery = array(

                "school_name"           => $get_class_school_names[0]->school,
                "class_name"            => $get_class_school_names[0]->class,
                "teachers"              => $get_school_class_teachers,
                "total_students"        => $get_total_students[0]->total_students,
                "month"                 => $Month_array[$month_no],
                "holiday_recored"       => $get_holiday,
                'weekend'               => $weekend[0]['value'],
                "attendance_detail"     => $get_attendance_detail_array,
                "month_total_days"      => $month_total_days,  

                ); 

        }else{
            
             $Attendance_summery = array();
             return response()->json(['message'=>'fail']);
        }

        return view("super-admin/ajax_pages/get_monthly_individual_report_for_view_attendance",['attendance'=>$Attendance_summery,'month_year_class_school_id'=>$data]);

    }

    /*Get report of monhtly individual */
    public function get_report_monthly_individual(Request $request){

         /*this code for set month and year for get attendance recoreds*/             
        $month_year     = substr($request['month_year'],3,5);
        $month_year[4]  = "-";
        $month_year     .=  substr($request['month_year'],0,2);

        /*this code for set month and year for get attendance recoreds*/             
        $month_year     = substr($request['month_year'],3,5);
        $month_year[4]  = "-";
        $month_year     .=  substr($request['month_year'],0,2);
        $class_school_id =  $request['class_school_id'];

        $data =  array(
            "month_year"            => $request['month_year'],
            "class_school_id"      => $request['class_school_id'],

        );

        $holiday_recored = array();
        $month_total_days = array();

        $month = substr($month_year,5,2);
        $year = substr($month_year,0,4);
        $number = cal_days_in_month(CAL_GREGORIAN,$month,$year); // 31
        for($d=1; $d<=$number; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);          
            if (date('m', $time)==$month)       
                $month_total_days[]=date('Y-m-d', $time);
        }


            
        /*Get monthly attendance recored day by day by class_school_id and month and year*/
        $get_class_attendance = Sms_attendance::get_attendance_recoreds_monthly_per_day_attendance_info_by_class_school_id($request['class_school_id'],$month_year);
        

        /*This condion check for if this attendance takened the get recoreds*/
        if( isset($get_class_attendance[0]->id) && $get_class_attendance[0]->id > 0 ){

             /*Get school name and class  name by school class id */
            $get_class_school_names = Class_school::get_school_name_and_class_name_by_class_school_id($class_school_id);

            /*Get class school teachers by class_school_id for view attendance*/
            $get_school_class_teachers = Sms_class_role_user::get_school_class_teachers_by_class_school_id($class_school_id);
        
            /*Get count total students in school class by class_school_id*/
            $get_total_students = Sms_student::get_count_total_students_by_class_school_id($class_school_id,$month_year);   

            /*Get weekend value */
            $weekend = Sms_setting::where('status', '=', 1)
                                ->where('key', '=', 'Weekend')
                                ->get(['value'])->toArray();

                        
      
             /*Get holiday information for view attendance by school id and attendance id */    
             $get_holiday = Sms_holiday::get_holiday_information_for_view_attendance_by_school_id_and_class_attendance_date($get_class_school_names[0]->school_id,$get_class_attendance[0]->created_date);


            /*Code for get attendance detail*/
            foreach ($get_class_attendance as $key => $get_attendance) {

                /*Get attendance taken by teacher by attendance id */
                $get_taken_by_teachers = Sms_class_role_user::get_teacher_of_taken_by_attendance_by($get_attendance->id);

                /*Get get present students by attendance id*/
                $get_present_students = Sms_attendance::get_present_students_by_attendacne_id($get_attendance->id);

                /*Get get absent students by attendance id*/
                $get_absent_students  = Sms_attendance::get_absent_students_by_attendacne_id($get_attendance->id);


                /*Get all students  by attendance id */
                $get_all_students = Sms_student::get_all_students_by_attendance_id($get_attendance->id);


                    $total_count_student = 0;
                     foreach ($get_all_students as $key => $value) {
                        $total_count_student++;

                        if($value->attendance_status == 0){
                            
                            $get_absent_resion =  DB::select("SELECT `sms_student_attendance_detail`.`reason`
                                    FROM `sms_attendances` ,`sms_student_attendance_detail`             
                                    WHERE `sms_attendances`.`status` = 0
                                    AND `sms_student_attendance_detail`.`sms_attendance_id` =".$value->id." ");
                            $get_all_students[$key]->resion = $get_absent_resion[0]->reason;
                         }



                        /*Get school name with school id  in small alphabets for create a school folder name */
                        $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($get_class_school_names[0]->school_id,$get_class_school_names[0]->school);
                        $class_name = Sms_class::get_class_name_to_make_student_images_folder($get_class_school_names[0]->class);
                         
                        /*code for get student image path with every year */  
                        $image =  $get_all_students[$key]->student_image;
                        $get_all_students[$key]->student_image = "/storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".substr($month_year,0,4)."/".$image;
                        
                    
                     }


                /*store all attendance recored of one day store in get_attendance_detail_array array */  
                $array[$key]['date'] =  $get_attendance->created_date;
                $array[$key]['attendance_taken_by'] = $get_taken_by_teachers[0]->teacher_name." ".$get_taken_by_teachers[0]->last_name;
                $array[$key]['class_total_students'] = $total_count_student;
                $array[$key]['present_students'] = $get_present_students[0]->present_students;
                $array[$key]['absent_students'] = $get_absent_students[0]->absent_students;
                $array[$key]['students_info'] = (array) $get_all_students;
                $total_count_student = 0;
                
                $get_attendance_detail_array[] = $array;       
                
            }

           

            $Month_array = array(
                "01"   =>'January', 
                "02"   =>'February', 
                "03"   =>'March', 
                "04"   =>'April', 
                "05"   =>'May', 
                "06"   =>'June', 
                "07"   =>'July', 
                "08"   =>'August', 
                "09"   =>'September', 
                "10"  =>'October', 
                "11"  =>'November', 
                "12"  =>'December',
            );
            //get month 
            $month_no = substr($month_year,5,2); 
            
                /*store monthly recored day by day in Attendance_summery array */
                $Attendance_summery = array(

                "school_name"           => $get_class_school_names[0]->school,
                "class_name"            => $get_class_school_names[0]->class,
                "teachers"              => $get_school_class_teachers,
                "total_students"        => $get_total_students[0]->total_students,
                "month"                 => $Month_array[$month_no],
                "holiday_recored"       => $get_holiday,
                'weekend'               => $weekend[0]['value'],
                "attendance_detail"     => $get_attendance_detail_array,
                "month_total_days"      => $month_total_days,  

                );
            
               
        }else{
            
            return response()->json(['message'=>'fail']);
        }

        return view("super-admin/report/report_monhtly_individual",['attendance'=>$Attendance_summery]);


    }


    /*Date Range Average Report*/
    public function generate_average_attendance_report_by_school_id_date_range(Request $request)
    {
        $date_from  =  date('Y-m-d',strtotime($request->from_date));
        $date_to    =  date('Y-m-d',strtotime($request->to_date));
        $all_attendance = array();
        
        
        /*Get All School Teachers*/
        $school_teachers = Sms_school_role_user::get_teachers_of_school($request->school_id);
        
        
        /*Get All Class Students*/
        $school_classes = Class_school::get_school_classes_by_school_id_without_status($request->school_id);
            
        
        if(!empty($school_classes))
        {
            $total_working_days = 0;
            
            foreach($school_classes as $class)
            {
                
                $absent_days   = 0;
                $present_days  = 0;
            
                /*Count Total Class Students*/
                $class_students = Sms_class_role_user::get_students_by_class_school_id($class->class_school_id);
                
                /*Get Total Working Days*/
                $result_total_working_days = Sms_attendance::count_total_working_days_by_class_school_id_date_range($class->class_school_id,$date_from,$date_to);
                
                if(!empty($result_total_working_days))
                {
                   $total_working_days =  count($result_total_working_days);
                
                    
                $result_absent_days = Sms_attendance::get_attendance_by_class_school_id_date_range($class->class_school_id,$date_from,$date_to,0);
                $result_present_days=  Sms_attendance::get_attendance_by_class_school_id_date_range($class->class_school_id,$date_from,$date_to,1);
                
                    
                if(!empty($result_absent_days))
                {
                   $absent_days  =$result_absent_days[0]->total_days; 
                }    
                    
                if(!empty($result_present_days))
                {
                    $present_days =$result_present_days[0]->total_days;
                }    
                 
                $all_attendance[$class->class_school_id] = array("class"=>$class->class,"total_class_students"=>count($class_students),"total_working_days"=>$total_working_days,"present_days"=>$present_days,"absent_days"=>$absent_days);
                
                }
            }    
        }
            
        if(!empty($all_attendance))
        {
        
            return view("super-admin/ajax_pages/generate_average_attendance_report_by_school_id_date_range",['all_attendance'=>$all_attendance,"school_name"=>$request->school_name,"school_teachers"=>$school_teachers,"date_from"=>$date_from,"date_to"=>$date_to,"school_id"=>$request->school_id]);
        }
        else
        {
            return response()->json(["message"=>'fail',"school_name"=>$request->school_name,"date_from"=>$request->from_date,"date_to"=>$request->to_date]);
        }
        
    }
    
    /*Generate Excel Average Attendance Report Date Range*/
    public function generate_excel_average_report_date_range(Request $request)
    {
        
        $school_id  = $request['school_id'];
        $school_name= $request['school_name'];
        $date_from  = $request['date_from'];
        $date_to    = $request['date_to'];
        
        $all_attendance = array();
        
        /*Get All School Teachers*/
        $school_teachers = Sms_school_role_user::get_teachers_of_school($school_id);
        
        /*Get All Class Students*/
        $school_classes = Class_school::get_school_classes_by_school_id_without_status($school_id);    
        
        if(!empty($school_classes))
        {
            $total_working_days = 0;
            
            
            foreach($school_classes as $class)
            {
                
            $absent_days   = 0;
            $present_days  = 0;
            
                /*Count Total Class Students*/
                $class_students = Sms_class_role_user::get_students_by_class_school_id($class->class_school_id);
                
                /*Get Total Working Days*/
                $result_total_working_days = Sms_attendance::count_total_working_days_by_class_school_id_date_range($class->class_school_id,$date_from,$date_to);
                
                if(!empty($result_total_working_days))
                {
                   $total_working_days =  count($result_total_working_days);
                
                    
                $result_absent_days = Sms_attendance::get_attendance_by_class_school_id_date_range($class->class_school_id,$date_from,$date_to,0);
                $result_present_days=  Sms_attendance::get_attendance_by_class_school_id_date_range($class->class_school_id,$date_from,$date_to,1);
                
                    
                if(!empty($result_absent_days))
                {
                   $absent_days  =$result_absent_days[0]->total_days; 
                }    
                    
                if(!empty($result_present_days))
                {
                    $present_days =$result_present_days[0]->total_days;
                }    
                 
                $all_attendance[$class->class_school_id] = array("class"=>$class->class,"total_class_students"=>count($class_students),"total_working_days"=>$total_working_days,"present_days"=>$present_days,"absent_days"=>$absent_days);
                
                }
            }    
        }
            
            return view("super-admin/report/report_average_date_range",['all_attendance'=>$all_attendance,"school_name"=>$request->school_name,"school_teachers"=>$school_teachers,"date_from"=>$date_from,"date_to"=>$date_to,"school_id"=>$request->school_id]);
    }

    /*Get Yearly Attendance Report*/
    public function get_yearly_attendance_report(Request $request)
    {
               
            $full_year = (int)$request->yearly_date;
            $class_school_id = (int)$request->class_school_id;
            $school_id = (int)$request->school_id;
            $year = '%'.$full_year.'%';
            $total_months_of_year = 12;
            $total_working_days_year = 0;

            $folder_school_name = Sms_school::get_school_name_to_make_school_name_folder($request->school_id,$request->school_name);

            $folder_class_name = Sms_class::get_class_name_to_make_student_images_folder($request->class_name); 

            $attendance = Sms_attendance::get_monthly_combine_attendance($class_school_id,$year); 
        
            $calendar_dates = array(); 
            $all_attendance = array();
            $myattendance = array();

            for($i=1; $i<=12; $i++)
                {
                  $calendar_dates[]= $full_year.'-'.$i;
                }

                for($i=0; $i<=isset($calendar_dates[$i]); $i++)
                {

                    $month_attendance = Sms_attendance::get_yearly_attendance_report($class_school_id,date('Y-m',strtotime($calendar_dates[$i])));
                    $month_present_attendance = Sms_attendance::get_attendance_by_class_school_id_with_status($class_school_id,date('Y-m',strtotime($calendar_dates[$i])),1);
                    
                     $total_days_of_month = cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($calendar_dates[$i])),$full_year);
                     $total_working_days_year += $total_days_of_month;
                    $all_attendance[date('Y-m',strtotime($calendar_dates[$i]))] =array(
                        "total_attendance"=>$month_attendance,
                        "total_days_of_month"=>$total_days_of_month,
                        "month_present_attendance"=>$month_present_attendance,
                        
                    );

                }

                foreach ($attendance as $key => $value) 
                 {
                     $myattendance[$value->id]['profile_picture'] = 'storage/schools/'.$folder_school_name.'/'.$folder_class_name.'/'.$full_year."/".$value->student_image;
                    $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name.' ( '.$value->gender.' )';
                    $myattendance[$value->id]['student_combine_image'] = $value->student_image;
                    
                   
                    $created_date = date('Y-n',strtotime($value->created_date));
                    

                    if($created_date == $calendar_dates[0])
                    {
                       
                      $myattendance[$value->id]['jan'][$value->created_date] = $value->status;
                        
                    }
                    if($created_date == $calendar_dates[1])
                    {
                        
                     $myattendance[$value->id]['feb'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[2])
                    {
                        
                     $myattendance[$value->id]['mar'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[3])
                    {
                        
                     $myattendance[$value->id]['apr'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[4])
                    {
                       
                     $myattendance[$value->id]['may'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[5])
                    {
                       
                     $myattendance[$value->id]['jun'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[6])
                    {
                        $myattendance[$value->id]['jul'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[7])
                    {
                       
                     $myattendance[$value->id]['aug'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[8])
                    {
                        
                     $myattendance[$value->id]['sep'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[9])
                    {
                       
                     $myattendance[$value->id]['oct'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[10])
                    {
                       
                     $myattendance[$value->id]['nov'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[11])
                    {
                       
                     $myattendance[$value->id]['dec'][$value->created_date] = $value->status;   
                    }

                }
               if(!empty($myattendance))
               {
                     return view('super-admin/ajax_pages/get_yearly_attendance_report',['all_attendance'=>$all_attendance,'total_working_days_year'=>$total_working_days_year,'myattendance'=>$myattendance,'full_year'=>$full_year,'class_school_id'=>$class_school_id,'school_id'=>$school_id,'school_name'=>$request->school_name,'class_name'=>$request->class_name]);
               }
               else
               {
                    return response()->json([
                        'message'=>'fail',
                        'year'=>$full_year,
                    ]);

               }
    }

    /*Generate Yearly Attendance Report*/
    public function generate_yearly_attendance_report(Request $request)
    {
            

            $full_year = (int)$request->yearly_date;
            $class_school_id = (int)$request->class_school_id;
            $school_id = (int)$request->school_id;
            $year = '%'.$full_year.'%';
            $total_months_of_year = 12;
            $total_working_days_year = 0;

             $attendance = Sms_attendance::get_monthly_combine_attendance($class_school_id,$year);

             $calendar_dates = array(); 
            $all_attendance = array();

            for($i=1; $i<=12; $i++)
                {
                  $calendar_dates[]= $full_year.'-'.$i;
                }

             for($i=0; $i<=isset($calendar_dates[$i]); $i++)
            {

                $month_attendance = Sms_attendance::get_yearly_attendance_report($class_school_id,date('Y-m',strtotime($calendar_dates[$i])));

                $month_present_attendance = Sms_attendance::get_attendance_by_class_school_id_with_status($class_school_id,date('Y-m',strtotime($calendar_dates[$i])),1);
                
                 $total_days_of_month = cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($calendar_dates[$i])),$full_year);
                 $total_working_days_year += $total_days_of_month;
                $all_attendance[date('Y-m',strtotime($calendar_dates[$i]))] =array(
                    "total_attendance"=>$month_attendance,
                    "total_days_of_month"=>$total_days_of_month,
                    "month_present_attendance"=>$month_present_attendance,
                    
                );

            }

            foreach ($attendance as $key => $value) 
            {
                     
                    $myattendance[$value->id]['full_name'] = $value->first_name.' '.$value->last_name.' ( '.$value->gender.' )';
                    $myattendance[$value->id]['student_combine_image'] = $value->student_image;
                    
                   
                    $created_date = date('Y-n',strtotime($value->created_date));
                    

                    if($created_date == $calendar_dates[0])
                    {
                       
                      $myattendance[$value->id]['jan'][$value->created_date] = $value->status;
                        
                    }
                    if($created_date == $calendar_dates[1])
                    {
                        
                     $myattendance[$value->id]['feb'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[2])
                    {
                        
                     $myattendance[$value->id]['mar'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[3])
                    {
                        
                     $myattendance[$value->id]['apr'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[4])
                    {
                       
                     $myattendance[$value->id]['may'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[5])
                    {
                       
                     $myattendance[$value->id]['jun'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[6])
                    {
                        $myattendance[$value->id]['jul'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[7])
                    {
                       
                     $myattendance[$value->id]['aug'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[8])
                    {
                        
                     $myattendance[$value->id]['sep'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[9])
                    {
                       
                     $myattendance[$value->id]['oct'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[10])
                    {
                       
                     $myattendance[$value->id]['nov'][$value->created_date] = $value->status;   
                    }
                    if($created_date == $calendar_dates[11])
                    {
                       
                     $myattendance[$value->id]['dec'][$value->created_date] = $value->status;   
                    }

                }
                
                 return view('super-admin/report/generate_yearly_attendance_report',['all_attendance'=>$all_attendance,'total_working_days_year'=>$total_working_days_year,'myattendance'=>$myattendance,'full_year'=>$full_year,'class_school_id'=>$class_school_id,'school_id'=>$school_id,'school_name'=>$request->school_name,'class_name'=>$request->class_name]);
    }
    
    /*Add Modification Days*/
    public function add_modification_days()
    {
        return view('super-admin/add_modification_days');    
    }
   
    /*Add Holiday*/
    public function add_holiday()
    {

        return view('super-admin/add_holiday')->with("holidays");
    }
    
     public function add_holiday_process(Request $request)
    {
        $controls = $request->all();
        $start_date = date("Y-m-d", strtotime(substr($controls['daterangepicker'],0,10)));
        $end_date = date("Y-m-d", strtotime(substr($controls['daterangepicker'],13)));
        $rules = array
               (
                "title"                       => "required",
                "description"                 => "required",
                "daterangepicker"             =>"required",
                );
            
            $messages = [
            'title.required'       => 'Please enter holiday :attribute',
            'description.required' => 'Please enter holiday :attribute',
            'daterangepicker.required'=>'please enter holiday date range'
            ];
            
            $validator  = Validator::make($controls, $rules,$messages);
            
            if($validator->fails())
             {
                  return redirect("/super_admin/add_holiday")->withErrors($validator);
             }      
            else
            {
                $role_user_id = Sms_user::get_current_user_logined_sms_role_user_id();

            $data = array(
                'sms_role_user_id' => $role_user_id,
                'title'       => $controls['title'],
                'description' => $controls['description'],
                'start_date'  =>$start_date,
                'end_date'    =>$end_date,
                'status'      =>$controls['status'],
            );
            $result = Sms_holiday::create($data);

                       if($result)
                       {
                            return redirect("/super_admin/add_holiday")->with('holiday_success','New Holiday : '.ucfirst($request['title']).' Has Been Added Successfully!...');
                       }
                        else{
                            return redirect("/super_admin/add_holiday")->with('holiday_fail','Something Went Wrong Please Try Again');
                        }
            }
        
    }
       /*View Holidays*/
    public function view_holidays()
    {
        $result = Sms_holiday::all()->toArray();
        return view('super-admin/view_holidays')->with("holidays",$result);
    }

     /*holiday_assign_school*/
    public function holiday_assign_school($id)
    {
        $holidays = Sms_holiday::where('id',$id)->get()->toArray();
        $schools = Sms_school::where("status",1)->get()->toArray();
        
         /*Get School Name Of Current Selected Holiday*/
        $holiday_name = $holidays[0]['title'];
         /*Get School Name Of Current Selected School*/

            /*Get All Schools Of Current Selected Holiday*/
       $holiday_schools = Holiday_school::get_holiday_school_by_holiday_id($id);
           /*Get All Schools Of Current Selected Holiday*/

         $all_holidays = array();
         $all_holiday_school = array();
         $all_schools = array();

        /*Get All Holiday School In Key Value Format*/
        foreach($holiday_schools as $holiday_school)
        {

         $all_holiday_school[$holiday_school->holiday_id] = $holiday_school->title;    
         $all_holidays[$holiday_school->sms_school_id]=$holiday_school->school;
  
        }

        /*Get All Schools In Key Value Format*/
        foreach($schools as $school)
        {   
           $all_schools[$school['id']] = $school['school']; 
        }
        return view('super-admin/assign_holiday_school',["all_holiday_school"=>$all_holiday_school,"all_schools"=>$all_schools,"holiday_schools"=>$holiday_schools,"holiday_name"=>$holiday_name,'all_holidays'=>$all_holidays,"holidays"=>$holidays]);
    }

    
    public function holiday_assign_school_process(Request $request)
    {
        $controls = $request->all();
           
        if(isset($request->previous_school_ids))
        {
           $result_new_classes_ids = array_diff($request->new_school_ids,$request->previous_school_ids);
        }
        else
        {
                $result_new_classes_ids=$request->new_school_ids;
        }

          $count = 0;
        foreach($result_new_classes_ids as $new_school_id)
        {
            $flag=false;
            $insert = Holiday_school::assign_holiday_to_school($new_school_id,$request->holiday_id);
        
        if($insert)
        {
           $flag=true;
            $count++;
        }    
        else
        {
            $flag=false;
        }

    }

    if($flag)
    {
         
        $holidays = Sms_holiday::where('id',$request->holiday_id)->get()->toArray();
        $schools = Sms_school::where("status",1)->get()->toArray();
        
        $holiday_name = $holidays[0]['title'];
        
        /*Get All Schools Of Current Selected Holiday*/
        $holiday_schools = Holiday_school::get_holiday_school_by_holiday_id($request->holiday_id);
        /*Get All Schools Of Current Selected Holiday*/

         $all_holidays = array();
         $all_holiday_school = array();
         $all_schools = array();

        /*Get All Holiday School In Key Value Format*/
        foreach($holiday_schools as $holiday_school)
        {

         $all_holiday_school[$holiday_school->holiday_id] = $holiday_school->title;    
         $all_holidays[$holiday_school->sms_school_id]=$holiday_school->school;
  
        }

        /*Get All Schools In Key Value Format*/
        foreach($schools as $school)
        {   
           $all_schools[$school['id']] = $school['school']; 
        }
        return view('super-admin/ajax_pages/get_holidays_for_assigning',["all_holiday_school"=>$all_holiday_school,"all_schools"=>$all_schools,"holiday_schools"=>$holiday_schools,"holiday_name"=>$holiday_name,'all_holidays'=>$all_holidays,"holidays"=>$holidays,"count"=>$count,"message"=>"success"]);
    
        }    
    else
        {
            return response()->json([
                "message"   =>"fail"
            ]);
        }
  }

    public function remove_school_from_existing_holiday_school(Request $request)
    {    
        if(isset($request->new_school_ids))
        {
        
            $result_previous_school_ids = array_diff($request->previous_school_ids,$request->new_school_ids);
         
        }
        else
        {
            $result_previous_school_ids = $request->previous_school_ids;
        }  
            
        $count=0;
        foreach($result_previous_school_ids as $result_previous_school_id)
        {
            $flag=false;
            $delete = Holiday_school::remove_holiday_from_school($result_previous_school_id,$request->holiday_id);

                if($delete)
                {
                    $flag=true;
                    $count++;
                }
                else
                {
                    $flag=false;
                } 
        }

        if($flag)
        {
    
        ?>
            <div class="alert alert-success" id="div_assign_classes_to_school">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                <b>
                <?php 
                if($count==1)
                {
                    $count=$count." School ";
                }
                else if($count>1)
                {
                    $count=$count." Schools";
                }

                echo " ".$request->holiday_title." ( Holiday ) Has Been Removed From ".$count." Successfully!...";
                ?>
                </b>
                <br />
            </div>
        <?php        
        }
        else
        {
        ?>
                <div class="alert alert-warning" id="div_assign_classes_to_school">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    <b>
                        <?php  echo " ".$request->holiday_title." ( Holiday ) Has Not Been Assigned To Schools";?>
                    </b> <br>
                </div>
        <?php
        }  
    }
    
    /* Edit Holiday */
    public function edit_holiday($id)
    {
         $result = Sms_holiday::where('id',$id)->get()->toArray();
         return view('super-admin/edit_holiday')->with("holiday",$result);

    }
    
    /*Update holiday*/
    public function update_holiday(Request $request)
    {
        $controls = $request->all();
        $id = $controls['id'];
        $start_date = date("Y-m-d", strtotime(substr($controls['daterangepicker'],0,10)));
        $end_date = date("Y-m-d", strtotime(substr($controls['daterangepicker'],13)));
        
        $rules = array(
                "title"                       => "required",
                "description"                 => "required",
                "daterangepicker"             =>"required",
                );
            
            $messages = [
            'title.required'       => 'Please enter holiday :attribute',
            'description.required' => 'Please enter holiday :attribute',
            'daterangepicker.required'=>'please enter holiday date range'
            ];
            
            $validator  = Validator::make($controls, $rules,$messages);
            
            if($validator->fails())
             {                
                  return redirect("/super_admin/edit_holiday/$id")->withErrors($validator);
             }
        
            else
            {
                    $data = array(
                    'title'       => $controls['title'],
                    'description' => $controls['description'],
                    'start_date'  =>$start_date,
                    'end_date'    =>$end_date,
                    'status'      =>$controls['status'],
                );
        
                $result = Sms_holiday::where('id',$request->holiday_id)->update($data);
                    if($result)
                    {
                        return redirect("/super_admin/view_holidays")->with('holiday_success','Holiday : '.ucfirst($request['title']).' Has Been Updated Successfully!...');
                    }
                    else
                    {
                        return redirect("/super_admin/view_holidays")->with('holiday_fail','Something Went Wrong Please Try Again');
                    }
            }

    }

         /*Holiday Detail*/
    public function detail_holiday($id)
    {
         $holiday_detail = Sms_holiday::where('id',$id)->first()->toArray();

         $role_user_id = $holiday_detail['sms_role_user_id'];

         $acccount_created_by = Sms_user::get_user_information_with_role_type_by_role_user_id($role_user_id);

         $user_data =  Sms_holiday::get_user_detail_and_role_types_by_user_id($role_user_id);

         $get_holiday_assigned_schools=Holiday_school::get_holiday_assigned_schools($holiday_detail['id']); 

         $result = array(
            "user_data" => $user_data,
            "holidays"=>$holiday_detail,
            "get_holiday_assigned_schools"=>$get_holiday_assigned_schools,
         );
        return view('super-admin/view_holiday_detail')->with($result);
    }
    


    /*Add School*/
    public function add_school()
    {   
        $result_district_operations = DB::select("SELECT * FROM `com_operation_branch`");
        
        $result = array(""=>"-- Select District Operation --");
        foreach($result_district_operations as $result_district_operation)
        {
            $result[$result_district_operation->district_operation_id] = $result_district_operation->district_operation_full_name;
        }
                
        return view('super-admin/add_school',['district_operations'=>$result]);
    }


    /*add_school_process*/
    public function add_school_process(Request $request){
        $controls  = $request->all();
         
        
        $rules = array(
            "district_operation"                    => "required",
            "school"                                => "required|unique:sms_schools",
            "email"                                 => "required|email|unique:sms_schools",
            "school_number"                         => "required",
            "school_address"                        => "required",
            "school_description"                    => "required",
            "school_status"                         => "required",
            );
        
        
        $messages = [
            'district_operation.required' => 'Please select :attribute',
            'school.required' => 'Please enter :attribute',
            'email.required' => 'Please enter :attribute',
            'school_number.required' => 'Please enter :attribute',
            'school_address.required' => 'Please enter :attribute',
            'school_description.required' => 'Please enter :attribute',
            'school_status.required' => 'Please enter :attribute',
        ];
        
        
        $data = array(
                "district_operation_id"         =>$controls['district_operation'],
                "school"                        =>$controls['school'],
                "school_description"            =>$controls['school_description'],
                "phone_number"                  =>$controls['school_number'],
                "email"                         =>$controls['email'],
                "address"                       =>$controls['school_address'],
                "status"                        =>$controls['school_status'],
        );
        
    
        $validator  = Validator::make($controls, $rules,$messages);
        if($validator->fails())
        {
            
            return redirect("/super_admin/add_school")->withInput($request->all())->withErrors($validator);
            
        }
        else
        {
            
            $insert = Sms_school::create($data);
            if($insert){

                    /*create dynamic directory of schools folder*/
                    if(!File::exists("public/schools")) {
                        Storage::makeDirectory("public/schools");
                    }
                    /*Get school name with school id  in small alphabets for create a school folder name */
                    $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($insert->id,$controls['school']);
                    /*create dynamic directory of school name folder*/
                    if(!File::exists("public/schools/".$schools_name_with_id)) {
                        Storage::makeDirectory("public/schools/".$schools_name_with_id);
                    }

                return Redirect::back()->with('insert_message_success','New School: '.$controls['school'].' Has Been Added Successfully!...');
            }else{
                return Redirect::back()->with('insert_message_fail','New School: '.$controls['school'].' Has Not Been Added Successfully!...');
            }
            
            
            
        }
    }
    
    /*View Schools*/
    public function view_schools()
    {
        $result = DB::select("SELECT `sms_schools`.*,`com_operation_branch`.`district_operation_full_name` FROM `sms_schools`,`com_operation_branch` WHERE  
`sms_schools`.`district_operation_id` = `com_operation_branch`.`district_operation_id` ORDER BY `sms_schools`.`id` DESC");
        
        return view('super-admin/view_schools',['schools'=>$result]);
    }
    
     /*View School*/
    public function view_school($id)
    {
        $result  = DB::select("SELECT `sms_schools`.* , `com_operation_branch`.`district_operation_full_name` FROM `sms_schools`,`com_operation_branch` WHERE 
`sms_schools`.`id` = ".$id." AND `com_operation_branch`.`district_operation_id` = `sms_schools`.`district_operation_id`");
        
        return view('super-admin/view_school_detail',['school'=>$result]);
    }
    
    
    /*Edit school form*/
    public function edit_school($id){
        
        $result  = Sms_school::find($id)->toArray();
        
        $district_operations = DB::select("SELECT * FROM `com_operation_branch`");   
        $result_district_operations = array(""=>"-- Select District Operation --");
        foreach($district_operations as $district_operation){
            $result_district_operations[$district_operation->district_operation_id] = $district_operation->district_operation_full_name;
        }
        
        return view('super-admin/edit_school',['school'=>$result,'district_operations'=>$result_district_operations]);
        
    }
    /*edit School process*/
    public function edit_school_process(Request $request){
         $controls  = $request->all();
       
        $rules = array(
            "district_operation"                    => "required",
            "school"                                => "required|unique:sms_schools,school,".$controls["id"],
            "email"                                 => "required|email|unique:sms_schools,email,".$controls["id"],
            "school_number"                         => "required",
            "school_address"                        => "required",
            "school_description"                    => "required",
            "school_status"                         => "required",
            );
        
        
        $messages = [
            'district_operation.required' => 'Please select :attribute',
            'school.required' => 'Please enter :attribute',
            'email.required' => 'Please enter :attribute',
            'school_number.required' => 'Please enter :attribute',
            'school_address.required' => 'Please enter :attribute',
            'school_description.required' => 'Please enter :attribute',
            'school_status.required' => 'Please enter :attribute',
        ];
        
        $validator  = Validator::make($controls, $rules,$messages);
        if($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }
        else
        {
            
            $data = array(
                "district_operation_id"         =>$controls['district_operation'],
                "school"                        =>$controls['school'],
                "school_description"            =>$controls['school_description'],
                "phone_number"                  =>$controls['school_number'],
                "email"                         =>$controls['email'],
                "address"                       =>$controls['school_address'],
                "status"                        =>$controls['school_status'],
            );
            
            $update_status = Sms_school::where("id","=",$controls['id'])->update($data);
            if($update_status){

                 /*This code for rename of school folder name*/

                /*Get school name with school id  in small alphabets for create a school folder name */
                 $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($controls['id'],$controls['school']);
                 $school_old_id        =  Sms_school::get_school_name_to_make_school_name_folder($controls['id'],$controls['school_old']);
                /*check directory then  school folder remane */
                if(!File::exists("public/schools/".$school_old_id)) {
                    /*rename of school folder name*/
                    $d = rename("storage/schools/".$school_old_id,"storage/schools/".$schools_name_with_id);
                 }
                /*End school folder name*/    


                return redirect("/super_admin/view_schools")->with('edit_message_success',"School: ".$controls['school'].' Has Been Updated Successfully!...');
            }else{
                return redirect("/super_admin/view_schools")->with('edit_message_fail',"School: ".$controls['school'].' Has Not Been Updated Successfully!...');
            }
            
            
            
        }
        
        
    }


    //====== START USERS ======

    /* ADD USER */
    public function add_user()
    {
        $items = Sms_qualification::where('status', 1)->orderBy('id')->pluck('degree_title', 'id')->toArray();

        $myitems = array(
            ''   =>     "-- Select Qualification --",
        );
        foreach ($items as $key => $value) {
            $myitems[$key] = $value;
        }

        $mydata = array(
            "qualifications" => $myitems,
        );

        return view ('super-admin/add_user',$mydata);
    }

    /* ADD USER PROCESS */
    public function add_user_process(Request $request)
    {
        $controls  = $request->all();
        
        $rules = array(
            "qualification"     => "required",
            "first_name"        => "required",
            "last_name"         => "required",
            "email"             => "required|email|unique:sms_users",
            "password"          => "required|min:8|max:20",
            "conform_password"  => "required|same:password",
            "contact_number"    => "required",
            "address"           => "required",
            "profile_image"     => "required|image|mimes:jpeg,png,jpg,gif",
            );
        
        $messages = [
            'qualification.required' => 'Please select :attribute',
            'first_name.required' => 'Please enter :attribute',
            'last_name.required' => 'Please enter :attribute',
            'email.required' => 'Please enter :attribute',
            'password.required' => 'Please enter :attribute',
            'conform_password.required' => 'Please enter :attribute',
            'contact_number.required' => 'Please enter :attribute',
            'address.required' => 'Please enter :attribute',
            'profile_image.required' => 'Please upload :attribute',
            'email.email' => 'Please enter :attribute in correct format',
            'password.min' => 'Minimum length of :attribute is 8',
            'password.max' => 'Maximum length of :attribute is 20',
            'conform_password.same' => 'Conform password must match with password',
        ];
        
        $validator  = Validator::make($controls, $rules,$messages);
        if($validator->fails())
        {
            return redirect("/super_admin/add_user")->withErrors($validator);
        }
        else
        {
            $first_name = $controls['first_name']; 
            $last_name = $controls['last_name']; 
            $middle_name = "";
            $profile_image = "";

            $user_id = Auth::user()->id;

            $role_id = session('role_id');

            $result = DB::select("Select * from sms_role_user where sms_user_id=$user_id AND sms_role_id=$role_id");
            
            if(isset($controls['middle_name']) && $controls['middle_name'] != "")
            {
                $middle_name = $controls['middle_name'];
            }

            $data1 = array(
                "sms_qualification_id"  =>  $controls['qualification'],
                "sms_role_user_id"      =>  $result['0']->id,
                "first_name"            =>  $controls['first_name'],
                "middle_name"           =>  $middle_name,
                "last_name"             =>  $controls['last_name'],
                "email"                 =>  $controls['email'],
                "password"              =>  bcrypt($controls['conform_password']),
                "contact_number"        =>  $controls['contact_number'],
                "gender"                =>  $controls['gender'],
                "address"               =>  $controls['address'],
                "status"                =>  $controls['status'],
                "profile_image"         =>  $profile_image,
            );

            $result = Sms_user::create($data1);

            $lastId = $result->id;

            $mimetype = $request->file("profile_image")->getClientOriginalExtension();

            if(isset($controls['middle_name']) && $controls['middle_name'] != "")
            {
                $img_name = $lastId."_".$first_name."_".$middle_name."_".$last_name.".".$mimetype;
            }
            else
            {
                $img_name = $lastId."_".$first_name."_".$last_name.".".$mimetype;
            }

            Storage::putFileAs("public/user_profile_images", $request->file("profile_image"), $img_name);

            $full_name = $first_name." ".$last_name; 

            $data = array(
                "profile_image" => $img_name,
            );

            $user_insert = Sms_user::where("id","=",$lastId)->update($data);

            if($user_insert)
            {
                return redirect("super_admin/add_user")->with(array("add_user_success_message"=>"New User: $full_name Has Been Added Successfully!..."));
            }
            else
            {
                return redirect("super_admin/add_user")->with(array("add_user_fail_message"=>"New User: $full_name Has Not Been Added!..."));
            }

        }
    }

    /* VIEW USERS */
    public function view_users()
    {
        $users = Sms_user::all()->toArray();
        $myarray1 = array();

        foreach ($users as $key => $value) 
        {
            $userbyrole = Sms_holiday::get_user_detail_and_role_types_by_user_id($value['sms_role_user_id']);

                if(!empty($userbyrole))
                {
                    $users[$key]['create_by_name'] = $userbyrole[0]->first_name;
                    $users[$key]['account_created_by_role_type'] = $userbyrole[0]->role_type;
                }
        
                
        }          
            
        $data = array(
            "myusers"   => $users,
        );

        return view('super-admin/view_users',$data);
    }

    /* VIEW USER DETAIL */
    public function view_user_detail($id)
    {
        $user_info = Sms_user::where("id", "=", $id)->get()->toArray();
        $qualification = Sms_user::get_user_qualification($user_info['0']['sms_qualification_id']);
        $user_roles = Sms_user::get_all_user_roles_without_status($id);
        $acccount_created_by = Sms_user::get_user_information_with_role_type_by_role_user_id($user_info['0']['sms_role_user_id']);

        $user_schools = Sms_user::get_user_schools($id);

        $user_schools_without_status = Sms_user::get_user_schools_without_status($id);

        
        $myuser_schools = array();
        if($user_schools)
        {
            foreach ($user_schools as $school) 
            {
                if($school->role_id == 2)
                {
                    $myuser_schools[$school->role_id][] = $school->school;
                }
                else
                {
                    $myuser_schools[$school->role_id][] = $school->school;
                }
            }
        }

        if($id == 1)
        {
            $disable_to_inactive_role = "Yes";
        }
        else
        {
            $disable_to_inactive_role = "No";   
        }

        $data = array(
            "user_info"     =>  $user_info,
            "qualification" =>  $qualification,
            "user_roles"    =>  $user_roles,
            "created_by"    =>  $acccount_created_by,
            "user_schools"  =>  $myuser_schools,
            "user_schools_without_status"   => $user_schools_without_status,
            "user_id"       =>  $id 
        );

        return view("/super-admin/view_user_detail",$data);
    }

    /* EDIT USER */
    public function edit_user($id)
    {
        $items = Sms_qualification::where('status', 1)->orderBy('id')->pluck('degree_title', 'id')->toArray();
        $myitems = array(
            ''   =>     "-- Select Qualification --",
        );
        foreach ($items as $key => $value) {
            $myitems[$key] = $value;
        }

        $users = Sms_user::where("id", "=", $id)->get()->toArray();
       
        
        $mydata = array(
            "qualifications"    =>  $myitems,
            "myusers"           =>  $users,
        );

        return view ("super-admin/edit_user",$mydata);
    }

    /* EDIT USER PROCESS */
    public function edit_user_process(Request $request)
    {
        $controls = $request->all();

 
        $rules = array(
            "qualification"     => "required",
            "first_name"        => "required",
            "last_name"         => "required",
            "email"             => "required|email|unique:sms_users,email,".$controls["id"],
            "contact_number"    => "required",
            "address"           => "required",
            );
        
        $messages = [
            'qualification.required'    => 'Please select :attribute',
            'first_name.required'       => 'Please enter :attribute',
            'last_name.required'        => 'Please enter :attribute',
            'email.required'            => 'Please enter :attribute address',
            'contact_number.required'   => 'Please enter :attribute',
            'address.required'          => 'Please enter :attribute',
            'email.email'               => 'Please enter a valid email address',
            'email.unique'              => 'Email Address Already Exists',

        ];
       
        $validator  = Validator::make($controls, $rules,$messages);
        
        if($validator->fails())
        {
            return redirect("/super_admin/edit_user/$id")->withErrors($validator);
        }
        else
        {
            $middle_name = "";
            if(isset($controls['profile_image']))
            {
                $mimetype = $request->file("profile_image")->getClientOriginalExtension();

                if($controls['middle_name'] != null)
                {
                    $middle_name = $controls['middle_name'];

                    $user_name = $controls['first_name'].' '.$middle_name.' '.$controls['last_name'];

                    $img_name = $controls['id']."_".$controls['first_name']."_".$middle_name."_".$controls['last_name'].".".$mimetype;
                }
                else
                {
                    $user_name = $controls['first_name'].' '.$controls['last_name'];

                    $img_name = $controls['id']."_".$controls['first_name']."_".$controls['last_name'].".".$mimetype;
                }

                Storage::putFileAs("public/user_profile_images", $request->file("profile_image"), $img_name);

                if(isset($controls['status']))
                {
                    $data1['status']=$controls['status'];
                }

                $data1 = array(
                    "sms_qualification_id"  =>  $controls['qualification'],
                    "first_name"            =>  $controls['first_name'],
                    "middle_name"           =>  $middle_name,
                    "last_name"             =>  $controls['last_name'],
                    "email"                 =>  $controls['email'],
                    "gender"                =>  $controls['gender'],
                    "address"               =>  $controls['address'],
                    'profile_image'         =>  $img_name,
                );

                
                $result = Sms_user::where("id", "=", $controls['id'])->update($data1);

                if($result)
                {
                    return redirect('/super_admin/view_users')->with("user_update_success_message","User: $user_name Has Been Updated Successfully!...");
                }
                else
                {
                    return redirect('/super_admin/view_users')->with("user_update_fail_message","User: $user_name Has Not Been Updated!...");
                }
            }
            else
            {
                if($controls['middle_name'] != null)
                {
                    $middle_name = $controls['middle_name'];

                    $user_name = $controls['first_name'].' '.$middle_name.' '.$controls['last_name'];
                }
                else
                {
                    $user_name = $controls['first_name'].' '.$controls['last_name'];
                }

                if(isset($controls['status']))
                {
                    $data1['status']=$controls['status'];
                }
                
                $data1 = array(
                    "sms_qualification_id"  =>  $controls['qualification'],
                    "first_name"            =>  $controls['first_name'],
                    "middle_name"           =>  $middle_name,
                    "last_name"             =>  $controls['last_name'],
                    "email"                 =>  $controls['email'],
                    "gender"                =>  $controls['gender'],
                    "address"               =>  $controls['address'],
                );

                
                $result = Sms_user::where("id", "=", $controls['id'])->update($data1);
                if($result)
                {
                    return redirect('/super_admin/view_users')->with("user_update_success_message","User: $user_name Has Been Updated Successfully!...");
                }
                else
                {
                    return redirect('/super_admin/view_users')->with("user_update_fail_message","User: $user_name Has Not Been Updated!...");
                }
            }
        }
    }
    
	/// ASSIGN ROLE (START)
	
	/*It Return the View of Assign Role*/
    public function assign_role($id)
    {
        $user = Sms_user::where("id","=",$id)->get()->toArray();

        $schools = Sms_school::where("status","=",1)->orderby('id',"ASC")->get()->toArray();

        $result = Sms_role::where("status","=",1)->orderby('id',"ASC")->get()->toArray();

        $admin_schools = Sms_role_user::get_schools_by_user_id_and_role_id($id,2);
        
        $teacher_schools = Sms_role_user::get_schools_by_user_id_and_role_id($id,3);

        $adminSchools = array();

        foreach ($schools as $key => $value) 
        {
            $adminSchools[$value['id']] = $value['school'];
        }

        if($admin_schools)
        {
            foreach ($admin_schools as $admin_school) 
            {    
                foreach ($adminSchools as $key => $school) 
                {
                    if($key == $admin_school->sms_school_id)
                    {
                       unset($adminSchools[$key]);
                    }
                }
            }
        }

        $teacherSchools = array();

        foreach ($schools as $key => $value) 
        {
            $teacherSchools[$value['id']] = $value['school'];
        }

        if($teacher_schools)
        {
            foreach ($teacher_schools as $teacher_school) 
            {    
                foreach ($teacherSchools as $key => $school) 
                {
                    if($key == $teacher_school->sms_school_id)
                    {
                       unset($teacherSchools[$key]);
                    }
                }
            }
        }

        $roles_data = array(
            "myroles"           => $result,
            "id"                => $id,
            "admin_schools"     => $adminSchools,
            "teacher_schools"   => $teacherSchools,
            "user"              => $user,
        );

        return view("super-admin/assign_role",$roles_data);
    }

    /*Assign Super Admin Role to User*/
    public function assign_super_admin_role(Request $request)
    {
        $insert = Sms_role_user::assign_super_admin_role($request->user_id,$request->role_id);
        
        if($insert)
        {
            if($insert === "Already_Assigned")
            {
                ?>
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <b>Role Type: Super Admin Already Assigned!...</b>
                    </div>
            <?php
            }
            else
            {
                ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    <b>Role Type: Super Admin Has Been Assigned Successfully!...</b>
                </div>
            <?php
            }
        }
        else
        {
            ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    <b>Role Type: Super Admin Has Not Been Assigned!...</b>
                </div>
        <?php
        }
    }

    /*Assign School Admin OR School Teacher Role to User*/
    public function assign_school_admin_role(Request $request)
    {
        $insert = Sms_role_user::assign_role_school_admin_or_teacher($request->user_id,$request->role_id,$request->school_id);

        if($insert)
        {
            if($request->role_id == 2)
            {
                $role_type = "School Admin";
            }
            else
            {
                $role_type = "School Teacher";
            }

            if($insert === "Already_Assigned")
            {
                ?>
                <div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type:
        <?php echo $role_type; ?> Already Assigned AND New Schools Assigned Successfully!...</b>
</div>
                <?php
            }
            else
            {
                ?>
                    <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type:
        <?php echo $role_type; ?> Has Been Assigned Successfully!...</b>
</div>
                <?php
            }   
        }
        else
        {
            ?>
                <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type:
        <?php echo $role_type; ?> Has Not Been Assigned!...</b>
</div>
            <?php
        }
    }

    /*Assign Super Admin AND School Admin Role to User*/
    public function assign_super_admin_and_school_admin_role(Request $request)
    {
        $role_ids = array(
            "role_id_super_admin"   => $request->role_id_super_admin,
            "role_id_school_admin"  => $request->role_id_school_admin
        );

        $insert = Sms_role_user::assign_super_admin_and_admin_or_teacher_role($request->user_id,$role_ids,$request->schools);

        if($insert)
        {
            ?>
                <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type: Super Admin and School Admin Has Been Assigned Successfully!...</b>
</div>
            <?php
        }
        else
        {
            ?>
                <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type: Super Admin and School Admin Has Not Been Assigned!...</b>
</div>
            <?php
        }
    }

    /*Assign Super Admin AND School Teacher Role to User*/
    public function assign_super_admin_and_school_teacher_role(Request $request)
    {
        $role_ids = array(
            "role_id_super_admin"   => $request->role_id_super_admin,
            "role_id_school_teacher"   => $request->role_id_school_teacher,
        );

        $insert = Sms_role_user::assign_super_admin_and_admin_or_teacher_role($request->user_id,$role_ids,$request->schools);

        if($insert)
        {
            ?>
                <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type: Super Admin and School Teacher Has Been Assigned Successfully!...</b>
</div>
            <?php
        }
        else
        {
            ?>
                <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type: Super Admin and School Teacher Has Not Been Assigned!...</b>
</div>
            <?php
        }
    }

    /*Assign School Admin AND School Teacher Role to User*/
    public function assign_school_admin_and_school_teacher_role(Request $request)
    {
        $roles = array(
            "role_id_school_admin"      =>  $request->role_id_school_admin,
            "role_id_school_teacher"    =>  $request->role_id_school_teacher,
        );

        $insert = Sms_role_user::assign_school_admin_and_school_teacher_role($request->user_id,$roles,$request->schools_admin,$request->schools_teacher);

        if($insert)
        {
            ?>
                <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type: School Admin and School Teacher Has Been Assigned Successfully!...</b>
</div>
            <?php
        }
        else
        {
            ?>
                <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type: School Admin and School Teacher Has Not Been Assigned!...</b>
</div>
            <?php
        }
    }

    /*Assign All Three Roles Super Admin, School Admin and School Teacher to User*/
    public function assign_super_admin_school_admin_and_teacher_roles_to_user(Request $request)
    {
        $roles = array(
            "role_id_super_admin"       =>  $request->role_id_super_admin,
            "role_id_school_admin"      =>  $request->role_id_school_admin,
            "role_id_school_teacher"    =>  $request->role_id_school_teacher,
        );

        $insert = Sms_role_user::assign_super_admin_school_admin_and_teacher_roles_to_user($request->user_id,$roles,$request->schools_admin,$request->schools_teacher);

        if($insert)
        {
            ?>
                <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type: Super Admin, School Admin and School Teacher Has Been Assigned Successfully!...</b>
</div>
            <?php
        }
        else
        {
            ?>
                <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type: Super Admin, School Admin and School Teacher Has Not Been Assigned!...</b>
</div>
            <?php
        }
    }

    ///ASSIGN ROLE (END)

    ///START Manage Roles and School For School Admin and School Teacher

    public function super_admin_active_or_deactive(Request $request)
    {
        if($request->flag === "active")
        {
            $update=Sms_role_user::active_super_admin($request->role_user_id);

            if($update)
            {
                ?>
                    <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type: Super Admin Has Been Activated Successfully For
        <?php echo $request->user_name;?>!...</b>
</div>
                <?php
            }
            else
            {
                ?>
                    <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type: Super Admin Has Not Been Activated For
        <?php echo $request->user_name;?>!...</b>
</div>
                <?php
            }
        }
        elseif($request->flag === "inactive")
        {
            $update = Sms_role_user::inactive_super_admin($request->role_user_id);

            if($update)
            {
                ?>
                    <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type: Super Admin Has Been Inactivated Successfully For
        <?php echo $request->user_name;?>!...</b>
</div>
                <?php
            }
            else
            {
                ?>
                    <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>Role Type: Super Admin Has Not Been Inactivated
        <?php echo $request->user_name;?>!...</b>
</div>
                <?php
            }   
        }
    }

    public function active_or_inactive_school_for_admin_or_teacher(Request $request)
    {
        if($request->flag === "active")
        {
            $update = Sms_school_role_user::active_school_for_school_admin_or_teacher($request->school_role_user_id);

            if($update)
            {
                if(isset($request->teacher))
                {
                    ?>
                        <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>School:
        <?php echo $request->school_name;?> Has Been Activated Successfully For School Teacher:
        <?php echo $request->user_name;?>!...</b>
</div>
                    <?php
                }
                else
                {
                    ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <b>School:
                            <?php echo $request->school_name;?> Has Been Activated Successfully For School Admin:
                            <?php echo $request->user_name;?>!...</b>
                    </div>
                    <?php
                }   
            }
            else
            {
                if(isset($request->teacher))
                {
                    ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="ace-icon fa fa-times"></i>
                            </button>
                            <b>School:
                                <?php echo $request->school_name;?> Has Not Been Activated For School Teacher:
                                <?php echo $request->user_name;?>!...</b>
                        </div>
                    <?php
                }
                else
                {
                    ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <b>School:
                            <?php echo $request->school_name;?> Has Not Been Activated For School Admin:
                            <?php echo $request->user_name;?>!...</b>
                    </div>
                    <?php
                }
            }
        }
        elseif($request->flag === "inactive")
        {
            $update = Sms_school_role_user::inactive_school_for_school_admin_or_teacher($request->school_role_user_id);

            if($update)
            {
                if(isset($request->teacher))
                {
                    ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <b>School:
                            <?php echo $request->school_name;?> Has Been Inactivated Successfully For School Teacher:
                            <?php echo $request->user_name;?>!...</b>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <b>School:
                            <?php echo $request->school_name;?> Has Been Inactivated Successfully For School Admin:
                            <?php echo $request->user_name;?>!...</b>
                    </div>
                    <?php
                }
            }
            else
            {
                if(isset($request->teacher))
                {
                    ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <b>School:
                            <?php echo $request->school_name;?> Has Not Been Inactivated For School Teacher:
                            <?php echo $request->user_name;?>!...</b>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <b>School:
                            <?php echo $request->school_name;?> Has Not Been Activated For School Admin:
                            <?php echo $request->user_name;?>!...</b>
                    </div>
                    <?php
                }
            }
        }
    }

    ///END Manage Roles and School For School Admin and School Teacher
 //====== END USERS ======


    
    
    
    
    /*Assign School Classes*/
    public function assign_school_classes()
    {
        $schools = Sms_school::orderby('id',"ASC")->select('id','school')->get()->toArray();
        $classes = Sms_class::orderby('id',"ASC")->get()->toArray();
        
        return view('super-admin/assign_school_classes',['schools'=>$schools,'classes'=>$classes]); 
    }
    
    /*Get School Classes By School ID*/
    public function get_school_assigned_classes(Request $request)
    {
     
        /*Get School Name Of Current Selected School*/
        $school_name = Sms_school::get_school_name_by_id($request->school_id);
        
        /*Get All Classes Of Current Selected School*/
       $school_classes = Sms_school::get_school_classes_by_school_id($request->school_id);
        
        /*Get All Classes Not Assigned In Current Selected School*/ 
       $classes = Sms_class::orderby('id',"ASC")->get()->toArray();    
       
   
        
        $all_school_classes = array();
        $all_classes = array();
        /*Gel All School Classes In Key Value Format*/
        foreach($school_classes as $school_class)
        {
         $all_school_classes[$school_class->class_id] = $school_class->class;    
        }
        /*Gel All Classes In Key Value Format*/
        foreach($classes as $class)
        {
         $all_classes[$class['id']] = $class['class'];    
        }
        

        return view("super-admin/ajax_pages/get_school_classes_for_assigning",['all_classes'=>$all_classes,"school_classes"=>$school_classes,"all_school_classes"=>$all_school_classes,"school_name"=>$school_name]);
    
    }
    
    /*Get Classes IDs To Assign Classes To School*/
    public function assign_classes_to_school(Request $request)
    {
        /*Make Folder Name With School ID & Name*/
        $folder_name_with_school_name = Sms_school::get_school_name_to_make_school_name_folder($request->school_id,$request->school_name);
        $count=0;
        
       if(isset($request->previous_class_ids)){
            $result_new_classes_ids = array_diff($request->new_class_ids,$request->previous_class_ids);
       }
        else
        {
            $result_new_classes_ids=$request->new_class_ids;
        }        

        foreach($result_new_classes_ids as $class_id)
        {
            $flag=false;
            $data = array('sms_class_id'=>$class_id,'sms_school_id'=>$request->school_id,'created_at'=>date('Y-m-d'));
            
            /*Get Class Data By Class ID To Make Class Folder With Class Name*/
            $class_name = Sms_class::find($class_id)->toArray();

            $foleder_name_with_class_name= Sms_class::get_class_name_to_make_student_images_folder($class_name['class']);
            
            $insert = Class_school::assign_new_classes_to_school($data);      

            
            
            if($insert)
            {
                $flag=true;
                $count++;
                if(!File::exists("public/schools/".$folder_name_with_school_name."/".$foleder_name_with_class_name)) 
                {
                    Storage::makeDirectory("public/schools/".$folder_name_with_school_name."/".$foleder_name_with_class_name);

                }
            }    
            else
            {
                $flag=false;
            } 
        }

        
        if($flag==true)
        {

        /*Get School Name Of Current Selected School*/
        $school_name = Sms_school::get_school_name_by_id($request->school_id);
        
        /*Get All Classes Of Current Selected School*/
       $school_classes = Sms_school::get_school_classes_by_school_id($request->school_id);
        
        /*Get All Classes Not Assigned In Current Selected School*/ 
       $classes = Sms_class::orderby('id',"ASC")->get()->toArray();    
       
   
        
        $all_school_classes = array();
        $all_classes = array();
        /*Gel All School Classes In Key Value Format*/
        foreach($school_classes as $school_class)
        {
         $all_school_classes[$school_class->class_id] = $school_class->class;    
        }
        /*Gel All Classes In Key Value Format*/
        foreach($classes as $class)
        {
         $all_classes[$class['id']] = $class['class'];    
        }
        

        return view("super-admin/ajax_pages/get_school_classes_for_assigning",['all_classes'=>$all_classes,"school_classes"=>$school_classes,"all_school_classes"=>$all_school_classes,"school_name"=>$school_name,"message"=>"success","count"=>$count]);
            
           }
            else
            {
                return response()->json([
                    "message" =>"fail"
                ]);
            }

    }
   
    
    
    
    
        /*View Schools With All Its Clasess*/
    public function view_school_classes()
    {
        
        /*Get All Schools*/
        $schools = Sms_school::all()->toArray();
        
        $all_school_classes = array();
        
        $all_classes_students = array();
        $class_students=null;
      
        if(!empty($schools))
        {
            foreach($schools as $school)
            {
                /*Get School-Classes By School ID*/
                $school_classes = Class_School::view_school_classes($school['id']);
                
                if(!empty($school_classes))
                {
                    foreach($school_classes as $school_class)
                    {
                        /*Storing School Name, Class ID & Class Name In New Array*/
                        $all_school_classes[$school['school']][$school_class->id] = array($school_class->class,$school_class->sms_school_id,$school_class->sms_class_id);

                        $school_id = ((int)$school_class->sms_school_id); 
                        $class_id = (int)$school_class->sms_class_id; 
                      
                        $class_students = Sms_class_student::get_class_students_by_school_id_class_id($school_id,$class_id);
                        $all_classes_students[]=$class_students;
                    }
                }
                
            }
        }
    


    return view('super-admin/view_school_classes',['school_classes'=>$all_school_classes,'all_class_students'=>$all_classes_students]);
    }
    
    
    /*Add Students To School-Classes*/
    public function add_students_to_school_class($school_id,$class_id)
    {
        /*Get All Schools To To show in selectbox to Promote Students*/
        $schools = Sms_school::all()->toArray();
       
        
         /*Get School Info by school id to show alert for like:(School -> Class xyz has no students)
            AND To show class name in table of page (Add Students To Class)*/
        $school_information =  Sms_school::find($school_id);
        
        /*Get Class info by class id to show alert for like:(School -> Class xyz has no students)
            AND To show class name in table of page (Add Students To Class)*/
        $class_information= Sms_class::find($class_id);
        
       
        
            $data = array('schools'=>$schools,'school_information'=>$school_information,'class_information'=>$class_information);
            return view('super-admin/add_students_to_school_class',$data);
        
    }
    
    
    public function get_class_students_for_promoting(Request $request)
    {
        
    /*Get All Previous Class Students By Schhol ID And its Class ID To check if has students*/
    $previous_class_students = Sms_class_student::get_class_students_by_school_id_class_id($request->previous_school_id,$request->previous_class_id);
      
    
    /*Get All Previous Class Students By Schhol ID And its Class ID To check if has students*/
    $new_class_students = Sms_class_student::get_class_students_by_school_id_class_id($request->new_school_id,$request->new_class_id);
        
        
    /*Get School Info by school id to show alert for like:(School -> Class xyz has no students)
            AND To show class name in table of page (Add Students To Class)*/
        $school_information =  Sms_school::find($request->previous_school_id);
        
        /*Get Class info by class id to show alert for like:(School -> Class xyz has no students)
            AND To show class name in table of page (Add Students To Class)*/
        $class_information= Sms_class::find($request->previous_class_id);
           
        
       
        
    return view("super-admin/ajax_pages/get_class_students_for_promoting",["previous_class_students"=>$previous_class_students,"new_class_students"=>$new_class_students,'school_information'=>$school_information,'class_information'=>$class_information,"new_school_name"=>$request->new_school_name,"new_class_name"=>$request->new_class_name]);    
        
    }
    
    
    
    /*Get Classes By School Id To Show Class Students*/
    public function get_classes_by_school_id(Request $request)
    {
        /*Get School Name By School ID*/
        $school_name = Sms_school::find($request->school_id)->toArray();
        
        
        /*Get School-Classes By School ID*/
        $school_classes = Class_School::view_school_classes($request->school_id);
       
                /*Check If School Has Classes*/
        if(!empty($school_classes))
        {
            ?>
            <option value="">-- Select Class --</option>
            <?php 
            foreach($school_classes as $class)
            {
                ?>
                <option class_id="<?php echo $class->sms_class_id;?>" value="<?php echo $class->id;?>"><?php echo $class->class;?>
                <?php     
            }
       
         }
        else
        {
            echo 'no classes';
        }
     
    }
    

    /*Add Class*/
    public function add_class()
    {
        return view('super-admin/add_class');
    }

    /*Add Class Process*/
    public function add_class_process(Request $request)
    {
        $controls  = $request->all();
        
        $rules = array(
			"class_name"            => "required",
            "class_description"     => "required",
			);
        
        $messages = [
            'class_name.required' => 'Please enter :attribute',
            'class_description.required' => 'Please enter :attribute',
        ];
		
        $validator  = Validator::make($controls, $rules,$messages);
		if($validator->fails())
		{
			return redirect("/super_admin/add_class")->withErrors($validator);
        }
		else
        {
            
            
            $data = array(
                "class"             =>$controls['class_name'],
                "class_description"       =>$controls['class_description'],
                "status"            =>$controls['class_status'] 
            );
            
            $insert = Sms_class::create($data);
            if($insert){
                return redirect("/super_admin/add_class")->with('insert_message_success','New Class: '.$controls['class_name'].' Has Been Added Successfully!...');
            }else{
                return redirect("/super_admin/add_class")->with('insert_message_fail','New Class: '.$controls['class_name'].' Has Not Been Added Successfully!...');
            }
        }
    }
    
    /*View Classes*/
    public function view_classes()
    {
        $classes = Sms_class::orderby('id',"DESC")->get()->toArray();
        return view('super-admin/view_classes',["classes"=>$classes]);
    }
    /*Edit Class*/
    public function edit_class($id)
    {
     $edit_classes = Sms_class::find($id)->toArray();
    return view('super-admin/edit_class',['edit_classes'=>$edit_classes]);    
    }
    /*Edit Class Process*/
     public function edit_class_process(Request $request)
     {
        $controls  = $request->all();
        
         $rules = array(
			"class_name"            => "required",
            "class_description"     => "required",
			);
        
        $messages = [
            'class_name.required' => 'Please enter :attribute',
            'class_description.required' => 'Please enter :attribute',
        ];
		
         
        $validator  = Validator::make($controls, $rules,$messages);
		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator);
        }
		else
        {
            
            $data = array(
                "class"             =>$controls['class_name'],
                "class_description" =>$controls['class_description'],
                "status"            =>$controls['class_status'] 
            );
            
            
            $insert = Sms_class::where("id","=",$controls['class_id'])->update($data);
            if($insert){
                return redirect("/super_admin/view_classes")->with('edit_message_success',"Class: ".$controls['class_name'].' Has Been Updated Successfully!...');
            }else{
                return redirect("/super_admin/view_classes")->with('edit_message_fail',"Class: ".$controls['class_name'].' Has Not Been Updated Successfully!...');
            }
            
            
        }
    }
   
    

    /*View Class Students*/
    public function view_class_students($school_id,$class_id)
    {
        $class_students = Sms_class_student::get_class_students_by_school_id_class_id($school_id,$class_id);
        
        if($class_students)
        {
         return view('super-admin/view_class_students',['class_students'=>$class_students]);   
        }
        else
        {
            $school = Sms_school::find($school_id)->toArray();
            $class = Sms_class::find($class_id)->toArray();  
            return view('super-admin/view_class_students',['school_name'=>$school,'class_name'=>$class]);  
        }
    }
    


    /*Promote Previous Class Students To New C;ass*/
    public function promote_class_students(Request $request)
    {
        $all_students= $request->promote_to_class_students;
       
        $flag_update=false;
        $flag_insert=false;
        $count=0;
         
        /*Get Previous Class School ID by Previous Class ID & Previous School ID*/
        $previous_class_school_id = Sms_class_student::get_class_school_id_by_class_id_school_id($request->previous_school_id,$request->previous_class_id);
 
        /*Get New Class School ID by New Class ID & New School ID*/
        $new_class_school_id = $request->new_class_school_id;
         
        
        if(!empty($previous_class_school_id))
        {
            
            foreach($all_students as $student_id)
            {
                $update = Sms_class_student::update_class_students_to_promote($previous_class_school_id[0]->id,$student_id); 

                if($update)
                {
                      
                  $flag_update=true; 
                  $insert = Sms_class_student::promote_class_students($new_class_school_id,$student_id);
                    if($insert)
                    {
                        $count++;
                        $flag_insert=true;  
                    }
                    else
                    {
                        $flag_insert=false;
                    }    
                    
                }
                else
                {
                    $flag=false;
                }
            } 
        }
    
        
        if($flag_update==true && $flag_insert==true)
        {
            if($count==1)
            {
                $count =  $count." Student Has Been ";
            }
            else if($count>1)
            {
                $count =  $count." Students Have Been ";
            }
            

             /*Get All Previous Class Students By Schhol ID And its Class ID To check if has students*/
    $previous_class_students = Sms_class_student::get_class_students_by_school_id_class_id($request->previous_school_id,$request->previous_class_id);
      
    
    /*Get All Previous Class Students By Schhol ID And its Class ID To check if has students*/
    $new_class_students = Sms_class_student::get_class_students_by_school_id_class_id($request->new_school_id,$request->new_class_id);
   

        
         /*Get School Info by school id to show alert for like:(School -> Class xyz has no students)
            AND To show class name in table of page (Add Students To Class)*/
        $school_information =  Sms_school::find($request->previous_school_id);
        
        /*Get Class info by class id to show alert for like:(School -> Class xyz has no students)
            AND To show class name in table of page (Add Students To Class)*/
        $class_information= Sms_class::find($request->previous_class_id);
        
            
            return view("super-admin/ajax_pages/get_class_students_for_promoting",['message'=>"success","count"=>$count,"previous_class_students"=>$previous_class_students,"new_class_students"=>$new_class_students,'school_information'=>$school_information,'class_information'=>$class_information,"new_school_name"=>$request->new_school_name,"new_class_name"=>$request->new_class_name]);    
        }
        else
        {       
            return response()->json([
               "message" =>"fail"
            ]);
        }
        
     
        
    }


    public function get_teachers_by_school_id(Request $request)
    {
        
         /*Get All School Teachers By School Id*/
        $school_teachers =  Sms_class_role_user::get_all_teachers_by_school_id($request->school_id);
        
         /*Get All Class Teachers By School Id And Class Id*/
        $class_school_teachers = Sms_class_role_user::get_all_class_school_teachers_by_class_school_id($request->class_id);

            $unassigned_teachers = array();
            $assigned_teachers = array();

            foreach($school_teachers as $school_teacher)
            {

                 $unassigned_teachers[$school_teacher->sms_role_user_id] = $school_teacher->first_name.' '.$school_teacher->last_name; 
            }

            foreach($class_school_teachers as $class_school_teacher)
            {
                 $assigned_teachers[$class_school_teacher->sms_role_user_id] = $class_school_teacher->first_name; 
            }
            
          return view("super-admin/ajax_pages/get_all_teachers_by_school_id",['school_teachers'=>$unassigned_teachers,'class_school_teachers'=>$assigned_teachers,'school_name'=>$request->school_name,'class_name'=>$request->class_name,'school_id'=>$request->school_id,'class_id'=>$request->class_id]); 
    }

    public function assign_teachers_to_class(Request $request)
    {
          $count=0;
          /*Get Sms_Class_School_id By School Id And Class Id*/
          $sms_class_school_id = Sms_class_role_user::get_sms_class_school_id($request->school_id,$request->class_id);
          
          /*Insert All Assigned Teachers To Sms_class_role_user Table*/
          foreach($request->role_user_id as $teacher_id)
            {
                 $assign_teacher_to_class = Sms_class_role_user::assign_teacher_to_class($request->class_id,$teacher_id);
                 $count++;    
            }


          if($assign_teacher_to_class)      
            {
                 /*Show Message At Top Of The Model*/  
                 if($count==1)    
                    {
                        $count=$count." Teacher Has";
                    }
                    else if($count>1)
                    {
                        $count=$count." Teachers Have";
                    }
                    ?>
                        <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
        <strong>
            <?php echo $count." Been Assigned To ".$request->school_name.' ('.$request->class_name.')'." Successfully!...";?>
        </strong>
    </div>
                    <?php

                     /*Sending All The Data To View For The Ajax Response Where All Data Will Be Shown*/
                     $school_teachers =  Sms_class_role_user::get_all_teachers_by_school_id($request->school_id);

                      $class_school_teachers = Sms_class_role_user::get_all_class_school_teachers_by_class_school_id($request->class_id);

                       $unassigned_teachers = array();
                       $assigned_teachers = array();
                       if(!empty($school_teachers))
                       {

                        foreach($school_teachers as $school_teacher)
                        {

                             $unassigned_teachers[$school_teacher->sms_role_user_id] = $school_teacher->first_name.' '.$school_teacher->last_name; 
                        }


                       }
                    if(!empty($class_school_teachers))
                    {
                      foreach($class_school_teachers as $class_school_teacher)
                        {
                             $assigned_teachers[$class_school_teacher->sms_role_user_id] = $class_school_teacher->first_name; 
                        }  
                    }
                     
                    
                    return view("super-admin/ajax_pages/get_all_teachers_by_school_id",['school_teachers'=>$unassigned_teachers,'class_school_teachers'=>$assigned_teachers,'school_name'=>$request->school_name,'class_name'=>$request->class_name,'school_id'=>$request->school_id,'class_id'=>$request->class_id]);                    
            }
            else
            {
                ?>
                    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
        <strong>
            <?php 'Teacher Has Not Assigned To Any School';?>
        </strong>
    </div>
                <?php
            }
        }


    /*Add Role*/
    public function add_role()
    {
        return view('super-admin/add_role');    
    }

    public function add_role_process(Request $request)
    {
        $controls  = $request->all();
        $rules = array(
            "role_type"         =>  "required",
            "role_description"  =>  "required",
        );
        $messages = array(
            "role_type.required" => "Please enter role type",
            "role_description.required" => "Please enter role description"
        );
        $validator  = Validator::make($controls, $rules, $messages);
        if($validator->fails())
        {
            $messages = $validator->messages();
            return redirect("super_admin/add_role")->withErrors($validator);
        }
        else
        {
            $data = array(
                "role_type"         => $controls['role_type'],
                "role_description"  => $controls['role_description'],
                "status"            => $controls['status']
            );

            $roleType = $controls['role_type'];

            $myresult = Sms_role::create($data);

            if($myresult)
            {
                return redirect("super_admin/add_role")->with(array("add_role_success_message"=>"New Role Type: $roleType Has Been Added Successfully!..."));
            }
            else
            {
                return redirect("super_admin/add_role")->with(array("add_role_fail_message"=>"New Role Type: $roleType Has Not Been Added!..."));
            }
        }
    }

    /*View Roles*/
    public function view_roles()
    {
        $result = Sms_role::all()->toArray();
        $roles = array("myroles"   => $result);
        return view('super-admin/view_roles', $roles);    
    }

    /* Edit Role*/
    public function edit_role($id)
    {
        $result = Sms_role::where("id", "=", $id)->get()->toArray();
        $data = array("editData"=>$result);
        return view("super-admin/edit_role",$data);
    }

    /* Edit Role Proccess*/
    public function edit_role_process(Request $request, $id)
    {   
        $controls  = $request->all();
        $rules = array(
            "role_type"         =>  "required",
            "role_description"  =>  "required",
        );

        $id = $controls['id'];
        $messages = array(
            "role_type.required" => "Please enter role type",
            "role_description.required" => "Please enter role description"
        );
        $validator  = Validator::make($controls, $rules, $messages);
        if($validator->fails())
        {
            $messages = $validator->messages();
            return redirect("super_admin/edit_role/$id")->withErrors($validator);
        }
        else
        {
            $data= array(
                "role_type"         => $controls['role_type'],
                "role_description"  => $controls['role_description'],
                "status"            => $controls['status']
            );
            
            $roleType = $controls['role_type'];
            $result = Sms_role::where("id", "=", $controls['id'])->update($data);
            if($result)
            {
                 return redirect('/super_admin/view_roles')->with("role_update_success_message","Role Type: $roleType Has Been Updated Successfully!...");
            }
            else
            {
                 return redirect('/super_admin/view_roles')->with("role_update_fail_message","Role Type: $roleType Has Not Been Updated!...");
            }
        }
    }
    
    /*Add Qualification*/
    public function add_qualification()
    {
         return view('super-admin/add_qualification');
    }
    
    /*View Qualifications*/
    public function view_qualifications()
    {
        $result = Sms_qualification::all()->toArray();   
        return view('super-admin/view_qualifications')->with("qualifications",$result);
    }

    public function add_qualification_process(Request $request)
    {
            $controls  = $request->all();

            /*Validation*/
            $rules = array(
                "degree_title"                       => "required",
                "degree_description"                 => "required"
                );
            
            $messages = [
            'degree_title.required'       => 'Please enter :attribute',
            'degree_description.required' => 'Please enter :attribute',
            ];
            
            $validator  = Validator::make($controls, $rules,$messages);
            
            if($validator->fails())
             {
                  return redirect("/super_admin/add_qualification")->withErrors($validator);
             }
            /*Inserting Data*/
             else
             {
                 
                $data = array
                     (
                    "degree_title"       => $request->degree_title,
                    "degree_description" =>$request->degree_description,
                    "status"             =>$request->status);

                    $result = Sms_qualification::create($data);
                    
                    if($result)
                    {
                        return redirect("/super_admin/add_qualification")->with('qualification','New Qualification : '.ucfirst($request->degree_title).' Has Been Added Successfully!...');    
                    }
                        
                    else
                    {
                        return redirect("/super_admin/add_qualification")->with('qualification_fail','Something Went Wrong Please Try Again');
                    }
                        
             }       
    }

    public function edit_qualification($id)
    {
         $result = Sms_qualification::where('id',$id)->get()->toArray();
        return view('super-admin/edit_qualification')->with("qualifications",$result);
    }


    public function update_qualification(Request $request)
    {
        $controls = $request->all();
        /*Validation*/
        $id = $controls['id'];
        $rules = array(
                "degree_title"                       => "required",
                "degree_description"                 => "required"
                );
            
            $messages = [
            'degree_title.required'       => 'Please enter :attribute',
            'degree_description.required' => 'Please enter :attribute',
            ];
            
            $validator  = Validator::make($controls, $rules,$messages);
            
            if($validator->fails())
             {
                  return redirect("/super_admin/edit_qualification/$id")->withErrors($validator);
             }
            /*Update*/
             else
             {
                 $data = array
                         (
                        "degree_title"       => $request->degree_title,
                        "degree_description" =>$request->degree_description,
                        "status"             =>$request->status,
                          );
         
                      $result = Sms_qualification::where('id',$request->qual_id)->update($data);
                        if($result)
                        {
                            return redirect("/super_admin/view_qualifications")->with('qualification','Qualification: '.ucfirst($request->degree_title).' Has Been Updated Successfully!...');
                        } 
                        else{
                            return redirect("/super_admin/view_qualifications")->with('qualification_fail','Something Went Wrong Please Try Again');
                        }
            }    
    }

    /*Add setting*/
    public function add_setting()
    {
        return view('super-admin/add_setting');
    }
    
    /*View settings*/
    public function view_settings()
    {
       
        $result = Sms_setting::orderBy('ID', 'DESC')->get()->toArray();
        
        return view('super-admin/view_settings',['settings'=>$result]);
    }
    
    /*add_setting_process*/
    public function add_setting_process(Request $request){
        $controls  = $request->all();
       
        $rules = array(
			"key"                   => "required",
			"value"                 => "required"
			);
        
        $messages = [
            'key.required' => 'Please enter :attribute',
            'value.required' => 'Please enter :attribute',  
        ];
		
        $validator  = Validator::make($controls, $rules,$messages);
		if($validator->fails())
		{
			return redirect("/super_admin/add_setting")->withErrors($validator);
        }
		else
        {
            
            $data = array(
                "key"       =>$controls['key'],
                "value"     =>$controls['value'],
                "status"    =>$controls['setting_status'],
            );
            
            $flag = Sms_setting::create($data);
            if($flag){
                return redirect("/super_admin/add_setting")->with('success_msg','New Setting : '.ucwords($controls["key"]).' Has Been Added Successfully!...');
            }else{
                return redirect("/super_admin/add_setting")->with('error_msg','Something Went Wrong Please Try Again!..');
            }
            
            
        }
        
        
    }
    
    /*eidt_setting_page*/
    public function edit_setting($id){
        $edit_setting = Sms_setting::find($id)->toArray();
        return view("/super-admin/edit_setting",['edit_setting'=>$edit_setting]);
    }
    
    
    
    /*eidt setting data */
        
    public function edit_setting_process(Request $request){
        
        $controls  = $request->all();
        $rules = array(
			"key"                   => "required",
			"value"                 => "required"
			);
        
        $messages = [
            'key.required' => 'Please enter :attribute',
            'value.required' => 'Please enter :attribute',  
        ];
		
        $validator  = Validator::make($controls, $rules,$messages);
		if($validator->fails())
		{
           
			return Redirect::back()->withErrors($validator);
        }
		else
        {
            $data = array(
                "key"       =>$controls['key'],
                "value"     =>$controls['value'],
                "status"    =>$controls['setting_status'],
            );
            
            $flag = Sms_setting::where("id", "=", $controls['id'])->update($data); ;
            if($flag){
               return redirect("/super_admin/view_settings")->with('msg','Setting : '.ucfirst($controls['key']).' Has Been Updated Successfully!...');
            }else{
               return redirect("/super_admin/view_settings")->with('msg','Something Went Wrong Please Try Again!..');
            }
        }
    }


     /* view district operations */
    public function view_district_operations()
    {
        $get_opration_brach = Sms_school::get_operation_branch();
    
        return view('/super-admin/view_district_operations',['district_operations'=>$get_opration_brach]);
    }
     /* view district operations */

 
    
    public function load_camera_for_attendance_picture()
    {
        return view('/super-admin/ajax_pages/load_camera_for_attendance_picture');
    }

   

    public function view_class_attendance_pictures()
    {
        $schools = Sms_school::all()->toArray();
        $week_end_name = null;

        /*Get Weekend Full Name*/
        $result_week_end = Sms_setting::where('key',"Weekend")->where('status',1)->get()->toArray();
        if(!empty($result_week_end))
        {
              $week_end_name = date('l',strtotime($result_week_end[0]['value']));
        }
        
        return view('/super-admin/view_class_attendance_pictures',['schools'=>$schools,'week_end_name'=>$week_end_name]);
    }
    

    
    public function view_class_attendance_pictures_by_date_range(Request $request)
    {
        
        $month_year=explode("/",$request->month);
        
        $replace_date=$month_year[1]."-".$month_year[0];
        $month_date=date("Y-m",strtotime($replace_date));
        
        /*Get Folder Name With School Name like:(house_of_knowledge_(hok-1))*/
        $school_folder_name     = Sms_school::get_school_name_to_make_school_name_folder($request->school_id,$request->school_name);
        
        /*Get Folder Name With Class Name like:(class_1))*/
        $class_folder_name = Sms_class::get_class_name_to_make_student_images_folder($request->class_name);
        
        /*Make Students Image Path With School Name,Class Name And Current Year*/
        $images_path = $school_folder_name."/".$class_folder_name."/".$month_year[1]."/class_attendance/".strtolower(date("F",strtotime($month_date)));
        
         /*
        Note For Class Attendance Image Path:
        (Complete Path Is = $school_folder_name."/".$class_folder_name."/class_attendance/dynamic month [august]/" })
        We will add month name in half path when attendance will be submited.
        */
        /*Make Half Class Attendance Image Path*/
        $class_attendance_image_path = $school_folder_name."/".$class_folder_name; 
        
       
        $attendances= Sms_attendance::get_class_attendance_pictures_data($request->class_school_id,$month_date);
        $data=array();
        foreach($attendances as $attendance)
        {
            
            $present=Sms_attendance::get_all_student_attendance_status_by_class_school_id($attendance->sms_class_school_id,$attendance->created_date,1);
            
            $absent=Sms_attendance::get_all_student_attendance_status_by_class_school_id($attendance->sms_class_school_id,$attendance->created_date,0);
           
           $data[$attendance->id]=array("present"=>count($present),"absent"=>count($absent),"created_date"=>$attendance->created_date,"class_image"=>$attendance->class_image);
        }
       
   
        //print_r($month_year);
       return view('super-admin/ajax_pages/get_class_attendance_pictures',["class_attendance_pictures"=>$data,"images_path"=>$images_path]);
    }    
}