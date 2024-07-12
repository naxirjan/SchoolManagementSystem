<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Sms_role_user extends Model
{
    //
	protected $fillable = [
        "sms_user_id","sms_role_id","status"
    ];


    /*GET SCHOOLS BY USER ID AND ROLE ID*/
    public static function get_schools_by_user_id_and_role_id($user_id, $role_id)
    {
        $result = DB::select("SELECT * FROM sms_role_user,sms_school_role_user WHERE sms_user_id = $user_id AND sms_role_id = $role_id AND sms_role_user.id = sms_school_role_user.sms_role_user_id AND sms_school_role_user.status=1");

        return $result;
    }

    /*ASSIGN SUPER ADMIN ROLE*/
    public static function assign_super_admin_role($user_id, $role_id)
    {
    	$already_assigned = DB::select("SELECT * FROM sms_role_user WHERE  sms_user_id = $user_id AND sms_role_id = $role_id");

    	if($already_assigned)
    	{
    		$result = "Already_Assigned";
    	}
    	else
    	{
    		$result = DB::table("sms_role_user")->insert([
			    'sms_user_id'	=> 	$user_id,
			    'sms_role_id'	=> 	$role_id,
                'created_at'        => date('Y-m-d h:i:s'),
			    'status'		=>	1
			]);
    	}

    	return $result;
    }

    /*ASSIGN SCHOOL ADMIN OR TEACHER ROLE*/
    public static function assign_role_school_admin_or_teacher($user_id , $role_id , $school_id)
    {
    	$already_assigned = DB::select("SELECT * FROM sms_role_user WHERE sms_user_id = $user_id AND sms_role_id = $role_id");

    	if($already_assigned)
    	{
            $role_user_id = $already_assigned['0']->id;
                
            foreach ($school_id as $school) 
            {
                $result = DB::table("sms_school_role_user")->insert([
                    'sms_school_id'     => $school,
                    'sms_role_user_id'  => $role_user_id,
                    'created_at'        => date('Y-m-d h:i:s'),
                    'status'            => 1
                ]);
            }

            $result = "Already_Assigned";
    	}
    	else
    	{
    		$result_insert_id = DB::table("sms_role_user")->insertGetId([
	    		'sms_user_id'	=> $user_id,
	    		'sms_role_id'	=> $role_id,
                'created_at'        => date('Y-m-d h:i:s'),
	    		'status'		=> 1
	    	]);

	    	if($result_insert_id)
	    	{
	            foreach ($school_id as $myschool_id)
	            {
	                $result = DB::table("sms_school_role_user")->insert([
	                    'sms_school_id'     => $myschool_id,
	                    'sms_role_user_id'  => $result_insert_id,
                        'created_at'        => date('Y-m-d h:i:s'),
	                    'status'            => 1
	                ]);    
	            }
	    		
		        if(!$result)
		        {
		        	$result = 0;
		        }
	    	}
	    	else
	    	{
	    		$result = 0;
	    	}	
    	}
    	
    	return $result;
    }

    /*ASSIGN SUPER ADMIN AND ADMIN OR TEACHER ROLE*/
    public static function assign_super_admin_and_admin_or_teacher_role($user_id , $roles , $schools)
    {
        foreach ($roles as $role) 
        {
            if($role == 1)
            {
                $already_assigned = DB::select("SELECT * FROM sms_role_user WHERE sms_user_id = $user_id AND sms_role_id = $role");

                if($already_assigned)
                {
                    $result = "Already_Assigned";
                }
                else
                {
                    $result = DB::table("sms_role_user")->insert([
                        'sms_user_id'   =>  $user_id,
                        'sms_role_id'   =>  $role_id,
                        'created_at'        => date('Y-m-d h:i:s'),
                        'status'        =>  1
                    ]);
                }
            }
            else
            {
                $result_insert_id = DB::table("sms_role_user")->insertGetId([
                    'sms_user_id'   =>  $user_id,
                    'sms_role_id'   =>  $role,
                    'created_at'        => date('Y-m-d h:i:s'),
                    'status'        =>  1
                ]);
            }  
        }

        if($result_insert_id)
        {
            foreach ($schools as $school_id) 
            {
                $result = DB::table("sms_school_role_user")->insert([
                    'sms_school_id'     => $school_id,
                    'sms_role_user_id'  => $result_insert_id,
                    'created_at'        => date('Y-m-d h:i:s'),
                    'status'            => 1
                ]);
            }

            if(!$result)
            {
                $result = 0;
            }
        }
        else
        {
            $result = 0;
        }

        return $result;
    }

    /*ASSIGN SCHOOL ADMIN AND SCHOOL TEACHER ROLE*/
    public static function assign_school_admin_and_school_teacher_role($user_id,$roles,$schools_admin, $schools_teacher)
    {
        foreach ($roles as $role_id) 
        {

            $already_assigned = DB::select("SELECT * FROM sms_role_user WHERE sms_user_id = $user_id AND sms_role_id = $role_id");
            if($already_assigned)
            {
                $result_insert_id = $already_assigned['0']->id;
            }
            else
            {
                $result_insert_id = DB::table("sms_role_user")->insertGetId([
                    'sms_user_id'   =>  $user_id,
                    'sms_role_id'   =>  $role_id,
                    'created_at'    =>  date('Y-m-d h:i:s'),
                    'status'        =>  1
                ]);
            }   

            if($result_insert_id)
            {
                if($role_id == 2)
                {
                    foreach ($schools_admin as $school_id) 
                    {
                        $result = DB::table("sms_school_role_user")->insert([
                            'sms_school_id'     => $school_id,
                            'sms_role_user_id'  => $result_insert_id,
                            'created_at'        => date('Y-m-d h:i:s'),
                            'status'            => 1
                        ]);
                    }

                    if(!$result)
                    {
                        $result = 0;
                    }
                }
                else if($role_id == 3)
                {
                    foreach ($schools_teacher as $school_id) 
                    {
                        $result = DB::table("sms_school_role_user")->insert([
                            'sms_school_id'     => $school_id,
                            'sms_role_user_id'  => $result_insert_id,
                            'created_at'        => date('Y-m-d h:i:s'),
                            'status'            => 1
                        ]);
                    }

                    if(!$result)
                    {
                        $result = 0;
                    }
                }
            }
            else
            {
                $result = 0;
            }
        }
        

        return $result;
    }

    /*ASSIGN SUPER ADMIN, SCHOOL ADMIN AND TEACHER ROLES TO USER*/
    public static function assign_super_admin_school_admin_and_teacher_roles_to_user($user_id,$roles,$schools_admin,$schools_teacher)
    {
        foreach ($roles as $role_id)
        {
            $already_assigned = DB::select("SELECT * FROM sms_role_user WHERE sms_user_id = $user_id AND sms_role_id = $role_id");
            if($already_assigned)
            {
                $result_insert_id = $already_assigned['0']->id;
            }
            else
            {
                $result_insert_id = DB::table("sms_role_user")->insertGetId([
                    'sms_user_id'   =>  $user_id,
                    'sms_role_id'   =>  $role_id,
                    'created_at'        => date('Y-m-d h:i:s'),
                    'status'        =>  1
                ]);
            }   

            if($result_insert_id)
            {
                if($role_id == 2)
                {
                    foreach ($schools_admin as $school_id) 
                    {
                        $result = DB::table("sms_school_role_user")->insert([
                            'sms_school_id'     => $school_id,
                            'sms_role_user_id'  => $result_insert_id,
                            'created_at'        => date('Y-m-d h:i:s'),
                            'status'            => 1
                        ]);
                    }

                    if(!$result)
                    {
                        $result = 0;
                    }
                }
                else if ($role_id == 3)
                {
                    foreach ($schools_teacher as $school_id) 
                    {
                        $result = DB::table("sms_school_role_user")->insert([
                            'sms_school_id'     => $school_id,
                            'sms_role_user_id'  => $result_insert_id,
                            'created_at'        => date('Y-m-d h:i:s'),
                            'status'            => 1
                        ]);
                    }

                    if(!$result)
                    {
                        $result = 0;
                    }
                }
            }
            else
            {
                $result = 0;
            }
        }

        return $result;
    }
	
	public static function active_super_admin($role_user_id)
    {
        $update=  DB::table('sms_role_user')
            ->where('id',"=", $role_user_id)
            ->update(['status' => 1]);
       
        return $update;
    }

    public static function inactive_super_admin($role_user_id)
    {
        $update=  DB::table('sms_role_user')
            ->where('id',"=", $role_user_id)
            ->update(['status' => 0]);
       
        return $update;   
    }
}
