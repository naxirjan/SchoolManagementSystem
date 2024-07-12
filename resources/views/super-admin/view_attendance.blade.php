@extends('master/master')

@section('title')
View Attendance
@endsection

@section('page_content')
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs" id="breadcrumbs">
			<script type="text/javascript">
				try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
			</script>
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="/">Home</a>
				</li>
				<li class="active">View Attendance</li>
			</ul>
		</div>
		<div class="page-content">
			<div class="ace-settings-container" id="ace-settings-container">
				<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
					<i class="ace-icon fa fa-cog bigger-130"></i>
				</div>
				<div class="ace-settings-box clearfix" id="ace-settings-box">
					<div class="pull-left width-50">
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
						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
							<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
						</div>
						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
							<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
						</div>
						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
							<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
						</div>
						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
							<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
						</div>
						<div class="ace-settings-item">
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
							<label class="lbl" for="ace-settings-add-container">Inside<b>.container</b>
							</label>
						</div>
					</div>
					<div class="pull-left width-50">			
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
					</div>
				</div>
			</div>
			<div class="page-header"><h1>View Attendance</h1></div>
			<div class="row">
				<div class="col-sm-12">



					<!--Alert If No Report Type Is Selected-->
		            <div class="alert alert-block alert-danger" id="alert_no_report_type_is_selected" style="display:none;">
		                <button type="button" class="close" data-dismiss="alert">
		                    <i class="ace-icon fa fa-times"></i>
		                </button>
		                <b>Please Select Any Report Type!...</b>
		            </div>
		            <!--Alert If No Report Type Is Selected-->

					<!--Alert If No School Is Selected-->
		            <div class="alert alert-block alert-danger" id="alert_no_school_is_selected" style="display:none;">
		                <button type="button" class="close" data-dismiss="alert">
		                    <i class="ace-icon fa fa-times"></i>
		                </button>
		                <b>Please Select Any School!...</b>
		            </div>
		            <!--Alert If No School Is Selected-->

		            <!--Alert If School Has No Classes-->
		            <div class="alert alert-block alert-danger" id="alert_no_school_classes" style="display:none;">
		                <button type="button" class="close" data-dismiss="alert">
		                    <i class="ace-icon fa fa-times"></i>
		                </button>
		                <span id="no_school_classes_message"></span>
		            </div>
		            <!--Alert If School Has No Classes-->

		            <!--Alert If No Class In Selected-->
		            <div class="alert alert-block alert-danger" id="alert_no_class_is_selected" style="display:none;">
		                <button type="button" class="close" data-dismiss="alert">
		                    <i class="ace-icon fa fa-times"></i>
		                </button>
		                <b>Please Select Any Class!...</b>
		            </div>
		           	<!--Alert If No Class In Selected-->
				</div>
			</div>
			<div class="row">
                <div class="col-xs-12">

                	@if(!empty($schools))

                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <div class="profile-user-info profile-user-info-striped">
                        	<div class="profile-info-row" id="div_report_type">
                                <div class="profile-info-name"> Report Type </div>
                                <div class="profile-info-value">
	                                <select class="form-control" id="report_type_id" style="color:#333333;font-weight:bold;font-size:13px;">
	                                	<option value=''>-- Select Report Type --</option>
                                        <option value='1'>Daily</option>
                                        <option value='2'>Monthly (Individual)</option>
                                        <option value='3'>Monthly (Combine)</option>
                                        <option value='4'>Yearly</option>
                                        <option value='5'>Date Range (Individual)</option>
                                        <option value='6'>Date Range (Combine)</option>
                                        <option value='7'>Date Range (Average)</option>
                                        <option value='8'>Student Report</option>
	                                </select> 
                                </div>
                            </div>
                            @if(!empty($schools))
                            <div class="profile-info-row" style="display:none;" id="div_school">
                                <div class="profile-info-name">School Name</div>
                                <input type="hidden" id="school_weekend" value="{{$weekend_day_name}}">
                                <div class="profile-info-value">
                                	<select class="form-control" id="schools" style="color:#333333;font-weight:bold;font-size:13px;">
                                		<option value="">-- Select School --</option>
                         				@foreach($schools as $school)
                                    	<option value="{{$school['id']}}"> {{$school['school']}} </option>
                                    	@endforeach
                                 	</select> 
                                 	 <input type="hidden" id="school_name" value="{{$school['school']}}" />
			                    </div>
			                </div>
                            @endif
	                        <div class="profile-info-row" id="div_class" style="display:none;">
	                            <div class="profile-info-name"> Class Name </div>
                                <div class="profile-info-value">
	                                 <select class="form-control" id="class_school_id"  style="color:#333333;font-weight:bold;font-size:13px;">
	                                </select> 
                                </div>
	                        </div>
							<div class="profile-info-row" id="div_student" style="display:none;">
	                            <div class="profile-info-name"> Student Name </div>
                                <div class="profile-info-value">
	                                 <select class="form-control" id="student_id"  style="color:#333333;font-weight:bold;font-size:13px;">
	                                </select> 
                                </div>
	                        </div>
                            <div class="profile-info-row" id="div_month" style="display:none;">
                                <div class="profile-info-name">Month</div>
                                <div class="profile-info-value">
                                    <div class="input-group input-group-addon" style="background-color: white;border:none;text-align: left;padding:0px;">
                                        <input class="form-control" id="var_month" placeholder="--Select Month--" type="text" style='padding:13px 20px'>
                                         
                                    </div>
                                </div>
                            </div>
                            <div class="profile-info-row" id="daily_attendance_date_picker" style="display:none;">
                                <div class="profile-info-name">Daily</div>
                                <div class="profile-info-value">
                                    <div class="input-group">
                                        <input class="form-control date-picker" id="daily_date_picker" type="text" data-date-format="dd MM yyyy" placeholder="Enter Attendance Date" style="color:black;font-weight:bold;font-size:13px;">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
							
							<div class="profile-info-row" id="div_date_from" style="display:none;">
                                <div class="profile-info-name">Date (From)</div>
                                <div class="profile-info-value">
                                   	<div class="input-group">
                                        <input class="form-control date-picker" id="datepicker_date_from" type="text" data-date-format="dd MM yyyy" placeholder="Date From" style="color:black;font-weight:bold;font-size:13px;">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                     <span class="badge badge-danger" id="error_from_date" style="display:none;"></span>
                                </div>
                            </div>
                            <div class="profile-info-row" id="div_date_to" style="display:none;">
                                <div class="profile-info-name">Date (To)</div>
                                <div class="profile-info-value">
                                    <div class="input-group">
                                        <input class="form-control date-picker" id="datepicker_date_to" type="text" data-date-format="dd MM yyyy" placeholder="Date To" style="color:black;font-weight:bold;font-size:13px;">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                             <div class="profile-info-row" id="yearly_attendance_date_picker" style="display:none;">
                                <div class="profile-info-name">Year</div>
                                <div class="profile-info-value">
                                    <div class="input-group">
                                        <input class="form-control date-picker" id="yearly_date_picker" type="text" data-date-format="d MM yyyy" placeholder="Enter Attendance Date" style="color:black;font-weight:bold;font-size:13px;">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
								
		                    <div class="profile-info-row" id="div_show_attendance" style="display:none;">
		                        <div class="profile-info-name" style="background-color: white;"> &nbsp;&nbsp;&nbsp;</div>
		                        <div class="profile-info-value">
		                            <span class="editable editable-click">
		                                <button id="show_attendance" class="btn bt
		                                n-xl btn-info" style="float:right;">Show Attendance</button>
		                            </span>
		                        </div>
						    </div>   
	                    </div>   
		            </div>
                    <div class="col-sm-2"></div>
                    @else
                    <div class="alert alert-block alert-danger">
		                <button type="button" class="close" data-dismiss="alert">
		                    <i class="ace-icon fa fa-times"></i>
		                </button>
		                <b>No Schools Were Found!...</b>
		            </div>
                    @endif
                </div>
            </div>
			<div class="space-30"></div>
			<div class="row" id="show_attendance_information" >

			</div>
		</div>
	</div>
</div>

<div class="space-20"></div>

<div id="modal-table" class="modal fade" tabindex="-1">
	<div class="modal-dialog" style="top: 30%;right: 0;">
		<div class="modal-content" style="border: 2px solid blue;">
			<div class="modal-header no-padding">
				<div class="table-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<span class="white">&times;</span>
					</button>
					<span id="holiday_title_model" style="font-weight: bolder; font-size: 18px;"></span>
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


		/*Month Picker CSS Setting*/
        $(".monthpicker").html('<span class="placeholder" style="color: rgb(51, 51, 51); font-weight: bold; padding: 10px;">--Select Month--</span>');

	               $('#var_month').Monthpicker({
						format: 'mm/yyyy',
						minYear: null,
						maxYear: null,
						minValue: null,
						maxValue: null,
						monthLabels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
					    onSelect: function() { return; },
					    onClose: function() { return; }
					});
	    			//Adding CSS in Month Picker
	    			$('.monthpicker').css('border','1px solid #e4e6e9');
	    			$('.monthpicker').css('font-size','15px;');
	    			$('div.monthpicker_input').removeAttr('style');
	    			$('div.monthpicker_input').css({'background-color':'#fff','color':'#333333','font-weight':'bold','height':'34px'});
	    			$('div.monthpicker_input').addClass('form-control');
	                $('.monthpicker_selector').css({'width':'100%','background-color':'#fff'});
	                $('.monthpicker_selector table').css({'color':'black','height':'150px','font-size':'12px','font-weight':'bold'});
	                $('.yearValue').css({'color':'black','font-size':'22px','margin-top':'15px'});
	                $('.yearSwitch').addClass('btn btn-primary');
	                $(".placeholder").css({'color':'#333333','font-weight':'bold','font-size':'13px;','padding':'10px'});


/*Month Picker CSS Setting*/


		/*Attendance Table & Button*/		
		$('.myAttendanceTable').css('margin-bottom','-5px');
        $('.myAttendanceTable').css('margin-top','-5px');
		/*Attendance Table & Button*/

		//YEAR PICKER HERE SETUP
	            	$('#yearly_date_picker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy',
			    	viewMode: "years", 
			    	minViewMode: "years",
			        autoClose:true
                })
                //show datepicker when clicking on the icon
                .next().on(ace.click_event, function() {
                    $(this).prev().focus();

                });


		/*Report Type SelectBx*/
        $(document).on("change","#report_type_id",function(){

        	var report_type_id = $("#report_type_id").val();

        	$("#show_attendance_information").html('');

	        	$("#div_date_from").hide();
				$("#div_date_to").hide();
				$("#datepicker_date_from").val('');
				$("#datepicker_date_to").val('');
				$(".monthpicker_input").html('--Select Month--');
				$("#yearly_attendance_date_picker").hide();
				$("#yearly_date_picker").val('');
				$("#div_student").hide();
				$("#student_id").val('');

        	if(report_type_id == '')
        	{
        		$('#div_school').hide();
        		$("#div_class").hide();
        		$("#daily_attendance_date_picker").hide();
        		$("#daily_date_picker").val('');
        		$("#div_month").hide();
	            $("#div_show_attendance").hide();
	            $('#alert_no_school_classes').hide();   
	            $("#alert_no_school_is_selected").hide();
	            $("#show_attendance_information").hide();
	            $("#alert_no_class_is_selected").hide();
	            $('#alert_no_report_type_is_selected').show();
	        }
        	else
        	{
        		$("#div_class").hide();
        		$("#daily_attendance_date_picker").hide();
        		$("#div_month").hide();
	            $("#div_show_attendance").hide();
	            $('#alert_no_school_classes').hide();   
	            $("#alert_no_school_is_selected").hide();
	            $("#alert_no_class_is_selected").hide();
        		$('#alert_no_report_type_is_selected').hide();
        		$('#div_school').show();
        	}


        	 $("#schools").val('');
        });
        /*Report Type SelectBx*/


       /*Schools SelectBx*/
		$(document).on("change","#schools",function(){

			var report_type_id = $("#report_type_id").val();
			var school_id = $('#schools').val();
			school_name = $("#schools option[value='"+$("#schools").val()+"']").text();
			$("#error_from_date").html('').hide();

			$("#alert_no_class_is_selected").hide();
			$("#show_attendance_information").html('');
			$(".monthpicker_input").html('--Select Month--');
			$("#yearly_attendance_date_picker").hide();
			$("#yearly_date_picker").val('');
			$("#div_student").hide();
			$("#student_id").val('');


			$("#div_show_attendance").hide();

			//individaul rang date
				$("#div_date_from").hide();
				$("#div_date_to").hide();
				$("#datepicker_date_from").val('');
				$("#datepicker_date_to").val('');

			if(school_id == '')
			{
        		$("#div_class").hide();
        		$("#daily_attendance_date_picker").hide();
        		$("#div_month").hide();
	            $("#div_show_attendance").hide();
	            $("#alert_no_class_is_selected").hide();
	            $('#alert_no_report_type_is_selected').hide();
	            $('#alert_no_school_classes').hide();   
	            $("#alert_no_school_is_selected").show();
				
				
				$("#error_from_date").html('').hide();
				
			}
			else
			{
                $("#alert_no_school_is_selected").hide();
				
                
                
				if(report_type_id == '')
				{
					$('#alert_no_report_type_is_selected').show();
					$('#div_school').hide();
				}
				else if (report_type_id == 1 || report_type_id == 2 || report_type_id == 3 || report_type_id == 4 || report_type_id == 5 || report_type_id == 6 || report_type_id == 8)
				{
					$.ajax({
		                url:'get_classes_by_school_id_for_reporting',
		                type:'post',
		                data: {
		                     _token: '{{csrf_token()}}',
		                     school_id:school_id,
		                },
		                success: function(data){
		                    if(data == 'no classes')
		                    {
		                        $("#no_school_classes_message").html("<b>"+school_name+" Has No Classes!...</b>");
		                        $('#alert_no_school_classes').show();   
		                        $("#div_class").hide();
				        		$("#daily_attendance_date_picker").hide();
				        		$("#div_month").hide();
					            $("#div_show_attendance").hide();
					            $("#alert_no_school_is_selected").hide();
					            $("#alert_no_class_is_selected").hide();
				        		$('#alert_no_report_type_is_selected').hide();
		                    }
		                    else
		                    {
				        		$("#daily_attendance_date_picker").hide();
				        		$("#div_month").hide();
					            $("#div_show_attendance").hide();
					            $('#alert_no_school_classes').hide();   
					            $("#alert_no_school_is_selected").hide();
					            $("#alert_no_class_is_selected").hide();
				        		$('#alert_no_report_type_is_selected').hide();
		                        $("#div_class").show();
		                        $("#class_school_id").html(data);
		                    }   
		                }
		            });
				}
                 else if(report_type_id==7)
                {
                        $("#datepicker_date_from").val('');
                        $("#datepicker_date_to").val('');
            
                        $("#div_date_from").show();
                        $("#div_date_to").show();
                }
            }
		});        
		/*Schools SelectBx*/

		/*Classes SelectBx*/
        $(document).on("change","#class_school_id",function(){

        	var report_type_id = $("#report_type_id").val();
        	$('#alert_no_school_classes').hide();
            $("#no_school_classes_message").html("");
            $("#error_from_date").html('').hide();
            $("#show_attendance_information").html('');
            $("#daily_attendance_date_picker").hide();
            $("#daily_date_picker").val('');
            $("#div_student").hide();
			$("#student_id").val('');


        	if($('#class_school_id').val() == '')
        	{
        		
        		$("#div_month").hide();
        		
        		$("#alert_no_class_is_selected").show();
        		$("#show_attendance_information").hide();
        		$("#daily_attendance_date_picker").hide();
        		$("#daily_date_picker").val('');
        		$("#show_attendance").hide();
        		$(".monthpicker_input").html('--Select Month--');
        		$("#yearly_attendance_date_picker").hide();
				$("#yearly_date_picker").val('');


				
				//individaul rang date
				$("#div_date_from").hide();
				$("#div_date_to").hide();
				$("#datepicker_date_from").val('');
				$("#datepicker_date_to").val('');
        			
        	}
        	else if($('#class_school_id').val() != '')
        	{
        		$("#show_attendance").show();
        		$("#alert_no_class_is_selected").hide();
        		if(report_type_id == 1)
            	{
 
			        $(document).on("click","#daily_date_picker",function(){
			        	disable_weekend_in_calender($("#school_weekend").val());	
			        });

					$('.date-picker').datepicker({
						autoclose: true,
						todayHighlight: true,
					});

	                $("#daily_attendance_date_picker").show();
	                $("#div_show_attendance").show();
	                $("#div_month").hide();
	            }
	            else if(report_type_id == 2 || report_type_id == 3)
	            {
	                $("#div_month").show();
	                $("#div_show_attendance").show();
	                $(".monthpicker + .monthpicker_input ").remove();
        			$("#daily_attendance_date_picker").hide();
	            	$('#alert_no_school_classes').hide();   
	            	$("#alert_no_school_is_selected").hide();
	            	$("#alert_no_class_is_selected").hide();
        			$('#alert_no_report_type_is_selected').hide();
        			$('#div_school').show();
					$("#div_date_from").hide();
					$("#div_date_to").hide();
	            }
	            else if(report_type_id == 4)
	            {
	            	//YEAR PICKER HERE SETUP
	            	 $("#yearly_attendance_date_picker").show();
	                $("#div_show_attendance").show();
	            	
	            }
	            else if(report_type_id == 5 || report_type_id == 6 || report_type_id == 7)
	            {
	            	//DATE RANGE PICKERS HERE SETUP
					$("#daily_attendance_date_picker").hide();
	            	$("#div_month").hide();
	            	$('#div_date_from').show();
	            	$('#div_date_to').show();
                	//$("#div_show_attendance").show();
	            }
	            else if(report_type_id == 8)
	            {
					var class_id = $("#class_school_id option:selected").attr('class_id');
	            	var class_name = $("#class_school_id option:selected").text();
	            	var school_id = $('#schools').val();
	            	$.ajax({
		                url:'get_students_by_school_id_and_class_id',
		                type:'post',
		                data: {
		                     _token: '{{csrf_token()}}',
		                     school_id:school_id,
		                     class_id:class_id
		                },
		                success: function(data){
		                    if(data.message == 'noStudents')
		                    {
		                        $("#no_school_classes_message2").html("<b>"+class_name+" Has No Students!...</b>");
		                        $('#alert_no_school_classes2').show();   
		                    }
		                    else
		                    {
		                        $("#div_student").show();
		                        $("#student_id").html(data);
		                    }   
		                }
		            });
					
					$("#div_month").hide();
                	$("#div_show_attendance").hide();	                
	            }
	            else
	            {
	            	$("#div_month").hide();
                	$("#div_show_attendance").hide();	                
	            }
        	}
        });
        /*Classes SelectBx*/

        /* Daily Date Picker*/
		$(document).on('change','#daily_date_picker',function(){

			$("#show_attendance").show();
		});
		/*Daily Date Picker*/
		
		/*Student Dropdown For Student Report*/
		$(document).on('change','#student_id',function(){

        	if($('#student_id').val() != '')
        	{
    			//DATE RANGE PICKERS HERE SETUP
            	$("#daily_attendance_date_picker").hide();
            	$("#div_month").hide();
            	$('#div_date_from').show();
            	$('#div_date_to').show();
            	//$("#div_show_attendance").show();
        	}
        	else
        	{
        		$('#no_school_classes_message').html("<b>Please Select Student Name!...</b>");
			    $('#alert_no_school_classes').show();
				$('#div_date_from').hide();
            	$('#div_date_to').hide();
            	$("#div_show_attendance").hide();
        	}
        });
		/*Student Dropdown For Student Report*/
		
		

		/*Show Attendance Button*/
		$(document).on('click','#show_attendance',function(){

			var school_name = $("#schools option[value='"+$("#schools").val()+"']").text();
			var class_name = $("#class_school_id option[value='"+$("#class_school_id").val()+"']").text();
			var school_id = $('#schools').val();
			var class_school_id = $('#class_school_id').val();
			var class_id = $("#class_school_id option:selected").attr('class_id');
			var month = $("#var_month").val();
			var month_name = $(".monthpicker_input").text();
			var report_type_id = $("#report_type_id").val();
			var date_from = $('#datepicker_date_from').val();
			var date_to = $('#datepicker_date_to').val();
			var student_id = $('#student_id').val();
			 
			 /* Daily Report  */
            if($("#report_type_id").val() == 1)
            {

                var daily_date = $('#daily_date_picker').val();
                
                $.ajax({
                url:'get_daily_attendance_for_reporting',
                type:'post',
                data: {
                     _token: '{{csrf_token()}}',
                     school_id:school_id,
                     school_name:school_name,
                     class_school_id:class_school_id,
                     class_id:class_id,
                     class_name:class_name,
                     daily_date:daily_date,
                },
                success: function(data)
                	{
                        /*If Holiday Date Exists*/
                        if(data.message == 'holiday_school_exists')
                        {
                            $('#alert_no_school_classes').show();
                            $("#no_school_classes_message").html("<b>"+data.daily_attendance_date+" Has Been Assigned To Holiday ("+data.holiday_title+"</b> ["+data.holiday_description+"] <b>)</b>");
                            $("#show_attendance_information").hide();
                        }
                        /*If Weekend Day Exists*/
                        else if(data.message == 'weekend_day_exist')
                        {
                            $('#alert_no_school_classes').show();
                            $("#no_school_classes_message").html("<b> "+data.weekend_day_name+" That Is School Weekend Off Day!...</b>");
                            $("#show_attendance_information").hide();
                        }
                                /*If Attendance Not Taken*/
                        else if(data.message == 'attendance_not_exist')
                        {
                            $('#alert_no_school_classes').show();
                            $("#no_school_classes_message").html("<b> Attendance For "+data.daily_attendance_date+" Has Not Been Taken !...</b>");
                            $("#show_attendance_information").hide();
                        }
                        else
                        {
                            $("#show_attendance_information").html(data);
                            $("#show_attendance_information").show();
                            $('#alert_no_school_classes').hide();  
                        }
                       
                	}
            		});  
            }
                    /*End Daily Report*/
            else if(report_type_id == 2)
            {

            	var get_month = $("#var_month").val();

                	
				if(get_month != ""){
					 					
						$('#error_message_select_month').hide();
		 			
	 				 	$.ajax({
					        url:"monthly_individual_function",
					        type:"POST",
					        data:{_token: '{{csrf_token()}}',
					        class_school_id:class_school_id,
					        month_year:get_month,
					        school_id:school_id,
		                    school_name:school_name,
		                    class_id:class_id,
		                    class_name:class_name,
					    },
					        success:function(ResponseText){
					        
					        	//this condition for check attendacne taken in this month year
					        	if(ResponseText.message == 'fail'){
					        		
					        		$("#alert_no_school_classes").show();
					        		$("#no_school_classes_message").html("<b> Attendance For "+month_name+" Has Not Been Taken!...</b>");
					        		$("#no_school_classes_message").show();
					        		$('#show_attendance_information').html("");

					        	}else{
					        		$('#show_attendance_information').html(ResponseText);
					        		$('#show_attendance_information').show();
					        		$("#alert_no_school_classes").hide();
					        		
					        	}
					        }   
			    		}); 


		 			}else{

		 				$('#error_message_select_month').show();
		 				
		 			}


				//$("#show_attendance_information").show();	
            }
            else if(report_type_id == 3)
            {
				
				
            	$.ajax({
		            url:'generate_monthly_combine_report',
		            type:"POST",
		            data:{
		                _token:'{{csrf_token()}}',
		                school_id:school_id,
		                class_school_id:class_school_id,
		                class_id:class_id,
		                month:month,
		                school_name:school_name,
		                class_name:class_name,
		                month_name:month_name,
		                },
		            success:function(data){
			            if(data.message == "fail")
			            {
			            	$('#no_school_classes_message').html("<b>Attendance For "+month_name+" Has Not Been Taken!...</b>").show();
			            	$('#alert_no_school_classes').show();
							$("#show_attendance_information").hide();
			        		$("#daily_attendance_date_picker").hide();
				            $("#alert_no_school_is_selected").hide();
				            $("#alert_no_class_is_selected").hide();
			        		$('#alert_no_report_type_is_selected').hide();
			            }
			            else
			            {
			            	$("#daily_attendance_date_picker").hide();
				            $('#alert_no_school_classes').hide();   
				            $("#alert_no_school_is_selected").hide();
				            $("#alert_no_class_is_selected").hide();
			        		$('#alert_no_report_type_is_selected').hide();
			            	$('#show_attendance_information').html(data);
			            	$('#show_attendance_information').show();
			            }
	        		}             
		   		 });
            }
            else if(report_type_id == 4)
            {

            		var yearly_date = $('#yearly_date_picker').val();
            		
            	$.ajax({
            		url:'get_yearly_attendance_report',
            		type:'POST',
            		data:{
            			 _token:'{{csrf_token()}}',
            			yearly_date:yearly_date,
        				school_id:school_id,
		   				class_school_id:class_school_id,
		                class_id:class_id,
		                school_name:school_name,
		                class_name:class_name,
		            },
		    		success:function(data){
		    			if(data.message == 'fail')
		    			{
		    				$('#alert_no_school_classes').show();
		    				$('#no_school_classes_message').html("<b>Attendance For "+data.year+" Has Not Been Taken!...</b>");
			            	$('#show_attendance_information').html('');
			            	$('#show_attendance_information').hide();
		    			}
		    			else
		    			{
		    				$("#alert_no_school_classes").hide();
		    				$("#no_school_classes_message").html('');
		    				$('#show_attendance_information').html(data);
			            	$('#show_attendance_information').show();
		    			}
		    				
		    		}
            		
            	});
            	
            }
            else if(report_type_id == 5)
            {
					
				if(Date.parse(date_from) > Date.parse(date_to))
				{
                    $("#error_from_date").html("From Date Must Less Than To Date!...").show();
				}
				else
				{
                
					
              	 	$.ajax({
					        url:"generate_individual_attendance_report_by_class_school_id_date_range",
					        type:"POST",
					        data:{_token: '{{csrf_token()}}',
                            class_school_id:class_school_id,
                            school_name:school_name,
                            date_from:date_from,
                            date_to:date_to,      
                                 
                            },
					        success:function(data){
								if(data.message == "fail")
								{
									$('#no_school_classes_message').html("<b>Attendance From "+date_from+" To "+date_to+" Has Not Been Taken!...</b>");
									$('#alert_no_school_classes').show();
									$("#show_attendance_information").hide();
									$("#daily_attendance_date_picker").hide();
									$("#alert_no_school_is_selected").hide();
									$("#alert_no_class_is_selected").hide();
									$('#alert_no_report_type_is_selected').hide();
								}
								else
								{
									$("#daily_attendance_date_picker").hide();
									$('#alert_no_school_classes').hide();   
									$("#alert_no_school_is_selected").hide();
									$("#alert_no_class_is_selected").hide();
									$('#alert_no_report_type_is_selected').hide();
									$('#show_attendance_information').html(data);
									$('#show_attendance_information').show();
								} 	
					        	
					        }   
			    		}); 
						
				}
            	
            }
            else if(report_type_id == 6)
            {
            	if(Date.parse(date_from) > Date.parse(date_to))
            	{
                    $("#error_from_date").html("Date(From) Must Be Less Than From Date(To)!...").show();
            	}
            	else
            	{
            		$.ajax({
			            url:'show_date_range_combine_report',
			            type:"POST",
			            data:{
			                _token:'{{csrf_token()}}',
			                school_id:school_id,
			                class_school_id:class_school_id,
			                class_id:class_id,
			                date_from:date_from,
			                date_to:date_to,
			                school_name:school_name,
			                class_name:class_name,
			                },
			            success:function(data){
				            if(data.message == "fail")
				            {
				            	$('#no_school_classes_message').html("<b>Attendance From "+date_from+" To "+date_to+" Has Not Been Taken!...</b>");
				            	$('#alert_no_school_classes').show();
								
				            }
				            else
				            {
				            	$("#daily_attendance_date_picker").hide();
					            $('#alert_no_school_classes').hide();   
					            $("#alert_no_school_is_selected").hide();
					            $("#alert_no_class_is_selected").hide();
				        		$('#alert_no_report_type_is_selected').hide();
				            	$('#show_attendance_information').html(data);
				            	$('#show_attendance_information').show();
				            }
		        		}             
			   		});
            	}
            }
            else if(report_type_id == 7)
            {
  				$("#alert_no_school_is_selected").hide();
            	
				if(Date.parse(date_from) > Date.parse(date_to))
				{
						$("#error_from_date").html("Date(From) Must Be Less Than From Date(To)!...").show();
				}
				else
				{
              	 	$.ajax({
						url:"/super_admin/generate_average_attendance_report_by_school_id_date_range",
						type:"POST",
						data:{_token: '{{csrf_token()}}',
						school_id:school_id,
						school_name:school_name,
						from_date:date_from,
						to_date:date_to,      
							 
						},
						success:function(data){
						   if(data.message=='fail')
							{
								$("#show_attendance_information").html("");
								$("#alert_no_school_classes").show();
								$("#no_school_classes_message").html("<b>Attendance From "+data.date_from+" To: "+data.date_to+" Has Not Been Taken!...</b>");
								
							}
							else
							{
								$("#show_attendance_information").html(data);
								$("#alert_no_school_classes").hide();
								$("#no_school_classes_message").html("");
							}
						}   
					}); 
				}                
            }
            else if(report_type_id == 8)
            {
            	if(Date.parse(date_from) > Date.parse(date_to))
            	{
                    $("#error_from_date").html("Date(From) Must Be Less Than From Date(To)!...").show();
            	}
            	else
            	{
            		$.ajax({
			            url:'show_date_range_student_report',
			            type:"POST",
			            data:{
			                _token:'{{csrf_token()}}',
			                school_id:school_id,
			                class_school_id:class_school_id,
			                class_id:class_id,
			                date_from:date_from,
			                date_to:date_to,
			                student_id:student_id,
			                school_name:school_name,
			                class_name:class_name,
			                },
			            success:function(data){
				            if(data.message == "fail")
				            {
				            	$('#no_school_classes_message').html("<br>Attendance From "+date_from+" To "+date_to+" Has Not Been Taken!...</br>");
				            	$('#alert_no_school_classes').show();
				            }
				            else
				            {
				            	$('#show_attendance_information').html(data);
				            	$('#show_attendance_information').show();
				            }
		        		}             
			   		});
            	}
            }
            else
            {
            	
            }
		});
		/*Show Attendance Button*/
	
		/*School Holiday Title Click*/
		$(document).on('click','#leave_popover',function(){
			$('#modal-table').modal('show');
			$('#holiday_title_model').html($(this).attr('holiday_title'));
			$('#holiday_description_model').html($(this).attr('holiday_description'));
		});
		/*School Holiday Title Click*/
    
   		/*Disbale Weekend Date In Calender*/        
        function disable_weekend_in_calender(weekend)
        {
          	switch (weekend.toLowerCase()) 
          	{
            	case 'sunday':
                	$(".datepicker-days table tbody tr td:nth-child(1)" ).css({"background-color":"red","cursor":"not-allowed","border-bottom":"1px solid white"});
                    break;        
                case 'monday':
                    $(".datepicker-days table tbody tr td:nth-child(2)" ).css({"background-color":"red","cursor":"not-allowed","border-bottom":"1px solid white"});
                    break;
                case 'tuesday':
                    $(".datepicker-days table tbody tr td:nth-child(3)" ).css({"background-color":"red","cursor":"not-allowed","border-bottom":"1px solid white"});
                    break;
                case 'wedensday':
                    $(".datepicker-days table tbody tr td:nth-child(4)" ).css({"background-color":"red","cursor":"not-allowed","border-bottom":"1px solid white"});
                    break;
                case 'thursday':
                    $(".datepicker-days table tbody tr td:nth-child(5)" ).css({"background-color":"red","cursor":"not-allowed","border-bottom":"1px solid white"});
                    break;
                case 'friday':
                    $(".datepicker-days table tbody tr td:nth-child(6)" ).css({"background-color":"red","cursor":"not-allowed","border-bottom":"1px solid white"});
                    break;       
                case 'saturday':
                    $(".datepicker-days table tbody tr td:nth-child(7)" ).css({"background-color":"red","cursor":"not-allowed","border-bottom":"1px solid white"});
                    break;
          	}
        }
         /*Disbale Weekend Date In Calender*/        

        
        
        
           /*From*/
        
        $("#datepicker_date_to").change(function(){
           
            if($(this).val()=='')
            {
                $("#div_show_attendance").hide();
            }
            else if($(this).val()!='')
            {
             $("#div_show_attendance").show(); 
                
            }

        });
        
        
        
        /*To*/
          $("#datepicker_date_from").change(function(){
           
              $("#error_from_date").html("").hide();

        });
        

        
        $(document).on("click","#show-picture",function(){
            
           alert("OK"); 
        });
        
        
        
     });


</script>
@endsection

