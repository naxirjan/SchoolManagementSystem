<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Sms_class_role_user extends Model
{
    //

public static function get_teacher_classes_by_school_id_role_user_id($school_id,$user_id,$role_id)
{
    
    $result = DB::select("SELECT s.id as school_id, s.school, c.class,c.id as class_id,cru.sms_class_school_id,cru.sms_role_user_id FROM `sms_classes` c,`sms_schools` s, `sms_class_school` cs,`sms_class_role_user` cru,`sms_role_user` ru,`sms_roles` r,
	`sms_users` u,`sms_school_role_user` sru
	WHERE c.status=1
	AND  s.status=1
	AND  cs.status=1
	AND  cru.status=1
	AND  ru.status=1	
	AND  r.status=1
	AND  u.status=1
	AND  sru.status=1
	AND r.id = ru.sms_role_id
	AND u.id = ru.sms_user_id 
	AND c.id = cs.sms_class_id
 	AND s.id = cs.sms_school_id
	AND cs.id = cru.sms_class_school_id
	AND ru.id = cru.sms_role_user_id
	AND sru.sms_school_id=s.id
	AND sru.sms_role_user_id = ru.id
    AND sru.sms_school_id=".$school_id."
	AND ru.sms_user_id=".$user_id."
	AND ru.sms_role_id=".$role_id." ORDER BY c.id ASC");
 
    
    return $result;
    
}

public static function get_students_by_class_school_id($class_school_id)
{
    
    $result = DB::select("SELECT sms_classes.class,sms_schools.school,sms_schools.id AS school_id,`sms_students`.*,`sms_class_student`.`student_image`,`sms_class_student`.`created_at` AS 'class_student_date'
                FROM `sms_students`,`sms_class_student`,`sms_role_user`,`sms_roles`,`sms_users`,`sms_class_school`,`sms_schools`,sms_classes
                WHERE `sms_class_student`.`sms_student_id` = `sms_students`.`id`
                AND `sms_role_user`.`id` = `sms_students`.`sms_role_user_id`
                AND `sms_role_user`.`sms_role_id` = `sms_roles`.`id`
                AND `sms_role_user`.`sms_user_id` = `sms_users`.`id`
                AND `sms_class_student`.`sms_class_school_id` = `sms_class_school`.`id`
                AND `sms_schools`.`id` = `sms_class_school`.`sms_school_id`
                AND `sms_classes`.`id` = `sms_class_school`.`sms_class_id`
                AND  `sms_class_student`.`status`=1
                AND  `sms_students`.`status`=1
                AND  `sms_role_user`.`status`=1
                AND  `sms_roles`.`status`=1
                AND  `sms_users`.`status`=1
                AND  `sms_class_school`.`status`=1
                AND  `sms_schools`.`status`=1
                AND  sms_classes.`status` =  1
                AND `sms_class_school`.`id` = ".$class_school_id." ");
    
    return $result;
    
} 

    
public static function check_current_date_attendance($class_school_id,$role_user_id,$current_date)
{
    $result = DB::table("sms_attendance_class")
                ->where('sms_class_school_id',"=",$class_school_id)
                ->where('sms_role_user_id',"=",$role_user_id)
                ->where('created_date',"=",$current_date)
                ->get()->toArray();
return $result;
}

public static function get_all_teachers_by_school_id($school_id)
{
    	
		$get_all_teachers_by_school_id = DB::select("SELECT u.id as user_id,u.first_name,u.middle_name,u.last_name,ru.id as sms_role_user_id FROM `sms_users` u,`sms_role_user` ru,`sms_roles` r,`sms_schools` s,`sms_school_role_user` sru
		WHERE r.id = ru.sms_role_id
		AND u.id = ru.sms_user_id
		AND s.id = sru.sms_school_id
		AND ru.id=sru.sms_role_user_id
        AND u.status=1
        AND ru.status=1
        AND r.status=1
        AND s.status=1
        AND sru.status=1
		AND sru.sms_school_id=".$school_id."
		AND r.id=3 ");

return $get_all_teachers_by_school_id;
}

public static function get_all_class_school_teachers_by_class_school_id($class_school_id)
{
$teachers = DB::select("
        SELECT u.id AS user_id ,ru.id AS sms_role_user_id,u.first_name,u.middle_name,u.last_name,s.id AS school_id,c.id AS class_id ,s.school,c.class FROM `sms_class_school` csch,`sms_classes` c,`sms_schools` s,`sms_class_role_user` cru,`sms_role_user` ru,`sms_users` u,`sms_roles` r
WHERE csch.sms_school_id = s.id
AND csch.sms_class_id = c.id
AND csch.id = cru.sms_class_school_id
AND ru.id  = cru.sms_role_user_id
AND ru.sms_user_id = u.id
AND ru.sms_role_id = r.id
AND csch.status=1
AND c.status=1
AND s.status=1
AND cru.status=1
AND ru.status=1
AND u.status=1
AND r.status=1
AND csch.id = ".$class_school_id." ");


return $teachers;
}

public static function get_sms_class_school_id($school_id,$class_id)
    {
        $get_sms_class_school_id = DB::select("SELECT id FROM sms_class_school
        WHERE sms_school_id= ".$school_id."
        AND sms_class_id=".$class_id." 
        AND status=1 ");
        return $get_sms_class_school_id;
}

public static function assign_teacher_to_class($sms_class_school_id,$sms_role_user_id)
{
		$result = DB::table('sms_class_role_user')->insert([
			'sms_class_school_id'=>$sms_class_school_id,
			'sms_role_user_id'=>$sms_role_user_id,
			'created_at'=>date("Y-m-d h:i:s"),
			'status'=>1,
		]);

		return $result;
}


/*Get class school teachers by class_school_id for view attendance*/
public static function get_school_class_teachers_by_class_school_id($class_school_id){

    $get_school_class_teachers = DB::select("SELECT DISTINCT CONCAT (`sms_users`.`first_name`,' ',`sms_users`.`last_name`) AS 'teacher_names'   
            FROM `sms_attendance_class`,`sms_class_school`,`sms_class_role_user`,`sms_users`,`sms_role_user`
            WHERE `sms_attendance_class`.`sms_class_school_id` = ".$class_school_id."
            AND `sms_class_school`.`id` = `sms_attendance_class`.`sms_class_school_id`
            AND `sms_class_role_user`.`sms_class_school_id` = `sms_class_school`.`id`
            AND `sms_role_user`.`id` = `sms_class_role_user`.`sms_role_user_id`
            AND `sms_role_user`.`sms_role_id` = 3
            AND `sms_role_user`.`sms_user_id` = `sms_users`.`id`");
    return $get_school_class_teachers;
        
}

/*Get attendance taken by teacher by class_attendance id */
public static function get_teacher_of_taken_by_attendance_by($get_attendance_class_id){

    $get_taken_by_teacher = DB::select("SELECT `sms_users`.`first_name`  AS 'teacher_name',`sms_users`.`last_name`  
    FROM `sms_attendance_class`,`sms_role_user`,`sms_users`
    WHERE `sms_attendance_class`.`id` = ".$get_attendance_class_id."
    AND `sms_role_user`.`id` = `sms_attendance_class`.`sms_role_user_id`
    AND `sms_users`.`id` = `sms_role_user`.`sms_user_id`
    ORDER BY `sms_attendance_class`.id ASC"); 

    return $get_taken_by_teacher;
}



	
    
}
