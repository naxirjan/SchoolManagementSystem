<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Sms_user;

class Sms_school extends Model
{
    //
    
    //protected $fillable = ["sms_district_operation_id","school","phone_number","email","address","status"];

    protected $fillable = [
        "district_operation_id","school","school_description","phone_number","email","address","status"
    ];
    
    /*Get All Active Schools*/
    public static function get_all_schools()
    {
        
        $result = DB::select("SELECT * FROM `sms_schools` WHERE `sms_schools`.`status` = 1");
        
        return $result;
    }
    
    
    
    /*Get All School Classes By School ID*/
    public static function get_school_classes_by_school_id($school_id)
    {
                $school_classes =  DB::table('sms_class_school')
                        ->join('sms_classes','sms_class_school.sms_class_id','=','sms_classes.id')
                        ->join('sms_schools','sms_class_school.sms_school_id','=','sms_schools.id')
                        ->where('sms_schools.id','=',$school_id)
                        ->where('sms_class_school.status',1)
                        ->where('sms_schools.status',1)
                        ->where('sms_classes.status',1)
                        ->select('sms_schools.school','sms_classes.id AS class_id','sms_classes.class')
                        ->get()->toArray();
                        
        return $school_classes;     
    }
    
    /*Get School Name By School ID (To show school name in header bar)*/
    public static function get_school_name_by_id($school_id)
    {
        $school_name = DB::table('sms_schools')
                            ->where('id','=',$school_id)
                            ->select('school')
                            ->get()->toArray();
       
    return $school_name;
    }


   /*Get school by sms_role_user_id (To show school in add student form in school admin side)*/
    public static function get_school_by_sms_role_user_id($get_sms_role_user_id){
       
        $result_schools = DB::select("SELECT `sms_schools`.* FROM `sms_schools`,`sms_school_role_user`
            WHERE `sms_school_role_user`.`sms_school_id` = `sms_schools`.`id`
            AND `sms_school_role_user`.status=1
            AND `sms_schools`.status=1
            AND `sms_school_role_user`.`sms_role_user_id` = ".$get_sms_role_user_id."
            ORDER BY `sms_schools`.`id` DESC  LIMIT 1");

        return $result_schools;
    }


    /*Making school name for school folder*/
    public static function get_school_name_to_make_school_name_folder($school_id,$school_name)
    {
        $remove_spaces = str_replace(' ', '_', $school_name);
        return strtolower($school_id.'_'.$remove_spaces);
    }

    /*Get all distraction operation */
    public static function get_operation_branch(){
        $result = DB::select("SELECT * FROM `com_operation_branch`");
        return $result;
    }

}
