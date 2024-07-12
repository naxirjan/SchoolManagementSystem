<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;

use DB;
use App\Sms_user;
use App\Sms_role;
use App\Sms_qualification;
use App\Sms_school;




class LoginController extends Controller
{
        
    /*Login*/
    public function login()
    {
        /*this code for one superadmin in inserted in database*/
        if (Schema::hasTable('sms_users')) 
        {
            $get_any_user = Sms_user::all()->toArray();
            
            if(!$get_any_user)
            {
               
                $result = Sms_user::create(
                    [
                        "first_name"          =>'Hidaya',
                        "middle_name"         =>'Trust',
                        "last_name"           =>'HIST',
                        "email"               =>'superadmin@gmail.com',
                        "password"            => bcrypt('12345678'), 
                        "contact_number"      =>'12345678901',  
                        "gender"              =>'Male',  
                        "address"             =>'A-17, Phase - I, Sindh University Employees Co-operative Housing Society Jamshoro, 76060',
                        "profile_image"       =>'1_superadmin.jpg',
                        "status"              =>1, 
                    ]
                );
                

                Sms_role::create(["role_type"=>'Super Admin',"role_description"=>'Super admin is user that belongs to Super Administrators users, and between other thing, this user can execute maintenance tasks.',"status"=>1]);
               
                DB::table('sms_role_user')->insert(
                    ['sms_user_id' => 1, 'sms_role_id' => 1,'status'=>1]
                );
                
                Sms_qualification::create([
                    "degree_title"=>'PHD',
                    "degree_description"=>'This Is Degree Description',
                    "status"=>1,
                ]);
                
                Sms_user::where("id",'=',1)->update(["sms_qualification_id"=>1,"sms_role_user_id"=>1]);

                //Create table com_operation_branch with data insertion
                DB::transaction(function(){
                DB::statement("CREATE TABLE `com_operation_branch` (
                  `district_operation_id` smallint(6) NOT NULL AUTO_INCREMENT,
                  `district_operation_full_name` varchar(100) NOT NULL,
                  `district_operation_short_name` varchar(100) DEFAULT NULL,
                  PRIMARY KEY (`district_operation_id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;");

                DB::insert("insert  into `com_operation_branch`(`district_operation_id`,`district_operation_full_name`,`district_operation_short_name`) values (1,'Central Field Operation','CFO'),(2,'Shikarpur Jacobabad District Operation','SJDO'),(3,'Sukkur Khairpur Disctrict Operation','SKDO'),(4,'Jamshoro Hyderabad District Operation','JHDO'),(5,'Karachi Thatta Distrcit Operation','KTDO'),(6,'Abbottabad Mansehra District Operation','AMDO'),(7,'Rahimyar Kan District Operation','RDO'),(8,'Qambar Shahdadkot Distrcit OPeration','QsDO'),(9,'Nagpur','Nagpur'),(10,'Kandy','Kandy');
                ");
                
                 });
                /*end code*/
            }
        }
        return view('login');
    }
    
       /*Checking User Email & Password For Login Process*/
    public function login_process(Request $request)
	{ 
        $controls  = $request->all();
		
		$rules = array(
			"email"                    => "required|email",
			"password"                 => "required"
			);
		
        $messages = [
        'email.required' => 'Please enter your :attribute address',
        'email.email' => 'Please enter your :attribute address in correct format',
        'password.required' => 'Please enter your :attribute',    
        ];
		
        $validator  = Validator::make($controls, $rules,$messages);
		
        /*If Validation Fails*/
		if($validator->fails())
		{
			return redirect("/")->withErrors($validator);
        }
		else
		{
            
                /*this code for one superadmin in inserted in database*/
            if (Schema::hasTable('sms_users')) 
            {

                    /*If email and password are coorects*/
                    if(Auth::attempt(["email"=>$request->input("email"), "password"=>$request->input("password")]))
                    {
                        /*Getting Last Assigned Role From Sms_user Model*/    
                        $roles = Sms_user::roles(Auth::user()->id);    
            		    $user_roles = Sms_user::get_all_user_roles(Auth::user()->id);    
                        $qualification = Sms_user::get_user_qualification(Auth::user()->sms_qualification_id);
                        $acccount_created_by = Sms_user::get_user_information_with_role_type_by_role_user_id(Auth::user()->sms_role_user_id);
                        $user_schools = Sms_user::get_user_schools(Auth::user()->id);
                        
                        $myuser_schools = array();
                        /*Check If User Has Schools*/    
                        if(!empty($user_schools))
                        {
                            foreach ($user_schools as $school) 
                            {
                                if($school->role_id == 2)
                                {
                                    $myuser_schools[$school->role_id]['school_id'] = $school->school_id;
                                    $myuser_schools[$school->role_id]['school_name'] = $school->school;
                                }
                                else if($school->role_id == 3)
                                {
                                    $myuser_schools[$school->role_id]['school_id'] = $school->school_id;
                                    $myuser_schools[$school->role_id]['school_name'] = $school->school;
                                }
                            }
                        }
                        /*Check If User Has Schools*/    
                        
                           
                            
                        /*Check If User Account Is Active*/
                        if(!empty($user_roles))
                        {
                        /*Setting User Data In Session*/
                        $request->session()->put("role_id", $roles[0]->role_id);
                        $request->session()->put("role_type", $roles[0]->role_type);
                        $request->session()->put('user_roles',$user_roles);  
                        $request->session()->put("user_id", Auth::user()->id);
                        $request->session()->put("first_name", Auth::user()->first_name);
                        $request->session()->put("last_name", Auth::user()->last_name);    
            			$request->session()->put("profile_image", Auth::user()->profile_image);
                        $request->session()->put("degree_title", $qualification[0]->degree_title);
                        $request->session()->put("degree_description", $qualification[0]->degree_description);
                        /*Setting User Data In Session*/

            			/*USER SCHOOLS SESSIONS START*/
                        //Last Assigned School Of User (School Admin/Teacher)    
                        $request->session()->put('myuser_schools',$myuser_schools);
                        $request->session()->put('user_schools',$user_schools);
                        /*USER SCHOOLS SESSIONS END*/
                        
                        if($acccount_created_by){
                        $request->session()->put("account_created_by_full_name", $acccount_created_by[0]->first_name." ".$acccount_created_by[0]->last_name);
                        $request->session()->put("account_created_by_role_type", $acccount_created_by[0]->role_type);         
                        }    
                            
                            
                        /*Check Super Admin Role*/    
                        if(Auth::check() && $roles[0]->role_id==1)
            			{
                            return redirect("/super_admin/dashboard");
            			}
                        /*Check Admin Role*/    
            			else if(Auth::check() && $roles[0]->role_id==2)
            			{
                            
                            if(session("myuser_schools"))
                            {
                                return redirect("/admin/dashboard");
                                
                            }
                            else
                            {
                                return redirect("/")->with('login_fail_message','You Are Not Assigned To Any School!...');
                            }
                            
                        }
                        /*Check Teacher Role*/
                        else if(Auth::check() && $roles[0]->role_id==3)
            			{
                            
                            if(session("myuser_schools"))
                            {
                            
                                return redirect("/teacher/dashboard"); 
                                
                            }
                            else
                            {
                                return redirect("/")->with('login_fail_message','You Are Not Assigned To Any School!...');
                            }
                            
                            
                            
            			}    
                    
                            
                        }
                        /*Check If User Account Is Not Active*/
                        else
                        {
                          return redirect("/")->with('login_fail_message','Your Account Is Deactive!...');  
                        }    
                    }
                    /*Check If Email Or Password Is Incorrect*/    
            		else
            		{
            			return redirect("/")->with('login_fail_message','Email Or Password Is Incorrect!...');
            		}
            }

            else
            {
                return redirect("/")->with('login_fail_message','Database Connection Error!...');
            }
		
        }		
	}
  
    /*Logout User Account*/
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect('/')->with("logout_message","Logout Successfully!...");
    }

    /*Change/Switch User Account According To User Role ID*/
    public function switch_user_role($role_id)
    {
        Session::put('role_id',$role_id);   
        return redirect('/');
    }

    /*Forgot Password*/
    public function forgot_passowrd()
    {
        return view("forgot_password");
    }

    /*Verfy Email Address Throug JQuery Ajax*/
    public function forgot_password_verify_email(Request $request)
    {
       
         if (Schema::hasTable('sms_users')) 
            {

                $user = Sms_user::where('email', '=', $request->email)->first();

                if ($user === null) 
                {
                    echo "email_not_exists";
                }
                else
                {
                    echo "email_exists";
                } 
            }
            else
            {
                 return response()->json(["message"=>'fail',"result"=>"Database Connection Error!..."]);
            }
    }

    /*Validation of Password and login to User Through Auth and Redirect to Dashboard*/
    public function forgot_password_login(Request $request)
    {
        $controls  = $request->all();
        
        //JQUERY VALIDATION
        $rules = array(
            "password"          => "required|min:8|max:20",
            "confirm_password"  => "required|same:password",
        );
        
        $messages = [
            'password.required'         => 'Please enter :attribute',
            'password.min'              => 'Minimum length of :attribute is 8',
            'password.max'              => 'Maximum length of :attribute is 20',
            'confirm_password.required' => 'Please enter :attribute',
            'confirm_password.same'     => 'Confirm password must match with password',
        ];
        
        $validator  = Validator::make($controls, $rules,$messages);
        
        /*If Validation Fails*/
        if($validator->fails())
        {
            return redirect("/forgot_password")->withErrors($validator);
        }
        else
        {
            $password = bcrypt($controls['confirm_password']);

            $data = array(
                "password" => $password
            );

            //Update Password
            $update_password = Sms_user::where("email","=",$controls['email_address'])->update($data);
            
            if($update_password)
            {
                /*Login Though Auth*/
                if(Auth::attempt(["email"=>$request->input("email_address"), "password"=>$request->input("confirm_password")]))
                {
                    /*Getting Roles From Sms_user Model*/    
                    $roles = Sms_user::roles(Auth::user()->id);    
                  
                    $user_roles = Sms_user::get_all_user_roles(Auth::user()->id);    
                    $qualification = Sms_user::get_user_qualification(Auth::user()->sms_qualification_id);
                    $acccount_created_by = Sms_user::get_user_information_with_role_type_by_role_user_id(Auth::user()->sms_role_user_id);

                    /*USER SCHOOLS START*/
                    $user_schools = Sms_user::get_user_schools(Auth::user()->id);
                    
                    $myuser_schools = array();
                    
                    if($user_schools)
                    {
                        foreach ($user_schools as $school) 
                        {
                            if($school->role_id == 2)
                            {
                                $myuser_schools[$school->role_id]['school_id'] = $school->school_id;
                                $myuser_schools[$school->role_id]['school_name'] = $school->school;
                            }
                            else
                            {
                                $myuser_schools[$school->role_id]['school_id'] = $school->school_id;
                                $myuser_schools[$school->role_id]['school_name'] = $school->school;
                            }
                        }
                    }
                    /*USER SCHOOLS END*/
                        
                    /*Setting User Data In Session*/
                    $request->session()->put('user_roles',$user_roles);    
                    $request->session()->put("role_id", $roles[0]->role_id);
                    $request->session()->put("role_type", $roles[0]->role_type);
                    $request->session()->put("user_id", Auth::user()->id);
                    $request->session()->put("first_name", Auth::user()->first_name);
                    $request->session()->put("last_name", Auth::user()->last_name);    
                    $request->session()->put("profile_image", Auth::user()->profile_image);
                    $request->session()->put("degree_title", $qualification[0]->degree_title);
                    $request->session()->put("degree_description", $qualification[0]->degree_description);
                    
                    /*USER SCHOOLS SESSIONS START*/
                    $request->session()->put('myuser_schools',$myuser_schools);
                    $request->session()->put('user_schools',$user_schools);
                    /*USER SCHOOLS SESSIONS END*/
                    
                    if($acccount_created_by)
                    {
                        $request->session()->put("account_created_by_full_name", $acccount_created_by[0]->first_name." ".$acccount_created_by[0]->last_name);
                        $request->session()->put("account_created_by_role_type", $acccount_created_by[0]->role_type);         
                    }
                           
                    /*Check Super Admin Role*/    
                    if(Auth::check() && $roles[0]->role_id==1)
                    { 
                        return redirect("/super_admin/dashboard")->with('forgot_pass_message_update','Your Password Has Been Reset Successfully!...');
                    }
                    /*Check Admin Role*/    
                    else if(Auth::check() && $roles[0]->role_id==2)
                    {
                        return redirect("/admin/dashboard")->with('forgot_pass_message_update','Your Password Has Been Reset Successfully!...');
                    }
                    /*Check Teacher Role*/
                    else if(Auth::check() && $roles[0]->role_id==3)
                    {
                        return redirect("/teacher/dashboard")->with('forgot_pass_message_update','Your Password Has Been Reset Successfully!...');
                    }    
                }
                else
                {
                    return redirect("/forgot_password")->with('forgot_password_fail_message','Some Error Occurs Please Try Again Later!...');
                }    
            }
            else
            {
                return redirect("/forgot_password")->with('forgot_password_fail_message','Password Has Not been Updated!...');
            }
            
        }
    }


}//Class