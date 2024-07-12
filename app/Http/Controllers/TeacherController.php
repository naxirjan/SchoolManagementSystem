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


class TeacherController extends Controller
{

    public function __construct()
	{
		$this->middleware("teacherMiddleware");
	}
    



    /*Dashboard*/
    public function dashboard(Request $request)
    {
        $current_date = date("Y-m-d");
        
        $school_id = session('myuser_schools')[3]['school_id'];

        /*To Check If School Has Classes Greater Than 0 To Class Teacher Side*/
        /*If It Is Greater Than Zero Then Take Attendance Menu Option Will be shown In Sidebar*/        
        $teacher_classes = Sms_class_role_user::get_teacher_classes_by_school_id_role_user_id($school_id,session('user_id'),session('role_id'));

        $request->session()->put('check_school_classes_for_teacher_side_bar',$teacher_classes);

        $school_holiday = Holiday_school::get_holiday_by_school_id($school_id,$current_date);

        $school_weekend = Sms_setting::get_school_holiday_by_school_id($school_id);

        $result = array();

        if(!empty($teacher_classes))
        {
            
        foreach ($teacher_classes as $class)
            {

                $school_name = Sms_school::get_school_name_to_make_school_name_folder($class->school_id,$class->school);

                $class_name = Sms_class::get_class_name_to_make_student_images_folder($class->class);

                $total_teachers = 0;
                $total_students = 0;
                
                $teachers = Sms_class_role_user::get_all_class_school_teachers_by_class_school_id((int)$class->sms_class_school_id);
                if(!empty($teachers))
                {
                    $total_teachers = count($teachers);
                }
                $students = Sms_class_role_user::get_students_by_class_school_id((int)$class->sms_class_school_id);
                if(!empty($students))
                {
                    $total_students  = count($students);
                }
                $result[$class->sms_class_school_id]['class_name'] = $class->class;
                $result[$class->sms_class_school_id]['teachers'] = $total_teachers;
                $result[$class->sms_class_school_id]['students'] = $total_students;
                $attendance = Sms_attendance::get_daily_attendance_report($class->sms_class_school_id,$current_date);

                if(!empty($attendance))
                {
                    $present = 0;
                    $absent = 0;

                    foreach ($attendance as $value) 
                    {
                        if($value->status == 1)
                        {
                            $present++;
                        }
                        else if($value->status == 0)
                        {
                            $absent++;
                        }
                    }

                    $total_attendance = ($present+$absent);

                    $img_path = 'schools/'.$school_name.'/'.$class_name.'/'.date('Y',strtotime($value->created_at));
                    $result[$class->sms_class_school_id]['present'] = $present;
                    $result[$class->sms_class_school_id]['absent'] = $absent;
                    $result[$class->sms_class_school_id]['image_path'] = $img_path;
                    $result[$class->sms_class_school_id]['percentage'] = ($present*100)/$total_attendance;
                }
                else
                {
                    $result[$class->sms_class_school_id]['present'] = 0;
                    $result[$class->sms_class_school_id]['absent'] = 0;   
                    $result[$class->sms_class_school_id]['image_path'] = "";
                    $result[$class->sms_class_school_id]['percentage'] = 0;
                }
            }
        }
        

        $data = array(
            'result'            =>  $result,
            'school_holiday'    =>  $school_holiday,
            'school_weekend'    =>  $school_weekend,
            "current_date"      =>  $current_date    
        );

        return view('teacher/dashboard',$data);
    }
    
    /*Get School class students for dashboard*/
    public function  get_present_students_for_dashboard_function(Request $request)
    {
        $controls  = $request->all();
        $current_date   = date("Y-m-d"); 

        if($controls['status'] == 1)
        {
            $class_info = $controls['class_name']." Present Students";  
        }
        else
        {
            $class_info = $controls['class_name']." Absent Students";  
        }
       
        $present_students  = Sms_attendance::get_all_student_attendance_status_by_class_school_id($controls['class_school_id'],$current_date,$controls['status']);

        return view("teacher/ajax_pages/get_students_for_dashboard",['students'=>$present_students,"students_image_path"=>$controls['image_path'],'class_students'=>$class_info]);    
    }

    
       /*Profile*/
    public function view_profile()
    {
        return view('teacher/view_profile');
    }

    /*Chnage Password*/
    public function change_password(){
        return view('teacher/change_password');
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
            return redirect("/teacher/change_password")->withInput($request->all())->withErrors($validator);
        }
        else
        {

            /*This function check your input old password and database saved password*/
            $update = Sms_user::reset_user_password($controls['old_password'],$controls['new_password']);
            if($update){
                 return redirect("/teacher/change_password")->with("success_message","Your Password Has Been Successfully Changed!...");
            }else{
                return redirect("/teacher/change_password")->with("error_message","Your old password doesn't match!...");
            }
            
        }

    }



    /*Check password using ajax function */
    public function check_old_password_school_teacher_function(Request $request){

        $user = Sms_user::find(Auth::user()->id);
       
        if(Hash::check($request->old_password,$user->password)) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    
    /*View Teachers*/
    public function view_teachers()
    {
        return  view('teacher/view_teachers');
    }
   
    
    /*View Students*/
    public function view_students()
    {
        return  view('teacher/view_students');
    }
    
      
    /*Take Attendance*/
    public function take_attendance()
    {
        
        $school_id =session('myuser_schools')[3]['school_id']; 
        $user_id   = session('user_id');
        $role_id   = session('role_id');
        $week_end_name = null;
        /*Get Teacher Classes*/
        $teacher_classes = Sms_class_role_user::get_teacher_classes_by_school_id_role_user_id($school_id,$user_id,$role_id);
        
        /*Get Weekend Full Name*/
        $result_week_end = Sms_setting::where('key',"Weekend")->where('status',1)->get()->toArray();
        

          if(!empty($result_week_end))
        {
              $week_end_name = date('l',strtotime($result_week_end[0]['value']));

        }

        return view('teacher/take_attendance',['teacher_classes'=> $teacher_classes,'week_end_name'=>$week_end_name]);
    }
  
    /*Check Cureent Date Attendance*/
    public function check_current_date_attendance(Request $request)
    {
        /*Get Data From Ajax Request*/ 
        $role_user_id    = (int)$request->role_user_id;
        $class_school_id = (int)$request->class_school_id;
        $attendance_date = date('Y-m-d',strtotime($request->attendance_date));
       
    
        /*Get School ID & Name Of Last Assigned School Of Teacher*/
        $school_id = session('myuser_schools')[3]['school_id'];
        $school_name = session('myuser_schools')[3]['school_name'];
        
        /*Get Folder Name With School Name like:(house_of_knowledge_(hok-1))*/
        $school_folder_name     = Sms_school::get_school_name_to_make_school_name_folder($school_id,$school_name);
        
        /*Get Folder Name With Class Name like:(class_1))*/
        $class_folder_name      = Sms_class::get_class_name_to_make_student_images_folder($request->class_name);
      
        /*Make Students Image Path With School Name,Class Name And Current Year*/
        $students_image_path = $school_folder_name."/".$class_folder_name."/".date("Y");
        
        /*Check If Current Date Attendance Already Exists*/
        $attendance_exists = Sms_attendance::check_current_date_attendance($class_school_id,$attendance_date);
        $result_attendance_added_by =null;
        
        
		if(!empty($attendance_exists))
        {
            /*Get User Info By role_user_id*/
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
            $class_attendance_role_user_id=null;
       
            
            $students_attendance_to_modify = Sms_attendance::get_students_attendance_by_class_school_id($class_school_id,$attendance_date);
        
            
            if(!empty($students_attendance_to_modify))
            {
                /*Get Class Attedance Image*/   
                $class_attendance_image = $students_attendance_to_modify[0]->class_image;
                $class_attendance_role_user_id = $students_attendance_to_modify[0]->sms_role_user_id;
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
                  return view("teacher/ajax_pages/get_students_for_attendance",['students'=>$students,"students_image_path"=>$students_image_path]);  
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
            
            else if(!empty($all_students_attendance) && $class_attendance_role_user_id == $role_user_id)
            {
                return view("teacher/ajax_pages/get_students_attendance_to_modify",['students_attendance_to_modify'=>$all_students_attendance,"students_image_path"=>$students_image_path,'class_attendance_image_path'=>$class_attendance_image_path,"role_user_id"=>$role_user_id,"class_school_id"=>$class_school_id,"attendance_date"=>$attendance_date,'class_attendance_image'=>$class_attendance_image]); 
            }
            else if(!empty($all_students_attendance) && $class_attendance_role_user_id != $role_user_id)
            {
                return response()->json([ 'message'   => "attendance_is_added",
                                            "date"=>date('d F Y',strtotime($request->attendance_date))]);         
            }
            
        }
        
        
        
    }
    
    /*Set Students Attendance In Session*/
    public function get_un_submitted_students_attendance(Request $request)
    {
        
        $data = array();
        
        $school_id = session('myuser_schools')[3]['school_id'];
        $school_name = session('myuser_schools')[3]['school_name'];
        
        /*Get Folder Name With School Name like:(house_of_knowledge_(hok-1))*/
        $school_folder_name     = Sms_school::get_school_name_to_make_school_name_folder($school_id,$school_name);
        
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
    
        return view("teacher/ajax_pages/get_un_submitted_students_attendance",['un_submitted_attendance'=>$data,"class_school_id"=>$request->class_school_id,"role_user_id"=>$request->role_user_id,"attendance_date"=>$request->attendance_date,"students_image_path"=>$students_image_path,'class_attendance_image_path'=>$class_attendance_image_path]) ;   
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
            
            
            /*Check If Image Is Taken*/
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
                'result'    =>$validation->errors()->all(),
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
                    /*Check If Image File Is Not Uploaded In Folder*/
                    else
                    {
                        
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
    
    
    /*Modify Attendance*/   
    public function modify_attendance()
    {
        $school_id = session('myuser_schools')[3]['school_id']; 
        $user_id   = session('user_id');
        $role_id   = session('role_id');
        /*Get Teacher Classes*/
        $teacher_classes = Sms_class_role_user::get_teacher_classes_by_school_id_role_user_id($school_id,$user_id,$role_id);
       
        
        /*Get Weekend Full Name*/
        $result_week_end = Sms_setting::where('key',"Weekend")->where('status',1)->get()->toArray();
        $week_end_name = date('l',strtotime($result_week_end[0]['value']));
       
        return view('teacher/modify_attendance',['teacher_classes'=> $teacher_classes,'week_end_name'=>$week_end_name]);
    }
 
    
    
    
    
    //ATTENDANCE
    public function view_attendance()
    {

        $school_id = session('myuser_schools')[3]['school_id'];
        $user_id   = session('user_id');
        $role_id   = session('role_id');
        
        $teacher_classes = Sms_class_role_user::get_teacher_classes_by_school_id_role_user_id($school_id,$user_id,$role_id);


        /*Get Current School weekend Name*/
       $school_weekend = Sms_setting::where('key','weekend')->where('status',1)->get()->toArray();
       $weekend_day_name = null;

        if(!empty($school_weekend))
        {
               $weekend_day_name = $school_weekend[0]['value'];
        }

        return view('teacher/view_attendance',['teacher_classes'=>$teacher_classes,'weekend_day_name'=>$weekend_day_name]);
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

            if(!empty($daily_attendance_report)){
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
        if($check_school_holiday)
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
                
                return view('teacher/ajax_pages/get_attendance_daily_report',['daily_attendance_report'=>$daily_attendance_report,'school_name'=>$school_name,'class_name'=>$request->class_name,'all_students'=>$all_students,'present_students'=>$present_students,'absent_students'=>$absent_students,'daily_attendance_date'=>$request->daily_date,'class_teachers'=>$class_teachers,'image_path'=>$image_path,'attendance_taken_teacher_name'=>$attendance_taken_teacher_name,"class_attendance_picture_path"=>$class_attendance_picture_path]); 
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

         return view('teacher/report/generate_daily_attendance_report',['school_name'=>$school_name,'class_name'=>$class_name,'class_teachers'=> $class_teachers,'attendance_taken_by'=>$attendance_taken_by,'present_students'=>$present_students,'absent_students'=>$absent_students,'attendance_day'=>$attendance_day,'all_students'=>$all_students,'all_student_data'=>$all_student_data]);        
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


 
        $teachers = Sms_class_role_user::get_all_class_school_teachers_by_class_school_id($class_school_id);

        $students = Sms_class_role_user::get_students_by_class_school_id($request->class_school_id);

        $total_students  = count($students);


        if(!empty($attendance))
        {
           
        return view('teacher/report/get_attendance_for_monthy_combine_report',[
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
        else
        {
          return response()->json([
                "message"   =>"fail",
            ]);  
        }
    }

    /*Generate Monthly Combine Excel Sheet Report*/
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

        return view('teacher/report/generate_excel_for_monthy_combine_report',[
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
            return view('teacher/report/view_date_range_combine_report',[
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

        
        return view('teacher/report/generate_excel_date_range_combine_report',[
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

        

        if(!empty($attendance))
        {
                return view('teacher/report/view_date_range_student_report',[
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

       
                return view('teacher/report/generate_excel_date_range_student_report',[
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
	
    /*Get recoreds of students attendance monthly wise day by day */
    public function monthly_individual_function_teacher_side(Request $request)
	{
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

            
            /*array of month for view attnedance*/   
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

        return view("teacher/ajax_pages/get_monthly_individual_report_for_view_attendance",['attendance'=>$Attendance_summery,'month_year_class_school_id'=>$data]);


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

           
            /*array of month for view attnedance*/   
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

        return view("teacher/report/report_monhtly_individual",['attendance'=>$Attendance_summery]);


    }


	/*Get recoreds of students attendance individual by class_school_id and date range */ 
	public function generate_individual_attendance_report_by_class_school_id_date_range_teacher_function(Request $request){
		
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
                "date_range"            => "From".$request['date_from']." To".$request['date_to'],
                "holiday_recored"       => $get_holiday,
                'weekend'               => $weekend[0]['value'],
                "attendance_detail"     => $get_attendance_detail_array,
                "total_range_days"      => $get_all_dates,
              );
			  
			  
			
		}else{
			
			 $Attendance_summery = array();
             return response()->json(['message'=>'fail']);
			
		}
		
		$data = array(
			'class_school_id' =>$class_school_id,
			'date_from'		  =>$request['date_from'],
			'date_to'		  =>$request['date_to'],
			
		);
		
		return view("teacher/ajax_pages/get_date_range_individual_report_for_view_attendance_teacher",['attendance'=>$attendance_summery,'date_range_class_school_id'=>$data]);
		
		
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
		
	  return view("teacher/report/report_date_range_individual",['attendance'=>$attendance_summery,'date_range_year_class_school_id'=>$data,'date_from'=>$request['date_from'],'date_to'=>$request['date_to']]);

		
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
            
        /*Check If School Classes Exist*/
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
                    return view("teacher/ajax_pages/generate_average_attendance_report_by_school_id_date_range",['all_attendance'=>$all_attendance,"school_name"=>$request->school_name,"school_teachers"=>$school_teachers,"date_from"=>$date_from,"date_to"=>$date_to,"school_id"=>$request->school_id]);
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
            
            return view("teacher/report/report_average_date_range",['all_attendance'=>$all_attendance,"school_name"=>$request->school_name,"school_teachers"=>$school_teachers,"date_from"=>date('Y-m-d',strtotime($date_from)),"date_to"=>date('Y-m-d',strtotime($date_to)),"school_id"=>$request->school_id]);
   
    }

    /*Get Attendance Report Of Year*/
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
                     return view('teacher/ajax_pages/get_yearly_attendance_report',['all_attendance'=>$all_attendance,'total_working_days_year'=>$total_working_days_year,'myattendance'=>$myattendance,'full_year'=>$full_year,'class_school_id'=>$class_school_id,'school_id'=>$school_id,'school_name'=>$request->school_name,'class_name'=>$request->class_name]);
               }
               else
               {
                    return response()->json([
                        'message'=>'fail',
                        'year'=>$full_year,
                    ]);

               }
    }
    /*Generate Attendance Report Of year*/
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
                 
                 return view('teacher/report/generate_yearly_attendance_report',['all_attendance'=>$all_attendance,'total_working_days_year'=>$total_working_days_year,'myattendance'=>$myattendance,'full_year'=>$full_year,'class_school_id'=>$class_school_id,'school_id'=>$school_id,'school_name'=>$request->school_name,'class_name'=>$request->class_name]);
    }
    
    
    
    
    
    /*View Holidays*/
    public function view_holidays()
    {
         
         $school_id = session("myuser_schools")[3]['school_id'];
        $result = Holiday_school::get_school_holidays_by_school_id($school_id);

          $role_user_id = Sms_user::get_current_user_logined_sms_role_user_id();
        return view('teacher/view_holidays',["holidays"=>$result,'role_user_id'=>$role_user_id]);
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
                return view('teacher/view_holiday_detail')->with($result);
            }
    


    /*View District Operations*/
    public function view_district_operations()
    {
        $get_opration_brach = Sms_school::get_operation_branch();
        
        return view('teacher/view_district_operations',['district_operations'=>$get_opration_brach]);
    }
    
    public function switch_teacher_school($id)
    {
        $school = Sms_school::where([["id","=",$id],["status","=",1]])->get()->toArray();
        $myschool = array();
        foreach ($school as $value) 
        {
            $myschool['school_id']  = $value['id'];
            $myschool['school_name']  = $value['school'];
        }
        Session::put("myuser_schools.3",$myschool);
        
        return redirect('/');
    }


     public function view_my_classes()
    {
        $all_class_students = [];

        $all_classes = [];


         $school_id = session('myuser_schools')[3]['school_id']; 

            $user_id   = session('user_id');
            $role_id   = session('role_id');
        
        $teacher_classes = Sms_class_role_user::get_teacher_classes_by_school_id_role_user_id($school_id,$user_id,$role_id);
        


        foreach($teacher_classes  as $teacher_class)
        {
           $all_classes[$teacher_class->sms_class_school_id] = $teacher_class->class;
        }
       
        foreach($teacher_classes as $teacher_class)
        {
             $class_students = Sms_class_role_user::get_students_by_class_school_id($teacher_class->sms_class_school_id);

             foreach($class_students as $class_student)
              {

                /*get student updated recored year*/
                $year = substr($class_student->class_student_date,0,4);

                $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($class_student->school_id,$class_student->school);
                      $class_name = Sms_class::get_class_name_to_make_student_images_folder($class_student->class);
                   $all_class_students[$teacher_class->sms_class_school_id][$class_student->id] = array(
                        "class_school_id"=>$teacher_class->sms_class_school_id,
                        "school_name"=>$class_student->school,
                        "class_name"=>$class_student->class,
                        "student_id"=>$class_student->id,
                        "image"=>$class_student->student_image,
                        "first_name"=>$class_student->first_name,
                        "middle_name"=>$class_student->middle_name,
                        "last_name"=>$class_student->last_name,
                        "gender"=>$class_student->gender,
                        "student_image_path"=>"storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".$year."/".$class_student->student_image,
                        
                      ); 
             }

        }

        return view('teacher/view_my_classes',['all_classes'=>$all_classes,'all_class_students'=>$all_class_students]);
    }

      public function view_student_detail($id){
        /*Get student detail by student id for super admin side view student detail*/
        $get_student = Sms_student::get_student_datail_by_student_id($id);
        /*Get school name with school id  in small alphabets for create a school folder name */
        $schools_name_with_id =  Sms_school::get_school_name_to_make_school_name_folder($get_student[0]->school_id,$get_student[0]->school);
        

        $class_name = Sms_class::get_class_name_to_make_student_images_folder($get_student[0]->class);
        
        $student_image_path = array(
            'student_image_path'=>"storage/schools/".$schools_name_with_id."/".strtolower($class_name)."/".date('Y')."/".$get_student[0]->student_image
        );
        
        return  view('teacher/view_student_detail',['student'=>$get_student,'student_image_path'=>$student_image_path,"student_image"=>$get_student[0]->student_image]);
    
    }

    
    public function load_camera_for_attendance_picture()
    {
        return view('/teacher/ajax_pages/load_camera_for_attendance_picture');
    }
    

}//Class