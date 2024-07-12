<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Sms_setting extends Model
{
    //
    protected $fillable = [
        "key","value","status" 
    ];

    public static function get_school_holiday_by_school_id($school_id)
	{
		$result = DB::table("sms_settings")
					->where("key","Weekend")
					->where("status",1)->get()->toArray();	 

		return $result;
	}
}
