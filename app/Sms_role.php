<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms_role extends Model
{
    //
    protected $fillable = [ "role_type", "role_description","status"];
}
