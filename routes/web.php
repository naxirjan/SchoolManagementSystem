<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*AUTHENTICATION*/
/*Login*/
Route::get('/', "LoginController@login")->middleware("checkLoginSessionMiddleware");
Route::post('/login_process', "LoginController@login_process");
Route::get('/logout', "LoginController@logout");


/* ============ SUPER ADMIN =============*/

/*Dashboard*/
Route::get('/super_admin/dashboard', "SuperAdminController@dashboard");
Route::get('/super_admin', "SuperAdminController@dashboard");

/*PASSWORD*/
    /*Change password*/
    Route::get('/super_admin/change_password', "SuperAdminController@change_password");
    /*Change password process*/
    Route::post('/super_admin/change_password_process', "SuperAdminController@change_password_process");
    /*Check old password using ajax */
    Route::post("/super_admin/check_old_password_super_admin_function","SuperAdminController@check_old_password_super_admin_function");
/*PASSWORD*/

// OTHER ROUTES ARE REMOVED BY DEVELOPER HIMSLEF.

/* ============ SUPER ADMIN =============*/


/* ============ SCHOOL ADMIN =============*/

/*DASHBOARD*/
    Route::get('/admin/dashboard', "AdminController@dashboard");
    Route::get('/admin/', "AdminController@dashboard");
    /*Get view class school students for dashboard*/
    Route::post('admin/get_present_students_for_dashboard', "AdminController@get_present_students_for_dashboard_function");
/*DASHBOARD*/


/*ACCOUNT*/
    /*Profile*/
    Route::get('/admin/view_profile', "AdminController@view_profile");
    /*Switch School For Admin*/
    Route::get('/admin/switch_admin_school/{id}', "AdminController@switch_admin_school");
/*ACCOUNT*/


/*PASSWORD*/
    /*Change password*/
    Route::get('/admin/change_password', "AdminController@change_password");
    /*Change password process*/
    Route::post('admin/change_password_process', "AdminController@change_password_process");
    /*Check old password using ajax */
    Route::post("/admin/check_old_password_school_admin_function","AdminController@check_old_password_school_admin_function");
/*PASSWORD*/


// OTHER ROUTES ARE REMOVED BY DEVELOPER HIMSLEF.
/* ============ SCHOOL ADMIN =============*/





/* ============ TEACHER =============*/

/*DASHBOARD*/
Route::get('/teacher/dashboard', "TeacherController@dashboard");
/*Get Present Or Absent Students On Dashborad*/
Route::post('teacher/get_present_students_for_dashboard', "TeacherController@get_present_students_for_dashboard_function");
Route::get('/teacher/', "TeacherController@dashboard");
/*DASHBOARD*/


/*ACCOUNT*/
    /*View Profile*/
    Route::get('/teacher/view_profile', "TeacherController@view_profile");
    /*Switch School For Teacher*/
    Route::get('/teacher/switch_teacher_school/{id}', "TeacherController@switch_teacher_school");
/*ACCOUNT*/


/*PASSWORD*/
    /*Change password*/
    Route::get('/teacher/change_password', "TeacherController@change_password");
    /*Change password process*/
    Route::post('teacher/change_password_process', "TeacherController@change_password_process");
    /*Check old password using ajax */
    Route::post("/teacher/check_old_password_school_teacher_function","TeacherController@check_old_password_school_teacher_function");
/*PASSWORD*/


// OTHER ROUTES ARE REMOVED BY DEVELOPER HIMSLEF.

/* ============ TEACHER =============*/



/* ============ ERROR 404 =============*/
/*Error 404 Not Founs*/

Route::get('/file_not_found','GeneralController@error_404');
Route::get('/went_wrong','GeneralController@error_500');

/* ============ ERROR 404 =============*/
