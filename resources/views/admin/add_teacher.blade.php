@extends('master/master')

@section('title')
Add Teacher
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
			<li class="active">Add Teacher</li>
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
							<label class="lbl" for="ace-settings-add-container">
								Inside
								<b>.container</b>
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
			<div class="page-header">
				<h1>Add Teacher</h1>
			</div>
			<div class="row">
				<div class="col-xs-12">
					@if(session('add_teacher_success_message'))
                    <div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">
							<i class="ace-icon fa fa-times"></i>
						</button>
						<b>{{session('add_teacher_success_message')}}</b>
					</div>
                    @endif
                    
                    @if(session('add_teacher_fail_message'))
                    <div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">
							<i class="ace-icon fa fa-times"></i>
						</button>
						<b>{{session('add_teacher_fail_message')}}</b>
					</div>
                    
                    @endif

					{!!Form::open(array("url"=>"admin/add_teacher_process","method"=>"post","class"=>"form-horizontal","role"=>"form", "id"=>"addTeacherForm", "enctype"=>"multipart/form-data"))!!}
					{{--dd($qualifications)--}}
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="qualification">Qualification </label>
						<div class="col-sm-5">
							{!! Form::select("qualification", $qualifications,NULL, array("class"=>"form-control","id"=>"qualification")) !!}

							@if($errors->has("qualification"))
                                <span class="badge badge-danger">
                                	{{$errors->first("qualification")}}
                                </span>		 
                            @endif
						</div>
                        <div class="col-sm-4"></div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="first_name">First Name </label>
						<div class="col-sm-5">
							{!!Form::text("first_name",NULL,array("placeholder"=>"Enter First Name","class"=>"form-control", "id"=>"first_name"))!!}

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
							{!!Form::text("middle_name",NULL,array("placeholder"=>"Enter Middle Name","class"=>"form-control","id"=>"middle_name"))!!}

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
							{!!Form::text("last_name",NULL,array("placeholder"=>"Enter Last Name","class"=>"form-control","id"=>"last_name"))!!}

							@if($errors->has("last_name"))
                            	
                                <span class="badge badge-danger">
                                	{{$errors->first("last_name")}}
                                </span>		 
                            @endif
						</div>
                        <div class="col-sm-4"></div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="email_address">Email Address </label>
						<div class="col-sm-5">
							{!!Form::text("email_address",NULL,array("placeholder"=>"Enter Email Address","class"=>"form-control","id"=>"email_address"))!!}

							@if($errors->has("email_address"))
                            	
                                <span class="badge badge-danger">
                                	{{$errors->first("email_address")}}
                                </span>		 
                            @endif
						</div>
                        <div class="col-sm-4"></div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="password">Password </label>
						<div class="col-sm-5">
							{!! Form::password("password", array("placeholder"=>"Enter Password", "class"=>"form-control","id"=>"password")) !!}

							@if($errors->has("password"))
                            
                                <span class="badge badge-danger">
                                	{{$errors->first("password")}}
                                </span>		 
                            @endif
						</div>
                        <div class="col-sm-4"></div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="conform_password">Confirm Password </label>
						<div class="col-sm-5">
							{!! Form::password("conform_password", array( "placeholder"=>"Enter Confirm Password", "class"=>"form-control","id"=>"conform_password")) !!}

							@if($errors->has("conform_password"))
                            
                                <span class="badge badge-danger">
                                	{{$errors->first("conform_password")}}
                                </span>		 
                            @endif
						</div>
                        <div class="col-sm-4"></div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="contact_number">Contact Number </label>
						<div class="col-sm-5">
							{!! Form::text("contact_number", NULL, array("placeholder"=>"Enter Contact Number", "class"=>"form-control","id"=>"contact_number")) !!}

							@if($errors->has("contact_number"))
                            
                                <span class="badge badge-danger">
                                	{{$errors->first("contact_number")}}
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
									{!! Form::radio("gender", "Male", true, array("class"=>"ace",'id'=>'male')) !!}
									<span class="lbl"> Male </span>
								</label>
								<label>
									{!! Form::radio("gender", "Female", false, array("class"=>"ace",'id'=>'female')) !!}
									<span class="lbl"> Female </span>
								</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="address">Address </label>
						<div class="col-sm-5" id="div_address">
							{!! Form::textarea("address", NULL, array("placeholder"=>"Enter Address", 'id'=>'address', "class"=>"form-control", "rows"=>"2")) !!}

                            @if($errors->has("address"))
                               
                            	<span class="badge badge-danger">
                                	{{$errors->first("address")}}
                                </span>		 
                            @endif
						</div>
                        <div class="col-sm-4"></div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="profile_image">Profile Picture </label>
						<div class="col-sm-5">
							
							<input type="file" id="id-input-file-2" name="profile_image" class="form-control">	
							@if($errors->has("profile_image"))
                            	
                                <span class="badge badge-danger">
                                	{{$errors->first("profile_image")}}
                                </span>		 
                            @endif
						</div>
						<div class="col-sm-4"></div>
					</div>		
			
					<div class="form-group" id="user-status-radios">
                        <br />
						{!!Form::label("form-field-1","Teacher Status",array("class"=>"col-sm-3 control-label no-padding-right"))!!}
						<div class="col-sm-9">
							<div class="radio">
								<label>
									{!! Form::radio("status", "1", true, array("class"=>"ace")) !!}
									<span class="lbl"> Active </span>
								</label>
								<label>
									{!! Form::radio("status", "0", false, array("class"=>"ace")) !!}
									<span class="lbl"> Inactive </span>
								</label>
							</div>
						</div>
                       
					</div>

					<div class="form-group">
						{!!Form::label("form-field-1","&nbsp;",array("class"=>"col-sm-3 control-label no-padding-right"))!!}
						<div class="col-sm-9">
							{!! Form::submit("Add Teacher", array("class"=>"btn btn-primary")) !!}
						</div>
					</div> 					
		 			{!!Form::close()!!}
				</div>
			</div>			
		</div>	
    </div>
</div>
<div class="space-20"></div>
<style type="text/css">
	#qualification-error{
		display: block;
		margin-top: -6px;
	}
</style>

<script type="text/javascript" language="javascript">
$(document).ready(function(event){


         
      $("#id-input-file-2").change(function(){
           $("#id-input-file-2-error").hide();
            
            });


	teacherValidator = $("#addTeacherForm").validate({
		rules: {
			qualification: {
				required: true
			},
			first_name: {
				required: true
			},
			last_name: {
				required: true
			},
			email_address: {
				required: true
			},
			password:{
				required:true,
				minlength:8,
				maxlength:20
			},
			conform_password:{
				required:true,
				equalTo:"#password"
			},
			contact_number: {
				required:true
			},
			address: {
				required:true
			},
			profile_image: {
				required:true,
			},
		},
		messages: {
			qualification: {
				required: "<span class='badge badge-danger'>Please select qualification</span>",
			},
			first_name: {
				required: "<span class='badge badge-danger'>Please enter first name</span>",
			},
			last_name: {
				required: "<span class='badge badge-danger'>Please enter last name</span>",
			},
			email_address: {
				required: "<span class='badge badge-danger'>Please enter email address</span>",
			},
			password:{
				required: "<span class='badge badge-danger'>Please enter password</span>",
				minlength:"<span class='badge badge-danger'>Minimum Length is 8 </span>",
				maxlength:"<span class='badge badge-danger'>Maximum length is 20 </span>",
			},
			conform_password:{
				required:"<span class='badge badge-danger'>Please enter confirm password</span>",
				equalTo:"<span class='badge badge-danger'>confirm password must match with password </span>",
			},
			contact_number: {
				required:"<span class='badge badge-danger'>Please enter contact number </span>",
			},
			address: {
				required:"<span class='badge badge-danger'>Please enter address</span>",
			},
			profile_image: {
				required:"<br /><span class='badge badge-danger'>Please upload profile picture </span>",
			},
		},
	});

	//alert(teacherValidator.val());
});
</script>

@endsection

