<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms_class extends Model
{
    //
    
    protected $fillable = [ "class","class_description","status" ];
    
 

public static function get_class_name_to_make_student_images_folder($class_name)
    {
        
        $remove_spaces = str_replace(' ', '_', $class_name);
        
        return strtolower($remove_spaces);
    }
       

}
