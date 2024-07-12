@extends('master/master')

@section('title')
View Users
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
				<li class="active">View Users</li>
			</ul>
		</div>
		<div class="page-content">
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
								View Users
							</h1>
						</div><!-- /.page-header -->

						{{--dd($myusers)--}}
						
						<!--Message Section START-->
						@if(session('user_update_success_message'))
			            	<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">
									<i class="ace-icon fa fa-times"></i>
								</button>
								<b>{{session('user_update_success_message')}}</b>
							</div>
			            @endif
			            
			            @if(session('user_update_fail_message'))
			            	<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">
									<i class="ace-icon fa fa-times"></i>
								</button>
								<b>{{session('user_update_fail_message')}}</b>
							</div>
			            @endif
			            <!--Message Section END-->
			            
                        
                        
                        
						<!--DATA TABLE START -->
						<div class="row">
							<div class="col-xs-12">
								<table id="dynamic-table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
                                        <th class="hidden"></th>
										<th>Profile</th>
										<th>User Name</th>
										<th>Created By</th>
										<th class="hidden-480">Created Date</th>
										<th class="hidden-480">Updated Date</th>
										<th>Status</th>
										<th width="20%">Actions</th>
									</tr>
								</thead>
								<tbody>
									@if(!empty($myusers))
									@forelse($myusers as $user)
									<tr>
                                    <td class="hidden"> {{$user['id'] }}</td>

										<td align="center">

											<img class="img-responsive" alt="No Image" src="{{asset('storage/user_profile_images')}}/{{$user['profile_image']}}" style="border-radius:50%;width: 50px;height: 50px;">
										</td>
										<?php
											if(!isset($user['middle_name']))
											{
												?>
												<td>{{ $user['first_name'].' '.$user['last_name'] }}</td>
												<?php
											}
											else
											{
												?>
												<td>{{ $user['first_name'].' '.$user['middle_name'].' '.$user['last_name'] }}</td>
												<?php
											}
										?>

										<td>{{$user['create_by_name']}}<small class="blue"><b> ( 
											
												{{$user['account_created_by_role_type']}}
											)</b></small></td>
										<td class="hidden-480">{{ date('d F Y',strtotime($user['created_at'])) }}</td>
										<td class="hidden-480">{{ date('d F Y',strtotime($user['updated_at'])) }}
										</td>
										<td>
											@if($user['status'] == 1)
												<span class="label label-sm label-success">Active</span>
											@else
												<span class="label label-sm label-danger">Inactive</span>
											@endif
										</td>
										<td>
											
												<a class="green" href="/super_admin/edit_user/{{ $user['id'] }}">
													<button class="btn btn-xs btn-info" title="Edit">
														<i class="ace-icon fa fa-pencil bigger-120"></i>
													</button>
												</a>
												|
												<a class="green" href="/super_admin/view_user_detail/{{ $user['id'] }}">
													<button class="btn btn-xs btn-info" title="View Detail">
														<i class="ace-icon fa fa-eye bigger-120"></i>
													</button>
												</a>
												|
                                                <a class="green" href="/super_admin/assign_role/{{ $user['id'] }}">
													<button class="btn btn-xs btn-info" title="Assign Role">
														<i class="ace-icon fa fa-cogs bigger-120"></i>
													</button>
												</a>
											
											
										</td>
									</tr>
									@empty
									@endforelse
									@endif
								</tbody>
								</table>
							</div>
						</div>
					</div>
							</div><!-- /.span -->
						</div>

<div class="space-30"></div>
@endsection