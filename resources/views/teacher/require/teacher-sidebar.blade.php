<!-- #section:basics/sidebar -->
<div id="sidebar" class="sidebar responsive">
    <script type="text/javascript">
        try {
            ace.settings.check('sidebar', 'fixed')
        } catch (e) {}
    </script>
    <!--nav-list -->
    <ul class="nav nav-list">
        <!--Dashboard-->
        <li <?php 
				if(trim(Route::getFacadeRoot()->current()->uri()) == "teacher/dashboard"){
					echo "Active";
				}
			
			?>>
            <a href="/teacher/dashboard">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>
            <b class="arrow"></b>
        </li>
        <!--Dashboard-->
        @if(session('check_school_classes_for_teacher_side_bar'))
        <!--Attendance-->
        <li class='<?php 
				
				if(trim(Route::getFacadeRoot()->current()->uri()) == "teacher/take_attendance" || trim(Route::getFacadeRoot()->current()->uri()) == "teacher/modify_attendance" || trim(Route::getFacadeRoot()->current()->uri()) == "teacher/view_attendance" ){
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
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "teacher/take_attendance"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/teacher/take_attendance">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Take Attendance
                    </a>
                    <b class="arrow"></b>
                </li>

                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "teacher/modify_attendance"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/teacher/modify_attendance">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Modify Attendance
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "teacher/view_attendance"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/teacher/view_attendance">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Attendance
                    </a>
                    <b class="arrow"></b>
                </li>


            </ul>
        </li>
        <!--Attendance-->
        @endif
        <!-- My CLasses -->

        <li class='<?php 
						
						if(trim(Route::getFacadeRoot()->current()->uri()) =="teacher/view_student_detail/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "teacher/view_my_classes" ){
							echo "active open";
						}
					
					?>'>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon glyphicon glyphicon-home"></i>
                <span class="menu-text">My Classes </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class='<?php 
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "teacher/view_my_classes"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/teacher/view_my_classes">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View My Classes
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <!-- My CLasses -->
        <!--Official Holidays-->
        <li class='<?php 
						
						if(trim(Route::getFacadeRoot()->current()->uri()) =="teacher/view_holiday_detail/{id}" || trim(Route::getFacadeRoot()->current()->uri()) == "teacher/view_holidays" ){
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
						
								if(trim(Route::getFacadeRoot()->current()->uri()) == "teacher/view_holidays"){
									echo "active";
								}else{echo "";}
							
							?>'>
                    <a href="/teacher/view_holidays">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Holidays
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <!--Official Leaves-->



        <!--Switch School (Teacher)-->
        <?php
                	if(session('user_schools'))
                	{
                		$teacher_schools = array();

                		foreach (session('user_schools') as $key => $value) 
						{
							if($value->role_id == 3)
							{
								$teacher_schools[$value->school_id] = $value->school;
							}
						}

						if(count($teacher_schools) > 1)
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
							foreach ($teacher_schools as $key => $value) 
							{
								if(session('myuser_schools')[3]['school_id'] == $key)
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
                    </a>

                    </b>
                    <b class="arrow"></b>
                </li>
                <?php
								}
								else
								{
									?>
                <li class="">
                    <a href="\teacher\switch_teacher_school\<?php echo $key;?>">
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
        <!--Switch School (Teacher)-->


    </ul>
    <!-- /.nav-list -->

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