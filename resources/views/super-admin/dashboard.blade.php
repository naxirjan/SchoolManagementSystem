@extends('master/master')

@section('title')
Super Admin Dashboard
@endsection

@section('page_content')
<div class="main-content">
    <div class="main-content-inner">
        <!-- #section:basics/content.breadcrumbs -->
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try {
                    ace.settings.check('breadcrumbs', 'fixed')
                } catch (e) {}
            </script>

            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="/">Home</a>
                </li>
                <li class="active">Super Admin Dashboard</li>
            </ul><!-- /.breadcrumb -->



        </div>

        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content">
            <!-- #section:settings.box -->
            <div class="ace-settings-container" id="ace-settings-container">
                <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                    <i class="ace-icon fa fa-cog bigger-130"></i>
                </div>

                <div class="ace-settings-box clearfix" id="ace-settings-box">
                    <div class="pull-left width-50">
                        <!-- #section:settings.skins -->
                        <div class="ace-settings-item">
                            <div class="pull-left">
                                <select id="skin-colorpicker" class="hide">
                                    <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                    <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                    <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                    <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                </select>
                            </div>
                            <span>&nbsp; Choose Skin</span>
                        </div>

                        <!-- /section:settings.skins -->

                        <!-- #section:settings.navbar -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                            <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                        </div>

                        <!-- /section:settings.navbar -->

                        <!-- #section:settings.sidebar -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                            <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                        </div>

                        <!-- /section:settings.sidebar -->

                        <!-- #section:settings.breadcrumbs -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                            <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                        </div>

                        <!-- /section:settings.breadcrumbs -->

                        <!-- #section:settings.rtl -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                            <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                        </div>

                        <!-- /section:settings.rtl -->

                        <!-- #section:settings.container -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                            <label class="lbl" for="ace-settings-add-container">
                                Inside
                                <b>.container</b>
                            </label>
                        </div>

                        <!-- /section:settings.container -->
                    </div><!-- /.pull-left -->

                    <div class="pull-left width-50">
                        <!-- #section:basics/sidebar.options -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
                            <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
                            <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
                            <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                        </div>

                        <!-- /section:basics/sidebar.options -->
                    </div><!-- /.pull-left -->
                </div><!-- /.ace-settings-box -->
            </div><!-- /.ace-settings-container -->

            <!-- /section:settings.box -->
            <div class="page-header">
                <h1>
                    <strong>
                    Super Admin Dashboard
                   
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        {{date('d F Y',strtotime($current_date))}}</strong>
                  
                </h1>
            </div><!-- /.page-header -->
            @if(session('forgot_pass_message_update'))
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                <strong>
                    {{ session('forgot_pass_message_update') }}
                </strong>
                <br>
            </div>
            @endif
        
            <div class="row">
            	<div class="col-sm-12">
                   <?php
                            $output = "";
                			$seperator = " , ";
                	?>

                    	@if(!empty($attendance_record))

			                	@if($all_schools_holiday==true)

			                		<div class="alert alert-info">
				                		<span class="header smaller lighter">
			                            <i class="ace-icon fa fa-bullhorn"></i>
			                            <b>Holiday:&nbsp;
			                            	@foreach($attendance_record as $attendance)
			                            		
			                            		@if(!empty($attendance['school_holiday']))

			                            		{{$attendance['school_holiday'][0]->title}}
			                            		@break;
			                            		@endif
			                            	@endforeach
			                            </b>
			                        	</span>
			                        	<br />
			                            	{{$attendance['school_holiday'][0]->description}}
			                        </div>
                                   @elseif(!empty($school_weekend))
                                        @if($school_weekend == date('l',strtotime($current_date)))
                                            <div class="row">
                                                <div class="alert alert-info">
                                                    <span class="header smaller lighter">
                                                    <i class="ace-icon fa fa-bullhorn"></i>
                                                    <b>Weekend:&nbsp;
                                                        {{$school_weekend}}
                                                    </b>
                                                </span>
                                                    <br/>
                                                    School Is Closed Due To The {{$school_weekend}} !...
                                                </div>
                                            </div>
                                        @endif 
			           			   @endif
						                	@foreach($attendance_record as $attendance)

                                            <?php 
                                                $total_attendance = $attendance['total_presents']+$attendance['total_absents'];
                                            ?>

						                	<div class="col-xs-12 col-sm-3" style="margin-top:20px">
																<div class="widget-box widget-color-blue">
																	<div class="widget-header">
                                                                        <center>
																		      <h5 class="widget-title bigger lighter"><b>{{$attendance['school']}}</b></h5>
                                                                        </center>
																	</div>

																	<div class="widget-body">
																		<div class="widget-main" style="overflow:auto; height:300px">
                                                                            
                                                                                @if($all_schools_holiday==false)

                                                                                    @if(!empty($attendance['school_holiday']))
                                                                                            <div class="alert-info" style="padding: 5px;">
                                                                                            &nbsp;
                                                                                            <span class="header smaller lighter warning alert-info">
                                                                                            <i class="ace-icon fa fa-bullhorn"></i>
                                                                                            <b>Holiday:&nbsp;{{$attendance['school_holiday'][0]->title}}</b>
                                                                                            </span>
                                                                                            <br />
                                                                                            {{$attendance['school_holiday'][0]->description}}
                                                                                        </div>
                                                                                    @endif
                                                                                @endif
                                                                            <div class="price center">
                                                                                <h3><b>
                                                                                    Attendance
                                                                                     
                                                                                    @if($attendance['total_presents']!=0 && $attendance['total_students']!=0)
                                                                                     <?php   
                                                                                    $percentage = (($attendance['total_presents']/$total_attendance)*100)
                                                                                     ?>

                                                                                   {{round($percentage)}}%
                                                                                    

                                                                                    @else
                                                                                        0%
                                                                                    @endif
                                                                                </b>
                                                                                </h3>
                                                                            </div>
                                                                           <table class="table table-responsive table-bordered">
                                                                            <tr>

                                                                                <td><i class="ace-icon fa fa-users purple"></i>
                                                                                    Total Teachers</td>
                                                                                   
                                                                                <td class="center"> <b>{{$attendance['total_teachers']}}</b> </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="ace-icon fa fa-users blue"></i>
                                                                                    Total Students</td>
                                                                                    
                                                                                <td class="center"><b>{{$attendance['total_students']}}</b></td>
                                                                            </tr> 
                                                                            <tr>
                                                                                <td><i class="ace-icon fa fa-users orange"></i>
                                                                                    Total Attendance</td>
                                                                                    
                                                                                <td class="center"><b>{{($attendance['total_presents']+$attendance['total_absents'])}}</b></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td ><i class="ace-icon fa fa-check green"></i>
                                                                                        Total Present Students</td>
                                                                                    
                                                                                <td class="center"><b>{{$attendance['total_presents']}}</b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="ace-icon fa fa-times red"></i>
                                                                                    Total Absent Students</td>
                                                                                    
                                                                                <td class="center"><b>{{$attendance['total_absents']}}</b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><i class="ace-icon glyphicon glyphicon-home"></i>
                                                                                    Classes</td>
                                                                                   
                                                                                <td style="width: 90px;" class="center"><b>
                                                                                    @if(!empty($attendance['school_classes']))    
                                                                                    @foreach($attendance['school_classes'] as $class)
                                                                                        <?php 
                                                                                            //$output.= $class->class.$seperator; 
                                                                                            ?> 
                                                                                           {{$class->class}}<br />    
                                                                                    @endforeach
                                                                                    @else
                                                                                        None
                                                                                    @endif
                                                                                    
                                                                                </b></td>
                                                                            </tr>
                                                                        </table>
																	</div>
																</div>
															</div>
											             </div>
											         @endforeach
			                	                @endif    	                			
                                            </div>
                                        </div>
                                    </div><!-- /.page-content -->
                                </div>
                            </div><!-- /.main-content -->
                        <div class="space-20"></div>
                    @endsection