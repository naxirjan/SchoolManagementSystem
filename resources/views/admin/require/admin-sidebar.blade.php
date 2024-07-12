 <!-- #section:basics/sidebar -->
 <div id="sidebar" class="sidebar responsive">
     <script type="text/javascript">
         try {
             ace.settings.check('sidebar', 'fixed')
         } catch (e) {}
     </script>

     <ul class="nav nav-list">
         <li <?php 
			if(trim(Route::getFacadeRoot()->current()->uri()) == "admin/dashboard"){
				echo "Active";
			}
		
			?>>
             <a href="/admin/dashboard">
                 <i class="menu-icon fa fa-tachometer"></i>
                 <span class="menu-text"> Dashboard </span>
             </a>

             <b class="arrow"></b>
         </li>
         <!--Attendance-->
         <li class='<?php 
						
			if(trim(Route::getFacadeRoot()->current()->uri()) == "admin/take_attendance" || trim(Route::getFacadeRoot()->current()->uri()) == "admin/modify_attendance" || trim(Route::getFacadeRoot()->current()->uri()) == "admin/view_attendance" ){
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
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "admin/take_attendance"){
									echo "active";
								}else{echo "";}
							
							?>'>
                     <a href="/admin/take_attendance">
                         <i class="menu-icon fa fa-caret-right"></i>
                         Take Attendance
                     </a>
                     <b class="arrow"></b>
                 </li>

                 <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "admin/modify_attendance"){
									echo "active";
								}else{echo "";}
							
							?>'>
                     <a href="/admin/modify_attendance">
                         <i class="menu-icon fa fa-caret-right"></i>
                         Modify Attendance
                     </a>
                     <b class="arrow"></b>
                 </li>

                 <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "admin/view_attendance"){
									echo "active";
								}else{echo "";}
							
							?>'>
                     <a href="/admin/view_attendance">
                         <i class="menu-icon fa fa-caret-right"></i>
                         View Attendance
                     </a>
                     <b class="arrow"></b>
                 </li>


             </ul>
         </li>
         <!--Attendance-->

         <!-- School Classes-->
         <li class='<?php 
						
						if( trim(Route::getFacadeRoot()->current()->uri()) =="admin/add_students_to_school_class/{school_id}/{class_id}"  || trim(Route::getFacadeRoot()->current()->uri()) =="admin/view_class_students/{school_id}/{class_id}" || trim(Route::getFacadeRoot()->current()->uri()) == "admin/view_school_classes" ){
							echo "active open";
						}
					
					?>'>
             <a href="#" class="dropdown-toggle">
                 <i class="menu-icon fa fa-university"></i>
                 <span class="menu-text">
                     School Classes
                 </span>

                 <b class="arrow fa fa-angle-down"></b>
             </a>

             <b class="arrow"></b>
             <ul class="submenu">

                 <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "admin/view_school_classes"){
									echo "active";
								}else{echo "";}
							
							?>'>
                     <a href="/admin/view_school_classes">
                         <i class="menu-icon fa fa-caret-right"></i>
                         View School Classes
                     </a>

                     <b class="arrow"></b>
                 </li>
             </ul>
         </li>
         <!--School Classes-->

         <!--Teachers-->
         <li class='<?php 
						
						if( trim(Route::getFacadeRoot()->current()->uri()) =="admin/view_teacher_detail/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "admin/add_teacher" || trim(Route::getFacadeRoot()->current()->uri()) == "admin/view_teachers" ){
							echo "active open";
						}
					
					?>'>
             <a href="#" class="dropdown-toggle">
                 <i class="menu-icon glyphicon glyphicon-user"></i>
                 <span class="menu-text">Teachers </span>

                 <b class="arrow fa fa-angle-down"></b>
             </a>

             <b class="arrow"></b>

             <ul class="submenu">
                 <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "admin/add_teacher"){
									echo "active";
								}else{echo "";}
							
							?>'>
                     <a href="/admin/add_teacher">
                         <i class="menu-icon fa fa-caret-right"></i>
                         Add Teacher
                     </a>

                     <b class="arrow"></b>
                 </li>

                 <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "admin/view_teachers"){
									echo "active";
								}else{echo "";}
							
							?>'>
                     <a href="/admin/view_teachers">
                         <i class="menu-icon fa fa-caret-right"></i>
                         View Teachers
                     </a>

                     <b class="arrow"></b>
                 </li>
             </ul>
         </li>
         <!--Teachers-->

         <!--Students-->
         <li class='<?php 
						
						if(trim(Route::getFacadeRoot()->current()->uri()) =="admin/view_student_detail/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "admin/add_student" || trim(Route::getFacadeRoot()->current()->uri()) == "admin/view_students" || trim(Route::getFacadeRoot()->current()->uri()) =="admin/edit_student/{id}"){
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
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "admin/add_student"){
									echo "active";
								}else{echo "";}
							
							?>'>
                     <a href="/admin/add_student">
                         <i class="menu-icon fa fa-caret-right"></i>
                         Add Student
                     </a>

                     <b class="arrow"></b>
                 </li>

                 <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "admin/view_students"){
									echo "active";
								}else{echo "";}
							
							?>'>
                     <a href="/admin/view_students">
                         <i class="menu-icon fa fa-caret-right"></i>
                         View Students
                     </a>

                     <b class="arrow"></b>
                 </li>
             </ul>
         </li>
         <!--Students-->


         <!--Official Holidays-->
         <li class='<?php 
						
						if( trim(Route::getFacadeRoot()->current()->uri()) =="admin/holiday_assign_school/{id}" || trim(Route::getFacadeRoot()->current()->uri()) =="admin/view_holiday_detail/{id}" || trim(Route::getFacadeRoot()->current()->uri()) =="admin/edit_holiday/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "admin/add_holiday" || trim(Route::getFacadeRoot()->current()->uri()) == "admin/view_holidays" ){
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
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "admin/add_holiday"){
									echo "active";
								}else{echo "";}
							
							?>'>
                     <a href="/admin/add_holiday">
                         <i class="menu-icon fa fa-caret-right"></i>
                         Add Holiday
                     </a>

                     <b class="arrow"></b>
                 </li>

                 <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "admin/view_holidays"){
									echo "active";
								}else{echo "";}
							
							?>'>
                     <a href="/admin/view_holidays">
                         <i class="menu-icon fa fa-caret-right"></i>
                         View Holidays
                     </a>

                     <b class="arrow"></b>
                 </li>
             </ul>
         </li>
         <!--Official Leaves-->
         <!--Switch School (Admin)-->
         <?php

                	if(session('user_schools'))
                	{
                		$admin_schools = array();

                		foreach (session('user_schools') as $key => $value) 
						{
							if($value->role_id == 2)
							{
								$admin_schools[$value->school_id] = $value->school;
							}
						}

						if(count($admin_schools) > 1)
						{
							?>
         <li class="">
             <a href="#" class="dropdown-toggle">
                 <i class="menu-icon fa fa-key"></i>
                 <span class="menu-text">Switch School</span>

                 <b class="arrow fa fa-angle-down"></b>
             </a>

             <b class="arrow"></b>
             <ul class="submenu">
                 <?php
							foreach ($admin_schools as $key => $value) 
							{
								if(session('myuser_schools')[2]['school_id'] == $key)
								{
									?>
                 <li class="">
                     <a class="green">
                         <i class="menu-icon fa fa-caret-right"></i>
                         <b>
                             <?php
												
						                    	echo $value;
						               	?>
                             (Active)
                         </b>
                     </a>
                     <b class="arrow"></b>
                 </li>
                 <?php
								}
								else
								{
									?>
                 <li class="">
                     <a href="\admin\switch_admin_school\<?php echo $key;?>">
                         <i class="menu-icon fa fa-caret-right"></i>
                         <?php
												
						                    echo $value;
						                    ?>
                     </a>
                     <b class="arrow"></b>
                 </li>
                 <?php
								}
							}
							?>
             </ul>
         </li>
         <?php
						}
                	}
                	?>
         <!--Switch School (Admin)-->

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