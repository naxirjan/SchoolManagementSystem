
@if(!empty($daily_attendance_report))
    {!! Form::open(array("url"=>"/admin/get_daily_attendance_report","method"=>"post","role"=>"form")) !!}
        &nbsp;&nbsp;&nbsp;&nbsp;


          <div class="col-sm-1"></div>
          <div class="col-sm-10">
            <button class="btn btn-success">
                <i class="ace-icon fa fa-download align-top bigger-125"></i>
                    Download Excel  
            </button>
            <hr />
            <div class="tabbable">
                <ul class="nav nav-tabs padding-16">
                     <li class="active">
                        <a data-toggle="tab" href="#tab-1" aria-expanded="true">
                            <i class="menu-icon fa fa-info-circle bigger-150"></i>
                                <b>&nbsp;Attendance Information (Summary)</b>
                        </a>
                     </li>
                </ul>

                <div class="tab-content profile-edit-tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="profile-user-info profile-user-info-striped"> 
                            <div class="profile-info-row" >
                                <div class="profile-info-name" style="background-color: #0f8070"> School Name </div>
                                <div class="profile-info-value">
                                    <span class="dark" id="get_school_name">
                                        <b>{{$school_name}}</b>
                                            <input type="hidden" name="school_name" value="{{$school_name}}">
                                    </span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name" style="background-color: #0f8070"> Class Name </div>
                                <div class="profile-info-value">
                                    <span class="dark" id="get_school_name">
                                           <b>{{$class_name}}</b>
                                        <input type="hidden" name="class_name" value="{{$class_name}}">
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name" style="background-color: #0f8070">Class Teachers </div>
                                <div class="profile-info-value">
                                    <span class="dark" id="get_school_name">
                                        <b>
                                            <?php
                                                $seperator = " , ";
                                                $output = ""; 
                                            ?>
                                            @foreach($class_teachers as $class_teacher)
                                              <?php 
                                              $output.=$class_teacher->first_name.' '.$class_teacher->last_name.$seperator;?>
                                              <input type="hidden" name="all_teachers_full_name[]" value="{{$class_teacher->first_name.' '.$class_teacher->last_name}}">
                                              
                                              <input type="hidden" name="class_teacher_sms_role_user_id[]" value="{{$class_teacher->sms_role_user_id}}">
                                            @endforeach
                                            <?php 
                                            echo trim($output,$seperator);?>
                                        </b>
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name" style="background-color: #0f8070"> Attendance Taken By </div>
                                <div class="profile-info-value">
                                    <span class="dark" id="get_school_name">
                                        <b>
                                            {{$attendance_taken_teacher_name}}
                                        </b>
                                       <input type="hidden" name="daily_attendance_report_taken_by" value="{{$attendance_taken_teacher_name}}">
                                         
                                    </span>
                                </div>
                            </div>

                             <div class="profile-info-row" >
                                <div class="profile-info-name" style="background-color: #0f8070"> Total Students </div>
                                <div class="profile-info-value">
                                    <span class="dark" id="get_school_name">
                                        <b>{{$all_student = count($all_students)}}</b>
                                        <input type="hidden" name="all_students" value="{{$all_student}}">
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name" style="background-color: #0f8070">Present Students </div>
                                <div class="profile-info-value">
                                    <span class="dark" id="get_school_name">
                                        <b> {{$present_students}} &nbsp;( {{$present_students/count($all_students)*100}}% ) </b>
                                        <input type="hidden" name="present_students" value="{{$present_students}}">
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name" style="background-color: #0f8070">Absent Students </div>
                                <div class="profile-info-value">
                                    <span class="dark" id="get_school_name">
                                        <b> {{$absent_students}} &nbsp;( {{$absent_students/count($all_students)*100}}% ) </b>
                                        <input type="hidden" name="absent_students" value="{{$absent_students}}">
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name" style="background-color: #0f8070">Attendance Date </div>
                                <div class="profile-info-value">
                                    <span class="dark" id="get_school_name">
                                        <b> {{$daily_attendance_date}} </b>
                                        <input type="hidden" name="attendance_day" value="{{$daily_attendance_date}}">
                                    </span>
                                </div>
                            </div> 
                            <div class="profile-info-row">
                        <div class="profile-info-name" style="background-color: #0f8070">Class Attendance Picture </div>
                        <div class="profile-info-value">
                            <span class="dark">
                                <?php
                                $dir='storage/schools/'.$class_attendance_picture_path;
                                $files = array_diff(scandir($dir), array(".","..","...")); 
                                if(in_array($daily_attendance_report[0]->class_image,$files))
                                {
                                ?>
                                <a target="_blank" href="{{asset('storage/schools/'.$class_attendance_picture_path.'/'.$daily_attendance_report[0]->class_image)}}"  style="text-decoration:none;">
                                    <i class="ace-icon  glyphicon glyphicon-picture bigger-150"></i>
                                    <small class="blue">&nbsp;&nbsp;<b>Click to show</b></small>
                                </a>
                                <?php
                                }
                                else
                                {
                                ?>
                                    <span class="red"><b>Picture was deleted</b></span>
                                <?php
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                            
                            
                            
                            
                        </div>
                    </div>
                </div>
            </div> 
        
         <br />
            <div class="space-20"></div>
            
            <div class="tabbable">
                <ul class="nav nav-tabs padding-16">
                    <li class="active">
                        <a data-toggle="tab" href="#tab-1" aria-expanded="true">
                            <i class="menu-icon fa fa-info-circle bigger-150"></i>
                            <b>&nbsp;Attendance Information (Detail)</b>
                        </a>
                    </li>
                </ul>    
                <div class="tab-content profile-edit-tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="profile-user-info profile-user-info-striped">
                             <?php $count = 1;?>
                             <table id="simple-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                       <tr>
                                          <th align="center" class="hidden-480">#</th>
                                          <th>Image</th>
                                          <th>Full Name</th>
                                          <th class="hidden-480">Gender</th>
                                          <th>Status</th>
                                          
                                        </tr>
                                     </thead>
                                    <tbody>
                                        <?php $i=1; ?>
                                        @foreach($all_students as $all_student)  
                                        <tr>
                                            <td align="center" class="hidden-480"> <?php echo $count++; ?> </td>
                                            <td align="center"> 
                                                @if($all_student->student_image !='student_icon.jpg')
                                                <img class="img-responsive" alt="No Image" src="{{asset($image_path.$all_student->student_image)}}" width="50" height="50" style="border-radius:50%;">
                                            @else
                                                <img id="avatar" class="img-responsive" alt="No Image" src="{{asset('storage/dumy_image/student_icon.jpg')}}"
                                                width="50" height="50" style="border-radius:50%;">
                                            @endif 

                                             </td>
                                             <input type="hidden" name="image_path" value="{{$image_path.$all_student->student_image}}">
                                            <td> {{$all_student->first_name.' '.$all_student->last_name}} </td>
                                            <input type="hidden" name="students_full_name{{$i}}" value="{{$all_student->first_name.' '.$all_student->last_name}}">
                                            
                                            <td class="hidden-480"> {{$all_student->gender}} </td>
                                            <input type="hidden" name="gender{{$i}}" value="{{$all_student->gender}}">
                                            <td> <?php
                                                if($all_student->status == 1)
                                                    {   
                                                        ?> <span class="label label-sm label-success"> <?php echo "Present"?>
                                                        </span>
                                                   <?php }
                                                else if($all_student->status == 0)
                                                    {?>
                                                        <span class="label label-sm label-danger"><?php echo "Absent"?>
                                                        </span>
                                                        <?php if(!empty($all_student->reason))
                                                            {
                                                                ?> <br/><span class="label label-sm label-primary"><?php echo $all_student->reason;?>
                                                        </span> <?php
                                                               
                                                               ?>
                                                               <input type="hidden" name="absent_reason{{$i}}" value="<?php echo $all_student->reason; ?>">
                                                               <?php
                                                            }  
                                                            ?> 
                                                    <?php }?>
                                             </td>
                                             <input type="hidden" name="attendance_status{{$i}}" value="<?php echo $all_student->status?>">
                                            
                                        </tr>
                                        <?php $i++;?>
                                        @endforeach
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
         <div class="col-sm-1"> </div>
        
     {!!Form::close()!!}    
      
@endif
