@extends('master/master')

@section('title')
Add Role
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
					<li class="active">Add Role</li>
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
								Add Role
							</h1>
						</div>
				<div class="row">
						<div class="col-xs-12">
								<!--WRITE YOU MAIN CONTENT -->
								@if(session('add_role_success_message'))
	                            <div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<b>{{session('add_role_success_message')}}</b>
								</div>
	                            @endif
	                            
	                            @if(session('add_role_fail_message'))
	                            <div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<b>{{session('add_role_fail_message')}}</b>
								</div>
	                            
	                            @endif

								{!!Form::open(array("url"=>"super_admin/add_role_process","method"=>"post","class"=>"form-horizontal","role"=>"form", "name"=>"addRole_form", "id"=>"addRole_form"))!!}
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="role_type">Role Type </label>
									<div class="col-sm-5">
										{!!Form::text("role_type",NULL,array("placeholder"=>"Enter Role Type","class"=>"form-control","id"=>"role_type"))!!}

										@if($errors->has("role_type"))
                                        	
	                                        <span class="badge badge-danger">
	                                        	{{$errors->first("role_type")}}
	                                        </span>		 
                                        @endif
									</div>
                                    <div class="col-sm-4"></div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 col-xs-12 control-label no-padding-right" for="role_description">Role Description </label>
									<div class="col-sm-5">
										{!! Form::textarea("role_description", NULL, array("placeholder"=>"Enter Role Description", 'id'=>'role_description', "class"=>"col-xs-12", "rows"=>"10","cols"=>"50")) !!}
                                        @if($errors->has("role_description"))
                                            
                                        	<span class="control-label no-padding-right badge badge-danger">
	                                        	{{$errors->first("role_description")}}
	                                        </span>		 
                                        @endif
									</div>
                                    <div class="col-sm-4"></div>
								</div>
						
								<div class="form-group">
									{!!Form::label("form-field-1","Role Status",array("class"=>"col-sm-3 control-label no-padding-right"))!!}
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
										{!! Form::submit("Add Role", array("class"=>"btn btn-primary")) !!}
									</div>
								</div> 					
					 			{!!Form::close()!!}
						</div><!-- /.col -->
						</div>
				</div>
                </div>
			</div><!-- /.main-content -->


<!--<style type="text/css">
	#form-field-1-error{
		display: block;
		margin-top: -8px;
	}
</style>-->

<script type="text/javascript" language="javascript">
	$(document).ready(function(event){
				
		var role_validator = $("#addRole_form").validate({
			rules: {
				role_type: {
					required: true,
                    
				},
				role_description: {
					required: true,
				},
			},
			messages: {
				role_type: {
					required: "<span class='badge badge-danger'>Please enter role type</span>",
				},
				role_description: {
					required: "<span class='badge badge-danger'>Please enter role description",
				},
			}
		});
	});
</script>
<div class="space-20"></div>
@endsection

