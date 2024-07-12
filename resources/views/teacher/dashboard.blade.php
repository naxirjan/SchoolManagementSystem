@extends('master/master')

@section('title')
Teacher Dashboard
@endsection

@section('page_content')
<div class="main-content">
	<div class="main-content-inner">
		<!-- #section:basics/content.breadcrumbs -->
		<div class="breadcrumbs" id="breadcrumbs">
		<script type="text/javascript">
			try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		</script>
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="/">Home</a>
			</li>
			<li class="active">Teacher Dashboard</li>
			
		</ul><!-- /.breadcrumb -->
		<span class="pull-right">
						<span class="label label-success arrowed-in arrowed-in-right">
						You Are Currently Logged In As 
						
						School Teacher|
						<?php
                        	foreach (session('myuser_schools') as $key => $value)
			                {
			                    if($key == session('role_id'))
			                    {
			                        echo $value['school_name'];
			                    }
			                }
			            ?>
			            
			        	</span>
					   
                    </span>
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
						School Teacher Dashboard
						<i class="ace-icon fa fa-angle-double-right"></i>
						{{date('d F Y',strtotime($current_date))}}

					</strong>
					
				</h1>
				@if(session('forgot_pass_message_update'))
                <br/>
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
			</div><!-- /.page-header -->
			@if(!empty($school_weekend) || (!empty($school_holiday)))
				@if($school_weekend[0]->value == date('l',strtotime($current_date)))
					<div class="row">
						<div class="alert alert-info">
		            		<span class="header smaller lighter">
		                    <i class="ace-icon fa fa-bullhorn"></i>
		                    <b>Weekend:&nbsp;
		                    	{{$school_weekend[0]->value}}
		                    </b>
		                </span>
		                    <br/>
		                    School Is Closed Due To The {{$school_weekend[0]->value}} !...
		                </div>
					</div>
				@elseif(!empty($school_holiday))			
					<div class="row">
						<div class="alert alert-info">
		            		<span class="header smaller lighter">
		                    <i class="ace-icon fa fa-bullhorn"></i>
		                    <b>Holiday:&nbsp;
		                    	{{$school_holiday[0]->title}}
		                    </b>
		                </span>
		                    <br/>
		                    {{$school_holiday[0]->description}}
		                </div>
					</div>
				@endif
			@endif
			<div class="row">
				<?php $count = 1; ?>
                @if(!empty($result))
                	@foreach($result as $key => $data)
                		@if($count%4 == 0)
                			</div>
                			<hr/>
                			<div class="row">
                		@endif
                		<?php $count++; 

                		$total_attendance = $data['present']+$data['absent'];
                		?>
                		<div class="col-xs-6 col-sm-3" style="border-radius: 100px;margin-top: 20px;">
	                    	<div class="widget-box widget-color-blue">
	                        	<div class="widget-header">
	                        		<center>
	                            	<h5 class="widget-title bigger lighter class_name" class_name="{{$data['class_name']}}">
	                            		<b>{{$data['class_name']}}</b></h5>
	                            	</center>	
	                        	</div>
	                        	<div class="widget-body">
	                            	<div class="widget-main" style="overflow: auto;height: 300px">
	                            		<div class="price center">
		                                	<h3> <b>
													Attendance	
                                                   {{ round($data['percentage'])}}%
		                                	     </b>	
		                                	</h3>
		                                </div>
	                            		<table class="table table-responsive table-bordered">
	                            			<tr>
	                            				<td><i class="ace-icon fa fa-users purple"></i>
		                                        Total Teachers</td>
	                            				<td class="center"><b>{{$data['teachers']}}</b>
	                            				</td>
	                            			</tr>
	                            			
	                            			<tr>
	                            				<td><i class="ace-icon fa fa-users blue"></i>
		                                        Total Students </td>
	                            				<td class="center"><b>{{$data['students']}}</b></td>
	                            			</tr>

	                            			<tr>
	                            				<td><i class="ace-icon fa fa-users orange"></i>
		                                        Total Attendance </td>
	                            				<td class="center"><b>{{$total_attendance}}</b></td>
	                            			</tr>
	                            			<tr>
	                            				<td><i class="ace-icon fa fa-check green"></i>
		                                        Present Students &nbsp;@if($data['present'] != 0)
		                                        	<span style="float:right;"><a href="javascript:void(0);" class="students_dashboard" status="1" class_school_id="<?php echo $key;?>" image_path="<?php echo $data['image_path']?>"><b>| More Detail</b></a></span>
		                                        @endif</td>
	                            				<td class="center"><b>{{$data['present']}}</b>
		                                        	
		                                    </td>
	                            			</tr>
	                            			<tr>
	                            				<td><i class="ace-icon fa fa-times red"></i> 
		                                        Absent Students &nbsp;@if($data['absent'] != 0)
		                                        	<span style="float:right;">
		                                        		<a href="javascript:void(0);" class="students_dashboard" status="0" class_school_id="<?php echo $key;?>" image_path="<?php echo $data['image_path']?>"><b>| More Detail</b></a></span>
		                                        @endif</td>
	                            				<td class="center"><b>{{$data['absent']}}</b>
	                            					</td>
	                            			</tr>
	                            		</table>
		                            </div>
	                        	</div>
	                   		</div>
	                	</div>
	                @endforeach
                @else
                	<div class="col-sm-12 alert alert-danger">
                		<b>You Are Not Assigned To Any School Or Class!...</b>
                	</div>
                @endif
            </div>
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->

<div class="space-20"></div>

<div class="modal fade" id="modalStudents" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title"></h5>       
      </div>
      <div class="modal-body" id="all_students">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="assign_role_button" style="display: none;" class="btn btn-primary">Assign Teacher</button>
      </div>
    </div>
  </div>
</div>

<div id="modal-table" class="modal fade" tabindex="-1">
	<div class="modal-dialog" style="top: 30%;right: 0;">
		<div class="modal-content" style="border: 2px solid green;">
			<div class="modal-header no-padding">
				<div class="table-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<span class="white">&times;</span>
					</button>
					<span style="font-weight: bolder; font-size: 18px;" id=""></span>
				</div>
			</div>

			<div class="modal-body no-padding">
				<p style="padding: 10px; line-height: 30px; text-align: justify; font-size: 14px; font-weight: bold; margin:10px;" id="holiday_description_model"></p>								
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- PAGE CONTENT ENDS -->


<script type="text/javascript">			
	$(document).ready(function(){		  	
		$(".students_dashboard").click(function(e){
		  	e.preventDefault();
		  	
		  	var class_name 		=  $(".class_name").attr("class_name");
		  	var class_school_id =  $(this).attr("class_school_id");
		  	var status 			=  $(this).attr("status");
		  	var image_path 			=  $(this).attr("image_path");
		  	
		  	$.ajax({
			  url:'get_present_students_for_dashboard',
			  type:"POST",
			  data:{
			  _token:'{{csrf_token()}}',
			  status:status,
			  image_path:image_path,
			  class_name:class_name,
			  class_school_id:class_school_id,
			  },
			  success:function(data)
			    {
			       $("#modalStudents").modal('show');
			       $('#all_students ').html(data);
			    },
			});
		});
	});
</script>
@endsection

