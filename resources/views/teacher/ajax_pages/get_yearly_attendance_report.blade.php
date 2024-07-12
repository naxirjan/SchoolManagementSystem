        <div class="col-sm-1"></div>
        <div class="col-sm-10">
                    <!--print button -->
            {!!Form::open(array("url"=>"/teacher/generate_yearly_attendance_report","method"=>"post"))!!}
                <input type="hidden" name="class_school_id" value="{{$class_school_id}}">
                <input type="hidden" name="school_id" value="{{$school_id}}">
                <input type="hidden" name="yearly_date" value="{{$full_year}}">
                <input type="hidden" name="school_name" value="{{$school_name}}">
                <input type="hidden" name="class_name" value="{{$class_name}}">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn btn-success" type="submit">
                      <i class="ace-icon fa fa-download align-top bigger-125 icon-on-left"></i>
                      Download Excel
                </button>
            {!!Form::close()!!}
            <hr />  
                <!--end print button -->
        <div class="space-20"></div>
            <div class="tabbable">
                <ul class="nav nav-tabs padding-16">
                    <li class="active">
                        <a data-toggle="tab" href="#tab-1" aria-expanded="true">
                            <i class="menu-icon fa fa-info-circle bigger-150"></i>
                            <b>&nbsp;Class Attendance Rate</b>
                        </a>
                    </li>
                </ul>
                <div class="tab-content profile-edit-tab-content">
                    <br>
                    <h3><b>Year:</b> {{$full_year}} </h3>
                    <hr>
                    <div class="sticky-table sticky-headers sticky-ltr-cells" style="overflow-y: hidden;">
                        <table class="table table-responsive"  border="1px solid black">
                             <thead>
                                    <tr>
                                        <th class="sticky-cell">
                                            <span >
                                                <button class="btn btn-inverse" style="width: 200px">
                                                    <b>Month Names</b>
                                                </button>    
                                            </span>
                                        </th>
                                        <th >
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>January</b>
                                                </button>    
                                            </span>
                                        </th>
                                        <th>
                                            <span>
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>Febraury</b>
                                                </button>    
                                            </span>
                                        </th>
                                        <th>
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>March</b>
                                                </button>    
                                            </span>
                                        </th>
                                        <th> 
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>April</b>
                                                </button>    
                                            </span>
                                        </th>
                                        <th>
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>May</b>
                                                </button>    
                                            </span>
                                        </th>
                                        <th>
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>June</b>
                                                </button>    
                                            </span>
                                        </th>
                                        <th>
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>July</b>
                                                </button>    
                                            </span>
                                          </th>
                                          <th>  
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>August</b>
                                                </button>    
                                            </span>
                                          </th>
                                            <th>
                                                <span >
                                                    <button class="btn btn-inverse" style="width: 135px">
                                                        <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                        <b>September</b>
                                                    </button>    
                                                </span>
                                            </th>
                                            <th>
                                                <span >
                                                    <button class="btn btn-inverse" style="width: 135px">
                                                        <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                        <b>October</b>
                                                    </button>    
                                                </span>
                                            </th>
                                            <th>
                                                <span >
                                                    <button class="btn btn-inverse" style="width: 135px">
                                                        <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                        <b>Novmeber</b>
                                                    </button>    
                                                </span>
                                            </th>
                                            <th>
                                                <span >
                                                    <button class="btn btn-inverse" style="width: 135px">
                                                        <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                        <b>December</b>
                                                    </button>    
                                                </span>
                                            </th>
                                             <th>

                                                <span >

                                                    <button class="btn btn-inverse" style="width: 135px;">
                                                       &nbsp;
                                                        <b>Overall</b>
                                                    </button>    
                                                </span>
                                            </th>
                                    </tr>  
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="sticky-cell">
                                         <span >
                                                <button class="btn btn-inverse" style="width: 200px">
                                                     <b>Number Of Working Days</b>
                                                </button>    
                                        </span>
                                    </td>
                                        <?php $count = 0; ?>
                                        <?php $overall_working_days = 0 ?>
                                        @foreach($all_attendance as $val)
                                            <td>
                                                <span >
                                                    <button class="btn btn-white" style="width: 135px;padding: 10px;">
                                                        
                                                        <b>{{$val['total_attendance']}}
                                                        <?php $overall_working_days += $val['total_attendance'] ?></b>
                                                    </button>    
                                                </span>
                                            </td>
                                        @endforeach
                                    <td align="center">
                                         <b style="font-size:13px; font-weight: bolder; padding: 5px;" class="badge badge-success">
                                        {{$overall_working_days}}
                                        </b>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sticky-cell">
                                         <span >
                                            <button class="btn btn-inverse" style="width: 200px">
                                                <b>Average Attendance Rate</b>
                                            </button>    
                                        </span>
                                    </td>
                                    <?php $count = 0; ?>
                                    <?php $sub_avr = 0; ?>
                                    @foreach($all_attendance as $val)
                                        <td>
                                             <span >
                                                <button class="btn btn-white" style="width: 135px;padding: 10px;">
                                                    <b>
                                                         @if(!empty($val['month_present_attendance']) AND $val['total_attendance'])
                                                            <?php $count++; ?>
                                                            <?php echo round($val['month_present_attendance']/$val['total_attendance']); ?>
                                                            <?php $sub_avr += round($val['month_present_attendance']/$val['total_attendance']); ?>
                                                            @else
                                                             0
                                                        @endif
                                                    </b>
                                                </button>    
                                            </span>
                                        </td>
                                    @endforeach
                                    <td align="center">
                                        <b style="font-size:13px; font-weight: bolder; padding: 5px;" class="badge badge-primary">
                                            {{round($sub_avr)/$count}}
                                        </b>     
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
             <div class="space-30"></div>
             <div class="tabbable">
                    <ul class="nav nav-tabs padding-16">
                        <li class="active">
                            <a data-toggle="tab" href="#tab-1" aria-expanded="true">
                                <i class="menu-icon fa fa-info-circle bigger-150"></i>
                                <b>&nbsp;Student Attendance Rate</b>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content profile-edit-tab-content">
                        <br/>
                        <h3> <b>Year:</b> {{$full_year}} </h3>
                        <hr/>
                        <div class="sticky-table sticky-headers sticky-ltr-cells" style="overflow-y: auto; height: 500px;">
                            <table  width="100%" border="1px solid black" class="">
                                <tr>
                                    <th style="min-width:300px" align="center" class="sticky-cell">
                                        <table border="1px solid black" style="border:1px solid black">
                                            <tr style="height: 70px;">
                                                
                                                <td>
                                                <span >
                                                <button class="btn btn-inverse" style="width: 84px">
                                                    <i class="bigger-120"></i>
                                                    <b>Image</b>
                                                </button>    
                                            </span>
                                               </td> 
                                               

                                                <td>
                                                <span >
                                                <button class="btn btn-inverse" style="width: 230px">
                                                    <i class="bigger-120"></i>
                                                    <b>Full Name</b>
                                                </button>    
                                            </span>
                                            </td>
                                            </tr>
                                        </table>
                                    </th>
                                    <td> 
                                        <div style="width:1661px">
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>January</b>
                                                </button>    
                                            </span>

                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>Febraury</b>
                                                </button>    
                                            </span>
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>March</b>
                                                </button>    
                                            </span>
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>April</b>
                                                </button>    
                                            </span>
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>May</b>
                                                </button>    
                                            </span>

                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>June</b>
                                                </button>    
                                            </span>
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>July</b>
                                                </button>    
                                            </span>

                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>August</b>
                                                </button>    
                                            </span>

                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>September</b>
                                                </button>    
                                            </span>

                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>October</b>
                                                </button>    
                                            </span>

                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>Novmeber</b>
                                                </button>    
                                            </span>
                                            <span >
                                                <button class="btn btn-inverse" style="width: 135px">
                                                    <i class="ace-icon fa fa-calendar bigger-160"></i>
                                                    <b>December</b>
                                                </button>    
                                            </span>
                                        </div>  
                                    </td>
                                    <th style="min-width: 100px" class="center"><b class="btn btn-inverse" style="width: 135px">Overall</b></th>
                                </tr>
                                   <?php
                                        $present = 0;
                                        $absent  = 0;
                                        $jan = 0;
                                        $feb = 0;
                                        $mar = 0;
                                        $apr = 0;
                                        $may = 0;
                                        $jun = 0;
                                        $jul = 0;
                                        $aug = 0;
                                        $sep = 0;
                                        $oct = 0;
                                        $nov = 0;
                                        $dec = 0;
                                        $over_all_month = 0;
                                    ?>
                                    @foreach($myattendance as $attendance)
                                        <tr>
                                            <th style="min-width:300px" class="sticky-cell">
                                                <table border="1px solid black" style="border:1px solid black">
                                                    <tr style="height: 40px;">
                                                        <th style="min-width:70px;">
                                                            <center>
                                                            <b style="font-size:13px; padding: 5px;">
                                                            
                                                             @if($attendance['student_combine_image'] !='student_icon.jpg')
                                                             
                                                                <img  class="img-responsive" alt="No Image" src="{{asset($attendance['profile_picture'])}}"  style="border-radius:50%;width: 50px;height: 50px;">
                                                               
                                                            @else
                                                                <img id="avatar" class="img-responsive" alt="No Image" src="{{asset('storage/dumy_image/student_icon.jpg')}}"
                                                                 style="border-radius:50%;width: 50px;height: 50px;">
                                                            @endif     
                                                           
                                                            </b>
                                                            </center>
                                                        </th>
                                                        <td style="min-width:190px; text-align: left">
                                                            <b style="font-size:13px; padding: 5px;">
                                                                <?php echo $attendance['full_name']; ?>
                                                            </b>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </th>
                                            <td>
                                                <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                                                    <span >
                                                        @if(!empty($attendance['jan']))
                                                            <button title="January"  class="btn btn-white" style="width: 135px;background-color:white;">
                                                                @if(is_array($attendance['jan']))
                                                                    <?php $over_all_month.=1; ?>
                                                                        @foreach($attendance['jan'] as $status)
                                                                            @if($status == 1)
                                                                            <?php $present++; ?>
                                                                            @elseif($status == 0)
                                                                            <?php $absent++;?>
                                                                            @endif
                                                                        @endforeach
                                                                       <b>
                                                                            <?php 
                                                                                $jan =  round(($present/($present+$absent)*100));
                                                                                echo $jan;
                                                                                echo '%';
                                                                                $present = 0;
                                                                                $absent = 0;
                                                                            ?>
                                                                        </b>
                                                            </button>
                                                        @endif
                                                        @else
                                                         <button title="No Attendance Taken" class="btn btn-white" style="width: 135px;background-color:white;"><b> 0 </b></button>
                                                        @endif     
                                                    </span>
                                                    <span >
                                                        @if(!empty($attendance['feb']))
                                                              <button  title="February" class="btn btn-white" style="width: 135px;background-color:white;">
                                                                @if(is_array($attendance['feb']))
                                                                    @foreach($attendance['feb'] as $status)

                                                                        @if($status == 1)
                                                                           <?php $present++; ?>
                                                                           @elseif($status == 0)
                                                                           <?php $absent++;?>
                                                                           @endif
                                                                    @endforeach
                                                                    <b>
                                                                        <?php 
                                                                            $feb =  round(($present/($present+$absent)*100));
                                                                            echo $feb;
                                                                            echo '%';
                                                                            $present = 0;
                                                                            $absent = 0;
                                                                        ?>
                                                                    </b>
                                                                </button>
                                                                @endif
                                                            @else
                                                            <button title="No Attendance Taken" class="btn btn-white" style="width: 135px;background-color:white;"><b> 0 </b></button>
                                                            @endif
                                                            
                                                        
                                                    </span>

                                                     <span >
                                                            
                                                               
                                                                @if(!empty($attendance['mar']))
                                                                <button title="March" class="btn btn-white" style="width: 135px;background-color:white;">
                                                                @if(is_array($attendance['mar']))
                                                                    @foreach($attendance['mar'] as $status)

                                                                        @if($status == 1)
                                                                           <?php $present++; ?>
                                                                           @elseif($status == 0)
                                                                           <?php $absent++;?>
                                                                           @endif
                                                                        @endforeach
                                                                        <b>
                                                                        <?php
                                                                        $mar = round(($present/($present+$absent)*100));
                                                                        echo $mar;
                                                                        echo '%';
                                                                    $present = 0;
                                                                    $absent = 0;
                                                                    ?></b>
                                                                     </button>
                                                                @endif
                                                                @else
                                                                <button title="No Attendance Taken" class="btn btn-white" style="width: 135px;background-color:white;"><b> 0 </b></button>
                                                                @endif
                                                                
                                                        
                                                    </span>

                                                    <span >
                                                            
                                                            @if(!empty($attendance['apr']))
                                                            <button  title="April" class="btn btn-white" style="width: 135px;background-color:white;">
                                                                @if(is_array($attendance['apr']))
                                                                    @foreach($attendance['apr'] as $status)

                                                                        @if($status == 1)
                                                                           <?php $present++; ?>
                                                                           @elseif($status == 0)
                                                                           <?php $absent++;?>
                                                                           @endif
                                                                        @endforeach
                                                                       <b>
                                                                       <?php
                                                                        $apr = round(($present/($present+$absent)*100));
                                                                        echo $apr;
                                                                        echo '%';
                                                                    $present = 0;
                                                                    $absent = 0;
                                                                    ?>
                                                                    </b>
                                                                    </button>
                                                                @endif
                                                                @else
                                                                 <button title="No Attendance Taken" class="btn btn-white" style="width: 135px;background-color:white;"><b> 0 </b></button>
                                                                @endif
                                                            </span>

                                                    <span >
                                                     @if(!empty($attendance['may']))
                                                     <button  title="May" class="btn btn-white" style="width: 135px;background-color:white;">
                                                                @if(is_array($attendance['may']))
                                                                    @foreach($attendance['may'] as $status)

                                                                        @if($status == 1)
                                                                           <?php $present++; ?>
                                                                           @elseif($status == 0)
                                                                           <?php $absent++;?>
                                                                           @endif
                                                                        @endforeach
                                                                            <b>
                                                                            <?php
                                                                        $may = round(($present/($present+$absent)*100));
                                                                        echo $may;
                                                                        echo '%';
                                                                    $present = 0;
                                                                    $absent = 0;
                                                                    ?>
                                                                    </b>
                                                                    </button>
                                                                @endif
                                                                @else
                                                                <button title="No Attendance Taken" class="btn btn-white" style="width: 135px;background-color:white;"><b> 0 </b></button>
                                                                @endif
                                                            </span>

                                                    <span >

                                                                @if(!empty($attendance['jun']))
                                                                <button  title="June" class="btn btn-white" style="width: 135px;background-color:white;">
                                                                <?php $over_all_month=2; ?>
                                                                @endif

                                                                @if(!empty($attendance['jun']))
                                                                @if(is_array($attendance['jun']))
                                                                    @foreach($attendance['jun'] as $status)
                                                                        @if($status == 1)
                                                                           <?php $present++; ?>
                                                                           @elseif($status == 0)
                                                                           <?php $absent++;?>
                                                                           @endif
                                                                        @endforeach
                                                                        <b>
                                                                        <?php
                                                                        $jun = round(($present/($present+$absent)*100));
                                                                        echo $jun;
                                                                        echo '%';
                                                                    $present = 0;
                                                                    $absent = 0;
                                                                    ?>
                                                                    </b>
                                                                     </button>
                                                                @endif
                                                                @else
                                                                 <button title="No Attendance Taken" class="btn btn-white" style="width: 135px;background-color:white;"><b> 0 </b></button>
                                                                @endif
                                                            </span>

                                                    <span >
                                                            
                                                                @if(!empty($attendance['jul']))
                                                                <button  title="July" class="btn btn-white" style="width: 135px;background-color:white;">
                                                                @if(is_array($attendance['jul']))
                                                                    @foreach($attendance['jul'] as $status)
                                                                        @if($status == 1)
                                                                           <?php $present++; ?>
                                                                           @elseif($status == 0)
                                                                           <?php $absent++;?>
                                                                           @endif
                                                                        @endforeach
                                                                        <b>
                                                                        <?php
                                                                        $jul = round(($present/($present+$absent)*100));
                                                                        echo $jul;
                                                                        echo '%';
                                                                    $present = 0;
                                                                    $absent = 0;
                                                                    ?>
                                                                    </b>
                                                                    </button>
                                                                @endif
                                                                @else
                                                                <button title="No Attendance Taken" class="btn btn-white" style="width: 135px;background-color:white;"><b> 0 </b></button>
                                                                @endif
                                                                

                                                         
                                                    </span>
                                                    <span >
                                                            
                                                                
                                                                @if(!empty($attendance['aug']))
                                                                <button  title="August" class="btn btn-white" style="width: 135px;background-color:white;">
                                                                @if(is_array($attendance['aug']))
                                                                    @foreach($attendance['aug'] as $status)
                                                                        @if($status == 1)
                                                                           <?php $present++; ?>
                                                                           @elseif($status == 0)
                                                                           <?php $absent++;?>
                                                                           @endif
                                                                        @endforeach
                                                                        <b>
                                                                        <?php
                                                                        $aug = round(($present/($present+$absent)*100));
                                                                        echo $aug;
                                                                        echo '%';
                                                                    $present = 0;
                                                                    $absent = 0;
                                                                    ?>
                                                                    </b>
                                                                </button>
                                                                @endif
                                                                @else
                                                                <button title="No Attendance Taken" class="btn btn-white" style="width: 135px;background-color:white;"><b> 0 </b></button>
                                                                @endif
                                                            </span>

                                                    <span >
                                                            
                                                             
                                                             @if(!empty($attendance['sep']))
                                                             <button  title="September" class="btn btn-white" style="width: 135px;background-color:white;">
                                                                @if(is_array($attendance['sep']))
                                                                    @foreach($attendance['sep'] as $status)
                                                                        @if($status == 1)
                                                                           <?php $present++; ?>
                                                                           @elseif($status == 0)
                                                                           <?php $absent++;?>
                                                                           @endif
                                                                        @endforeach
                                                                        <b>
                                                                        <?php
                                                                        $sep = round(($present/($present+$absent)*100));
                                                                        echo $sep;
                                                                        echo '%';
                                                                    $present = 0;
                                                                    $absent = 0;
                                                                    ?>
                                                                    </b>
                                                            </button>
                                                                @endif
                                                                @else
                                                                <button title="No Attendance Taken" class="btn btn-white" style="width: 135px;background-color:white;"><b> 0 </b></button>
                                                                @endif
                                                               
                                                         
                                                    </span>
                                                    <span >
                                                             @if(!empty($attendance['oct']))
                                                             <button  title="October" class="btn btn-white" style="width: 135px;background-color:white;">
                                                                @if(is_array($attendance['oct']))
                                                                    @foreach($attendance['oct'] as $status)
                                                                        @if($status == 1)
                                                                           <?php $present++; ?>
                                                                           @elseif($status == 0)
                                                                           <?php $absent++;?>
                                                                           @endif
                                                                        @endforeach
                                                                        <b>
                                                                        <?php
                                                                        $oct = round(($present/($present+$absent)*100));
                                                                        echo $oct;
                                                                        echo '%';
                                                                        $present = 0;
                                                                        $absent = 0;
                                                                        ?>
                                                                    </b>
                                                             </button>
                                                                @endif
                                                                @else
                                                                 <button title="No Attendance Taken" class="btn btn-white" style="width: 135px;background-color:white;"><b> 0 </b></button>
                                                                @endif 
                                                            </span>
                                                    <span >
                                                            
                                                             @if(!empty($attendance['nov']))
                                                             <button  title="November" class="btn btn-white" style="width: 135px;background-color:white;">
                                                                @if(is_array($attendance['nov']))
                                                                    @foreach($attendance['nov'] as $status)
                                                                        @if($status == 1)
                                                                           <?php $present++; ?>
                                                                           @elseif($status == 0)
                                                                           <?php $absent++;?>
                                                                           @endif
                                                                        @endforeach
                                                                        <b>
                                                                        <?php
                                                                        $nov = round(($present/($present+$absent)*100));
                                                                        echo $nov;
                                                                        echo '%';
                                                                    $present = 0;
                                                                    $absent = 0;
                                                                    ?>
                                                                    </b>
                                                                    </button>
                                                                @endif
                                                                @else
                                                                <button title="No Attendance Taken" class="btn btn-white" style="width: 135px;background-color:white;"><b> 0 </b></button>
                                                                @endif
                                                            </span>
                                                        <span >
                                                            
                                                            @if(!empty($attendance['dec']))
                                                            <button  title="December" class="btn btn-white" style="width: 135px;background-color:white;">
                                                                @if(is_array($attendance['dec']))
                                                                    @foreach($attendance['dec'] as $status)
                                                                        @if($status == 1)
                                                                           <?php $present++; ?>
                                                                           @elseif($status == 0)
                                                                           <?php $absent++;?>
                                                                           @endif
                                                                        @endforeach
                                                                        <b>
                                                                        <?php
                                                                        $dec = round(($present/($present+$absent)*100));
                                                                        echo $dec;
                                                                        echo '%';
                                                                    $present = 0;
                                                                    $absent = 0;
                                                                    ?>
                                                                    </b>
                                                             </button>
                                                                @endif
                                                                @else
                                                                <button title="No Attendance Taken" class="btn btn-white" style="width: 135px;background-color:white;"><b> 0 </b></button>
                                                                @endif
                                                                 </span>
                                             </div>
                                        </td>
                                        <?php $over_all_percent = round(($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec)/($count*100)*100)?>
                                        <td align="center">
                                            <b style="font-size:13px; font-weight: bolder; padding: 5px;" class="<?php
                                            if($over_all_percent >= 80)
                                            {echo "badge badge-success";}
                                            else
                                            {
                                                echo "badge badge-danger";
                                            }
                                            ?>">
                                                {{$over_all_percent}}%
                                            </b>
                                        </td>
                                       
                                </tr>
                                @endforeach
                            </table>
                            
                        </div>
                    </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>

