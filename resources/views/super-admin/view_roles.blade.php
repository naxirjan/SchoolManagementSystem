@extends('master/master')

@section('title')
View Roles
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
							<li class="active">View Roles</li>
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
								View Roles
								
							</h1>
						</div><!-- /.page-header -->

						{{--dd($myroles)--}}
						
						@if(session('role_update_success_message'))
			            	<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">
									<i class="ace-icon fa fa-times"></i>
								</button>
								<b>{{session('role_update_success_message')}}</b>
							</div>
			            @endif
			            
			            @if(session('role_update_fail_message'))
			            <div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">
									<i class="ace-icon fa fa-times"></i>
								</button>
								<b>{{session('role_update_fail_message')}}</b>
							</div>
			            @endif
			            
						<!--DATA TABLE START -->
						<div class="row">
							<div class="col-xs-12">
								<table id="dynamic-table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
                                        <th class="hidden"></th>
										<th>Role Type</th>
										<th>Role Description</th>
										<th class="hidden-480">Created Date</th>
										<th class="hidden-480">Updated Date</th>
										<th>Role Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@forelse($myroles as $role)
									<tr>
                                    <td class="hidden"> {{$role['id'] }}</td>

										<td>{{ $role['role_type'] }}</td>
										<td>{{ $role['role_description'] }}</td>
										<td class="hidden-480">{{ date('d F Y',strtotime($role['created_at'])) }}</td>
										<td class="hidden-480">{{ date('d F Y',strtotime($role['updated_at'])) }}</td>
										<td>
											@if($role['status'] == 1)
												<span class="label label-sm label-success">Active</span>
											@else
												<span class="label label-sm label-danger">Inactive</span>
											@endif
										</td>
										<td>
											
											<a class="green" href="/super_admin/edit_role/{{ $role['id'] }}">
												<button title="Edit" class="btn btn-xs btn-info">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</button>
											</a>
											
											
										</td>
									</tr>
									@empty
										<td colspan="6">{{"No Roles are found..."}}</td>
									@endforelse
								</tbody>
								</table>
							</div><!-- /.span -->
						</div>
</div>
				
        </div>
			</div><!-- /.main-content -->

<div class="space-30"></div>
@endsection