@extends('master/master')

@section('title')
Student Detail
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

                <li class="active">Student Detail</li>
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
                                <div class="dropdown dropdown-colorpicker"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="btn-colorpicker" style="background-color:#438EB9"></span></a>
                                    <ul class="dropdown-menu dropdown-caret">
                                        <li><a class="colorpick-btn selected" href="#" style="background-color:#438EB9;" data-color="#438EB9"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#222A2D;" data-color="#222A2D"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#C6487E;" data-color="#C6487E"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#D0D0D0;" data-color="#D0D0D0"></a></li>
                                    </ul>
                                </div>
                            </div>
                            <span>&nbsp; Choose Skin</span>
                        </div>

                        <!-- /section:settings.skins -->

                        <!-- #section:settings.navbar -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar">
                            <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                        </div>

                        <!-- /section:settings.navbar -->

                        <!-- #section:settings.sidebar -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar">
                            <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                        </div>

                        <!-- /section:settings.sidebar -->

                        <!-- #section:settings.breadcrumbs -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs">
                            <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                        </div>

                        <!-- /section:settings.breadcrumbs -->

                        <!-- #section:settings.rtl -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl">
                            <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                        </div>

                        <!-- /section:settings.rtl -->

                        <!-- #section:settings.container -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container">
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
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover">
                            <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact">
                            <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight">
                            <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                        </div>

                        <!-- /section:basics/sidebar.options -->
                    </div><!-- /.pull-left -->
                </div><!-- /.ace-settings-box -->
            </div><!-- /.ace-settings-container -->


            <div class="page-header">
                <h1>
                    Student Detail

                </h1>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="alert alert-danger" id="message" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <strong>
                            Please Upload Image File Only!...
                        </strong>
                        <br>
                    </div>

                    <div class="alert" id="div_alert_image" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <strong>
                            <span id="show_message"></span>
                        </strong>
                        <br>
                    </div>

                    <div class="alert alert-success" id="message_success" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <strong>
                            Image Has Been Changed Successfully!...
                        </strong>
                        <br>
                    </div>


                    <div class="">
                        <div id="user-profile-1" class="user-profile row">
                            <div class="col-xs-12 col-sm-1"></div>
                            <div class="col-xs-12 col-sm-3 center">
                                <div id="image_div" class="profile-picture" style="border: none;box-shadow:none;">
                                    <!--profile.picture -->



                                    <div id="div_profile_picture">

                                        <img id="avatar" class="editable img-responsive editable-click editable-empty" alt="No Image.." src="{{asset($student_image_path['student_image_path'])}}" style="border-radius:50%;border:1px solid black;width: 200px;height: 200px;">

                                    </div>
                                    <!--profile.picture -->
                                    <div class="space-4"></div>

                                    <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                        <div class="inline position-relative">
                                            <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                                <span class="white">{{ucfirst($student[0]->first_name)}}&nbsp;{{ucfirst($student[0]->last_name)}}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>

                                    <div class="width-80 label label-warning label-xlg arrowed-in arrowed-in-right">
                                        <div class="inline position-relative">

                                            <a href="" id="change_image" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                                <span class="white">Change Profile Picture</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="width-120  arrowed-in arrowed-in-center" id="image_upload_box" style="display: none;">
                                        <div class="inline position-relative">
                                            <!--  <form class="form-inline editableform"  > -->
                                            <!--  <script src="{{asset('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js')}}"></script> -->
                                            <!--  <form method="post" action="/super_admin/update_student_image" enctype="multipart/form-data"> -->
                                            <form enctype="multipart/form-data" id="upload_form" role="form" method="POST">
                                                {{ csrf_field() }}
                                                <label class="ace-file-input ace-file-multiple label-xlg" style="width: 150px;margin-bottom: 60px;">

                                                    <input type="file" name="id-input-file-2" class="form-control" id="id-input-file-2" onchange="loadFile(event)">

                                                    @if($student[0]->middle_name)
                                                    <input type="hidden" name="middle_name" value="{{$student[0]->middle_name}}">
                                                    @endif

                                                    <input type="hidden" name="hidden_image_src" id="hidden_image_src" value="{{asset($student_image_path['student_image_path'])}}">
                                                    <input type="hidden" name="student_old_image" id="student_old_image" value="{{$student[0]->student_image}}">
                                                    <input type="hidden" name="last_name" value="{{$student[0]->last_name}}">
                                                    <input type="hidden" name="first_name" value="{{$student[0]->first_name}}">
                                                    <input type="hidden" name="student_id" value="{{$student[0]->id}}">
                                                    <input type="hidden" name="class_school" value="{{$student[0]->sms_school_class_id}}">
                                                    <input type="hidden" name="class_name" value="{{$student[0]->class}}">
                                                    <input type="hidden" name="school_name" value="{{$student[0]->school}}">
                                                    <input type="hidden" name="school_id" value="{{$student[0]->school_id}}">

                                                </label>

                                                <br />
                                                <br />
                                                <div class="editable-buttons">
                                                    <button name="upload" id="upload" class="btn btn-info editable-submit" type="submit">
                                                        <i class="ace-icon fa fa-check"></i>
                                                    </button>

                                                    <button type="button" id="cancel-btn" class="btn editable-cancel">
                                                        <i class="ace-icon fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                </div>
                                <div class="space-6"></div>
                            </div>
                            <div class="col-xs-12 col-sm-7">
                                <div class="space-12"></div>
                                <!--School Information-->
                                <div class="profile-user-info profile-user-info-striped">

                                    <!--School Name-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Full Name</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                                <?php
                                                if(!isset($student[0]->middle_name))
                                                {
                                                    ?>
                                                {{ $student[0]->first_name.' '.$student[0]->last_name }}
                                                <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                {{ $student[0]->first_name.' '.$student[0]->middle_name.' '.$student[0]->last_name }}
                                                <?php
                                                }
                                               ?>

                                            </span>
                                        </div>
                                    </div>


                                    <!--Gaurdian Name-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Guardian Name</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{ucfirst($student[0]->gaurdian_name)}}</span>
                                        </div>
                                    </div>

                                    <!--Gaurdian Contact Phone-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Guardian Contact Number</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{ucfirst($student[0]->gaurdian_contact_number)}}</span>
                                        </div>
                                    </div>

                                    <!--Gender-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Gender</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                                {{ucfirst($student[0]->gender)}}
                                            </span>
                                        </div>
                                    </div>

                                    <!--Student Date of Brith-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Date of Birth </div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{date('d F Y',strtotime($student[0]->date_of_birth))}}</span>
                                        </div>
                                    </div>

                                    <!--Student Address-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Address </div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{ucwords($student[0]->address)}}</span>
                                        </div>
                                    </div>
                                    <!--Student School-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Student School </div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{ucwords($student[0]->school)}}</span>
                                        </div>
                                    </div>
                                    <!--Student Class-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Student Class </div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{ucwords($student[0]->class)}}</span>
                                        </div>
                                    </div>




                                    <!--Created Date-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Created Date</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click" id="age">

                                                {{date('d F Y',strtotime($student[0]->created_at))}}

                                            </span>
                                        </div>
                                    </div>

                                    <!--Updated Date-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Updated Date</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click" id="age">

                                                {{date('d F Y',strtotime($student[0]->updated_at))}}
                                            </span>
                                        </div>
                                    </div>

                                    <!--Account Created By-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Student Added By </div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                                {{ucfirst($student[0]->created_by)}}&nbsp;&nbsp;&nbsp;
                                                <small class="blue"><b> ({{ucfirst($student[0]->role_type)}})</b></small>
                                            </span>
                                        </div>
                                    </div>



                                    <!--Status-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Status</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                                @if($student[0]->status==1)
                                                Active
                                                @else
                                                Inactive
                                                @endif
                                            </span>
                                        </div>
                                    </div>




                                    <!--Back button-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name" style="background-color: white"> &nbsp;&nbsp;&nbsp;</div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                                <!-- <a href="/super_admin/view_students" style="float:right">
                                                    <button class="btn btn-xl btn-info">
                                                        <i class="ace-icon fa fa-arrow-left icon-on-left"></i>
                                                        Back
                                                    </button>
                                                </a> -->
                                                <a href="javascript:history.back()" style="float:right">
                                                    <button class="btn btn-xl btn-info">
                                                        <i class="ace-icon fa fa-arrow-left icon-on-left"></i>
                                                        Back
                                                    </button>
                                                </a>
                                                
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-10"></div>
                            </div>
                            <div class="col-xs-12 col-sm-1"></div>
                        </div>
                    </div>



                    <!-- PAGE CONTENT ENDS -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="space-30"></div>

<!-- inline scripts related to this page -->
<script>
    $(document).ready(function() {



        /*code for open image uploading form or close*/
        $('#change_image').click(function(e) {
            e.preventDefault();
            //$('').show();  
            $("#image_upload_box").toggle();

        });

        /*code for close of student image upload form*/
        $('#cancel-btn').click(function(e) {
            //$('').show();  
            //e.preventDefault();
            $("#avatar").attr("src", $("#hidden_image_src").val());
            $("#image_upload_box").hide();

        });





        /*This code for image uploading in folder in data store in database*/
        $('#upload_form').on('submit', function(event) {

            event.preventDefault();

            $.ajax({
                url: "{{ route('update_student_image.update_student_image_function') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.message == "success") {
                        $("#div_alert_image").addClass("alert-success").removeClass("alert-danger").show();
                        $("#show_message").html(data.result);
                    } else if (data.message == "fail") {
                        $("#div_alert_image").addClass("alert-danger").removeClass("alert-success").show();
                        $("#show_message").html(data.result);
                    }

                    $("#image_upload_box").hide();
                    $("#message").hide();


                }
            });
        });

    });
</script>
<script>
    /*code for image preview in uploading time*/
    var loadFile = function(event) {
        var output = document.getElementById('avatar');
        //alert(1);
        if ($("#id-input-file-2").val() != "") {

            var extension = $("#id-input-file-2").val().split('.').pop();

            if (extension == 'png' || extension == 'jpg' || extension == 'jpeg') {
                output.src = URL.createObjectURL(event.target.files[0]);
                $("#message").hide();

            } else {
                $("#id-input-file-2").val("");
                $("#message").show();

            }

            $("#div_alert_image").hide();
            $("#show_message").html("");
        }



    };
</script>

@endsection