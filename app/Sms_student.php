<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Sms_user;

class Sms_student extends Model
{
    //
    protected $fillable = [
        "sms_role_user_id","first_name","middle_name","last_name","gaurdian_name","gaurdian_contact_number","gender",  "address","date_of_birth","status",
    ];

    /* Get all students (To show for view students)*/
    public static function get_all_students($get_school_id = NULL){

    	if(!$get_school_id == NULL){
    		
            //get_roles = Sms_user::get_all_user_roles(Auth::user()->id);

        $query = "SELECT `sms_students`.* , `sms_class_student`.`student_image` ,`sms_class_school`.`id` AS 'sms_school_class_id',`sms_classes`.`class`,`sms_schools`.`school`,`sms_schools`.`id` AS 'school_id', CONCAT(`sms_users`.`first_name`,`sms_users`.`last_name`) AS 'created_by',`sms_roles`.`role_type`,`sms_class_student`.`created_at` AS 'class_student_date'
            FROM `sms_students`,`sms_class_student`,`sms_role_user`,`sms_roles`,`sms_users`,`sms_class_school`,`sms_classes`,`sms_schools`
            WHERE `sms_class_student`.`sms_student_id` = `sms_students`.`id`
            AND `sms_role_user`.`id` = `sms_students`.`sms_role_user_id`
            AND `sms_role_user`.`sms_role_id` = `sms_roles`.`id`
            AND `sms_role_user`.`sms_user_id` = `sms_users`.`id`
            AND `sms_class_student`.`sms_class_school_id` = `sms_class_school`.`id`
            AND `sms_class_school`.`sms_class_id` = `sms_classes`.`id`
            AND `sms_class_school`.`sms_school_id` = `sms_schools`.`id`
            AND `sms_class_student`.`status` = 1
            AND `sms_schools`.`id` =".$get_school_id;


    	}else{

			$query = "SELECT `sms_students`.* , `sms_class_student`.`student_image` ,`sms_class_school`.`id` AS 'sms_school_class_id',`sms_classes`.`class`,`sms_schools`.`school`,`sms_schools`.`id` AS 'school_id', CONCAT(`sms_users`.`first_name`,`sms_users`.`last_name`) AS 'created_by',`sms_roles`.`role_type`,`sms_class_student`.`created_at` AS 'class_student_date'
                FROM `sms_students`,`sms_class_student`,`sms_role_user`,`sms_roles`,`sms_users`,`sms_class_school`,`sms_classes`,`sms_schools`
                WHERE `sms_class_student`.`sms_student_id` = `sms_students`.`id`
                AND `sms_role_user`.`id` = `sms_students`.`sms_role_user_id`
                AND `sms_role_user`.`sms_role_id` = `sms_roles`.`id`
                AND `sms_role_user`.`sms_user_id` = `sms_users`.`id`
                AND `sms_class_student`.`sms_class_school_id` = `sms_class_school`.`id`
                AND `sms_class_school`.`sms_class_id` = `sms_classes`.`id`
                AND `sms_class_school`.`sms_school_id` = `sms_schools`.`id`
                AND `sms_class_student`.`status` = 1";

    	}

    	$get_students = DB::select($query);
 		return $get_students;
}

    /*Get Single student information (For view student details)*/
    public static function get_student_datail_by_student_id($student_id){
        $query = "SELECT `sms_students`.* ,`sms_class_student`.`id` as 'class_student_id', `sms_class_student`.`student_image` ,`sms_class_school`.`id` AS 'sms_school_class_id',`sms_classes`.`class`,`sms_schools`.`school`,`sms_schools`.`id` AS 'school_id', CONCAT(`sms_users`.`first_name`,' ',`sms_users`.`last_name`) AS 'created_by',`sms_roles`.`role_type`,`sms_class_student`.created_at as class_student_date
            FROM `sms_students`,`sms_class_student`,`sms_role_user`,`sms_roles`,`sms_users`,`sms_class_school`,`sms_classes`,`sms_schools`
            WHERE `sms_class_student`.`sms_student_id` = `sms_students`.`id`
            AND `sms_role_user`.`id` = `sms_students`.`sms_role_user_id`
            AND `sms_role_user`.`sms_role_id` = `sms_roles`.`id`
            AND `sms_role_user`.`sms_user_id` = `sms_users`.`id`
            AND `sms_class_student`.`sms_class_school_id` = `sms_class_school`.`id`
            AND `sms_class_school`.`sms_class_id` = `sms_classes`.`id`
            AND `sms_class_school`.`sms_school_id` = `sms_schools`.`id`
            AND `sms_class_student`.`status` = 1
            AND `sms_students`.`id` = ".$student_id;
        $get_student = DB::select($query);
        return $get_student;
    }



    /*Get count total students in school class by class_school_id*/
    public static function get_count_total_students_by_class_school_id($class_school_id,$year_month = null){
        
        $result = DB::select("SELECT COUNT(`sms_class_student`.`sms_student_id`) 'total_students' 
        FROM `sms_class_student` 
        WHERE `sms_class_student`.`status` = 1
        AND `sms_class_student`.`sms_class_school_id` = ".$class_school_id);

     
        return $result;


    }

    /*Get all students  by attendance id */
    public static function get_all_students_by_attendance_id($get_attendance_id){

        $get_all_students = DB::select(" SELECT  `sms_attendances`.`id`,`sms_class_student`.`created_at`,`sms_class_student`.`student_image`, `sms_students`.`first_name`,`sms_students`.`last_name`,`sms_students`.`gender` , `sms_attendances`.`status` AS 'attendance_status'
            FROM `sms_attendances`,`sms_students`,`sms_class_student`
            WHERE `sms_class_student`.`status` = 1
            AND `sms_attendances`.`sms_attendance_class_id` = ".$get_attendance_id."
            AND `sms_attendances`.`sms_student_id` = `sms_students`.`id`
            AND `sms_class_student`.`sms_student_id` = `sms_students`.`id`");

        return $get_all_students;
    }
	
	
	

    
    
}
