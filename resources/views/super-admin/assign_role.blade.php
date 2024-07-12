@extends('master/master')

@section('title')
Assign Role
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
					<li class="active">Assign Role</li>
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
				
				<div class="page-header">
					<h1>
						Assign Role <small><?php echo $user[0]['first_name'].' '.$user[0]['middle_name'].' '.$user[0]['last_name'];?></small>
					</h1>
				</div><!-- /.page-header -->

				<p id="result"></p>
				
				<input type="hidden" value="{{$id}}" id="userId"/>

				<div class="row">
					@forelse($myroles as $myrole)
						<div class="col-sm-4 text-center">
							<div class="checkbox">
								<label class="block">
									<input name="{{$myrole['role_type']}}" type="checkbox" class="ace input-lg ace-checkbox-2" value="{{$myrole['id']}}" id="{{$myrole['id']}}"> 
									<span class="lbl bigger-120"> {{ucwords($myrole['role_type'])}} </span>
								</label>
							</div>
						</div>
					@empty
						<div class="col-sm-12 alert alert-info">There Is No Any Role Please Add Role Then Assign Role</div>
					@endforelse
				</div>
				<br/>
				<hr/>
				<br/>
				<div class="row" id="div_for_school_admin">
					<div class="col-sm-3"></div>
					<div class="col-sm-6 well well-lg" id="load_selectBox_for_schoolAdmin">
						<h4 class="blue text-center">Select School To Assign School Admin</h4>
						<hr/>
						<select id="assign_school_to_admin" class="multiselect form-control" multiple="" placeholder="abc">
							@foreach($admin_schools as $key => $value)
								<div class="checkbox">
								<option value="{{$key}}">{{$value}}</option>
								</div>
							@endforeach
						</select>
						<br/>
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="row" id="div_for_school_teacher">
					<div class="col-sm-3"></div>
					<div class="col-sm-6  well well-lg" id="load_selectBox_for_schoolTeacher">
						<h4 class="blue text-center">Select School To Assign School Teacher</h4>
						<hr/>
						<select id="assign_school_to_teacher" class="multiselect form-control" multiple="">
							@foreach($teacher_schools as $key => $value)
								<option value="{{$key}}">{{$value}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="row" id="assign_role_button">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<button id="btn-assignRole" class="btn btn-info btn-block btn-lg" type="button">Assign Role</button>
					</div>
					<div class="col-sm-3"></div>
				</div>
			</div>
		</div>
	</div>

<div class="space-20"></div>					
<style type="text/css">
	#assign_role_button, #div_for_school_admin, #div_for_school_teacher{
		display: none;
	}
</style>


<script type="text/javascript">
	$(document).ready(function(){

		$('label > input[type=checkbox] ').addClass('ace-checkbox-2');

		$('button.multiselect.dropdown-toggle.form-control.btn.btn-white.btn-primary').html("None Selected <b class='fa fa-caret-down'></b>");		

		jQuery("input[type='checkbox']").change(function() {

			if($(this).prop("checked"))
			{
				$("#assign_role_button").css("display","block");

				if($(this).attr('id') == 2)
				{
					$("#div_for_school_admin").css("display","block");
				}
				else if ($(this).attr('id') == 3)
				{
					$("#div_for_school_teacher").css("display","block");
				}
			}
			else
			{
				if($(this).attr('id') == 1)
				{
					if($("#2").prop("checked"))
					{
						$("#assign_role_button").css("display","block");
					}
					else if($("#3").prop("checked"))
					{
						$("#assign_role_button").css("display","block");
					}
					else
					{
						$("#assign_role_button").css("display","none");
					}
				}
				else if($(this).attr('id') == 2)
				{
					$("#div_for_school_admin").css("display","none");
					if($("#1").prop("checked"))
					{
						$("#assign_role_button").css("display","block");
					}
					else if($("#3").prop("checked"))
					{
						$("#assign_role_button").css("display","block");
					}
					else
					{
						$("#assign_role_button").css("display","none");
					}
				}
				else if($(this).attr('id') == 3)
				{
					$("#div_for_school_teacher").css("display","none");
					if($("#1").prop("checked"))
					{
						$("#assign_role_button").css("display","block");
					}
					else if($("#2").prop("checked"))
					{
						$("#assign_role_button").css("display","block");
					}
					else
					{
						$("#assign_role_button").css("display","none");
					}
					$('.multiselect').parent('div').removeClass('btn-group');
				}
			}			
		});

		$(document).on('click','#btn-assignRole',function() {
			
			var user_id = $('#userId').val();

			var role_id_super_admin 	= 	$("#1").val();
			var role_id_school_admin 	= 	$("#2").val();
			var role_id_teacher 		= 	$("#3").val();

			var school_id_admin 		= 	$("#assign_school_to_admin").val();
			var school_id_teacher 		= 	$("#assign_school_to_teacher").val();

			if($("#1").prop("checked") && $("#2").prop("checked") && $("#3").prop("checked"))
			{
				if(school_id_admin == null)
				{
					$("#result").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><b>Please Select School For School Admin!...</b></div>');
				}
				else if(school_id_teacher == null)
				{
					$("#result").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><b>Please Select School For School Teacher!...</b></div>');
				}
				else
				{
					$.ajax({
						url:'assign_super_admin_school_admin_and_teacher_roles_to_user',
			            type:"POST",
			            data:{
			                _token:'{{csrf_token()}}',
			                user_id:user_id,
			                role_id_super_admin:role_id_super_admin,
			                role_id_school_admin:role_id_school_admin,
			                role_id_school_teacher:role_id_teacher,
			                schools_admin:school_id_admin,
			                schools_teacher:school_id_teacher
			            },
			            success:function($response){
			            $('#result').html($response);
                            $("#assign_role_button").css("display","none");
                            $("#div_for_school_admin").css("display","none");
                            $("#div_for_school_teacher").css("display","none");
			            }	
					});	
				}		
			}
			else if($("#1").prop("checked") && $("#2").prop("checked"))
			{
				if(school_id_admin == null)
				{
					$("#result").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><b>Please Select School For School Admin!...</b></div>');
				}
				else
				{
					$.ajax({
						url:'assign_super_admin_and_school_admin_role',
			            type:"POST",
			            data:{
			                _token:'{{csrf_token()}}',
			                user_id:user_id,
			                role_id_super_admin:role_id_super_admin,
			                role_id_school_admin:role_id_school_admin,
			                schools:school_id_admin
			            },
			            success:function($response){
			            $('#result').html($response);
                        $("#assign_role_button").css("display","none");
                        $("#div_for_school_admin").css("display","none");
                        $("#div_for_school_teacher").css("display","none");
			            }	
					});
				}	
			}
			else if($("#1").prop("checked") && $("#3").prop("checked"))
			{
				if(school_id_teacher == null)
				{
					$("#result").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><b>Please Select School For School Teacher!...</b></div>');
				}
				else
				{
					$.ajax({
						url:'assign_super_admin_and_school_teacher_role',
			            type:"POST",
			            data:{
			                _token:'{{csrf_token()}}',
			                user_id:user_id,
			                role_id_super_admin:role_id_super_admin,
			                role_id_school_teacher:role_id_teacher,
			                schools:school_id_teacher
			            },
			            success:function($response){
			            $('#result').html($response);
                        $("#assign_role_button").css("display","none");
                        $("#div_for_school_admin").css("display","none");
                        $("#div_for_school_teacher").css("display","none");
			            }	
					});
				}
			}
			else if($("#2").prop("checked") && $("#3").prop("checked"))
			{
				if(school_id_admin == null)
				{
					$("#result").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><b>Please Select School For School Admin!...</b></div>');
				}
				else if(school_id_teacher == null)
				{
					$("#result").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><b>Please Select School For School Teacher!...</b></div>');
				}
				else
				{
					$.ajax({
						url:'assign_school_admin_and_school_teacher_role',
			            type:"POST",
			            data:{
			                _token:'{{csrf_token()}}',
			                user_id:user_id,
			                role_id_school_admin:role_id_school_admin,
			                role_id_school_teacher:role_id_teacher,
			                schools_admin:school_id_admin,
			                schools_teacher:school_id_teacher
			            },
			            success:function($response){
			            $('#result').html($response);
                        $("#assign_role_button").css("display","none");
                        $("#div_for_school_admin").css("display","none");
                        $("#div_for_school_teacher").css("display","none");
			            }	
					});
				}
			}
			else if($("#1").prop("checked"))
			{
				$.ajax({
					url:'assign_super_admin_role',
		            type:"POST",
		            data:{
		                _token:'{{csrf_token()}}',
		                user_id:user_id,
		                role_id:role_id_super_admin
		                },
		            success:function($response){
		            $('#result').html($response);
                    $("#assign_role_button").css("display","none");
                    $("#div_for_school_admin").css("display","none");
                    $("#div_for_school_teacher").css("display","none");
		            }	
				});
			}
			else if($("#2").prop("checked"))
			{	
				if(school_id_admin == null)
				{
					$("#result").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><b>Please Select School For School Admin!...</b></div>');
				}
				else
				{
					$.ajax({
						url:'assign_school_admin_role',
			            type:"POST",
			            data:{
			                _token:'{{csrf_token()}}',
			                user_id:user_id,
			                role_id:role_id_school_admin,
			                school_id:school_id_admin
			                },
			            success:function($response){
			            $('#result').html($response);
                        $("#assign_role_button").css("display","none");
                        $("#div_for_school_admin").css("display","none");
                        $("#div_for_school_teacher").css("display","none");
			            }	
					});
				}
			}
			else if($("#3").prop("checked"))
			{
				if(school_id_teacher == null)
				{
					$("#result").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><b>Please Select School For School Teacher!...</b></div>');
				}
				else
				{
					$.ajax({
						url:'assign_school_admin_role',
			            type:"POST",
			            data:{
			                _token:'{{csrf_token()}}',
			                user_id:user_id,
			                role_id:role_id_teacher,
			                school_id:school_id_teacher
			                },
			            success:function($response){
			            $('#result').html($response);
                        $("#assign_role_button").css("display","none");
                        $("#div_for_school_admin").css("display","none");
                        $("#div_for_school_teacher").css("display","none");
			            }	
					});
				}
			}
		});
	});
</script>

@endsection