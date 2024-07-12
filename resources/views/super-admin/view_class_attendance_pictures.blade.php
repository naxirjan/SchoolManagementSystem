@extends('master/master')

@section('title')
View Class Attendance Pictures
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
					<li class="active">View Class Attendance Pictures</li>
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
						</div>
						<!-- /.pull-left -->
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
                        View Class Atttendance Pictures
                    </h1>
                </div>
				<div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                         <div class="alert alert-block" id="alert-messages" style="display:none;">
                        <span id="message"></span>
                        </div>
                        <div class="tabbable">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a data-toggle="tab" href="#tab-1" aria-expanded="true">
                                        <i class="menu-icon fa fa-info-circle bigger-150"></i>
                                        <b>&nbsp;Class Attendance Pictures For</b>
                                    </a>
                                </li>
                            </ul>
                            <input type="hidden" id="week_end_name" value="{{$week_end_name}}"/>
                            <div class="tab-content profile-edit-tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> School Name </div>
                                            <div class="profile-info-value">
                                              <select class="form-control" id="all_schools" style="color:#333333;font-weight:bold;font-size:13px;">
                                                    <option value="">--Select School--</option>
                                                    <option value="1">House Of Knowledge (HOK-01)</option>
                                                    <option value="2">House Of Knowledge (HOK-02)</option>
                                                    <option value="3">House Of Knowledge (HOK-03)</option>
                                                    <option value="4">House Of Knowledge (HOK-04)</option>
                                                    <option value="5">House Of Knowledge (HOK-05)</option>
                                                </select>   
                                            </div>
                                        </div>
                                        
                                        <div class="profile-info-row" id="get_all_classes">
                                            
                                        </div>
                                         <div class="profile-info-row" id="div_month" style="display:none;">
                                            <div class="profile-info-name">Month</div>
                                            <div class="profile-info-value">
                                                <div class="input-group input-group-addon" style="background-color: white;border:none;text-align: left;padding:0px;">
                                                    <input class="form-control" id="month" placeholder="--Select Month--" type="text" style='padding:13px 20px'>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="profile-info-row" id="div_btn_submit" style="display:none;">
                                            <div class="profile-info-name" style="background-color:white;border-bottom:1px solid #DCEBF7;border-left:1px solid #DCEBF7;"> &nbsp;&nbsp;&nbsp;</div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">
                                                    <button class="pull-right btn btn-xl btn-info" id="btn-attendance-show">
                                                        Take Attendance
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>         
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div id="get_class_attendance_pictures"></div>
                    </div>
                     <div class="col-md-2"></div>
                </div>    
                <div class="space-30"></div>
            </div>
        </div>
    </div>
    <script> 
        
        
        $(document).ready(function() {    
          
            
        /*Month Picker CSS Setting*/
        $(".monthpicker").html('<span class="placeholder" style="color: rgb(51, 51, 51); font-weight: bold; padding: 10px;">--Select Month--</span>');

        $('#month').Monthpicker({
            format: 'mm-yyyy',
            minYear: null,
            maxYear: null,
            minValue: null,
            maxValue: null,
            monthLabels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            onSelect: function() { $("#div_btn_submit").show(); },
            onClose: function() { return; }
        });
        //Month Picker CSS
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
        /*Month Picker CSS */    
            
            
        /*Disbale Weekend Date In Calender*/        
        function disable_weekend_in_calender(weekend)
        {
          switch (weekend.toLowerCase()) {
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
        
        /*Get School Classes By School ID*/
        $("#all_schools").change(function(){  
               
               
                $("#attendance_date_from").val('');
                $("#attendance_date_to").val('');
                $("#alert-messages").hide();
                $("#message").html("");
               
                $("#div_attendance_date_from").hide();
                $("#div_attendance_date_to").hide();
                if($(this).val() == "")
                {
                    $('#get_all_classes').html("");
                    $("#div_btn_submit").hide();
                }
                else{
                    $.ajax({
                    url:"get_school_classes_to_take_attendance",
                    type:"POST",
                    data:{_token: '{{csrf_token()}}',
                          school_id:$(this).val()},
                    success:function(data){
                        if(data=='no classes')
                        {
                            $("#alert-messages").removeClass("alert-success").addClass("alert-danger").show();
                            $("#message").html('<b>'+$("#all_schools option:selected").text()+' Has No Classes !...</b>');
                        }
                        else
                        {
                          $('#get_all_classes').html('<div class="profile-info-name"> Class Name </div><div class="profile-info-value"><select class="form-control" id="classes" style="color:#333333;font-weight:bold;font-size:13px;">'+data+'</select></div>');  
                        }
                    }   
                }); 
                }


            });
            
        /*Show/Hide Attendance DatePicker*/
        $(document).on('change',"#classes",function(){
            $("#div_month").val('');
            $("#div_month").hide();
            $("#div_btn_submit").hide();
            $("#get_class_attendance_pictures").html('');
            $(".monthpicker_input").html("--Select Month--");
            if($(this).val()=='')
            {
                $("#alert-messages").removeClass("alert-success").addClass("alert-danger").show();
                $("#message").html("<b>Please Select Any Class</b>");
            }
            else
            {
                $("#alert-messages").hide();
                $("#message").html("");
                $("#div_month").show();
            }   
        });
       
        /*btn Show Attendance Pictures*/
        $("#btn-attendance-show").click(function(){
                
                
            var school_name = $("#all_schools option[value='"+$("#all_schools").val()+"']").text();
			var class_name = $("#classes option[value='"+$("#classes").val()+"']").text();
			var school_id = $('#all_schools').val();
            var class_id = $("#classes option:selected").attr('class_id');
			var class_school_id = $("#classes").val();
			var month = $('#month').val();
            
          	     /*Check If No School Selected*/
                if ($("#all_schools").val() == '') {
                    $("#alert-messages").addClass("alert-danger").show();
                    $("#message").html("<b>Please Select Any School!...</b>");
                }
                /*Check If No Class Selected*/
                else if ($("#classes").val() == '') {
                    $("#alert-messages").addClass("alert-danger").show();
                    $("#message").html("<b>Please Select Any Class!...</b>");
                }
                /*Check If No Month Selected*/
                else if ($("#month").val() =='') {
                    $("#alert-messages").addClass("alert-danger").show();
                    $("#message").html("<b>Please Select Any Month!...</b>");
                }
                
                /*Check If Validation Is Correct*/
                else{
                    $("#alert-messages").hide();
                    $("#get_class_attendance_pictures").html("");
                    
                    /*jQuery Ajax*/
                    $.ajax({
			            url:'view_class_attendance_pictures_by_date_range',
			            type:"POST",
			            data:{
			                _token:'{{csrf_token()}}',
			                school_id:school_id,
			                class_id:class_id,
                            class_school_id:class_school_id,
			                month:month,
                            school_name:school_name,
			                class_name:class_name,
			                },
			            success:function(data)
                        {
                            $("#get_class_attendance_pictures").html(data);
		        		}             
			   		});
            	   /*jQuery Ajax*/
                }         
            });
              
    });
</script>        
@endsection

