<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
        {!! Form::open(array("url"=>"/super_admin/generate_excel_date_range_student_report","method"=>"post")) !!}
            <input type="hidden" name="school_id" value="{{$school_id}}" />
            <input type="hidden" name="class_school_id" value="{{$class_school_id}}" />
            <input type="hidden" name="class_id" value="{{$class_id}}" />
            <input type="hidden" name="student_id" value="{{$student_id}}" />
            <input type="hidden" name="school_name" value="{{$school_name}}" />
            <input type="hidden" name="class_name" value="{{$class_name}}" />
            <input type="hidden" name="total_students" value="{{$total_students}}" />
            <input type="hidden" name="date_from" value="{{$date_from}}" />
            <input type="hidden" name="date_to" value="{{$date_to}}" />
            <input type="hidden" name="student_name" value="{{$student_name}}">
            <input type="hidden" name="gaurdian_name" value="{{$gaurdian_name}}">
            <input type="hidden" name="gender" value="{{$gender}}">
            <input type="hidden" name="date_of_birth" value="{{$date_of_birth}}">
            <input type="hidden" name="address" value="{{$address}}">
            <input type="hidden" name="gaurdian_contact_number" value="{{$gaurdian_contact_number}}">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <button class="btn btn-success">
                <i class="ace-icon fa fa-download align-top bigger-125 icon-on-left"></i>Download Excel
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
                                <div class="profile-info-name"  style="background-color: #0f8070">Student Name </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $student_name;?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070">Guardian Name </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $gaurdian_name;?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070">Guardian Cell </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $gaurdian_contact_number;?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070">Gender </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $gender;?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070">Date of Birth </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $date_of_birth;?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070">Address </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $address;?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070">School Name </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $school_name;?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070"> Class Name </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $class_name;?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070"> Class Teachers </div>
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
                                <div class="profile-info-name"  style="background-color: #0f8070"> Date </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php
                                        echo 'From '.date('d F Y',strtotime($date_from)).' To '.date('d F Y',strtotime($date_to));
                                        ?></b>
                                    </span>                                            
                                </div>
                            </div>

                            <?php

                            if(!empty($attendance))
                            {
                                $total_working_days = 0;
                                $total_present_days = 0;
                                $total_absent_days  = 0;
                                $total_holidays     = 0;
                                $total_weekends     = 0;
                                $not_taken          = 0;

                                foreach ($attendance as $key => $value) 
                                {
                                    foreach($value['student_attendance'] as $date => $status)
                                    {
                                        if($status === "Friday")
                                        {
                                            $total_weekends++;
                                        }
                                        else if(is_array($status))
                                        {
                                            $total_holidays++;
                                        }
                                        else if($status === 1)
                                        {
                                            $total_working_days++;
                                            $total_present_days++;
                                        }
                                        else if($status === 0)
                                        {
                                            $total_working_days++;
                                            $total_absent_days++;
                                        }
                                        else
                                        {
                                            $not_taken++;
                                        }    
                                    }
                                }

                                $percentage = round(($total_present_days * 100)/$total_working_days,2).' %';
                            }

                            ?>


                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070"> Total School Days</div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $total_working_days; ?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070"> Total Present Days </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $total_present_days; ?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070"> Total Absent Days </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $total_absent_days; ?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070"> Weekends </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $total_weekends; ?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070"> Holidays </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $total_holidays; ?></b>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"  style="background-color: #0f8070"> Percentage </div>
                                <div class="profile-info-value">
                                    <span class="dark">
                                        <b><?php echo $percentage; ?></b>
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
                        <h3><b>Date:</b><?php echo 'From '.date('d F Y',strtotime($date_from)).' To '.date('d F Y',strtotime($date_to)); ?> </h3>
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
                                        <?php $width = $total_days * 103.4214; ?>
                                        <div style="width:<?php echo $width;?>px">
                                        <?php
                                            foreach($dates as $date_key => $date_value)
                                            {
                                                
                                                ?>
                                                    <span style="padding: 5px;">
                                                        <Button  class="btn btn-inverse" style="width: 90px">
                                                            <i class="ace-icon fa fa-calendar bigger-50"></i>
                                                            <b><?php echo date("M-d",strtotime($date_key));?></b>
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
                                                                <img src="{{asset($value['profile_picture'])}}" height="50px" width="50px">
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
                                                        foreach ($value['student_attendance'] as $key1 => $status) 
                                                        {
                                                            if($status === "Friday")
                                                            {
                                                                ?>
                                                                <span style="padding: 5px;">
                                                                    <button class="btn btn-yellow" style="width: 90px"><small>School<br/>Weekend</small>
                                                                </button>
                                                                </span>
                                                                <?php
                                                            }
                                                            else if(is_array($status))
                                                            {
                                                                ?>
                                                                <span style="padding: 5px;">
                                                                    <button class="btn btn-default" holiday_title = "{{$status['title']}}" holiday_description="{{$status['description']}}" id="leave_popover" style="width: 90px"><small>School<br/> Holiday</small>
                                                                </button>
                                                                </span>
                                                                <?php

                                                            }
                                                            else if($status === 0)
                                                            {
                                                                ?>
                                                                <span style="padding: 5px;">
                                                                    <button class="btn btn-danger btn-sm" style="width: 90px">Absent</button>
                                                                </span>
                                                                <?php
                                                            }
                                                            elseif($status === 1)
                                                            {
                                                                ?>
                                                                <span style="padding: 5px;">
                                                                    <button class="btn btn-success btn-sm" style="width: 90px">Present
                                                                </button>
                                                                </span>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                              ?>
                                                                <span style="padding: 5px;">
                                                                    <button title="No Attendance" class="btn btn-white" style="width: 90px;background-color:white;">
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
                                                        echo $percentage;
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