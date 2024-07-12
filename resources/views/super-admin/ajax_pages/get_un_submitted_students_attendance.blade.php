        <div class="col-xs-12 ">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <div class="tabbable">
            <ul class="nav nav-tabs padding-16">
                <li class="active">
                    <a data-toggle="tab" href="#tab-1" aria-expanded="true">
                        <i class="menu-icon glyphicon glyphicon-time bigger-150"></i>
                        <b>&nbsp;Attendance Of {{date('d F Y',strtotime($attendance_date))}}</b>
                    </a>
                </li>
            </ul>
        <div class="tab-content profile-edit-tab-content">
            <div id="tab-1" class="tab-pane active">
                <Button style="width:230px;" class="btn btn-app btn-xs btn-info pull-right btn-submit-attendance" id="btn-take-picture" >
                    <i class="ace-icon fa fa-camera bigger-160 "></i>    
                        Take Class Attendance Picture
                    </Button> 
                <br /><br /><br />
                <form method="post" id="my_form" role="form" enctype="multipart/form-data">
                  {{ csrf_field() }}                            
                    <input type="hidden" name="class_school_id" id="class_school_id" value="{{$class_school_id}}">
                    <input type="hidden" name="role_user_id" id="role_user_id" value="{{$role_user_id}}">
                    <input type="hidden" name="attendance_date" id="attendance_date" value="{{$attendance_date}}">
                    <input type="hidden" name="class_attendance_image_path" value="{{$class_attendance_image_path}}" /> 
                    <input type="hidden" name="user_action_name" value="add_new_attendance" />
                    
                    <?php $present=0; $absent=0; $total=0;?>    
                    @if(!empty($un_submitted_attendance))     
                        @foreach($un_submitted_attendance as $student_id => $attendances)
                             @if($attendances['status']==0)
                             <?php $absent++;?>   
                            @elseif($attendances['status']==1)
                             <?php $present++;?>
                            @endif
                        <?php $total++; ?>
                        @endforeach 
                    <div id="camera_section"></div>
                    <div id="attendance_table_section">
                   
                    <p class="">
                        <span class="label label-xlg label-success arrowed arrowed-right">Present: &nbsp;
                            <span id="present" class="badge " style="background-color:green"><?php echo $present++; ?></span>
                        </span>
                        <span class="label label-xlg label-info arrowed-in-right arrowed-in">Total: &nbsp;
                            <span class="badge" style="background-color:#1eaaef"> <?php echo $total++; ?></span>
                        </span>
                        <span class="label label-xlg label-danger arrowed arrowed-right">Absent: &nbsp;
                            <span id="absent" class="badge " style="background-color:red"><?php echo $absent++; ?>
                            </span>
                        </span>
                        
					</p>
                  
                    <table id="attendance-table" class="table table-bordered table-responsive table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Full Name</th>
                                <th class="hidden-480">Gender</th>
                                <th>Status</th>
                                <th>Modify Status</th>
                                <th class="hidden-480">Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach($un_submitted_attendance as $student_id => $attendances)
                            <tr>
                                <td><b>{{$i}}</b>
                                <input type="hidden" name="student_id{{$i}}" value="{{$student_id}}">
                                </td>
                                <td class="center">
                                   @if($attendances['image'] !='student_icon.jpg')
                                     <img class="img-responsive" alt="No Image" src="{{asset('storage/schools/'.$students_image_path.'/'.$attendances['image'])}}" 
                                    style="border-radius:50%;width: 50px; height: 50px;">
                                    @else
                                    <img id="avatar" class="img-responsive" alt="No Image" src="{{asset('storage/dumy_image/student_icon.jpg')}}"
                                    width="50" height="50" style="border-radius:50%;width: 50px; height: 50px;">
                                @endif 
                                </td>
                                <td>{{$attendances['full_name']}}</td>
                                <td class="hidden-480">{{$attendances['gender']}}</td>
                                <td class="center">
                                    @if($attendances['status']==0)
                                    <span id="status-badge{{$i}}" class="label label-sm label-danger">Absent</span>
                                    @elseif($attendances['status']==1)
                                    <span id="status-badge{{$i}}" class="label label-sm label-success">Present</span>
                                    @endif
                                </td>
                                <td class="center">
                                    @if($attendances['status']==0)
                                   <label>
                                        <input name="student_attendance_status{{$i}}" row="{{$i}}" id="student_attendance_status" type="radio" class="ace" value="1">
                                        &nbsp;
                                        <span class="lbl"> Present</span>
                                    </label>
                                    <label>
                                        <input name="student_attendance_status{{$i}}" checked row="{{$i}}" id="student_attendance_status" type="radio" class="ace" value="0">
                                        &nbsp;
                                        <span class="lbl"> Absent</span>
                                    </label>
                                    @elseif($attendances['status']==1)
                                   <label>
                                        <input name="student_attendance_status{{$i}}" checked row="{{$i}}" id="student_attendance_status" type="radio" class="ace" value="1">
                                        &nbsp;
                                        <span class="lbl"> Present</span>
                                    </label>
                                    <label>
                                        <input name="student_attendance_status{{$i}}" row="{{$i}}" id="student_attendance_status" type="radio" class="ace" value="0">
                                        &nbsp;
                                        <span class="lbl"> Absent</span>
                                    </label>
                                    @endif
                                </td>
                                <td class="hidden-480">
                                    @if($attendances['status']==0)
                                    <input name="student_attendance_status_reason{{$i}}" class="col-xs-12 col-sm-12" type="text" id="reason{{$i}}" >
                                    @else
                                    <input name="student_attendance_status_reason{{$i}}" class="col-xs-12 col-sm-12" type="hidden" id="reason{{$i}}" value="">
                                    @endif
                                </td>
                            </tr>
                            <?php $i++;?>
                            @endforeach
                        </tbody>
                    </table>
                    </div>    
                    @endif     
                </form> 
                 <Button style="width:230px;" class="btn btn-app btn-xs btn-info pull-right" id="btn-take-picture2" >
                <i class="ace-icon fa fa-camera bigger-160 "></i>    
                Take Class Attendance Picture
                </Button>
                <br/><br />
            </div>
        </div>
        </div>
    </div>
    <div class="col-sm-2"></div>
</div>

<!--Modal Confirm Camera-->
<div id="modal-confirm-camera" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header no-padding">
                <div class="table-header">
                    <b>Confirmation!!!</b>

                </div>
            </div>
            <div class="modal-body no-padding">
                <h3><b>&nbsp;&nbsp;Do you want to take <u>Class Attendance Picture</u> ?</b></h3>
            </div>
            <div class="modal-footer no-margin-top">
                <button class="btn btn-sm btn-success pull-left" id="btn-confirm-camera">
                    <i class="ace-icon glyphicon glyphicon-ok"></i>
                    YES
                </button>
                <button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
                    <i class="ace-icon fa fa-times"></i>
                    NO
                </button>
            </div>
        </div>
    </div>
</div>
<!--Modal Confirm Camera-->                                
        

        <!--JS Script-->
        <script>
        $(document).ready(function()
        {
            $(document).on("click","#btn-take-picture,#btn-take-picture2",function()
            {
                $("#modal-confirm-camera").modal('show');
            });

            $(document).on("click","#btn-confirm-camera",function()
            {
                $("#btn-take-picture").hide();
                $("#btn-take-picture2").hide();

                $("#modal-confirm-camera").modal('hide');
                $("#attendance_table_section").hide();
                $("#camera_section").load('/super_admin/load_camera_for_attendance_picture');   
            }); 
        });
        </script>
        <!--JS Script-->