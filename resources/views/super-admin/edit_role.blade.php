@extends('master/master')

@section('title')
Edit Role
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
							<li class="active">Edit Role</li>
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
								Edit Role
							</h1>
						</div><!-- /.page-header -->

						

							<div class="row">
						<div class="col-xs-12">
								<!--WRITE YOU MAIN CONTENT -->
								
								{!!Form::open(array("url"=>"super_admin/edit_role_process/{$editData['0']['id']}","method"=>"post","class"=>"form-horizontal","role"=>"form", "name"=>"editRole_form", "id"=>"editRole_form"))!!}
								<div class="form-group">
									{!!Form::label("form-field-1","Role Type",array("class"=>"col-sm-3 control-label no-padding-right"))!!}
									<div class="col-sm-5">
										{!!Form::text("role_type",$editData['0']['role_type'],array("placeholder"=>"Role Type","class"=>"form-control","id"=>"form-field-1"))!!}

										@if($errors->has("role_type"))
                                        	
	                                        <span class="badge badge-danger">
	                                        	{{$errors->first("role_type")}}
	                                        </span>		 
                                        @endif
									</div>
                                    <div class="col-sm-4"></div>
								</div>

								<div class="form-group">
									{!!Form::label("form-field-1","Role Description",array("class"=>"col-sm-3 control-label no-padding-right"))!!}
									<div class="col-sm-5">
										{!! Form::textarea("role_description", $editData['0']['role_description'], array("placeholder"=>"Role Description", "class"=>"form-control")) !!}

										@if($errors->has("role_description"))
                                        	
                                        	<span class="badge badge-danger">
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
											@if($editData['0']['status'] == 1)
											<label>
												{!! Form::radio("status", "1", true, array("class"=>"ace")) !!}
												<span class="lbl"> Active </span>
											</label>
											<label>
												{!! Form::radio("status", "0", false, array("class"=>"ace")) !!}
												<span class="lbl"> Inactive </span>
											</label>
											@endif

											@if($editData['0']['status'] == 0)
											<label>
												{!! Form::radio("status", "1", false, array("class"=>"ace")) !!}
												<span class="lbl"> Active </span>
											</label>
											<label>
												{!! Form::radio("status", "0", true, array("class"=>"ace")) !!}
												<span class="lbl"> Inactive </span>
											</label>
											@endif
											
										</div>
									</div>
								</div>
								{{ Form::hidden('id', $editData['0']['id']) }}
								<div class="form-group">
									{!!Form::label("form-field-1","&nbsp;",array("class"=>"col-sm-3 control-label no-padding-right"))!!}
									<div class="col-sm-9">
										{!! Form::submit("Update Role", array("class"=>"btn btn-primary")) !!}
									</div>
								</div> 					
					 			{!!Form::close()!!}
						</div><!-- /.col -->
						</div>
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
					

					</div><!-- /.page-content -->
			</div><!-- /.main-content -->



<script type="text/javascript" language="javascript">
	$(document).ready(function(event){
				
		var role_validator = $("#editRole_form").validate({
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

@endsection

