@extends('master/master')

@section('title')
User Profile
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

							<li class="active">User Profile</li>
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
											</select><div class="dropdown dropdown-colorpicker">		<a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="btn-colorpicker" style="background-color:#438EB9"></span></a><ul class="dropdown-menu dropdown-caret"><li><a class="colorpick-btn selected" href="#" style="background-color:#438EB9;" data-color="#438EB9"></a></li><li><a class="colorpick-btn" href="#" style="background-color:#222A2D;" data-color="#222A2D"></a></li><li><a class="colorpick-btn" href="#" style="background-color:#C6487E;" data-color="#C6487E"></a></li><li><a class="colorpick-btn" href="#" style="background-color:#D0D0D0;" data-color="#D0D0D0"></a></li></ul></div>
										</div>
										<span>&nbsp; Choose Skin</span>
									</div>

									<!-- /section:settings.skins -->

									<!-- #section:settings.navbar -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar">
										<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
									</div>

									<!-- /section:settings.navbar -->

									<!-- #section:settings.sidebar -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar">
										<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
									</div>

									<!-- /section:settings.sidebar -->

									<!-- #section:settings.breadcrumbs -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs">
										<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
									</div>

									<!-- /section:settings.breadcrumbs -->

									<!-- #section:settings.rtl -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl">
										<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
									</div>

									<!-- /section:settings.rtl -->

									<!-- #section:settings.container -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container">
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
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover">
										<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact">
										<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight">
										<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
									</div>

									<!-- /section:basics/sidebar.options -->
								</div><!-- /.pull-left -->
							</div><!-- /.ace-settings-box -->
						</div><!-- /.ace-settings-container -->

					
						<div class="page-header">
							<h1>
								User Profile Information
								
							</h1>
						</div>
                        
						<div class="row">
							<div class="col-xs-12">
								
								<div class="">
									<div id="user-profile-1" class="user-profile row" >
                                        
										<div class="col-xs-12 col-sm-4 center">
											<div>
												<!--profile.picture -->
												<span class="profile-picture" style="border-radius:50%;border:1px solid black">
													<img id="avatar" class="img-responsive" alt="No Image" src="{{asset('storage/user_profile_images/')}}/{{Auth::user()->profile_image}}" width="200" height="200" style="border-radius:50%;">
												</span>
                                                <!--profile.picture -->
												<div class="space-4"></div>

												<div class="width-60 label label-info label-xlg arrowed-in arrowed-in-right">
													<div class="inline position-relative">
														<a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
															
															<span class="white">{{ucfirst(Auth::user()->first_name)}}&nbsp;{{ucfirst(Auth::user()->last_name)}}</span>
														</a>
													</div>
												</div>
											</div>
                                            <div class="space-6"></div>
                                            <div class="width-60 label label-warning label-xlg arrowed-in arrowed-in-right">
			                                    <div class="inline position-relative">
			                                        <a href="/teacher/change_password" style="text-decoration: none;">
			                                            <span class="white">Change Password</span>
			                                        </a>
			                                    </div>
			                                </div>
		                                	<div class="space-6"></div>

										   @if(count(session('user_roles'))>1)  
                                        <!--User Roles-->    
                                        <div class="col-sm-12 infobox-container">
                                            <div class="space-6"></div>
                                           
                                            <h1 class="blue">
                                                Assigned Roles
                                            </h1>
                                            <h3><i class="ace-icon fa fa-key"></i>&nbsp;
                                            Switch Your Role
                                            </h3>
                                            
                                             @foreach (session('user_roles') as $user)
                                             @if(session('role_id')==$user->role_id)
                                                    <div class="infobox infobox-green" style="width:250px;">
                                                <div class="infobox-icon">
                                                    <i class="ace-icon fa fa-unlock"></i>
                                                </div>

                                                <div class="infobox-data">
                                                    <span class="infobox-data-number"><b>{{ucwords($user->role_type)}}</b></span>
                                                </div>
                                            </div>    
                                            @else
                                                    <div class="infobox infobox-red" style="width:250px";>
                                                <div class="infobox-icon">
                                                    <i class="ace-icon fa fa-lock"></i>
                                                </div>

                                                <div class="infobox-data">
                                                    <span class="infobox-data-number">{{ucwords($user->role_type)}}</span>
                                                    <div class="infobox-content"><a href="/switch_role/{{$user->role_id}}">Switch Role</a></div>
                                                </div>
                                            </div>    
                                            @endif
                                           @endforeach    
                                            <div class="space-6"></div>
									   </div>
										<!--User Roles--> 	
                                       @endif
                                        </div>

										<div class="col-xs-12 col-sm-7">
                                            <div class="space-12"></div>

											<!--User Profile Information-->
											<div class="profile-user-info profile-user-info-striped">
                                               
                                                <!--First Name-->
												<div class="profile-info-row">
													<div class="profile-info-name"> First Name </div>

													<div class="profile-info-value">
														<span class="editable editable-click" >{{ucfirst(Auth::user()->first_name)}}</span>
													</div>
												</div>
                                                
                                                @if(Auth::user()->middle_name)
                                                <!--Last Name-->
												<div class="profile-info-row">
													<div class="profile-info-name"> Middle Name </div>

													<div class="profile-info-value">
														<span class="editable editable-click" >{{ucfirst(Auth::user()->middle_name)}}</span>
													</div>
												</div>
                                                @endif
                                                
                                                
                                                <!--Surname-->
												<div class="profile-info-row">
													<div class="profile-info-name"> Last Name </div>

													<div class="profile-info-value">
														<span class="editable editable-click" id="age">{{ucfirst(Auth::user()->last_name)}}</span>
													</div>
												</div>
                                                
                                                
                                                <!--Email-->
												<div class="profile-info-row">
													<div class="profile-info-name"> Email </div>

													<div class="profile-info-value">
														<span class="editable editable-click" id="age">{{Auth::user()->email}}</span>
													</div>
												</div>
                                                
                                                <!--Gender-->    
												<div class="profile-info-row">
													<div class="profile-info-name"> Gender </div>

													<div class="profile-info-value">
														<span class="editable editable-click" id="signup">{{ucfirst(Auth::user()->gender)}}</span>
													</div>
												</div>
                                                
                                                <!--Qualification-->
												<div class="profile-info-row">
													<div class="profile-info-name">Qualification</div>

													<div class="profile-info-value">
														<span class="editable editable-click" >
                                                        {{session('degree_title')}}
                                                      
                                                        </span>
													</div>
												</div>
                                                
                                                <!--Qualification Description-->
												<div class="profile-info-row">
													<div class="profile-info-name">Qualification Description</div>

													<div class="profile-info-value">
														<span class="editable editable-click" >
                                                       {{session('degree_description')}}
                                                        </span>
													</div>
												</div>
                                                
                                                <!--Address-->
												<div class="profile-info-row">
													<div class="profile-info-name"> Address </div>

													<div class="profile-info-value">
														<span class="editable editable-click" >{{ucwords(Auth::user()->address)}}</span>
													</div>
												</div>
                                                
                                                
                                                <!--Status-->
												<div class="profile-info-row">
													<div class="profile-info-name"> Account Status </div>

													<div class="profile-info-value">
														<span class="editable editable-click" >
                                                        @if(Auth::user()->status==1)
                                                        Active    
                                                        @endif    
                                                        </span>
													</div>
												</div>
                                                
                                                <!--Account Role-->
												<div class="profile-info-row">
													<div class="profile-info-name"> Account Role </div>

													<div class="profile-info-value">
														<span class="editable editable-click green" >
                                                        @foreach (session('user_roles') as $user)
                                                            @if(session('role_id')==$user->role_id)
                                                                <b>{{ucwords($role=$user->role_type)}}</b>
                                                            @endif
                                                        @endforeach    
                                                        </span>
													</div>
												</div>
                                                
                                                @if(session('account_created_by_full_name'))
                                                 <!--Account Created By-->
												<div class="profile-info-row">
													<div class="profile-info-name"> Account Created By </div>

													<div class="profile-info-value">
														<span class="editable editable-click" >
                                                        {{ucwords(session('account_created_by_full_name'))}}
                                                        &nbsp;<small class="blue"><b> ( {{ucwords(session('account_created_by_role_type'))}} )</b></small>    
                                                        </span>
													</div>
												</div>
												<!--Account Created By-->
                                                @endif
												<!-- USER SCHOOLS START -->
												<?php
												if(session('user_schools'))
												{
													$admin_schools = array();
													$teacher_schools = array();

													foreach (session('user_schools') as $key => $value) 
													{
														if($value->role_id == 2)
														{
															$admin_schools[$value->school_id] = $value->school;
														}
														else
														{
															$teacher_schools[$value->school_id] = $value->school;
														}
													}
												}
												?>
												<?php
												if(session('user_schools'))
												{
													if($admin_schools)
													{
														?>
														<div class="profile-info-row">
															<div class="profile-info-name"> Admin Schools </div>
															<div class="profile-info-value">
																<?php
																foreach ($admin_schools as $key => $value) 
																{
																	?>
																	<span class="editable editable-click" >
																		<?php echo $value;?>
																	</span>
																	<br/>
																	<?php
																}

																?>
																
															</div>
														</div>
														<?php
													}
													if($teacher_schools)
													{
														?>
														<div class="profile-info-row">
															<div class="profile-info-name"> Teacher Schools </div>
															<div class="profile-info-value">
																<?php
																foreach ($teacher_schools as $key => $value) 
																{
																	if(session('myuser_schools')[3]['school_id'] == $key)
																	{
																		?>
																		<span class="editable editable-click" style="color: green">
																			<?php echo $value;?>
																		</span>
																		<br/>
																		<?php
																	}
																	else
																	{
																		?>
																		<span class="editable editable-click" >
																			<?php echo $value;?>
																			<a href="\teacher\switch_teacher_school\<?php echo $key;?>">&nbsp;&nbsp;&nbsp;(Switch School)
																			</a>
																		</span>
																		<br/>
																		<?php
																	}
																}
																?>
																
															</div>
														</div>
														<?php
													}
												}
												?>
												<!-- USER SCHOOLS END -->
											
                                            </div>
                                            <!--User Profile Information-->
											
											<div class="space-20"></div>
                                           
                                        </div>
                                        <div class="col-xs-12 col-sm-1"></div>
                                    </div>
								</div>

						
							
								<!-- PAGE CONTENT ENDS -->
							</div>
						</div>
					</div>
				</div>
			</div>					

@endsection

