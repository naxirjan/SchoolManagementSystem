<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;

class Sms_user extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sms_qualification_id','sms_role_user_id','first_name','middle_name','last_name','email', 'password','contact_number','gender','address','profile_image','status',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
      /*this function for get current logined user sms_role_user_id*/
    public static function get_current_user_logined_sms_role_user_id(){

            $result =  DB::select("SELECT `sms_role_user`.id FROM `sms_role_user` WHERE `sms_role_user`.sms_user_id = ".Auth::user()->id." AND `sms_role_user`.sms_role_id = ".session('role_id'));

            return $result[0]->id;
    }
    
    

    /*Get User Role which has more preference than other roles to login*/
    public static function roles($id)
    {

        $roles = DB::select("SELECT u.id,r.role_type,r.id AS role_id FROM `sms_users` u,`sms_roles` r,`sms_role_user` ru
            WHERE u.id = ru.sms_user_id
            AND r.id = ru.sms_role_id
            AND u.status=1
            AND r.status =1
            AND ru.status=1
            AND u.id='".$id."'
            ORDER BY r.id ASC LIMIT 1");

        return $roles;
    }

    /*Get all user roles when login*/    
    public static function get_all_user_roles($id)
    {

        $roles = DB::select("SELECT r.role_type,r.id AS role_id,ru.id as role_user_id,ru.status as status FROM `sms_users` u,`sms_roles` r,`sms_role_user` ru
            WHERE u.id = ru.sms_user_id
            AND r.id = ru.sms_role_id
            AND ru.status = 1
            AND r.status = 1
            AND u.status = 1
            AND u.id='".$id."'
            ORDER BY r.id ASC"
            );

        return $roles;
    }
    

    /*Ger User Qualification*/

    public static function get_user_qualification($qualification_id)
    {
    $result =  DB::select("SELECT * FROM `sms_qualifications` WHERE id='".$qualification_id."'");    
    return $result;
    }


    /*Ger Account Created By Name*/
    public static function get_user_information_with_role_type_by_role_user_id($role_user_id)
    {
    $result =  DB::select(
        "SELECT u.id,u.`first_name`,u.`last_name`,r.role_type FROM `sms_users` u,`sms_role_user` ru,`sms_roles` r
        WHERE r.id = ru.sms_role_id
        AND u.id = ru.sms_user_id
        AND ru.id='".$role_user_id."' ");    
    return $result;
    }

	  

		
    public static function get_user_schools($user_id)
    {
        $user_schools = DB::select("SELECT sms_users.id as user_id, sms_schools.id as school_id,sms_roles.id as role_id,sms_schools.school 
        FROM  sms_users,sms_role_user,sms_school_role_user,sms_schools,sms_roles 
        WHERE sms_users.id = $user_id 
        AND sms_users.id = sms_role_user.sms_user_id 
        AND sms_role_user.sms_role_id = sms_roles.id 
        AND sms_school_role_user.sms_role_user_id = sms_role_user.id 
        AND sms_school_role_user.sms_school_id = sms_schools.id 
        AND sms_role_user.status = 1 
        AND sms_schools.status = 1 
        AND sms_school_role_user.status = 1 
        ORDER BY sms_school_role_user.id ASC");

        return $user_schools;
    }


    /*reset new password function by user old password*/
    public static function reset_user_password($old_password,$new_password){
        $update = null;
        /*This function check your input old password and database saved password*/
        $user = Sms_user::find(Auth::user()->id);
        if(Hash::check($old_password,$user->password)) {
            $update = Sms_user::where("id",'=',Auth::user()->id)->update(['updated_at'=>date('Y-m-d h:i:s'),'password'=>bcrypt($new_password)]);
        } 
    return $update;

    }
	
	
	
	public static function get_user_schools_without_status($user_id)
    {
        $user_schools_status = DB::select("SELECT sms_users.id as user_id, sms_schools.id as school_id,sms_roles.id as role_id,sms_schools.school,sms_school_role_user.id as sms_school_role_user_id, sms_school_role_user.status as status FROM  sms_users, sms_role_user, sms_school_role_user, sms_schools, sms_roles WHERE sms_users.id = $user_id AND sms_users.id = sms_role_user.sms_user_id AND sms_role_user.sms_role_id = sms_roles.id AND sms_school_role_user.sms_role_user_id = sms_role_user.id AND sms_school_role_user.sms_school_id = sms_schools.id");

        return $user_schools_status;   
    }

    public static function get_all_user_roles_without_status($id)
    {

        $roles = DB::select("SELECT r.role_type,r.id AS role_id,ru.id as role_user_id,ru.status as status FROM `sms_users` u,`sms_roles` r,`sms_role_user` ru
            WHERE u.id = ru.sms_user_id
            AND r.id = ru.sms_role_id
            AND u.id='".$id."'
            ORDER BY r.id ASC"
            );

        return $roles;
    }



    
    
}
