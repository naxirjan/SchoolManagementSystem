<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
class Sms_class_student extends Model
{
    //
    
    
    
    /*function for insert student recored like image , class ,and school */
    public static function create_student_recored($school_class_id,$student_id,$image_name){

    $result = DB::table('sms_class_student')->insert(
    		[
            'sms_class_school_id'       =>$school_class_id,
            'sms_student_id'            =>$student_id,
            'student_image'             =>$image_name, 
            'created_at'                =>date("Y-m-d h:i:s"),    
            'status'                    =>1,
            ]
		);
    return $result;
    } 
    
    public static function get_class_students_by_school_id_class_id($school_id,$class_id)
    {
            $result =  DB::select("SELECT sch.`school`,c.`class`,c.id AS 'class_id',s.* FROM `sms_students` s,`sms_schools` sch,`sms_classes` c,`sms_class_school` cs,`sms_class_student` cstd
            WHERE c.`id` = cs.`sms_class_id`
            AND sch.`id` = cs.`sms_school_id`
            AND cs.`id`=cstd.`sms_class_school_id`
            AND s.`id`=cstd.`sms_student_id`
            AND cstd.status=1
            AND s.status=1
            AND sch.status=1
            AND c.status=1
            AND cs.status=1
            AND cs.`sms_class_id`=".$class_id."
            AND cs.`sms_school_id`=".$school_id." ");
        

        return $result;


    }
    
    
    
    public static function get_class_school_id_by_class_id_school_id($school_id,$class_id)
    {
        
        $result = DB::table("sms_class_school")
                        ->join("sms_classes","sms_class_school.sms_class_id","=","sms_classes.id")
                        ->join("sms_schools","sms_class_school.sms_school_id","=","sms_schools.id")
                        ->where('sms_class_school.status',1)
                        ->where('sms_classes.status',1)
                        ->where('sms_schools.status',1)
                        ->where('sms_class_school.sms_class_id',"=",$class_id)
                        ->where("sms_class_school.sms_school_id","=",$school_id)
                        ->select("sms_class_school.id")
                        ->get()->toArray();
    
    return $result;
    }
    


    public static function update_class_students_to_promote($class_school_id,$student_id)
    {
       $update=  DB::table('sms_class_student')
            ->where('sms_class_school_id', $class_school_id)
            ->where('sms_student_id', $student_id)
            ->update(["updated_at"=>date("Y-m-d h:i:s"),'status' => 0]);
       
    return $update;
    }


      public static function promote_class_students($class_school_id,$student_id)
      {
        
       $result= DB::table('sms_class_student')->insert([
            'sms_class_school_id' => $class_school_id,
            'sms_student_id'      => $student_id,
            'student_image'       => "student_icon.jpg",
            'created_at'          =>date('Y-m-d h:i:s'),
            'status'              =>1
            
        ]);

        return $result;      
      }

       /*update student image function  */
       public static function student_image_update($student_image,$student_id,$class_school_id){
    
      $query = 'UPDATE `sms_class_student` SET `sms_class_student`.`student_image` = "'.$student_image.'" WHERE `sms_class_student`.`status` = 1 AND `sms_class_student`.`sms_student_id` = "'.$student_id.'"  AND `sms_class_student`.`sms_class_school_id` = "'.$class_school_id.'"';  
      $res = DB::update($query);
      return  $res;   
   
    }




    public static function count_total_students_by_school_id($school_id)
    {
        $result = DB::select("SELECT COUNT(s.id) AS 'total_students' FROM `sms_students` s,`sms_schools` sch,`sms_class_school` cs,`sms_class_student` cstd
            WHERE sch.`id` = cs.`sms_school_id`
            AND cs.`id`=cstd.`sms_class_school_id`
            AND s.`id`=cstd.`sms_student_id`
            AND cstd.status=1
            AND cs.sms_school_id = ".$school_id." ");

        return $result[0]->total_students;
    }


}


