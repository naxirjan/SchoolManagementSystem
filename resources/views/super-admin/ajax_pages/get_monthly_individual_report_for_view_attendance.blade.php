@if(!empty($attendance))
 <div class="col-xs-1"></div>  
 <div class="col-xs-10">  
                                                                                      
            <!--print button -->
            {!!Form::open(array("url"=>"/super-admin/get_report_monthly_individual","method"=>"post"))!!}
                <input type="hidden" name="month_year" value="{{ $month_year_class_school_id['month_year'] }}">
                <input type="hidden" name="class_school_id" value="{{ $month_year_class_school_id['class_school_id'] }}">
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
                                        <b>{{ $attendance['school_name'] }}</b>
                                    </span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name" style="background-color: #0f8070;"> Class Name </div>

                                <div class="profile-info-value">
                                    <span class="dark" id="get_school_name">
                                        <b>{{ $attendance['class_name'] }}</b>
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name" style="background-color: #0f8070;" > Teachers </div>

                                <div class="profile-info-value">
                                    <span class="dark" id="get_school_name">
                                        <b>
                                          <?php

                                            $output = "";
                                            $seperator = " , ";
                                            foreach ($attendance['teachers'] as $key => $value) {
                                              $output .= $value->teacher_names."".$seperator;
                                              
                                            }
                                            $stllen = strlen($output);
                                            echo substr($output,0,$stllen-2);
                                           
                                          ?>
                                        </b>
                                    </span>
                                </div>
                            </div>

                             <div class="profile-info-row">
                                <div class="profile-info-name" style="background-color: #0f8070;" > Total Students </div>
                                <div class="profile-info-value">
                                    <span class="dark" id="get_school_name">
                                        <b>{{ $attendance['total_students'] }}</b>
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name" style="background-color: #0f8070;" > Month </div>

                                <div class="profile-info-value">
                                    <span class="dark" id="get_school_name">
                                        <b>
                                            <b>{{ $attendance['month'] }}</b>
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
                  <?php
                    $start_date = NULL;
                    $end_date =  NULL;
                  ?>  
                  @foreach($attendance['month_total_days'] as $key=>$date)
                        
                  <?php
                      $day = date('l',strtotime($date));
                       
                  


                      if($day == $attendance['weekend']){
					  
							if($date >= $start_date && $date <= $end_date && $day == $attendance['weekend']){
								continue;
							}
                          ?>
                           <div class="row">
                               <div class="col-xs-1"></div>
                               <div class="col-xs-10">

                              <h3 class="text-center"><span class="btn btn-light"><b>Date:</b> {{ date("d F Y",strtotime($date)) }} </span></h3>
                              <div class="profile-user-info profile-user-info-striped">
                       
                                  <div class="profile-info-row">
                                      <div class="profile-info-name" style="background-color:green;"> Date </div>

                                      <div class="profile-info-value">
                                          <span class="dark" id="get_school_name">
                                              <b>{{ date("d F Y",strtotime($date)) }}</b>
                                          </span>
                                      </div>
                                  </div>

                                   <div class="profile-info-row">
                                      <div class="profile-info-name" style="background-color:green;"> Status </div>
                                      <div class="profile-info-value">
                                          <span class="dark" id="get_school_name">
                                              <b>Weekend Holiday</b>
                                          </span>
                                      </div>
                                  </div> 
                                  <div class="profile-info-row">
                                      <div class="profile-info-name" style="background-color:green;" > Description </div>
                                      <div class="profile-info-value">
                                          <span class="dark" id="get_school_name">
                                              <b>This is a {{ $attendance['weekend'] }} that is school weekend off day</b>
                                          </span>
                                      </div>
                                  </div> 
                              </div> 
                              </div>
                               <div class="col-xs-1"></div>
                           </div>
                           <hr />
                          <?php

                        }else{

                            //this code for show class attendance details
                             foreach ($attendance['attendance_detail'] as $key => $attendance_detail_per_day) {
                                foreach ($attendance_detail_per_day as $key => $attendance_detail_per_day_values) {
                                    if($attendance_detail_per_day_values['date'] ==  $date){
                                        ?>
                                          <div class="row">
                                            <div class="col-xs-1"></div>  
                                            <div class="col-xs-10">

                                                  <h3 class="text-center">
                                                      <span class="btn btn-light"><b>Date:</b>
                                                     {{ date("d F Y",strtotime($attendance_detail_per_day_values['date'])) }} 
                                                    
                                                  </span></h3>
                                                  <div class="profile-user-info profile-user-info-striped">
                                           
                                                      <div class="profile-info-row">
                                                          <div class="profile-info-name"> Date </div>

                                                          <div class="profile-info-value">
                                                              <span class="dark" id="get_school_name">
                                                                  <b>{{ date("d F Y",strtotime($attendance_detail_per_day_values['date'])) }}</b>
                                                              </span>
                                                          </div>
                                                      </div>

                                                      <div class="profile-info-row">
                                                          <div class="profile-info-name"> Attendance Taken By </div>
                                                          <div class="profile-info-value">
                                                              <span class="dark" id="get_school_name">
                                                                  <b>{{ $attendance_detail_per_day_values['attendance_taken_by'] }}</b>
                                                              </span>
                                                          </div>
                                                      </div>

                                                      <div class="profile-info-row">
                                                          <div class="profile-info-name"> Total Students </div>

                                                          <div class="profile-info-value">
                                                              <span class="dark" id="get_school_name">
                                                                  <b>{{ $attendance_detail_per_day_values['class_total_students'] }} </b>
                                                              </span>
                                                          </div>
                                                      </div>

                                                      <div class="profile-info-row">
                                                          <div class="profile-info-name"> Present </div>

                                                          <div class="profile-info-value">
                                                              <span class="dark" id="get_school_name">
                                                                  <b>
                                                                      {{ $attendance_detail_per_day_values['present_students'] }}
                                                                      <?php 
                                                                        $Persant = (int) $attendance_detail_per_day_values['present_students'];
                                                                        echo "(".($Persant/$attendance_detail_per_day_values['class_total_students']*100)."%)";

                                                                      ?>
                                                                      

                                                                  </b>
                                                              </span>
                                                          </div>
                                                      </div>

                                                      

                                                       <div class="profile-info-row">
                                                          <div class="profile-info-name"> Absent </div>
                                                          <div class="profile-info-value">
                                                              <span class="dark" id="get_school_name">
                                                                  <b> {{ $attendance_detail_per_day_values['absent_students'] }} 
                                                                  <?php 
                                                                        $absent = (int) $attendance_detail_per_day_values['absent_students'];
                                                                        echo "(".($absent/$attendance_detail_per_day_values['class_total_students']*100)."%)";
                                                                  ?>
                                                                  </b>
                                                              </span>
                                                          </div>
                                                      </div>
                                                      
                                                         <div class="profile-info-row">
                                                            <div class="profile-info-name">Class Attendance Picture </div>
                                                            <div class="profile-info-value">
                                                                <span class="dark">
                                                                 <?php
                                                                    $dir='storage/schools/'.$attendance_detail_per_day_values['class_attendance_picture_path'];
                                                                    $files = array_diff(scandir($dir), array(".","..","...")); 
                                                                    if(in_array($attendance_detail_per_day_values['class_attendance_picture'],$files))
                                                                    {
                                                                        ?>   
                                                                    <a target="_blank" href="{{asset('storage/schools/'.$attendance_detail_per_day_values['class_attendance_picture_path'].'/'.$attendance_detail_per_day_values['class_attendance_picture'])}}" style="text-decoration:none;">
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
                                                      <br />
                                                    <div style="overflow-x:auto;">
                                                    <table id="simple-table" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                           <tr>
                                                              <th class="center">#</th>
                                                              <th>Image</th>
                                                              <th>Full Name</th>
                                                              <th>Gender</th>
                                                              <th>Status</th>
                                                              
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                          <?php $no = 1; ?>
                                                          @foreach ($attendance_detail_per_day_values['students_info'] as $key => $value)
                                                          <tr>
                                                                <td align="center">{{ $no++ }}</td>
                                                                <td>


                                                                  @if($value->student_individual_image !='student_icon.jpg')
                                                                    <img class="img-responsive" alt="No Image" src="{{asset($value->student_image)}}"  style="border-radius:50%;width: 50px;height: 50px;">
                                                                    
                                                                  @else
                                                                      <img id="avatar" class="img-responsive" alt="No Image" src="{{asset('storage/dumy_image/student_icon.jpg')}}"
                                                                      style="border-radius:50%;width: 50px;height: 50px;">
                                                                  @endif 


                                                                </td>
                                                                <td>{{$value->first_name }} {{$value->last_name }}</td>
                                                                <td>{{$value->gender}}</td>
                                                                <td>
                                                                  @if ($value->attendance_status == 1)
                                                                    <span class="label label-sm label-success">Present</span>
                                                                  @else
                                                                    <span class="label label-sm label-danger">Absent</span>
                                                                    <br />
                                                                    <span class="label label-sm label-info">
                                                                     @if(!empty($value->resion))
                                                                        {{ $value->resion }}
                                                                     @endif
                                                                   </span>
                                                                  @endif

                                                                </td>
                                                                
                                                            </tr>

                                                          @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                  </div>
                                          </div>
                                            <div class="col-xs-1"></div>  
                                         </div>
                                         <hr />
                                        <?php
                                        break 2;
                                    }
                                }
                              }
                            //end code of show class attendance details
                              
                              //this code for show holiday  details
                              foreach($attendance['holiday_recored'] as $key=>$holidays){
                               
                                foreach($holidays as $value){

                                           if($date == $value['date'] ){

                                              
                                              if($start_date == $value['start_date'] && $end_date == $value['end_date']){
                                                break 2;
                                              }

                                            ?>
                                              <div class="row">
                                                 <div class="col-xs-12">
                                                  <h3 class="text-center">
                                                    <span class="btn btn-light">
                                                    <b>Start Date: </b> {{ date("d F Y",strtotime($value['start_date'])) }}
                                                    <b> To </b>
                                                    <b>End: Date: </b> {{ date("d F Y",strtotime($value['end_date'])) }}

                                                  </span></h3>
                                                  <div class="profile-user-info profile-user-info-striped">
                                                      <div class="profile-info-row">
                                                          <div class="profile-info-name" style="background-color:gray;"> Dates </div>

                                                          <div class="profile-info-value">
                                                              <span class="dark" id="get_school_name">
                                                                  <b>{{ date("d F Y",strtotime($value['start_date'])) }}
                                                                  To 
                                                                  {{ date("d F Y",strtotime($value['end_date'])) }}</b>
                                                              </span>
                                                          </div>
                                                      </div>
                                                      <div class="profile-info-row">
                                                          <div class="profile-info-name" style="background-color:gray;"> Status </div>
                                                          <div class="profile-info-value">
                                                              <span class="dark" id="get_school_name">
                                                                  <b>Officale Holiday</b>
                                                              </span>
                                                          </div>
                                                      </div> 

                                                      <div class="profile-info-row">
                                                          <div class="profile-info-name" style="background-color:gray;"> Holiday Title </div>
                                                          <div class="profile-info-value">
                                                              <span class="dark" id="get_school_name">
                                                                  <b>{{ $value['title'] }}</b>
                                                              </span>
                                                          </div>
                                                      </div> 
                                                      <div class="profile-info-row">
                                                          <div class="profile-info-name" style="background-color:gray;"> Holiday Description </div>
                                                          <div class="profile-info-value">
                                                              <span class="dark" id="get_school_name">
                                                                  <b>{{ $value['description'] }}</b>
                                                              </span>
                                                          </div>
                                                      </div> 
                                                  </div> 
                                                  </div>
                                              </div>
                                              <hr /> 
                                              <?php
                                              $start_date = $value['start_date'];
                                              $end_date   = $value['end_date'];
                                              break 2;

                                            }
                                       
                               
                                }
                        
                              }
                              //end code of show holiday  details
                        } 

                        ?>
                   @endforeach 
                 
          </div>
          </div>
</div>
 <div class="col-xs-1"></div>  
                                           
       
 @endif