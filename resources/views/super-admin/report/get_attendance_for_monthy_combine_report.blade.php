<?php

    

    if(!empty($school_name))
    {
        ?>       
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    {!! Form::open(array("url"=>"/super_admin/generate_excel_monthly_combine_report","method"=>"post")) !!}
                        <input type="hidden" name="school_name" value="{{$school_name}}" />
                        <input type="hidden" name="class_name" value="{{$class_name}}" />
                        <input type="hidden" name="month_name" value="{{$month_name}}" />
                        <input type="hidden" name="total_students" value="{{$total_students}}" />
                        <input type="hidden" name="month" value="{{$month}}" />
                        <input type="hidden" name="school_id" value="{{$school_id}}" />
                        <input type="hidden" name="class_school_id" value="{{$class_school_id}}" />
                        <input type="hidden" name="class_id" value="{{$class_id}}" />
                        <input type="hidden" name="total_month_days" value="{{$total_month_days}}" />
                        <input type="hidden" name="year" value="{{$year}}" />
                        &nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-success">
                            <i class="ace-icon fa fa-download align-top bigger-125 icon-on-left"></i>
                            Download Excel
                        </button>
                    {!! Form::close() !!}              
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
                                <br/>
                                <div class="profile-user-info profile-user-info-striped">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"  style="background-color: #0f8070">School Name: </div>
                                        <div class="profile-info-value">
                                            <span class="dark">
                                                <b><?php echo $school_name;?></b>
                                            </span>                                            
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"  style="background-color: #0f8070"> Class Name: </div>
                                        <div class="profile-info-value">
                                            <span class="dark">
                                                <b><?php echo $class_name;?></b>
                                            </span>                                            
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"  style="background-color: #0f8070"> Class Teachers: </div>
                                        <div class="profile-info-value">
                                            <span class="dark">
                                                <b>
                                                    <?php
                                                        $name = "";

                                                        foreach ($teachers as $key => $value)
                                                        {
                                                            if($value->middle_name == '')
                                                            {
                                                                $name .= $value->first_name.' '.$value->last_name.', ';
                                                            }
                                                            else
                                                            {
                                                                $name .= $value->first_name.' '.$value->middle_name.' '.$value->last_name.', ';
                                                            }
                                                        }

                                                        echo rtrim($name,', ');
                                                    ?>
                                                </b>
                                            </span>                                            
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"  style="background-color: #0f8070"> Total Students: </div>
                                        <div class="profile-info-value">
                                            <span class="dark">
                                                <b><?php echo $total_students;?></b>
                                            </span>                                            
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"  style="background-color: #0f8070"> Month: </div>
                                        <div class="profile-info-value">
                                            <span class="dark">
                                                <b><?php echo $month_name;?></b>
                                            </span>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-sm-1"></div>
            </div>
            <hr/>
            <?php
            if(isset($attendance))
            {
                ?>
                <div class="row">
                    <div class="col-sm-12">
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
                                <br/>
                                <h3><b>Month:</b> <?php echo $month_name;?> </h3>
                                <hr/>
                                <div class="sticky-table sticky-headers sticky-ltr-cells" style="overflow-y: hidden;">
                                    <table  width="100%" border="1px solid black" class="">
                                        <tr>
                                            <th style="min-width:300px" align="center" class="sticky-cell">
                                                <table border="1px solid black" style="border:1px solid black">
                                                    <tr style="height: 70px;">
                                                        <th style="min-width:70px;"><b style="font-size:15px; padding: 5px;" class="btn btn-inverse btn-block">Image</b></th>
                                                        <td style="min-width:230px;"><b style="font-size:15px; padding: 5px;" class="btn btn-inverse btn-block">Full Name</b></td>
                                                    </tr>
                                                </table>
                                            </th>
                                            <td>
                                                <?php 
                                                $calendar_dates = array();
                                                if($total_month_days==31)
                                                {
                                                    ?><div style="width:2900px"><?php
                                                }
                                                else if($total_month_days==30)
                                                {
                                                    ?><div style="width:2805px"><?php  
                                                }
                                                else if($total_month_days==29)
                                                {
                                                    ?><div style="width:2715px"><?php  
                                                }
                                                else if($total_month_days==28)
                                                {
                                                  ?><div style="width:2620px"><?php  
                                                }
                                                ?>  
                                                <?php
                                                    for($i=1; $i<=$total_month_days; $i++)
                                                    {
                                                        $calendar_dates[]= date("Y-m-d",strtotime($i."-".$month."-".$year));
                                                        ?>
                                                            <span style="padding: 5px;">
                                                                <Button  class="btn btn-inverse" style="width: 80px">
                                                                   
                                                                    <span style="margin-top:2px;border-bottom:1px solid white;padding-bottom:2px;">
                                                                     <i class="ace-icon fa fa-calendar bigger-160"></i>    
                                                                        <b><?php echo $i;?></b></span>
                                                                    <?php
                                                        
                                                                         $dir='storage/schools/'.$class_attendance_picture_path;
                                                        
                                                                        $files = array_diff(scandir($dir), array(".","..","..."));
                                                        
                                                                        foreach($class_attendance_pictures as $date =>$pic)
                                                                        {
                                                                            if(date("Y-m-d",strtotime($i."-".$month."-".$year))==$date && in_array($pic,$files))
                                                                            {
                                                                                ?><br />
                                                                                      <span>
                                                                                    <a   class="white" target="_blank" href="{{asset('storage/schools/'.$class_attendance_picture_path.'/'.$pic)}}"  style="text-decoration:none;">
                                                                                    Click For<br />Picture
                                                                                </a>
                                                                                </span>          
                                                                            <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                   
                                                                </Button> 
                                                            </span>
                                                        <?php
                                                    }
                                                ?>
                                                    </div>  
                                            </td>
                                            <th style="min-width: 100px" class="center"><b class="btn btn-success btn-block btn-lg" style="font-size:15px; padding: 5px;">Total<br/>Present Days</b></th>
                                            <th style="min-width: 100px" class="center"><b class="btn btn-danger btn-block btn-lg" style="font-size:15px; padding: 5px;">Total<br/>Absent Days</b></th>
                                            <th style="min-width: 100px" class="center"><b class="btn btn-block btn-lg btn-primary" style="font-size:15px; padding: 5px;">%<br/>Percentage</b></th>
                                        </tr>
                                        <?php
                                            foreach ($attendance as $key => $value) 
                                            {
                                                ?>                                    
                                                <tr>
                                                    <th style="min-width:300px" class="sticky-cell">
                                                        <table border="1px solid black" style="border:1px solid black">
                                                            <tr style="height: 40px;">
                                                                <th style="min-width:70px">
                                                                    <b style="font-size:13px; padding: 5px;">
                                                                       
                                                                       @if($value['student_combine_image'] !='student_icon.jpg')
                                                                    <img src="{{asset($value['profile_picture'])}}"  style="border-radius:50%;width: 50px;height: 50px;">

                                                                  @else
                                                                      <img  src="{{asset('storage/dumy_image/student_icon.jpg')}}"
                                                                       style="border-radius:50%;width: 50px;height: 50px;">
                                                                  @endif

                                                                    </b>
                                                                </th>
                                                                <td style="min-width:230px; text-align: left">
                                                                    <b style="font-size:13px; padding: 5px;">
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['full_name'];?>
                                                                    </b>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                    <td>
                                                        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                                                        <?php
                                                            if(is_array($value['student_attendance']))
                                                            {
                                                                $total_present_days = 0;
                                                                $total_absent_days = 0;
                                                                $total_working_days = 0;
                                                                
                                                                foreach ($value['student_attendance'] as $key1 => $status) 
                                                                {

                                                                    if($status === "Friday")
                                                                    {
                                                                        ?>
                                                                        <span style="padding: 5px;">
                                                                            <button class="btn btn-yellow" style="width: 80px"><small>School<br/>Weekend</small>
                                                                        </button>
                                                                        </span>
                                                                        <?php
                                                                    }
                                                                    else if(is_array($status))
                                                                    {
                                                                        ?>
                                                                        <span style="padding: 5px;">
                                                                            <button class="btn btn-default" holiday_title = "{{$status['title']}}" holiday_description="{{$status['description']}}" id="leave_popover" style="width: 80px"><small>School<br/> Holiday</small>
                                                                        </button>
                                                                        </span>
                                                                        <?php

                                                                    }
                                                                    else if($status === 0)
                                                                    {
                                                                        $total_absent_days++;
                                                                        $total_working_days++;
                                                                        ?>
                                                                        <span style="padding: 5px;">
                                                                            <button class="btn btn-danger btn-sm" style="width: 80px">Absent</button>
                                                                        </span>
                                                                        <?php
                                                                    }
                                                                    elseif($status === 1)
                                                                    {
                                                                        $total_present_days++;
                                                                        $total_working_days++;
                                                                        ?>
                                                                        <span style="padding: 5px;">
                                                                            <button class="btn btn-success btn-sm" style="width: 80px">Present
                                                                        </button>
                                                                        </span>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                      ?>
                                                                        <span style="padding: 5px;">
                                                                            <button title="No Attendance" class="btn btn-white" style="width: 80px;background-color:white;">
                                                                                &nbsp;&nbsp;&nbsp;
                                                                        </button>
                                                                        </span>
                                                                        <?php   
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                        </div>
                                                    </td>
                                                    <td align="center">
                                                        <b style="font-size:13px; font-weight: bolder; padding: 5px;" class="badge badge-success">
                                                            &nbsp;
                                                            <?php echo $total_present_days; ?>
                                                            &nbsp;
                                                        </b>
                                                    </td>
                                                    <td align="center">
                                                        <b style="font-size:13px; font-weight: bolder; padding: 5px;" class="badge badge-danger">
                                                            &nbsp;
                                                            <?php echo $total_absent_days; ?>
                                                            &nbsp;
                                                        </b>
                                                    </td>
                                                    <td align="center">
                                                        <b style="font-size:13px; font-weight: bolder; padding: 5px;" class="badge badge-primary">
                                                            <?php
                                                                echo round(($total_present_days * 100)/$total_working_days,2).' %';
                                                            ?>
                                                        </b>
                                                    </td>
                                                </tr>
                                                <?php  
                                            }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }        
            ?>
        </div>

        <?php
    }
?>