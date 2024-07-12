<!-- #section:basics/sidebar -->
<div id="sidebar" class="sidebar responsive">
    <script type="text/javascript">
        try {
            ace.settings.check('sidebar', 'fixed')
        } catch (e) {}
    </script>
    <ul class="nav nav-list">
        <li <?php 
						if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/dashboard"){
							echo "Active";
						}
					
					?>>
            <a href="/super_admin/dashboard">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>

            <b class="arrow"></b>
        </li>

        <!--Attendance-->
        <li class='<?php 
						
						if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/take_attendance" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/modify_attendance" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_attendance" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_class_attendance_picture"){
							echo "active open";
						}
					
					?>'>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon glyphicon glyphicon-time"></i>
                <span class="menu-text">Attendance </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/take_attendance"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/take_attendance">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Take Attendance
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/modify_attendance"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/modify_attendance">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Modify Attendance
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_attendance"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/view_attendance">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Attendance
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_class_attendance_pictures"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/view_class_attendance_pictures">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Class Attendance Pictures
                    </a>

                    <b class="arrow"></b>
                </li>

            </ul>
        </li>
        <!--Attendance-->
        <!--Students-->
        <li class='<?php 
						
						if(trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/view_student_detail/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_student" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_students" || trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/edit_student/{id}"){
							echo "active open";
						}
					
					?>'>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-users"></i>
                <span class="menu-text">Students </span>

                <b class="arrow fa fa-angle-down"></b>
                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_student"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/add_student">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add Student
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_students"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/view_students">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Students
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <!--Students-->

        <!--Official Leaves-->
        <li class='<?php 
						
						if( trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/holiday_assign_school/{id}" || trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/view_holiday_detail/{id}" || trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/edit_holiday/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_holiday" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_holidays" ){
							echo "active open";
						}
					
					?>'>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-calendar"></i>
                <span class="menu-text">Holidays </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_holiday"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/add_holiday">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add Holiday
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_holidays"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/view_holidays">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Holidays
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <!--Official Leaves-->

        <!--Schools-->
        <li class='<?php 
						
						if(trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/view_school_detail/{id}" || trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/edit_school/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_school" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_schools" ){
							echo "active open";
						}
					
					?>'>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-university"></i>
                <span class="menu-text">
                    Schools
                </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_school"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/add_school">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add School
                    </a>

                    <b class="arrow"></b>
                </li>
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_schools"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/view_schools">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Schools
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <!--Schools-->

        <!--Start Users-->
        <li class='<?php 
						
						if( trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/assign_role/{id}" || trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/view_user_detail/{id}" || trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/edit_user/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_user" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_users" ){
							echo "active open";
						}
					
					?>'>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon  fa fa-users"></i>
                <span class="menu-text">Users </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_user"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/add_user">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add User
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_users"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/view_users">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Users
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <!--End Users-->

        <!-- School Classes-->

        <li class='<?php 
						
						if( trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/add_students_to_school_class/{school_id}/{class_id}"  || trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/view_class_students/{school_id}/{class_id}" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/assign_school_classes" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_school_classes" ){
							echo "active open";
						}
					
					?>'>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-exchange"></i>
                <span class="menu-text">
                    Assign Classes
                </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/assign_school_classes"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/assign_school_classes">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Assign School Classes
                    </a>

                    <b class="arrow"></b>
                </li>
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_school_classes"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/view_school_classes">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View School Classes
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <!--School Classes-->
        <!--Classes-->
        <li class='<?php 
						
						if(trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/edit_class/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_class" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_classes" ){
							echo "active open";
						}
					
					?>'>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon glyphicon glyphicon-home"></i>
                <span class="menu-text">
                    Classes
                </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_class"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/add_class">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add Class
                    </a>

                    <b class="arrow"></b>
                </li>
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_classes"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/view_classes">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Classes
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <!--Classes-->

        <!--Roles-->
        <li class='<?php 
						
						if(trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/edit_role/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_role" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_roles" ){
							echo "active open";
						}
					
					?>'>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-cogs"></i>

                <span class="menu-text">Role Types </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_role"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/add_role">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add Role
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_roles"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/view_roles">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Roles
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <!--Roles-->
        <!--Qualification-->
        <li class='<?php 
						
						if(trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/edit_qualification/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_qualification" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_qualifications" ){
							echo "active open";
						}
					
					?>'>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-mortar-board"></i>
                <span class="menu-text">Qualifications</span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_qualification"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/add_qualification">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add Qualification
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_qualifications"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/view_qualifications">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Qualifications
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <!--Qualification-->

        <!--District Operations-->
        <li class='<?php 
						
						if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_district_operations" ){
							echo "active open";
						}
					
					?>'>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon glyphicon glyphicon-map-marker"></i>
                <span class="menu-text">District Operations</span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_district_operations"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/view_district_operations">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View District Operations
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <!--District Operations-->
        <!--Settings-->
        <li class='<?php 
						
						if(trim(Route::getFacadeRoot()->current()->uri()) =="super_admin/edit_setting/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_setting" || trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_settings" ){
							echo "active open";
						}
					
					?>'>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon glyphicon glyphicon-cog"></i>
                <span class="menu-text">Settings</span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/add_setting"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/add_setting">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add Setting
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "super_admin/view_settings"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/super_admin/view_settings">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Settings
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <!--Settings-->
    </ul><!-- /.nav-list -->

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
        try {
            ace.settings.check('sidebar', 'collapsed')
        } catch (e) {}
    </script>
</div>

<!-- /section:basics/sidebar -->