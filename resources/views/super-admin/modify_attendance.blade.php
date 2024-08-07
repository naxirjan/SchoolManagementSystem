@extends('master/master')

@section('title')
Modify Attendance
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
                <li class="active">Modify Attendance</li>
            </ul><!-- /.breadcrumb -->



            <!-- /section:basics/content.searchbox -->
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
                    </div>
                </div>
            </div>
            <!-- /section:settings.box -->
            <div class="page-header">
                <h1>
                    Modify Attendance

                </h1>
            </div>

            <div class="row">
                <div class="col-xs-12">

                  
                   
                    <div class="alert alert-block" id="alert-messages" style="display:none;">
                        <button type="button" class="close">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <span id="message"></span>
                    </div>

                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <div class="tabbable">
                            <ul class="nav nav-tabs padding-16">
                                <li class="active">
                                    <a data-toggle="tab" href="#tab-1" aria-expanded="true">
                                        <i class="menu-icon fa fa-info-circle bigger-150"></i>
                                        <b>&nbsp;Attendance Of</b>
                                    </a>
                                </li>
                            </ul>
                           
                            <input type="hidden" id="week_end_name" value="{{$week_end_name}}"/>
                            <input type="hidden" id="role_user_id" value="{{$role_user_id}}" />
                            <div class="tab-content profile-edit-tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> School Name </div>
                                            <div class="profile-info-value">
                                              <select class="form-control" id="all_schools" style="color:#333333;font-weight:bold;font-size:13px;">
                                                    <option value="">--Select School--</option>
                                                    @foreach($schools as $school)
                                                    <option value="{{$school['id']}}">{{$school['school']}}</option>
                                                    @endforeach
                                                </select>   
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="profile-info-row" id="get_all_classes">
                                            
                                        </div>

                                            <div class="profile-info-row" id="div_attendance_date" style="display:none;">
                                            <div class="profile-info-name">
                                                Attendance Date
                                            </div>

                                            <div class="profile-info-value">
                                                <div class="input-group">
                                                    <input class="form-control date-picker" id="attendance_date" type="text" data-date-format="dd MM yyyy" placeholder="Enter attendance date" style="color:black;font-weight:bold;font-size:13px;">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar bigger-110"></i>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="profile-info-row" id="div_btn_submit" style="display:none;">
                                            <div class="profile-info-name" style="background-color:white;border-bottom:1px solid #DCEBF7;border-left:1px solid #DCEBF7;"> &nbsp;&nbsp;&nbsp;</div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">
                                                    <button class="pull-right btn btn-xl btn-info" id="btn-get-attendance">
                                                        Show Attendance
                                                    </button>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        
                            
                           
                        
                        </div>
                    </div>    
                    <div class="col-sm-2"></div>
                </div>
                   
                
            </div>
                <br />
                <div class="row" id="get_students_for_attendance"></div>
                <br />
                <div class="row" id="get_un_submitted_students_attendance">
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="space-30"></div>



    <script>
        

        $(document).ready(function() {

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
        
            
            var id = new Array();
            var image = new Array();
            var full_name = new Array();
            var gender = new Array();
            var status = new Array();
           
            var student_attendance_ids    = new Array();
            var student_attendance_status = new Array();
            
            
             /*Get School Classes By School ID*/
           $("#all_schools").change(function(){  
               
               
                $("#attendance_date").val('');
                $("#alert-messages").hide();
                $("#message").html("");
               $("#get_students_for_attendance").html("");
               $("#get_un_submitted_students_attendance").html("");
               
                $("#div_attendance_date").hide();
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
                            $("#message").html(data);
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
               
            $("#get_students_for_attendance").html("");   
            $("#attendance_date").val('');
               
            if($(this).val()=='')
            {
                $("#div_attendance_date").hide();
                $("#div_btn_submit").hide();
                $("#alert-messages").removeClass("alert-success").addClass("alert-danger").show();
                $("#message").html("<b>Please Select Any Class</b>");
            }
            else
            {
                
                $("#alert-messages").hide();
                $("#message").html("");
                $("#div_attendance_date").show();   
            }   
               
            
           });
                   
            /*Show/Hide Submit Button*/
            $(document).on("change","#attendance_date",function(){
                $("#div_btn_submit").show();
            });
            
            
            /*Disable All Sundays & Check Official Holiday With Selected Date*/
            $("#attendance_date").click(function(){
                disable_weekend_in_calender($("#week_end_name").val());        
            });
            
            
            /*Disable All Sundays & Check Official Holiday With Selected Date*/
            $("#attendance_date").click(function(){
                disable_weekend_in_calender($("#week_end_name").val());                
            });
            
            
            /*Disable All Sundays On DatePicker Previous/Next Button Click*/
            $(document).on("click","th.next,th.prev",function(){
            disable_weekend_in_calender($("#week_end_name").val());
            });
            
           
            
            /*Check Current Date Attendance*/
            $("#btn-get-attendance").click(function() {

                
                /*Check If No Class & Date Are Seleced*/
                if ($("#attendance_date").val() == '' && $("#classes").val() == '') {
                    $("#alert-messages").addClass("alert-danger").show();
                    $("#message").html("<b>Please Select Class And Attendance Date!...</b>");
                }
                /*Check If No Class Selected*/
                else if ($("#classes").val() == '') {
                    $("#alert-messages").addClass("alert-danger").show();
                    $("#message").html("<b>Please Select Any Class!...</b>");
                }
                /*Check If No Date Selected*/
                else if ($("#attendance_date").val() == '') {
                    $("#alert-messages").addClass("alert-danger").show();
                    $("#message").html("<b>Please Select Any Date!...</b>");
                } 
                /*Check If Validation Is Correct*/
                else {
                    $("#alert-messages").hide();

                    /*jQuery Ajax*/
                    $.ajax({
                        url: 'check_current_date_attendance',
                        type: "POST",
                        data: {
                            _token: '{{csrf_token()}}',
                            class_school_id: $('#classes').val(),
                            role_user_id: $('#role_user_id').val(),
                            attendance_date: $("#attendance_date").val(),
                            school_id:$("#all_schools").val(),
                            school_name:$("#all_schools").find(":selected").text(),
                            class_name:$("#classes").find(":selected").text(),
                            user_action_name:'modify_attendance',
                        },
                        success: function(data) {
                            
                            /*Check If Selected Date Is Equel To The Date Of School Weekend Day*/
                            if(data.message === 'school_weekend_day')
                            {
                               $("#alert-messages").addClass("alert-danger").show();
                                $("#message").html("<b>" + data.weekend_day + " That Is School Weekend Off Day !...</b>");
                                $("#get_students_for_attendance").html("");
                                $("#get_un_submitted_students_attendance").html(""); 
                            }
                            
                            /*Check If Selected Date Equels Or Exists Between In (Start & End Date) Of School Holiday*/
                            else if (data.message === 'school_holiday_exists') 
                            {
                                $("#alert-messages").addClass("alert-danger").show();
                                $("#message").html("<b>Date: " + data.date + " Has Been Assigned To Holiday ( "+data.holiday_title+"</b> ["+data.holiday_decription+"] <b>)</b> !...");
                                $("#get_students_for_attendance").html("");
                                $("#get_un_submitted_students_attendance").html("");
                            }
                            
                            /*Check If Selected Date Is Greater Than Current Date*/
                            /*OR*/
                            /*Check If Selected Date Is Less Than Attendance Allowed Days(date)*/
                            else if(data.message ==='date_is_not_allowed')
                            {
                                $("#alert-messages").addClass("alert-danger").show();
                                $("#message").html("<b>You Are Not Allowed To Modify Date: " + data.date + " Attendance !...");
                                $("#get_students_for_attendance").html("");
                                $("#get_un_submitted_students_attendance").html("");
                            }
                            
                            /*Check If Current Date Attendance Already Exists*/
                            else if (data.message === 'attendance_already_exists') 
                            {
                                $("#alert-messages").addClass("alert-danger").show();
                                $("#message").html("<b>Attendance Has Already Been Taken For Date: " + data.date + " !...</b>");
                                $("#get_students_for_attendance").html("");
                                $("#get_un_submitted_students_attendance").html("");
                            } 
                           
                           /*Check If Class Schoool Has No Students*/
                            else if(data.message === 'class_school_has_no_students')
                            {
                                $("#alert-messages").addClass("alert-danger").show();
                                $("#message").html("<b>"+data.class_name+" Has No Students !...</b>");
                                $("#get_students_for_attendance").html("");
                                $("#get_un_submitted_students_attendance").html(""); 
                            }
                            
                            else if(data.message === 'attendance_is_not_added')
                            {
                                $("#alert-messages").addClass("alert-danger").show();
                                $("#message").html("<b> Attendance Of "+data.date+" Has Not Been Taken For "+data.class_name+" !...</b>");
                                $("#get_students_for_attendance").html("");
                                $("#get_un_submitted_students_attendance").html("");   
                            }
                            
                            /*Check If Current Date Attendance Not Already Exists*/
                            else if (data !== 'attendance_already_exists') 
                            {
                                $("#get_students_for_attendance").show().html(data);
                            }
                            
                            $('#id-input-file-2').ace_file_input({
                                no_file:'No File ...',
                                btn_choose:'Choose',
                                btn_change:'Change',
                                thumbnail:false,
                                whitelist:'png|jpg|jpeg',
                                blacklist:'exe|php|txt',
                            });
                            
                             /*Attendance Datatable*/
                            $("#attendance-table").dataTable({

                                order: [
                                    [0, 'asc']
                                ],
                                "bPaginate": false,
                            });
                        }
                        
                        
                    });
                    /*jQuery Ajax*/
                }
            });
            /*Check Current Date Attendance*/


            /*Show/Hide Attendance Reason Input Field On Selectbox onChange Event*/
            $(document).on("click","#student_attendance_status",function(){
                
                    var present = parseInt($("#present").text());
                    var absent  = parseInt($("#absent").text());
                
                /*Check If Status Is Absent*/
                if ($(this).is(':checked') && $(this).val()==0)
                {
                    
                    
                    $("#status-badge"+$(this).attr("row")).html("Absent");
                    $("#status-badge"+$(this).attr("row")).removeClass("label-success");
                    $("#status-badge"+$(this).attr("row")).addClass("label-danger");
                    $("#reason"+$(this).attr("row")).removeAttr("type");
                    $("#reason"+$(this).attr("row")).attr("type","text");
                
                    if(present!=0)
                    {
                        present = present-1;
                        absent  = absent +1;
                        $("#present").html(present)
                        $("#absent").html(absent);
                        $("#present2").html(present)
                        $("#absent2").html(absent);
                    }
                   
                   
                }
                /*Check If Status Is Present*/
               else if ($(this).is(':checked') && $(this).val()==1)
                {
                    $("#status-badge"+$(this).attr("row")).html("Present");
                    $("#status-badge"+$(this).attr("row")).removeClass("label-danger");
                    $("#status-badge"+$(this).attr("row")).addClass("label-success");
                    $("#reason"+$(this).attr("row")).removeAttr("type");
                    $("#reason"+$(this).attr("row")).attr("type","hidden");
                
                
                    if(absent!=0)
                    {
                        present = present+1;
                        absent  = absent -1;
                        $("#present").html(present)
                        $("#absent").html(absent);
                        $("#present2").html(present)
                        $("#absent2").html(absent);
                    }
                }
           
               
                
                
                
            });

           
            /*Submit Attendance Through Form Submit After Uploading Class Attendance Picture*/ 
            $(document).on('submit','#my_form', function(event){
                      event.preventDefault();
                     
                       $.ajax({
                       url:"{{ route('super_admin.submit_students_attendance') }}",
                       method:"POST",
                       data:new FormData(this),
                       dataType:'JSON',
                       contentType: false,
                       cache: false,
                       processData: false,
                       success:function(data)
                       {
                           
                            /*Check If Validation Passes*/
                           if(data.message=='success')
                           {
                                $("#alert-messages").removeClass('alert-danger').addClass('alert-success').show();
                                $("#message").html("<b>"+data.result+"</b>");  
                                $("#get_students_for_attendance").html(''); 
                            if (window.stream) 
                            {
                                window.stream.getTracks().forEach(function(track) {
                                    track.stop();
                                });
                            }
                           }
                           /*Check If Validation Fails*/
                           else if(data.message=='fail')
                           {
                                /*Top Alert*/
                                $("#alert_attendance_div").removeClass('alert-success').addClass('alert-danger').show();
                                $("#alert_attendance_message").html("<b>"+data.result+"</b>");
                                /*Bottom Alert*/
                                $("#alert_attendance_div2").removeClass('alert-success').addClass('alert-danger').show();
                                $("#alert_attendance_message2").html("<b>"+data.result+"</b>");
                             
                            if (window.stream) 
                            {
                                window.stream.getTracks().forEach(function(track) {
                                    track.stop();
                                });
                            }   
                           }
                           
                           
                           
                       }
                    });
                });
           
            
            /*Show/Hide Alert Dialog When Close Icon Is Clicked (e.g: x icon)*/
            $(document).on("click", "button.close", function()
            {
                $("div.alert-danger").hide();
                $("div.alert-success").hide();
                $("div.alert-danger span").html('');
                $("div.alert-success span").html('');
               
            });
      
    });
</script>



    @endsection