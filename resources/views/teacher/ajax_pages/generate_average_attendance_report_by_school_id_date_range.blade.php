@if(!empty($all_attendance))

<div class="col-sm-1"></div>
<div class="col-sm-10">

    <!--print button -->
    {!!Form::open(array("url"=>"/teacher/generate_excel_average_report_date_range","method"=>"post"))!!}
    <input type="hidden" name="date_from" value="{{$date_from}}">
    <input type="hidden" name="date_to"   value="{{$date_to}}">
    <input type="hidden" name="school_id"   value="{{$school_id}}">
    <input type="hidden" name="school_name"   value="{{$school_name}}">
    
    
    &nbsp;&nbsp;&nbsp;&nbsp;
    <button class="btn btn-success" type="submit">
        <i class="ace-icon fa fa-download align-top bigger-125 icon-on-left"></i>
        Download Excel
    </button>
    {!!Form::close()!!}
    <hr />
    <!--end print button -->

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

                    <div class="profile-info-row">
                        <div class="profile-info-name" style="background-color: #0f8070;"> School Name </div>

                        <div class="profile-info-value">
                            <span class="dark" id="get_school_name">
                                <b>{{$school_name}}</b>
                            </span>
                        </div>
                    </div>


                    <div class="profile-info-row">
                        <div class="profile-info-name" style="background-color: #0f8070;"> Teachers </div>

                        <div class="profile-info-value">
                            <span class="dark" id="get_school_name">
                                <b>
                                    <?php

                                            $output = "";
                                            $seperator = " , ";
                                            foreach ($school_teachers as $teacher) {
                                              $output .= $teacher->first_name." ".$teacher->last_name.$seperator;
                                            }
                                            $strlen = strlen($output);
                                            echo substr($output,0,$strlen-2);
                                            ?>
                                </b>
                            </span>
                        </div>
                    </div>


                    <div class="profile-info-row">
                        <div class="profile-info-name" style="background-color: #0f8070;"> Date </div>

                        <div class="profile-info-value">
                            <span class="dark">
                                <b>From: {{ date('d F Y',strtotime($date_from))}}  To: {{date('d F Y',strtotime($date_to))}}
                                </b>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            <br>
            <h3><b>Date:</b> From: {{ date('d F Y',strtotime($date_from))}}  To: {{date('d F Y',strtotime($date_to))}}</h3>

            <table id="simple-table" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<th style="color:black"><b>Class Name</b></th>
													<th style="color:black" class="hidden-480"><b>Total Students</b></th>
													<th style="color:black" class="hidden-480"><b>Total Days</b></th>
                                                    <th style="color:black"><b>Present Students</b></th>
                                                    <th style="color:black"><b>Absent Students</b></th>
													<th style="color:black"><b>Average Present</b></th>
                                                    <th style="color:black"><b>Average Absent</b></th>
												</tr>
											</thead>

											<tbody>
                                                @if(!empty($all_attendance))
                                                    @foreach($all_attendance as $key => $attendance)
                                                        <?php 
                                                        $total_working_days    = $attendance['total_working_days'];
                                                        $present  = $attendance['present_days'];
                                                        $absent    = $attendance['absent_days'];
                                                        ?>
                                                
                                                <tr >
                                                    <td>
                                                        <b>{{$attendance['class']}}</b>
                                                    </td>
                                                    <td class="hidden-480">
                                                        <b>{{$attendance['total_class_students']}}</b>
                                                    </td>
                                                    <td class="hidden-480">
                                                        <b>{{$attendance['total_working_days']}}</b>
                                                    </td>
                                                    <td>
                                                        <b>{{$attendance['present_days']}}</b>
                                                    </td>
                                                    <td >
                                                        <b>{{$attendance['absent_days']}}</b>
                                                    </td>
                                                    <td class="center">
                                                        <b class="badge" style="background-color:green">{{substr($present/$total_working_days,0,4)}}</b>
                                                    </td>
                                                    <td class="center">
                                                        <b class="badge" style="background-color:red">{{substr($absent/$total_working_days,0,4)}}</b>
                                                    </td>
                                                </tr>                                                
                                                @endforeach
                                            @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
<div class="col-sm-1"></div>

    @endif