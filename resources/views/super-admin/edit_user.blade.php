@extends('master/master')

@section('title')
Edit User
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
					<li class="active">Edit User</li>
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
								Edit User
							</h1>
						</div>
				<div class="row">
						<div class="col-xs-12">
								<!--WRITE YOU MAIN CONTENT -->
								
 								

								{!!Form::open(array("url"=>"super_admin/edit_user_process","method"=>"post","class"=>"form-horizontal","role"=>"form", "name"=>"editUser_form", "id"=>"editUser_form", "enctype"=>"multipart/form-data"))!!}

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="qualification">Qualification </label>
									<div class="col-sm-5">
										{!! Form::select("qualification", $qualifications, $myusers['0']['sms_qualification_id'], array("class"=>"form-control","id"=>"qualification")) !!}

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

										{{ Form::hidden('id', $myusers['0']['id']) }}

										{!!Form::text("first_name",$myusers['0']['first_name'],array("placeholder"=>"Enter First Name","class"=>"form-control", "id"=>"first_name"))!!}

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
										{!!Form::text("middle_name",$myusers['0']['middle_name'],array("placeholder"=>"Enter Middle Name","class"=>"form-control","id"=>"middle_name"))!!}

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
										{!!Form::text("last_name",$myusers['0']['last_name'],array("placeholder"=>"Enter Last Name","class"=>"form-control","id"=>"last_name"))!!}

										@if($errors->has("last_name"))
                                        	
	                                        <span class="badge badge-danger">
	                                        	{{$errors->first("last_name")}}
	                                        </span>		 
                                        @endif
									</div>
                                    <div class="col-sm-4"></div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="email">Email Address </label>
									<div class="col-sm-5">
										{!!Form::text("email",$myusers['0']['email'],array("placeholder"=>"Enter Email Address","class"=>"form-control","id"=>"email"))!!}

										@if($errors->has("email"))
                                        	
	                                        <span class="badge badge-danger">
	                                        	{{$errors->first("email")}}
	                                        </span>		 
                                        @endif
									</div>
                                    <div class="col-sm-4"></div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="contact_number">Contact Number </label>
									<div class="col-sm-5">
										{!! Form::text("contact_number", $myusers['0']['contact_number'], array("placeholder"=>"Enter Contact Number", "class"=>"form-control","id"=>"contact_number")) !!}

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
										@if($myusers['0']['gender'] == "Male")
											<div class="radio">
												<label>
													{!! Form::radio("gender", "Male", true, array("class"=>"ace")) !!}
													<span class="lbl"> Male </span>
												</label>
												<label>
													{!! Form::radio("gender", "Female", false, array("class"=>"ace")) !!}
													<span class="lbl"> Female </span>
												</label>
											</div>
										@elseif($myusers['0']['gender'] == "Female")
											<div class="radio">
												<label>
													{!! Form::radio("gender", "Male", false, array("class"=>"ace")) !!}
													<span class="lbl"> Male </span>
												</label>
												<label>
													{!! Form::radio("gender", "Female", true, array("class"=>"ace")) !!}
													<span class="lbl"> Female </span>
												</label>
											</div>
										@endif
										
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="address">Address </label>
									<div class="col-sm-5">
										{!! Form::textarea("address", $myusers['0']['address'], array("placeholder"=>"Enter Address", 'id'=>'address', "class"=>"form-control", "rows"=>"2")) !!}

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
										
												<input type="file" id="id-input-file-2" name="profile_image" class="col-xs-10 col-sm-5 form-control"><br />
												<img src="{{asset('storage/user_profile_images')}}/{{$myusers['0']['profile_image']}}" height="100px" width="100px">
										</div>

										@if($errors->has("profile_image"))
                                        	
	                                        <span class="badge badge-danger">
	                                        	{{$errors->first("profile_image")}}
	                                        </span>		 
                                        @endif
									
									<div class="col-sm-4">
									</div>
								</div>

								@if(session('user_id')!=$myusers['0']['id'])
								<div class="form-group">
                                    {!!Form::label("form-field-1","User Status",array("class"=>"col-sm-3 control-label no-padding-right"))!!}
                                    
									<div class="col-sm-9">
										@if($myusers['0']['status'] == 1)
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
										@else
											<div class="radio">
												<label>
													{!! Form::radio("status", "1", false, array("class"=>"ace")) !!}
													<span class="lbl"> Active </span>
												</label>
												<label>
													{!! Form::radio("status", "0", true, array("class"=>"ace")) !!}
													<span class="lbl"> Inactive </span>
												</label>
											</div>
										@endif

									{{--Form::hidden('id', $myusers['0']['id'])--}}	
									</div>
								</div>
								@endif
								<div class="form-group">
									{!!Form::label("form-field-1","&nbsp;",array("class"=>"col-sm-3 control-label no-padding-right"))!!}
									<div class="col-sm-9">
										{!! Form::submit("Update User", array("class"=>"btn btn-primary")) !!}
									</div>
								</div> 					
					 			{!!Form::close()!!}
						</div><!-- /.col -->
						</div>
            </div>
                </div>
			</div><!-- /.main-content -->
<style type="text/css">
	#qualification-error{
		display: block;
		margin-top: -6px;
	}
</style>

<script type="text/javascript" language="javascript">
$(document).ready(function(event){
	
	var user_validator = $("#editUser_form").validate({
		rules: {
			qualification: {
				required: true,
			},
			first_name: {
				required: true,
			},
			last_name: {
				required: true,
			},
			email: {
				required: true,
			},
			contact_number: {
				required:true,
			},
			address: {
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
			email: {
				required: "<span class='badge badge-danger'>Please enter email address</span>",
			},
			contact_number: {
				required:"<span class='badge badge-danger'>Please enter contact number </span>",
			},
			address: {
				required:"<span class='badge badge-danger'>Please enter address</span>",
			},
		}
	});
});
</script>
<div class="space-20"></div>
@endsection

