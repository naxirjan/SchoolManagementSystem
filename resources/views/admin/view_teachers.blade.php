@extends('master/master')

@section('title')
View Teachers
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
				<li class="active">View Teachers</li>
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
				<h1>View Teachers</h1>
			</div>
			
					
			@if(session('teacher_update_success_message'))
            	<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					</button>
					<b>{{session('teacher_update_success_message')}}</b>
				</div>
            @endif
            
            @if(session('$teacher_update_fail_message'))
            	<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					</button>
					<b>{{session('$teacher_update_fail_message')}}</b>
				</div>
            @endif
            
			<!--DATA TABLE START -->
			<div class="row">
				<div class="col-xs-12">
					
						<table id="dynamic-table" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
	                            <th class="hidden"></th>
								<th>Profile</th>
								<th>Teacher Name</th>
								<th class="hidden-480">Email Address</th>
								<th>Contact No</th>
								<th class="hidden-480">Created Date</th>
								<th class="hidden-480">Updated Date</th>
								<th>Status</th>
								<th width="20%">Actions</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($myteachers))
							@foreach($myteachers as $teacher)
							<tr>
	                        	<td class="hidden"> {{$teacher->id }}</td>

								<td align="center">

									<img class="img-responsive" alt="No Image" src="{{asset('storage/user_profile_images')}}/{{$teacher->profile_image}}"  style="border-radius:50%;width: 50px;height: 50px;">
								</td>
								<?php
									if(!isset($teacher->middle_name))
									{
										?>
										<td>{{ $teacher->first_name.' '.$teacher->last_name }}</td>
										<?php
									}
									else
									{
										?>
										<td>{{ $teacher->first_name.' '.$teacher->middle_name.' '.$teacher->last_name }}</td>
										<?php
									}
								?>
								<td class="hidden-480">{{ $teacher->email }}</td>
								<td>{{ $teacher->contact_number }}</td>
								<td class="hidden-480">{{ date('d F Y',strtotime($teacher->created_at)) }}</td>
								<td class="hidden-480">{{ date('d F Y',strtotime($teacher->updated_at)) }}
								</td>
								<td>
									@if($teacher->status == 1)
										<span class="label label-sm label-success">Active</span>
									@else
										<span class="label label-sm label-danger">Inactive</span>
									@endif
								</td>
								<td>
										<a class="green" href="/admin/view_teacher_detail/{{ $teacher->id }}">
											<button class="btn btn-xs btn-info" title="View Detail">
												<i class="ace-icon fa fa-eye bigger-120"></i>
											</button>
										</a>
										@if($role_user_id==$teacher->sms_role_user_id)
										|	
										<a class="green" href="/admin/edit_teacher/{{ $teacher->id }}">
											<button class="btn btn-xs btn-info" title="Edit">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</button>
										</a>
										@endif
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
						</table>
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="space-20"></div>
@endsection

