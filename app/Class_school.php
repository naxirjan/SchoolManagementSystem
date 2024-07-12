<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
class Class_school extends Model
{
    //
    
    protected $fillable = ["sms_class_id","sms_school_id","status"];
    
    
    
    /*Add New Classes For School*/
    public static function assign_new_classes_to_school($data)
    {
        
     $result = DB::table('sms_class_school')->insert([
            'sms_class_id'  =>$data['sms_class_id'],
            'sms_school_id' =>$data['sms_school_id'],
            'created_at'    =>$data['created_at'],
            'status'        =>1
        ]);  
    
        return $result;
    }
    
    
public static function view_school_classes($school_id)
    {
    $school_classes = DB::table('sms_class_school')
                    ->join('sms_schools','sms_class_school.sms_school_id','=','sms_schools.id')
                    ->join('sms_classes','sms_class_school.sms_class_id','=','sms_classes.id')
                    ->where('sms_class_school.sms_school_id',$school_id)
                    ->where("sms_classes.status",1)
                    ->where("sms_schools.status",1)
                    ->where("sms_class_school.status",1)
                    ->select("sms_class_school.id as id","sms_schools.id as sms_school_id","sms_schools.school","sms_classes.id as sms_class_id","sms_classes.class")
                    ->get()->toArray();
               
       return $school_classes;
    }
    
    
     //get school's classes for add student form 
    public static function get_school_classes_for_student_add($id){
      $get_clesses_of_school = DB::select("SELECT sms_classes.* ,sms_class_school.id AS 'sms_class_school_id' FROM sms_classes, sms_class_school
        WHERE sms_class_school.sms_school_id = ".$id."
        AND sms_classes.status=1
        AND sms_class_school.status=1
        AND sms_class_school.sms_class_id = sms_classes.id");

      $result = array(""=>"-- Select Class --");
        foreach($get_clesses_of_school as $get_cless_of_school){
           $result[$get_cless_of_school->sms_class_school_id] = $get_cless_of_school->class;
        }

      return  $result;


    }

    //get school's classes by sms_role_user_id for views school student
    public static function get_school_id_for_student_view($role_user_id){

      $result = DB::select("SELECT sms_school_role_user.sms_school_id FROM sms_school_role_user WHERE sms_school_role_user.sms_role_user_id = ".$role_user_id);
    return  $result;
    
    }
	
	/*Get class name , school id and school name for checking directory and student create a folder for save image*/
    public static function get_school_id_school_name_and_class_name_by_class_school_id($class_school_id){

      $result = DB::select("SELECT `sms_schools`.`id` AS 'school_id',`sms_schools`.`school` , `sms_classes`.`class`
                          FROM `sms_schools`,`sms_classes`,`sms_class_school`
                          WHERE `sms_class_school`.`sms_class_id` = `sms_classes`.`id`
                          AND `sms_class_school`.`sms_school_id` = `sms_schools`.`id`
                          AND `sms_schools`.status=1
                          AND `sms_classes`.status=1
                          AND `sms_class_school`.status=1
                          AND `sms_class_school`.id = ".$class_school_id);

      return  $result;
    }


    /*Get school name and class  name by school class id */
    public static function get_school_name_and_class_name_by_class_school_id($class_school_id){

                $get_class_school_names = DB::select("SELECT `sms_classes`.`class`,`sms_schools`.`school`,`sms_schools`.`id` AS 'school_id'
                FROM `sms_class_school`,`sms_schools`,`sms_classes`
                WHERE `sms_class_school`.`id` = ".$class_school_id."
                AND `sms_class_school`.`sms_class_id` = `sms_classes`.`id`
                AND `sms_schools`.`id` = `sms_class_school`.`sms_school_id`");

                return $get_class_school_names;
    }



    public static function get_school_classes_by_school_id_without_status($school_id)
    {
     $result =  DB::select("SELECT c.`class`,cs.id AS 'class_school_id' FROM `sms_schools` s, `sms_classes` c,`sms_class_school` cs
    WHERE cs.`sms_class_id` = c.`id`
    AND cs.`sms_school_id` = s.`id`
    AND s.`id`=".$school_id." ");

    return $result;
    }



}
