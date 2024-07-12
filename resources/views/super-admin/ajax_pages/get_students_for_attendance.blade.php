<div class="col-xs-12">
    <div class="col-sm-2"></div>
    <div class="col-sm-8" id="divs">
        <div class="tabbable">
            <ul class="nav nav-tabs padding-16">
                <li class="active">
                    <a data-toggle="tab" href="#tab-1" aria-expanded="true">
                        <i class="menu-icon  fa fa-users bigger-150"></i>
                        <b>&nbsp;Students&nbsp;</b>
                    </a>
                </li>
                
            </ul>

            <div class="tab-content profile-edit-tab-content">
                <div id="tab-1" class="tab-pane active">
                    @if($students)
                    <?php $i=1;?>
                    @foreach($students as $student)
                    <div id="user-profile" class="pricing-box row">
                       
                        
                        <div class="col-xs-12 col-sm-3 center">
                            <br />
                                <!--profile.picture -->
                                <span class="profile-picture" style="border-radius:50%;border:1px solid #e4e6e9;width:150px; height:150px;">
                                  @if($student->student_image !='student_icon.jpg')
                                    <img  alt="No Image" src="{{asset('storage/schools/'.$students_image_path.'/'.$student->student_image)}}"
                                     style="border-radius:50%;width: 140px;height: 140px;">
                                @else
                                    <img  alt="No Image" src="{{asset('storage/dumy_image/student_icon.jpg')}}"
                                     style="border-radius:50%;width: 140px;height: 140px;">
                                @endif    
                            
                                </span>
                                <!--profile.picture --> 

                        </div>

                        <div class="col-xs-12 col-sm-9">
                            <div class="space-12"></div>
                            <!--User Profile Information-->
                            <div class="profile-user-info profile-user-info-striped">

                                
                                <div class="profile-info-row">
                                    <div class=""></div>
                                    <div class="profile-info-value">
                                        <span class="label label-primary arrowed arrowed-right pull-right">Showing 
                                        <span><?php echo $i;?></span> Of 
                                        <span>{{count($students)}}</span>
                                        </span> 
                                    </div>
                                </div>
                                <?php $i++;?>
                                <!--Full Name-->
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Full Name </div>
                                    <div class="profile-info-value">
                                        <span class=""><b>{{$student->first_name}}&nbsp;{{$student->middle_name}}&nbsp;{{$student->last_name}}</b></span>
                                    </div>
                                </div>
                                <!--Full Name-->

                                <!--Gender-->
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Gender </div>
                                    <div class="profile-info-value">
                                        <span class=""><b>{{$student->gender}}</b></span>
                                    </div>
                                </div>
                                <!--Gender-->

                                <!--Attendance-->
                                <div class="profile-info-row">
                                    <div class="profile-info-name">Attendance</div>
                                    <div class="profile-info-value center">
                                        <div class="btn-group btn-corner">
                                        <a  href="" student_id="{{$student->id}}" student_image="{{$student->student_image}}" student_full_name="{{$student->first_name}} {{$student->middle_name}} {{$student->last_name}}" student_gender="{{$student->gender}}" student_status="0" class="label label-xlg label-danger arrowed arrowed-right" id="btn-absent">Absent</a>&nbsp;
                                        <a href="" student_id="{{$student->id}}" student_full_name="{{$student->first_name}} {{$student->middle_name}} {{$student->last_name}}" student_image="{{$student->student_image}}" student_gender="{{$student->gender}}" student_status="1" class="label  label-xlg label-success arrowed arrowed-right" id="btn-present">Present</a>
                                        
                                        </div>    
								    </div>
                                </div>
                                <!--Attendance-->
                                </div>
                            <div class="space-12"></div>
                        </div>
                    </div>
                  
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-1"></div>
</div>