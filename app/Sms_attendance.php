<?php

namespace App;



use Illuminate\Database\Eloquent\Model;
use DB;


class Sms_attendance extends Model
{

    protected $fillable = ["sms_student_id","sms_attendance_class_id","created_date","updated_date","created_time","updated_time","class_image","status"];

    

  public static function get_daily_attendance_report($sms_class_school_id,$attendance_date)
  {
    
    $result = DB::select("SELECT `sms_attendance_class`.id,`sms_attendance_class`.sms_role_user_id,`sms_attendance_class`.class_image,`sms_class_student`.`student_image`,`sms_students`.`first_name`,`sms_students`.`middle_name`,`sms_students`.`last_name`,`sms_students`.`gender` ,`sms_attendances`.`status`,sms_class_student.created_at,sms_students.id as student_id FROM `sms_attendance_class`,`sms_students`,`sms_attendances`,`sms_class_student` WHERE  `sms_class_student`.`sms_student_id` = `sms_students`.`id` AND `sms_attendances`.`sms_attendance_class_id` = `sms_attendance_class`.`id` AND `sms_students`.`id` = `sms_attendances`.`sms_student_id` AND `sms_attendance_class`.`sms_class_school_id` = '".$sms_class_school_id."' AND  `sms_attendance_class`.`created_date` = '".$attendance_date."' ");            
    
    return $result;

  }



           public static function get_all_student_attendance_status_by_class_school_id($sms_class_school_id,$attendance_date,$status)
             {
        
                $result = DB::select("
                        SELECT `sms_class_student`.`created_at`,`sms_class_student`.`student_image`,`sms_students`.`first_name`,`sms_students`.`middle_name`,`sms_students`.`last_name`,`sms_students`.`gender` ,`sms_attendances`.`status`
                             FROM `sms_attendance_class`,`sms_students`,`sms_attendances`,`sms_class_student`
                             WHERE  `sms_class_student`.`sms_student_id` = `sms_students`.`id`
                             AND `sms_attendances`.`sms_attendance_class_id` = `sms_attendance_class`.`id`
                             AND `sms_students`.`id` = `sms_attendances`.`sms_student_id`
                             AND `sms_attendance_class`.`sms_class_school_id` = '".$sms_class_school_id."'
                             AND  `sms_attendance_class`.`created_date` = '".$attendance_date."' 
                             AND  `sms_attendances`.`status` = ".$status." "); 
                                      

                            return $result;
            }

            public static function get_students_attendance_by_class_school_id($class_school_id,$date)
                      {
                          $result = DB::select( "SELECT s.`id` AS 'student_id',ac.id AS 'attendance_class_id',a.id AS 'attendance_id',s.first_name,s.middle_name,s.last_name,s.gender , cstd.student_image,a.status,ac.class_image,ac.sms_role_user_id
                                               FROM `sms_attendance_class` ac,`sms_students` s,`sms_attendances` a,`sms_class_student` cstd,`sms_class_school` cs
                                                  WHERE  cstd.`sms_student_id` = s.`id`
                                                  AND a.`sms_attendance_class_id` = ac.`id`
                                                  AND cs.id = cstd.sms_class_school_id
                                                  AND s.`id` = a.`sms_student_id`
                                                  AND ac.sms_class_school_id=cs.id
                                                  AND ac.status=1
                                                  AND cstd.status=1
                                                  AND ac.`sms_class_school_id` = ".$class_school_id."
                                                  AND ac.`created_date` = '".$date."'
                                                  ");
                      return $result;
                      }

            public static function get_monthly_combine_attendance($sms_class_school_id,$year_and_month)
                {
                    $result = DB::select("SELECT sms_class_student.student_image ,sms_students.first_name,sms_students.last_name,sms_students.gender,sms_students.id,sms_attendances.status,sms_attendances.sms_attendance_class_id,sms_attendance_class.created_date,sms_attendance_class.class_image FROM sms_class_student,sms_students,sms_attendances,sms_attendance_class WHERE sms_class_student.sms_class_school_id = '".$sms_class_school_id."' AND sms_attendance_class.created_date LIKE '%".$year_and_month."%' AND sms_class_student.sms_student_id = sms_students.id AND sms_attendances.sms_student_id = sms_students.id AND sms_attendance_class.id = sms_attendances.sms_attendance_class_id");

                    return $result;

                }


	public static function get_date_range_combine_attendance($class_school_id,$date_from,$date_to)
	{
		$result = DB::select("SELECT sms_class_student.student_image ,sms_students.first_name,sms_students.last_name,sms_students.gender,sms_students.id,sms_attendances.status,sms_attendances.sms_attendance_class_id,sms_attendance_class.created_date,sms_attendance_class.class_image FROM sms_class_student,sms_students,sms_attendances,sms_attendance_class WHERE sms_class_student.sms_class_school_id = '".$class_school_id."' AND sms_attendance_class.created_date BETWEEN '".$date_from."' AND '".$date_to."' AND sms_class_student.sms_student_id = sms_students.id AND sms_attendances.sms_student_id = sms_students.id AND sms_attendance_class.id = sms_attendances.sms_attendance_class_id");
		return $result;
	}

	public static function get_date_range_student_attendance($class_school_id,$student_id,$date_from,$date_to)
	{
		$result = DB::select("SELECT sms_class_student.student_image ,sms_students.first_name,sms_students.last_name,sms_students.gender, sms_students.id,sms_attendances.status,sms_attendances.sms_attendance_class_id,sms_attendance_class.created_date  FROM sms_class_student,sms_students,sms_attendances,sms_attendance_class WHERE sms_class_student.sms_class_school_id = '".$class_school_id."' AND `sms_attendances`.`sms_student_id` = '".$student_id."' AND `sms_attendances`.`sms_student_id` = `sms_students`.`id` AND `sms_attendance_class`.`created_date` BETWEEN '".$date_from."' AND  '".$date_to."' AND sms_class_student.sms_student_id = sms_students.id  AND sms_attendances.sms_student_id = sms_students.id  AND sms_attendance_class.id = sms_attendances.sms_attendance_class_id");
		return $result;
	}
	

 
public static function check_current_date_attendance_by_role_user_id($class_school_id,$role_user_id,$current_date)
{
    $result = DB::table("sms_attendance_class")
                ->where('sms_class_school_id',"=",$class_school_id)
                ->where('sms_role_user_id',"=",$role_user_id)
                ->where('created_date',"=",$current_date)
                ->get()->toArray();
    

return $result;
}
    
    
public static function check_current_date_attendance($class_school_id,$current_date)
{
    $result = DB::table("sms_attendance_class")
                ->where('sms_class_school_id',"=",$class_school_id)
                ->where('created_date',"=",$current_date)
                ->get()->toArray();
return $result;
}    
     
    
        
public static function insert_class_attendance_image($class_school_id,$role_user_id,$image,$date)
{
    $result = DB::table("sms_attendance_class")->insertGetId([
        "sms_class_school_id" =>$class_school_id,
        "sms_role_user_id" =>$role_user_id,
        "class_image" =>$image,
        "created_date" =>$date,
        "created_time"=>date("h:i:s"),
        "created_at"=>date("Y-m-d h:i:s"),
        "status"=>1  
    ]);
    
    return $result;
} 

    /*Insert in Sms_attendance table is done though Eloquent Method*/
    
    
public static function insert_class_attendance_detail($sms_attendance_id,$reason)
{
    $result = DB::table("sms_student_attendance_detail")->insert([
        "sms_attendance_id" =>$sms_attendance_id,
        "reason"            =>$reason, 
        "created_at"        =>date("Y-m-d h:i:s"),
        "status"            =>1  
    ]);
    return $result;
} 


public static function delete_attendance_reason_by($attendance_detail_id)
{
    $result = DB::table('sms_student_attendance_detail')->where('id',$attendance_detail_id)->delete();
    
    return $result;
}
    
    
public static function get_students_attendance_by_class_school_id_role_user_id($class_school_id,$role_user_id,$date)
{
    $result = DB::select( "SELECT s.`id` AS 'student_id',ac.id AS 'attendance_class_id',a.id AS 'attendance_id',s.first_name,s.middle_name,s.last_name,s.gender , cstd.student_image,a.status,ac.class_image
	                       FROM `sms_attendance_class` ac,`sms_students` s,`sms_attendances` a,`sms_class_student` cstd,`sms_class_school` cs
                            WHERE  cstd.`sms_student_id` = s.`id`
                            AND a.`sms_attendance_class_id` = ac.`id`
                            AND cs.id = cstd.sms_class_school_id
                            AND s.`id` = a.`sms_student_id`
                            AND ac.sms_class_school_id=cs.id
                            AND ac.status=1
                            AND cstd.status=1
                            AND ac.`sms_class_school_id` = ".$class_school_id."
                            AND ac.sms_role_user_id= ".$role_user_id."
                            AND ac.`created_date` = '".$date."'
                            ");

return $result;
}




public static function get_all_students_attendance_by_class_school_id($class_school_id,$date)
{
    $result = DB::select( "SELECT s.`id` AS 'student_id',ac.id AS 'attendance_class_id',a.id AS 'attendance_id',s.first_name,s.middle_name,s.last_name,s.gender , cstd.student_image,a.status,ac.class_image
                           FROM `sms_attendance_class` ac,`sms_students` s,`sms_attendances` a,`sms_class_student` cstd,`sms_class_school` cs
                            WHERE  cstd.`sms_student_id` = s.`id`
                            AND a.`sms_attendance_class_id` = ac.`id`
                            AND cs.id = cstd.sms_class_school_id
                            AND s.`id` = a.`sms_student_id`
                            AND ac.sms_class_school_id=cs.id
                            AND ac.status=1
                            AND cstd.status=1
                            AND ac.`sms_class_school_id` = ".$class_school_id."
                            AND ac.`created_date` = '".$date."'
                            ");

return $result;
}




    
public static function get_attendance_reason_by_attendance_id($attendance_id) 
{
    $result = DB::table("sms_student_attendance_detail")
                        ->where('sms_attendance_id',$attendance_id)
                        ->get()->toArray();

    return $result;
}   
    

public static function update_attendance_class_image($attendance_class_id,$data)
{
    $result =  DB::table('sms_attendance_class')
            ->where('id',$attendance_class_id)
            ->update($data);    

return $result;
}    
    
public static function update_attendance($attendance_id,$data)
{
    $result =  DB::table('sms_attendances')
            ->where('id',$attendance_id)
            ->update($data);    

return $result;   
}
    

public static function update_attendance_detail($student_attendance_detail_id,$data)
{
    $result =  DB::table('sms_student_attendance_detail')
            ->where('id',$student_attendance_detail_id)
            ->update($data);    

return $result;   
}


    /*Get get present students by attendance id*/
    public static function get_present_students_by_attendacne_id($get_attendance_id){

         $get_present_students = DB::select("SELECT COUNT(`sms_attendances`.`status`) AS 'present_students'
                                            FROM `sms_attendances` 
                                            WHERE `sms_attendances`.`status` = 1
                                            AND `sms_attendances`.`sms_attendance_class_id` = ".$get_attendance_id." ");

         return $get_present_students;
    }

    /*Get get absent students by attendance id*/
    public static function get_absent_students_by_attendacne_id($get_attendance_id){

         $get_absent_students = DB::select("SELECT COUNT(`sms_attendances`.`status`) AS 'absent_students'
                                            FROM `sms_attendances` 
                                            WHERE `sms_attendances`.`status` = 0
                                            AND `sms_attendances`.`sms_attendance_class_id` = ".$get_attendance_id." ");


         return $get_absent_students;
    }


    /*Get monthly attendance recored day by day by class_school_id and month and year*/
    public static function get_attendance_recoreds_monthly_per_day_attendance_info_by_class_school_id($class_school_id,$month_year){

        

        /*get attendace class and created date for get all attendance info by class_school_id and month year*/
        $get_class_attendance = DB::select("SELECT `sms_attendance_class`.`id`,`sms_attendance_class`.`created_date`,`sms_attendance_class`.class_image
                                            FROM `sms_attendance_class`
                                            WHERE `sms_attendance_class`.`sms_class_school_id` = ".$class_school_id."
                                            AND `sms_attendance_class`.`created_date` LIKE '%".$month_year."%' ");
        
        return $get_class_attendance;

       


    }
	
	
	/*Get monthly attendance recored day by day by class_school_id and date range*/
    public static function get_attendance_recoreds_date_range_attendance_info_by_class_school_id($class_school_id,$date_from,$date_to){
		
		$from_date = date('Y-m-d',strtotime($date_from));
		$to_date = date('Y-m-d',strtotime($date_to));
		
		/*get attendace class id and created date for get all attendance info by class_school_id and date range*/
        $get_class_attendance = DB::select("SELECT `sms_attendance_class`.`id`,`sms_attendance_class`.`created_date`,`sms_attendance_class`.`class_image`
                                            FROM `sms_attendance_class`
                                            WHERE `sms_attendance_class`.`sms_class_school_id` = ".$class_school_id."
                                            AND `sms_attendance_class`.`created_date` BETWEEN '".$from_date."' AND '".$to_date."' ");
        
        return $get_class_attendance;
		
		
	}



        public static function count_total_working_days_by_class_school_id_date_range($class_school_id,$from_date,$to_date)
        {
            $result = DB::select("SELECT ac.created_date AS 'class_attendance_date',ac.id AS 'attendance_class_id' FROM `sms_attendance_class` ac WHERE ac.sms_class_school_id = ".$class_school_id." AND ac.created_date BETWEEN '".$from_date."' AND '".$to_date."'");
            
                return $result;
        }

        public static function get_yearly_attendance_report($sms_class_school_id,$year)
        {
          $result = DB::select("SELECT COUNT(ac.`created_date`) AS 'total_month_days' 
                              FROM `sms_attendance_class` ac 
                              WHERE ac.`sms_class_school_id`='".$sms_class_school_id."' 
                              AND ac.`created_date` LIKE '%".$year."%' ");

                              return $result[0]->total_month_days;
        }
    
   
    public static function get_attendance_by_class_school_id_date_range($class_school_id,$from_date,$to_date,$status)
    {
        $result = DB::select("SELECT COUNT(a.status) AS 'total_days' FROM `sms_attendance_class` ac,`sms_attendances` a
        WHERE a.`sms_attendance_class_id` = ac.`id`
        AND ac.status=1
        AND a.status=".$status."
        AND ac.`sms_class_school_id` = ".$class_school_id."
        AND ac.created_date BETWEEN '".$from_date."' AND '".$to_date."'");
    
        return $result;
    }

    public static function get_attendance_by_class_school_id_with_status($class_school_id,$month_year,$status)
    {
      $result = DB::select("SELECT count(a.status) as 'present_students' FROM `sms_attendance_class` ac,`sms_attendances` a
                          WHERE a.`sms_attendance_class_id` = ac.`id`
                          AND ac.status=1
                          AND a.status='".$status."'
                          AND ac.`sms_class_school_id` = '".$class_school_id."'
                          AND ac.created_date LIKE '%".$month_year."%'");

                         return $result[0]->present_students;
    }



public static function get_attendance_by_school_id($school_id,$status,$date)
{
    $result = DB::select("SELECT COUNT(a.sms_student_id) AS 'total_students' FROM `sms_attendance_class` ac,`sms_attendances` a,`sms_class_school` cs
        WHERE a.`sms_attendance_class_id` = ac.`id`
        AND ac.sms_class_school_id = cs.id
        AND cs.sms_school_id = ".$school_id."
        AND a.status = ".$status."
        AND ac.created_date = '".$date."'
        ");

    return $result[0]->total_students;
}

    
    
    
    public static function get_class_attendance_pictures_data($class_school_id,$month)
    {
        
    $result = DB::select("SELECT * FROM `sms_attendance_class` WHERE sms_class_school_id=$class_school_id AND created_date LIKE '%".$month."%' ");

    return $result;
    }
    
    
    
}
