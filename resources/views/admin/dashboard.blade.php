@extends('master/master')

@section('title')
School Admin Dashboard
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
							<li class="active">Admin Dashboard</li>
						</ul><!-- /.breadcrumb -->
						<span class="pull-right">
							
							<span class="label label-success arrowed-in arrowed-in-right">
									You Are Currently Logged In As School Admin 
									|<?php
                                    	foreach (session('myuser_schools') as $key => $value)
						                {
						                    if($key == session('role_id'))
						                    {
						                    	?>
						                    	 
						                    	<?php
						                        echo $value['school_name'];
						                        ?>
						                        
						                        <?php
						                    }
						                }
						            ?>
						            </span>
						</span>
					
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
						<div class="row page-header" >
							<div class="col-sm-12">
								<h1 style="display: inline;">
								<strong>
									School Admin Dashboard
									<i class="ace-icon fa fa-angle-double-right"></i>
									<span id="current_date_span"> {{date('d F Y',strtotime($current_date))}} </span>
								</strong>
								
							</h1>
                            @if(!empty($class_result))    
							<span class=" col-sm-3" style="float: right;margin-right:10px; " >
		                            <div class="input-group">
		                                <input style="text-align: center;font-weight: bold;color:black; " class="form-control date-picker" id="selected_date" type="text" data-date-format="dd MM yyyy" value="<?php echo date("d F Y")?>" placeholder="Enter attendance date" style="color:black;font-weight:bold;font-size:13px;">
		                                <span class="input-group-addon">
		                                    <i class="fa fa-calendar bigger-110"></i>
		                                </span>
		                        	</div>
		                    </span>
                            @endif
                              
						</div>
                        </div>    
						


						
						@if(session('forgot_pass_message_update'))
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="ace-icon fa fa-times"></i>
                            </button>
                            <strong>
                                {{ session('forgot_pass_message_update') }}
                            </strong>
                            <br>
                        </div>
                        @endif
                        
                        <div id="ajax_response">
                        		
                        	
                        	
	                        @if(!empty($school_weekend) || (!empty($school_holiday)))
                                @if($school_weekend[0]->value == date('l',strtotime($current_date)))

                                <div class="row">
                                        <div class="alert alert-info">
                                            <span class="header smaller lighter">
                                            <i class="ace-icon fa fa-bullhorn"></i>
                                            <b>Weekend:&nbsp;
                                                {{$school_weekend[0]->value}}
                                            </b>
                                           </span>
                                            <br/>
                                            School Is Closed Due To The {{$school_weekend[0]->value}} !...
                                        </div>
</div>
                                @elseif(!empty($school_holiday))			

                                    <div class="row">
                                        <div class="alert alert-info">
                                            <span class="header smaller lighter">
                                            <i class="ace-icon fa fa-bullhorn"></i>
                                            <b>Holiday:&nbsp;
                                                {{$school_holiday[0]->title}}
                                            </b>
                                            </span>
                                            <br/>
                                            {{$school_holiday[0]->description}}
                                        </div>
</div>
                                @endif
							@endif
							
						   @if(empty($class_result))
							
                                <div class="row">
							<div class="alert alert-danger">
			            		<span class="header smaller lighter">
			                	<h5>  
			                		  <b>
			                		  <?php
			                		  	$schools=session('myuser_schools');
						                echo $schools[2]['school_name'];
						              ?>
						          	  Has No Classes !... 
						          	  </b>
						        </h5> 
								</span>
			                </div>
							</div>
							 @endif
							
							
                             @if(!empty($class_result)) 
                             <?php
                                    $totals=0;
                                    $presents=0;
                                    $absents=0;
                                    $percentage=0;
                            
                                    foreach($class_result as $class_name=> $class_info)
                                    {
                                        $presents+=count($class_info['present_students']);
                                        $absents+=count($class_info['absent_students']); 
                                        
                                    }
                                    $totals=($presents+$absents);
                                    if(!empty($totals))
                                    {
                                        $persentage=(($presents/$totals)*100);
}

                                ?>
				            <div class="row">

							 <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        {{$totals}}
                                    </h3>
                                    <p>
                                        Total Students
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ace-icon fa fa-users"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-grass">
                                <div class="inner">
                                    <h3>
                                         {{$presents}}
                                    </h3>
                                    <p>
                                        Present Students
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ace-icon fa fa-user"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        {{$absents}}
                                    </h3>
                                    <p>
                                        Absent Students
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ace-icon fa fa-user"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        {{$percentage}}
                                    </h3>
                                    <p>
                                         Attendace Percentage
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ace-icon fa fa-bar-chart-o"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->


							 </div>

				            <div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
                                
                                <?php
                                //    echo "<pre>";
                                   // print_r($class_result);
                                ?>

									@if(!@empty($class_result))	
									<div class="row">

										@foreach($class_result as $class_name=> $class_info)

										<?php

										$total_attendance = count($class_info['absent_students'])+count($class_info['present_students']);
										?>
										<div class="col-xs-6 col-sm-3" style="margin-top:20px">
										<div class="widget-box widget-color-blue">
											<div class="widget-header">
												<center><h5 class="class_name" class_name="{{ $class_name }}" class="widget-title bigger lighter"><b>{{ $class_name }}</b></h5></center>
											</div>

											<div class="widget-body">
												<div class="widget-main" style="overflow: auto;height: 300px">

													<div class="price center">
														<h3><b>
														Attendance
														<?php 
															 $percentage=0;
															if(!empty($class_info['present_students']) && !empty($class_info['total_students']))
                                                            {
															 
                                                                if(!empty($total_attendance))
                                                                {
                                                                  $percentage = count($class_info['present_students'])/$total_attendance*100;  
                                                                }    
                                                                
                                                                	
												            echo round($percentage)."%";
															
                                                            
                                                            }else{
																echo "0%";
															}
															
														?>
														</b>
													</h3>
													</div>
													<table class="table table-responsive table-bordered">
	                            						<tr>
	                            							<td><i class="ace-icon fa fa-users purple"></i>
															Total Teachers</td>
	                            							<td class="center"> <b>{{ $class_info['total_teachers'] }}</b></td>
	                            						</tr>
	                            						
	                            						<tr>
                                                            <td><i class="ace-icon fa fa-users orange"></i>
                                                                Total Students</td>
                                                                
                                                            <td class="center"><b>{{$total_attendance}}</b></td>
                                                        </tr>

	                            						<tr>
	                            			        <td><i class="ace-icon fa fa-check green"></i>
															Total Present Students&nbsp;
															@if(count($class_info['present_students']) !=0)
															<a href="#" style="float: right;text-decoration: none;" current_date="<?php echo $current_date ?>" class_school_id="<?php echo $class_info['class_school_id']?>" image_path="<?php echo $class_info['image_path'] ?>" status="1" class="students_dashboard"><b>| More Detail</b></a>
															@endif
															
												    </td>
	                            							<td class="center"> <b><?php echo count($class_info['present_students']); ?></b>
	                            							</td>
	                            						</tr>
	                            						<tr>
	                            							<td><i class="ace-icon fa fa-times red"></i>
															Total Absent Students &nbsp;@if(count($class_info['absent_students']) !=0)

															 <a href="#" style="float: right;text-decoration: none;" current_date="<?php echo $current_date ?>" class_school_id="<?php echo $class_info['class_school_id']?>" image_path="<?php echo $class_info['image_path'] ?>"  status="0" class="students_dashboard"><b>| More Detail</b></a>
															@endif</td>
	                            							<td class="center"><b><?php echo count($class_info['absent_students']); ?></b>

															</td>
	                            						</tr>
	                            						
	                            					</table>	
													
												</div>

												
											</div>
										</div>
										</div>
										@endforeach
									</div>
									
									@endif
					</div>

								<!-- PAGE CONTENT ENDS -->
							</div>
                            @endif
                                
                                
                        <div class="modal fade" id="modalStudents" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					          <div class="modal-dialog modal-dialog-centered" role="document">
					            <div class="modal-content">
					              <div class="modal-header">
					                <h5 class="modal-title" id="modal-title"></h5>
					               
					              </div>
					              <div class="modal-body" id="all_students">
					               

					              </div>
					              <div class="modal-footer">
					                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					                
					              </div>
					            </div>
					          </div>
					        </div>
						</div><!-- /.row -->
					
                    </div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
			<div class="space-20"></div>

			<script type="text/javascript">
				
				$(document).ready(function(){
					 
				  $(".students_dashboard").click(function(e){
				  	e.preventDefault();
				  	
				  	var class_name 		=  $(".class_name").attr("class_name");
				  	var class_school_id =  $(this).attr("class_school_id");
				  	var current_date =  $(this).attr("current_date");
				  	var status 			=  $(this).attr("status");
				  	var image_path 			=  $(this).attr("image_path");
				  	
				  	$.ajax({
					  url:'get_present_students_for_dashboard',
					  type:"POST",
					  data:{
					  _token:'{{csrf_token()}}',
					  status:status,
					  image_path:image_path,
					  class_name:class_name,
					  class_school_id:class_school_id,
					  current_date:current_date,
					
					  },
					  success:function(data)
					    {
					       $("#modalStudents").modal('show');
					       $('#all_students ').html(data);
					    },
					  });

				  });

				
				$(document).on("change","#selected_date",function(e){
					 
					 var selected_date = $("#selected_date").val();
					 $("#current_date_span").html(selected_date);
					 var date_change = '';
					  
					  $.ajax({
					  url:'/admin/dashboard',
					  type:"GET",
					  data:{
					  _token:'{{csrf_token()}}',
					  selected_date:selected_date,
					  date_change:true,
					  },
					  success:function(data)
					    {
                          $("#ajax_response").html(data);
					    },

					  });

					});	
				
				});
			</script>
@endsection