<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Sms_school_role_user extends Model
{
    //
    protected $fillable = [
        "sms_school_id","sms_role_user_id","status"
    ];


    public static function get_teachers_of_school($school_id)
    {
    	$result = DB::table("sms_school_role_user")
        ->join("sms_role_user","sms_role_user.id","=","sms_school_role_user.sms_role_user_id")
        ->join("sms_users","sms_role_user.sms_user_id","=","sms_users.id")
        ->where("sms_school_role_user.sms_school_id",$school_id)
        ->where("sms_role_user.sms_role_id",3)
        ->where("sms_users.status",1)
        ->where("sms_role_user.status",1)
        ->select("sms_users.*")
        ->get()->toArray();
        return $result;
    }

    public static function active_school_for_school_admin_or_teacher($school_role_user_id)
    {
        $update=  DB::table('sms_school_role_user')
            ->where('id',"=", $school_role_user_id)
            ->update(['updated_at'=>date('Y-m-d h:i:s'),'status' => 1]);
       
        return $update;
    }

    public static function inactive_school_for_school_admin_or_teacher($school_role_user_id)
    {
        $update=  DB::table('sms_school_role_user')
            ->where('id',"=", $school_role_user_id)
            ->update(['updated_at'=>date('Y-m-d h:i:s'),'status' => 0]);
       
        return $update;   
    }

    public static function get_current_school_teacher($user_id,$school_id)
    {
    	$result = DB::select("SELECT sru.status, sru.id AS school_role_user_id, s.school AS school_name, r.role_type FROM sms_school_role_user sru,sms_role_user ru,sms_schools s, sms_users u, sms_roles r 
        WHERE sru.sms_school_id = s.id 
        AND sru.sms_role_user_id = ru.id 
        AND ru.sms_user_id = u.id 
        AND ru.sms_role_id = r.id 
        AND s.status=1
        AND u.status=1
        AND r.status=1
        AND ru.status=1
        AND sru.status=1
        AND u.id = $user_id 
        AND r.id = 3 
        AND s.id = $school_id");

    	return $result;
    }



public static function get_teachers_by_school_id($school_id)
{
    $result = DB::select("SELECT COUNT(sru.sms_role_user_id) AS 'total_teachers' FROM `sms_school_role_user` sru,`sms_role_user` ru 
WHERE sru.sms_role_user_id = ru.id
AND ru.sms_role_id=3
AND sru.sms_school_id = ".$school_id." ");

return $result[0]->total_teachers;

}

}