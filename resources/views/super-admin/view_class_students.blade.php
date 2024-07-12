@extends('master/master')

@section('title')
View Class Students
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
							<li class="active">View Class Students</li>
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
								View Class Students
								
							</h1>
						</div>
                        
                         @if(!empty($class_students))
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-8">
                               <div class="profile-user-info profile-user-info-striped">
                                                            <div class="profile-info-row">
                                                                <div class="profile-info-name"> School Name</div>
                                                                <div class="profile-info-value">
                                                                    <span class="dark">
                                                                        <b>{{$class_students[0]->school}}</b>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="profile-info-row">
                                                                <div class="profile-info-name"> Class Name</div>

                                                                <div class="profile-info-value">
                                                                    <span class="dark">
                                                                        <b>{{$class_students[0]->class}}</b>
                                                                    </span>

                                                                </div>
                                                            </div>
                                                            <div class="profile-info-row">
                                                                <div class="profile-info-name" style="background-color: white"> &nbsp;&nbsp;&nbsp;</div>    
                                                                <div class="profile-info-value">
                                                                        <span class="editable editable-click">
                                                                        <a href="javascript:history.back()" style="float:right">
                                                                        <button class="btn btn-xl btn-info">
                                                                            <i class="ace-icon fa fa-arrow-left icon-on-left"></i>
                                                                            Back
                                                                        </button>
                                                                        </a>
                                                                        </span>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                <div class="col-sm-2"></div>
                            </div>
                        </div>
                            <br />
                       
                        <div class="row">
                            <div class="col-xs-12">
                               
								<table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="hidden"></th>
                                            <th>First Name</th>
                                            <th class="hidden-480">Middle Name</th>
                                            <th>Last Name</th>
                                            <th>Guardian Name</th>
                                            <th class="hidden-480">Gender</th>
                                            <th class="hidden-480">Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
                                        @foreach($class_students as $class_student)
                                            <tr>
                                                    <td class="hidden">{{$class_student->id}}</td>
													<td>
														{{$class_student->first_name}}
													</td>
                                                    <td class="hidden-480">
														{{$class_student->middle_name}}
													</td>
                                                    <td>
														{{$class_student->last_name}}
													</td>
                                                    <td>
														{{$class_student->gaurdian_name}}
													</td>
                                                    <td class="hidden-480">
														{{$class_student->gender}}
													</td>
                                                    <td class="hidden-480">
                                                        @if($class_student->status==0)
                                                        <span class="label label-sm label-danger">Inactive</span>
                                                        @elseif($class_student->status==1)
                                                        <span class="label label-sm label-success">Active</span>
                                                        @endif
                                                    </td>
                                                    <td>
														<a title="View Detail" class="btn btn-xs btn-info" href="/super_admin/view_student_detail/{{$class_student->id}}">
																	<i class="ace-icon fa fa-eye bigger-130"></i>
																</a>	
                                                        </td>
												</tr>
                                       
                                        @endforeach
                                              
                                    </tbody>
								</table>
                               
                            </div>
					   </div>
                         @else
                            <div class="alert alert-block alert-danger">
							<a href="javascript:history.back()" class="btn btn-minier btn-dark pull-right"><i class="ace-icon fa fa-arrow-left icon-on-left"></i> &nbsp;<b>Go Back</b></a>    
                            <b>{{$school_name['school']}}&nbsp;&rArr;&nbsp;{{$class_name['class']}} Has No Students!...</b>
                            </div>
                        @endif
                    </div>
                </div>    
    </div>
<div class="space-30"></div>
<!-- /.main-content -->

@endsection

