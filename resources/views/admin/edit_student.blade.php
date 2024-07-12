@extends('master/master')

@section('title')
Edit Student
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
                <li class="active">Edit Student</li>
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

                        <!-- /section:basics/sidebar.options -->
                    </div><!-- /.pull-left -->
                </div><!-- /.ace-settings-box -->
            </div><!-- /.ace-settings-container -->

            <!-- /section:settings.box -->
            <div class="page-header">
                <h1>
                    Edit Student
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!--WRITE YOU MAIN CONTENT -->
                   
                    @if(session()->has('edit_student_error_message'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <strong>
                            {{ session()->get('edit_student_error_message') }}
                        </strong>
                        <br>
                    </div>
                    @endif

                    {!!Form::open(array("url"=>"/admin/edit_student_process","method"=>"post","class"=>"form-horizontal","role"=>"form", "name"=>"edit_student_form", "id"=>"edit_student_form", "enctype"=>"multipart/form-data"))!!}
                    {!! Form::hidden('class_school_id',$student[0]->sms_school_class_id,['id'=>"class_school_id"])!!}
                    {!! Form::hidden('student_id',$student[0]->id)!!}
                    {!! Form::hidden('class_student_id',$student[0]->class_student_id) !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="district_operation">School Name</label>
                        <div class="col-sm-5">
                            {!! Form::select('school_id',$schools,$student[0]->school_id,['id'=>"school_id","class"=>"form-control","disabled"]) !!}
                            @if($errors->has("school_id"))
                            <span class="badge badge-danger" id="school_id_error">{{$errors->first("school_id")}}</span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div id="classes_selectbox"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="first_name">First Name </label>
                        <div class="col-sm-5">
                            {!!Form::text("first_name",$student[0]->first_name,array("placeholder"=>"Enter First Name","class"=>"form-control", "id"=>"first_name"))!!}

                            @if($errors->has("first_name"))

                            <span class="badge badge-danger">
                                {{$errors->first("first_name")}}
                            </span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="middle_name">Middle Name </label>
                        <div class="col-sm-5">
                            {!!Form::text("middle_name",$student[0]->middle_name,array("placeholder"=>"Enter Middle Name","class"=>"form-control","id"=>"middle_name"))!!}

                            @if($errors->has("middle_name"))

                            <span class="badge badge-danger">
                                {{$errors->first("middle_name")}}
                            </span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="last_name">Last Name </label>
                        <div class="col-sm-5">
                            {!!Form::text("last_name",$student[0]->last_name,array("placeholder"=>"Enter Last Name","class"=>"form-control","id"=>"last_name"))!!}

                            @if($errors->has("last_name"))

                            <span class="badge badge-danger">
                                {{$errors->first("last_name")}}
                            </span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="first_name">Guardian Name </label>
                        <div class="col-sm-5">
                            {!!Form::text("gaurdian_name",$student[0]->gaurdian_name,array("placeholder"=>"Enter Guardian Name","class"=>"form-control", "id"=>"gaurdian_name"))!!}

                            @if($errors->has("gaurdian_name"))

                            <span class="badge badge-danger">
                                {{$errors->first("gaurdian_name")}}
                            </span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="contact_number">Guardian Contact Number </label>
                        <div class="col-sm-5">
                            {!! Form::text("gaurdian_contact_number",$student[0]->gaurdian_contact_number, array("placeholder"=>"Enter Guardian Contact Number", "class"=>"form-control","id"=>"contact_number")) !!}

                            @if($errors->has("gaurdian_contact_number"))

                            <span class="badge badge-danger">
                                {{$errors->first("gaurdian_contact_number")}}
                            </span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="first_name">Date Of Birth </label>
                        <div class="col-sm-5">
                            {!!Form::date("date_of_brith",$student[0]->date_of_birth,array("placeholder"=>"Enter Date Of Birth","class"=>"form-control", "id"=>"date_of_brith"))!!}

                            @if($errors->has("date_of_brith"))

                            <span class="badge badge-danger">
                                {{$errors->first("date_of_brith")}}
                            </span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="form-group">
                        {!!Form::label("gender","Gender",array("class"=>"col-sm-3 control-label no-padding-right"))!!}
                        <div class="col-sm-9">
                            
                            <div class="radio">
                                <label>
                                    {!! Form::radio("gender", "Male",($student[0]->gender=='Male'), array("class"=>"ace",'id'=>'male')) !!}
                                    <span class="lbl"> Male </span>
                                </label>
                                <label>
                                    {!! Form::radio("gender", "Female",($student[0]->gender=='Female'), array("class"=>"ace",'id'=>'female')) !!}
                                    <span class="lbl"> Female </span>
                                </label>
                            </div>
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="address">Address </label>
                        <div class="col-sm-5" id="div_address">
                            {!! Form::textarea("address",$student[0]->address, array("placeholder"=>"Enter Address", 'id'=>'address', "class"=>"form-control", "rows"=>"2")) !!}

                            @if($errors->has("address"))

                            <span class="badge badge-danger">
                                {{$errors->first("address")}}
                            </span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>

                    <!--student Image--> 
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Student Image</label>
                        <div class="col-sm-5">
                            
                        <input type="file" disabled id="id-input-file-2" name="student_image" class="form-control">  
                            @if($errors->has("student_image"))
                                <span class="badge badge-danger">
                                    {{$errors->first("student_image")}}
                                </span>      
                            @endif

                        <br />
                        <input type="hidden" name="edit_student_image_path" value="{{ $student_image_path['student_image_path'] }}">
                        <img src="{{asset($student_image_path['student_image_path'])}}" height="100px" width="100px">


                        </div>
                        <div class="col-sm-4"></div>
                    </div>      
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Student Status</label>
                        <div class="col-sm-9">
                            
                            <label class="control-label no-padding-right">
                                {!! Form::radio('student_status', '1',($student[0]->status=='1'),['class'=>'ace']); !!}
                                <span class="lbl">&nbsp;Active</span>
                            </label>
                            &nbsp;
                            &nbsp;
                            <label class="control-label no-padding-right">
                                {!! Form::radio('student_status', '0',($student[0]->status=='0'),['class'=>'ace']); !!}
                                <span class="lbl">&nbsp;Inactive</span>
                            </label>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                        <div class="col-sm-9">
                            {!! Form::submit("Update Student", array("class"=>"btn btn-primary")) !!}
                        </div>
                    </div>

                    {!!Form::close()!!}
                </div>
                <script type="text/javascript">
                    
                    $(document).ready(function() {

                        //thid code for if select box of school of error is emppty then not show of class select box otherwise show of selected school classes in new select box
                        error_of_school = $('#school_id_error').html();

                        if(error_of_school == ""){
                            $('#classes_selectbox').html("");
                            //alert("wokring");
                          }else{
                            //alert("wokring2");
                            //alert(school_id);
                            var school_id             = $("#school_id").val();
                            var class_school_id       = $("#class_school_id").val();
                            //alert(class_school_id);
                            $.ajax({
                            url:"/get_classes_for_edit_admin_side",
                            type:"POST",
                            data:{_token: '{{csrf_token()}}',school_id:school_id,class_school:class_school_id},
                            success:function(ResponseText){
                                //alert(ResponseText);
                                $('#classes_selectbox').html(ResponseText);
                                //$('#eidtform').html("");
                               // alert(ResponseText);
                            }   
                            }); 
                        }

                             


                         $("select[name='school_id']").change(function(){  

                          var school_id       = $("#school_id").val();
                          
                          if(school_id == ""){
                            $('#classes_selectbox').html("");
                          }else{
                          //alert(school_id);
                            var school_id             = $("#school_id").val();
                            var class_school_id       = $("#class_school_id").val();
                            $.ajax({
                            url:"/get_classes_for_edit_admin_side",
                            type:"POST",
                            data:{_token: '{{csrf_token()}}',school_id:school_id,class_school:class_school_id},
                            success:function(ResponseText){
                                //alert(ResponseText);
                                $('#classes_selectbox').html(ResponseText);
                                //$('#eidtform').html("");
                               // alert(ResponseText);
                            }   
                            }); 
                        }


                        });
                    });
                </script>

            </div><!-- /.col -->


        </div><!-- /.page-content -->

    </div>
</div><!-- /.main-content -->
<div class="space-30"></div>
<!-- jquery validation -->
<script>
    $(document).ready(function() {
        ValidationForm = $("#edit_student_form").validate({
            rules:{
                school_id :{
                    required: true,
                },
                school_classes:{
                    required: true,
                },
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                gaurdian_name: {
                    required: true,
                },
                gaurdian_contact_number: {
                    required: true,
                },
                date_of_brith: {
                    required: true,
                },
                address: {
                    required: true,
                },
                student_image: {
                required:true,
                accept: "image/*",
                },

            },
            messages: {
                school_id:{
                    required: "<span class='badge badge-danger'>Please select school</span>",
                },
                school_classes:{
                    required: "<span class='badge badge-danger'>Please select class</span>",
                },
                first_name: {
                    required: "<span class='badge badge-danger'>Please enter first name</span>",
                },
                last_name: {
                    required: "<span class='badge badge-danger'>Please enter last name</span>",
                },
                gaurdian_name: {
                    required: "<span class='badge badge-danger'>Please enter guardian name</span>",
                },
                gaurdian_contact_number: {
                    required: "<span class='badge badge-danger'>Please enter guardian contact number</span>",
                },
                date_of_brith: {
                    required: "<span class='badge badge-danger'>Please enter date of birth</span>",
                },
                address: {
                    required: "<span class='badge badge-danger'>Please enter address</span>",
                },
                student_image: {
                required:"<br /><span class='badge badge-danger'>Please upload student image</span>",
                accept: "student image must be .jpeg, .jpg, .png",
                },

            }
        });
    });
</script>
<!-- jquery validation -->

@endsection