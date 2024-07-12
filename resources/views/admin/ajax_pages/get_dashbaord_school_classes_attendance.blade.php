      
           
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
             });        
</script>
