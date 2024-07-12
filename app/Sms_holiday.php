<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class Sms_holiday extends Model
{
    //
    protected $fillable = [ 'sms_role_user_id','title','description', 'start_date' , 'end_date' , 'status'  ];





    /* Get User Role */
	public static function get_school_role_user_id()
        {
			
        $result =  DB::select("
                    SELECT sms_role_user.id FROM sms_role_user
                     WHERE sms_role_user.sms_user_id = '".session('user_id')."'
                     AND sms_role_user.sms_role_id= '".session('role_id')."'");    
           
 return $result;
					   
        }

        /* Get User Role ID */
        public static function get_user_detail_and_role_types_by_user_id($role_user_id)
        {
            $result = DB::table("sms_role_user")
                            ->join("sms_users","sms_role_user.sms_user_id","=","sms_users.id")
                            ->join("sms_roles","sms_role_user.sms_role_id","=","sms_roles.id")
                            ->where("sms_role_user.id",$role_user_id)
                            ->select("sms_users.first_name","sms_roles.role_type","sms_role_user.id as role_user_id","sms_role_user.sms_user_id")
                            ->get()->toArray();

            return $result;
        }

        /*Get School Name By School ID (To show school name in header bar)*/
    public static function get_holiday_title_by_id($holiday_id)
        {
            $holiday_title = DB::table('Sms_holidays')
                                ->where('id','=',$holiday_id)
                                ->select('*')
                                ->get()->toArray();   
                return $holiday_title;
        }

    public static function admin_assigned_schools($role_user_id)
        {
             $admin_schools = DB::select("
                            SELECT sms_users.id as user_id, sms_schools.id as school_id,sms_roles.id,sms_schools.school FROM  sms_users,sms_role_user,sms_school_role_user,sms_schools,sms_roles 
                                WHERE sms_users.id = ".session('user_id')." 
                                AND sms_users.id = sms_role_user.sms_user_id 
                                AND sms_role_user.sms_role_id = sms_roles.id 
                                AND sms_school_role_user.sms_role_user_id = sms_role_user.id 
                                AND sms_school_role_user.sms_school_id = sms_schools.id 
                                AND sms_users.status = 1
                                AND sms_role_user.status = 1 
                                AND sms_schools.status = 1 
                                AND sms_school_role_user.status = 1 
                                AND sms_schools.status = 1
                                AND sms_roles.status = 1
                                AND sms_school_role_user.sms_role_user_id =".$role_user_id);
                     return $admin_schools;
      }

    /*GET user_role_id*/
    public static function get_user_role()
        {
        $result =  DB::select("SELECT sms_school_role_user.id FROM sms_role_user,sms_school_role_user
             WHERE sms_role_user.sms_user_id = '".session('user_id')."'
             AND sms_role_user.sms_role_id= '".session('role_id')."'
             AND sms_role_user.status = 1
             AND sms_school_role_user.status = 1
             AND sms_school_role_user.sms_role_user_id = sms_role_user.id ");    
           return $result;
        }


     /*Get holiday information for view attendance by school id and attendance id */    
    public static function get_holiday_information_for_view_attendance_by_school_id_and_class_attendance_date($school_id,$class_attendance_date){

        /*This code for save all dates in this array for holidays conditions*/
        $get_all_dates = array();
        $month = substr($class_attendance_date,5,2);
        $year = substr($class_attendance_date,0,4);
        $number = cal_days_in_month(CAL_GREGORIAN,$month,$year); // 31
        for($d=1; $d<=$number; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);          
            if (date('m', $time)==$month)       
                $get_all_dates[]=date('Y-m-d', $time);
        }

         $month_year = substr($class_attendance_date,0,4);
         $month_year[4] ="-";
         $month_year .= substr($class_attendance_date,5,2);

        $get_holiday = DB::select("SELECT `sms_holidays`.* 
            FROM `sms_holiday_school`,`sms_holidays`
            WHERE `sms_holiday_school`.`sms_school_id` = ".$school_id."
            AND `sms_holidays`.`id` = `sms_holiday_school`.`sms_holiday_id`
            AND `sms_holidays`.`start_date` LIKE '%".$month_year."%' "); 

        /*set array of store holiday all dates in one array*/
        $get_holidays_dates = array();
        $i=1;$flag  = false;$index = 0;        
        foreach ($get_holiday as $key => $value) {
           
            foreach ($get_all_dates as $key => $value2) {
                
                if($value2 == $value->start_date){
                    
                    $flag  = true;
                }

                if($flag){
                    $get_holidays_dates[$index][$i++] = array('title' =>$value->title ,'description'=>$value->description,'start_date'=>$value->start_date,'end_date'=>$value->end_date,'date'=>$value2);
                }
                
                if($value2 == $value->end_date){
                   
                    $flag  = false;
                }

            
             }
             $index++;
        
        }
       
    return $get_holidays_dates;
	


    }
	
	/*Get holiday information for view attendance by school id and by date range */    
	public static function get_holiday_information_for_view_attendance_by_school_id_and_date_range($school_id,$date_from,$date_to){
		
		$from_date = date('Y-m-d',strtotime($date_from));
		$to_date = date('Y-m-d',strtotime($date_to));
		
		// Iterate over the period
		$period = CarbonPeriod::create($from_date,$to_date);
		$get_all_dates = array();
		foreach ($period as $date) {
			 $get_all_dates[] = $date->format('Y-m-d');
		}
		
		$get_holiday = DB::select("SELECT `sms_holidays`.* 
		FROM `sms_holiday_school`,`sms_holidays`
		WHERE `sms_holiday_school`.`sms_school_id` = 1
		AND `sms_holidays`.`id` = `sms_holiday_school`.`sms_holiday_id`
		AND `sms_holidays`.`start_date` BETWEEN '".$from_date."' AND '".$to_date."' "); 

        /*set array of store holiday all dates in one array*/
        $get_holidays_dates = array();
        $i=1;$flag  = false;$index = 0;        
        foreach ($get_holiday as $key => $value) {
           
            foreach ($get_all_dates as $key => $value2) {
                
                if($value2 == $value->start_date){
                    
                    $flag  = true;
                }

                if($flag){
                    $get_holidays_dates[$index][$i++] = array('title' =>$value->title ,'description'=>$value->description,'start_date'=>$value->start_date,'end_date'=>$value->end_date,'date'=>$value2);
                }
                
                if($value2 == $value->end_date){
                   
                    $flag  = false;
                }

            
             }
             $index++;
        
        }
        
	   
		return $get_holidays_dates;
	
		
	}
	
	
	
	
	

   

    }