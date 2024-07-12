<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Holiday_school extends Model
{
    //
    protected $fillable = ["sms_school_id","sms_holiday_id","status"];

    public static function assign_holiday_to_school($school_id,$holiday_id)
    {

     $result = DB::table('sms_holiday_school')->insert([
            'sms_school_id'  =>$school_id,
            'sms_holiday_id' =>$holiday_id,
            'created_at'    =>date("Y-m-d h:i:s"),
            'status'        =>1
        ]);  
    	
    	return $result;
    }

    public static function admin_assign_holiday_to_his_school($admin_school_id,$holiday_id)
    {
        
        $result = DB::table('sms_holiday_school')->insert([
            'sms_school_id'=> $admin_school_id,
            'sms_holiday_id'=> $holiday_id,
            'created_at'=>date("Y-m-d h:i:s"),
            'status'=>1
        ]);
        return $result;
    }


    public static function assigend_holiday_of_assigned_school_admin($holiday_id,$sms_role_user_id)
     {
        

        $result = DB::select("
                        SELECT `sms_schools`.`school`,`sms_schools`.id AS 'school_id'
                        FROM `sms_schools`,`sms_holiday_school`,`sms_school_role_user`
                        WHERE `sms_holiday_school`.`sms_holiday_id` = ".$holiday_id."
                        AND `sms_holiday_school`.`sms_school_id` = `sms_schools`.`id`
                        AND `sms_school_role_user`.`sms_school_id` = `sms_schools`.`id`
                        AND `sms_school_role_user`.`sms_role_user_id` = ".$sms_role_user_id);
                         return $result;
     }

   
        /* Get All Schools Of Holiday School */
    public static function get_holiday_assigned_schools($holiday_id)
    {
        $result = DB::select("
                SELECT `sms_schools`.`school`,`sms_schools`.id AS 'school_id'
                FROM `sms_schools`,`sms_holiday_school`,sms_holidays
                WHERE `sms_holiday_school`.`sms_holiday_id` =sms_holidays.id
                AND `sms_holiday_school`.`sms_school_id` = `sms_schools`.`id`
                AND sms_holiday_school.sms_holiday_id=".$holiday_id." ");
    
        return $result;
    
        
    
    }

       /*Get All Holiday School By Holiday ID*/
    public static function get_holiday_school_by_holiday_id($holiday_id)
    {
                $holiday_school =  DB::table('sms_holiday_school')
                        ->join('sms_holidays','sms_holiday_school.sms_holiday_id','=','sms_holidays.id')
                        ->join('sms_schools','sms_holiday_school.sms_school_id','=','sms_schools.id')
                        ->where('sms_holiday_school.status',1)
                        ->where('sms_holidays.status',1)
                        ->where('sms_schools.status',1)
                        ->where('sms_holidays.id','=',$holiday_id)
                        ->select('sms_holiday_school.sms_school_id','sms_schools.school','sms_holidays.id AS holiday_id','sms_holidays.title')
                        ->get()->toArray();      
    return $holiday_school;     
    }


    public static function get_holiday_by_school_id($school_id,$daily_attendance_date)
    {
        $result = DB::select("SELECT h.* FROM `sms_schools` s,`sms_holidays` h,`sms_holiday_school` hs
        WHERE h.id = hs.sms_holiday_id
        AND s.id = hs.sms_school_id
        AND s.status =1
        AND h.status=1
        AND hs.status=1
        AND h.start_date <='".$daily_attendance_date."'
        AND h.end_date >= '".$daily_attendance_date."'
        AND s.id=".$school_id." ");
    
        return $result;
    }




    public static function get_school_holidays_by_school_id($school_id)
    {
        $result  = DB::select("SELECT `sms_schools`.`school`,sms_holidays.*
                FROM `sms_schools`,`sms_holiday_school`,sms_holidays
                WHERE `sms_holiday_school`.`sms_holiday_id` =sms_holidays.id
        AND `sms_holiday_school`.`sms_school_id` = `sms_schools`.`id`
        AND `sms_holiday_school`.`sms_school_id` = ".$school_id." ");
        return $result;
    }
 }
