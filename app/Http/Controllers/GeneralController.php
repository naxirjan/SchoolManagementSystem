<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    
    public function __construct()
	{
		
	}
   
    
    /*Error 404*/
   public function error_404()
   {
       return view('error_404');
   }

     /*Error 500*/
   public function error_500()
   {
       return view('error_500');
   } 
  
    
}
