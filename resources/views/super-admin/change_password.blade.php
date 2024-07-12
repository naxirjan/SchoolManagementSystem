@extends('master/master')

@section('title')
Change Password
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
							<li class="active">Change Password</li>
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
								Change Password
							</h1>
						</div><!-- /.page-header -->
						<div class="row">
								<div class="col-sm-12">


								<!--WRITE YOU MAIN CONTENT -->
								@if(session('success_message'))
	                            <div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<b>{{session('success_message')}}</b>
								</div>
	                            @endif

									{!!Form::open(array("url"=>"super_admin/change_password_process","method"=>"post","class"=>"form-horizontal","role"=>"form", "name"=>"change_passowrd_form", "id"=>"change_passowrd_form",))!!}


									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="password">Old Password </label>
										<div class="col-sm-5">
											{!! Form::password("old_password",array("placeholder"=>"Enter Old Password", "class"=>"form-control","id"=>"old_password")) !!}

											@if($errors->has("old_password"))
		                                        <span class="badge badge-danger">
		                                        	{{$errors->first("old_password")}}
		                                        </span>		 
	                                        @endif

	                                        @if(session('error_message'))
							                    <span class="badge badge-danger"> 
							                        {{session('error_message')}}
							                    </span>   
                    						@endif
                    						<span class="badge badge-danger" id="messages_check_password_error" style="display: none;"> 
							      			</span> 
							      			<span class="badge badge-success" id="messages_check_password_success" style="display: none;"> 
							      			</span> 
                    						




										</div>
	                                    <div class="col-sm-4"></div>
									</div>

									<div class="form-group" id="new_password_groupform">
										<label class="col-sm-3 control-label no-padding-right" for="password">New Password </label>
										<div class="col-sm-5">
											{!! Form::password("new_password",array("placeholder"=>"Enter New Password", "class"=>"form-control","id"=>"new_password")) !!}

											@if($errors->has("new_password"))
	                                        
		                                        <span class="badge badge-danger">
		                                        	{{$errors->first("new_password")}}
		                                        </span>		 
	                                        @endif
										</div>
	                                    <div class="col-sm-4"></div>
									</div>

									<div class="form-group" id="conform_password_groupform">
										<label class="col-sm-3 control-label no-padding-right" for="conform_password">Confirm Password </label>
										<div class="col-sm-5">
											{!! Form::password("conform_password",array("placeholder"=>"Enter Confirm Password", "class"=>"form-control","id"=>"conform_password")) !!}

											@if($errors->has("conform_password"))
		                                        <span class="badge badge-danger">
		                                        	{{$errors->first("conform_password")}}
		                                        </span>		 
	                                        @endif
										</div>
	                                    <div class="col-sm-4"></div>
									</div>
								<div class="form-group" >
									{!!Form::label("form-field-1","&nbsp;",array("class"=>"col-sm-3 control-label no-padding-right"))!!}
									<div class="col-sm-9">
										{!! Form::submit("Change Password", array("class"=>"btn btn-primary",'id'=>"button_form")) !!}
									</div>
								</div> 					
					 			{!!Form::close()!!}
								</div>
						</div>
					</div><!-- /.page-content -->
        </div>
			</div><!-- /.main-content -->
		<div class="space-20"></div>
<script type="text/javascript" language="javascript">
$(document).ready(function(event){
	
	var role_validator = $("#change_passowrd_form").validate({
		rules: {
			old_password:{
				required:true,
				
			},
			new_password:{
				required:true,
				minlength:8,
				maxlength:20
			},
			conform_password:{
				required:true,
				equalTo:"#new_password",
			},
		},
		messages: {
			old_password:{
				required: "<span id='empty_password_message' class='badge badge-danger'>Please enter old password</span>",
			},
			new_password:{
				required: "<span class='badge badge-danger'>Please enter new password</span>",
				minlength:"<span class='badge badge-danger'>Minimum Length is 8 </span>",
				maxlength:"<span class='badge badge-danger'>Maximum length is 20 </span>",
			},
			conform_password:{
				required:"<span class='badge badge-danger'>Please enter confirm password</span>",
				equalTo:"<span class='badge badge-danger'>Confirm password must match with new password </span>",
			},
			
		}
	});


	/*This code for check old password match or not and using ajax*/
	$(document).on('keyup','#old_password',function(e){
           //alert(1);
           
            var old_password = $(this).val();
            if(!old_password){
            	//alert(1);
            	$("#old_password-error").hide();
            	//$("#messages_check_password_error").html("Please enter old password");
		        $("#messages_check_password_error").hide();
		        $("#old_password-error").hide();

            }else{

            	$.ajax({
	            url:'check_old_password_super_admin_function',
	            type:'POST',
	            data:{_token:'{{csrf_token()}}',old_password:old_password},
	            success:function(data){
	               //$('#eidtform').html(data);
	              	//alert(data);

					if(data == 1){
		              	
						$("#button_form").prop("disabled",false);
						$("#messages_check_password_success").html("Your password has been matched");
						$("#messages_check_password_success").show();
						$("#messages_check_password_error").hide();

		              }else if(data == 0){

		              	
		              	$("#old_password-error").hide();
		              	$("#messages_check_password_error").html("Your password doesn't match");
		              	$("#messages_check_password_error").show();
		              	$("#messages_check_password_success").hide();
		              	$("#button_form").prop("disabled",true);
		              	
		              }

	              

	            }
	            });

            }
	    
    });

	
	


});


</script>

@endsection

