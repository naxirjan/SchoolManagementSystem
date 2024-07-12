<?php

	  header("Content-Type:application/vnd.ms-excel; charset=utf-8");
        header("Content-type:application/x-msexcel; charset=utf-8");
        header("Content-Disposition: attachment; filename=Yearly_Report_".$full_year.".xls");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);

	
		?>




			<table border="2px solid black" width="100%"style="font-size: 12px; font-family: Arial Black;">
				<tr>
                	<td bgcolor="#FFA888" colspan="17" rowspan="2"><h2 align="left"><?php echo $school_name." (".$class_name.") Attendance Report Of ".$full_year;?></h2></td>
                </tr>	
			</table>
			<br/>

			 <table border="1px solid black" width="100%" style="font-size: 12px; font-family: Arial Black;">
            	<tr>
                	<td bgcolor="#3d2ca5" colspan="17" style="font-size: 14px; color: white">Class Attendance Rate</td>
                </tr>
            	<tr>
            		<th bgcolor="#e3e4e5" colspan="4">Month Names</th>
            		
            		
            				<th bgcolor="#e3e4e5" style="font-size: 13px">Janaury</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">February</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">March</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">April</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">May</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">June</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">July</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">August</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">September</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">October</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">November</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">December</th>
		            		<th bgcolor="#e3e4e5">Over All</th>
            	</tr>
            	
            				
                    	<tr>
	                    	<td colspan="4">Number Of Working Days</td>
	                    	
						<?php $count = 0; ?>
	                   	  <?php $overall_working_days = 0 ?>
	                        @foreach($all_attendance as $val)
	                            <td>{{$val['total_attendance']}}</td>
	                            
	                 	<?php $overall_working_days += $val['total_attendance'] ?>
	                 	@endforeach
                           <td> {{$overall_working_days}} </td>

                    	</tr>

                    	<tr>
	                    	<td colspan="4">Average Attendance Rate</td>
	                    	
							 
                                 <?php $sub_avr = 0; ?>
                                @foreach($all_attendance as $val)
                                <td>
                                	 @if(!empty($val['month_present_attendance']) AND $val['total_attendance'])
                                        <?php $count++; ?>
                                        <?php echo ($val['month_present_attendance']/$val['total_attendance']); ?>
                                        <?php $sub_avr += round($val['month_present_attendance']/$val['total_attendance']); ?>
                                        @endif
                                </td>
                                
                                @endforeach
	                   	  
                           <td> {{substr($sub_avr/$count,0,4)}} </td>

                    	</tr>
                    
                    	</table>
		<br />

			
            <table border="1px solid black" width="100%" style="font-size: 12px; font-family: Arial Black;">
            	<tr>
                	<td bgcolor="#3d2ca5" colspan="17" style="font-size: 14px; color: white">Student Attendance Rate</td>
                </tr>
            	<tr>
            		<th bgcolor="#e3e4e5" colspan="4">Full Name</th>
            		
            		
            				<th bgcolor="#e3e4e5" style="font-size: 13px">Janaury</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">February</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">March</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">April</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">May</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">June</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">July</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">August</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">September</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">October</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">November</th>
            				<th bgcolor="#e3e4e5" style="font-size: 13px">December</th>
		            		<th bgcolor="#e3e4e5">Over All</th>
			            	</tr>
			            	<?php
			                $present = 0;
			                $absent  = 0;
			                $jan = 0;
			                $feb = 0;
			                $mar = 0;
			                $apr = 0;
			                $may = 0;
			                $jun = 0;
			                $jul = 0;
			                $aug = 0;
			                $sep = 0;
			                $oct = 0;
			                $nov = 0;
			                $dec = 0;
			                $over_all_month = 0;
			               ?>
            				@foreach($myattendance as $attendance)
                    	<tr>
	                    	<td colspan="4"><?php echo $attendance['full_name'];?></td>
	                    	
						<td>
							@if(!empty($attendance['jan']))
                        	@if(is_array($attendance['jan']))
                            	<?php $over_all_month.=1; ?>
                            	@foreach($attendance['jan'] as $status)

                                @if($status == 1)
                                   <?php $present++; ?>
                                   @elseif($status == 0)
                                   <?php $absent++;?>
                                   @endif
                                @endforeach
                                <?php 
                                 
                                $jan =  round(($present/($present+$absent)*100));
                                echo $jan;
                                echo '%';
                            $present = 0;
                            $absent = 0;
                            ?>

                        @endif
                        @endif
						</td>
	                    
	                    <td>
	                         
	                         @if(!empty($attendance['feb']))
                                @if(is_array($attendance['feb']))
                                    @foreach($attendance['feb'] as $status)

                                        @if($status == 1)
                                           <?php $present++; ?>
                                           @elseif($status == 0)
                                           <?php $absent++;?>
                                           @endif
                                        @endforeach
                                        <?php 
                                        
                                        $feb =  round(($present/($present+$absent)*100));
                                        echo $feb;
                                        echo '%';
                                    $present = 0;
                                    $absent = 0;
                                    ?>

                                @endif
                                @endif

	                   </td>

	                   <td>
	                        
	                        @if(!empty($attendance['mar']))
                                @if(is_array($attendance['mar']))
                                    @foreach($attendance['mar'] as $status)

                                        @if($status == 1)
                                           <?php $present++; ?>
                                           @elseif($status == 0)
                                           <?php $absent++;?>
                                           @endif
                                        @endforeach
                                        <?php
                                        $mar = round(($present/($present+$absent)*100));
                                        echo $mar;
                                        echo '%';
                                    $present = 0;
                                    $absent = 0;
                                    ?>

                                @endif
                                @endif	

	                   </td>

	                   <td>
	                        
	                        @if(!empty($attendance['apr']))
                                @if(is_array($attendance['apr']))
                                    @foreach($attendance['apr'] as $status)

                                        @if($status == 1)
                                           <?php $present++; ?>
                                           @elseif($status == 0)
                                           <?php $absent++;?>
                                           @endif
                                        @endforeach
                                        <?php
                                        $apr = round(($present/($present+$absent)*100));
                                        echo $apr;
                                        echo '%';
                                    $present = 0;
                                    $absent = 0;
                                    ?>

                                @endif
                                @endif 	

	                   </td>


	                   <td>
	                   @if(!empty($attendance['may']))
                        @if(is_array($attendance['may']))
                            @foreach($attendance['may'] as $status)

                                @if($status == 1)
                                   <?php $present++; ?>
                                   @elseif($status == 0)
                                   <?php $absent++;?>
                                   @endif
                                @endforeach
                                    <?php
                                $may = round(($present/($present+$absent)*100));
                                echo $may;
                                echo '%';
                            $present = 0;
                            $absent = 0;
                            ?>

                        @endif
                        @endif      	

	                   </td>

	                   <td>
	                       
	                       @if(!empty($attendance['jun']))
                                    <?php $over_all_month=2; ?>
                                    @endif

                                    @if(!empty($attendance['jun']))
                                    @if(is_array($attendance['jun']))
                                        @foreach($attendance['jun'] as $status)
                                            @if($status == 1)
                                               <?php $present++; ?>
                                               @elseif($status == 0)
                                               <?php $absent++;?>
                                               @endif
                                            @endforeach
                                            <?php
                                            $jun = round(($present/($present+$absent)*100));
                                            echo $jun;
                                            echo '%';
                                        $present = 0;
                                        $absent = 0;
                                        ?>

                                    @endif
                                    @endif  	

	                   </td>

	                   <td>
	                         
	                         @if(!empty($attendance['jul']))
                                    @if(is_array($attendance['jul']))
                                        @foreach($attendance['jul'] as $status)
                                            @if($status == 1)
                                               <?php $present++; ?>
                                               @elseif($status == 0)
                                               <?php $absent++;?>
                                               @endif
                                            @endforeach
                                            <?php
                                            $jul = round(($present/($present+$absent)*100));
                                            echo $jul;
                                            echo '%';
                                        $present = 0;
                                        $absent = 0;
                                        ?>
                                    @endif
                                    @endif	

	                   </td>

	                   <td>
	                        
	                         @if(!empty($attendance['aug']))
                                @if(is_array($attendance['aug']))
                                    @foreach($attendance['aug'] as $status)
                                        @if($status == 1)
                                           <?php $present++; ?>
                                           @elseif($status == 0)
                                           <?php $absent++;?>
                                           @endif
                                        @endforeach
                                        <?php
                                        $aug = round(($present/($present+$absent)*100));
                                        echo $aug;
                                        echo '%';
                                    $present = 0;
                                    $absent = 0;
                                    ?>
                                @endif
                                @endif 
	                   </td>

	                   <td>
	                         
	                          @if(!empty($attendance['sep']))
                                    @if(is_array($attendance['sep']))
                                        @foreach($attendance['sep'] as $status)
                                            @if($status == 1)
                                               <?php $present++; ?>
                                               @elseif($status == 0)
                                               <?php $absent++;?>
                                               @endif
                                            @endforeach
                                            <?php
                                            $sep = round(($present/($present+$absent)*100));
                                            echo $sep;
                                            echo '%';
                                        $present = 0;
                                        $absent = 0;
                                        ?>
                                    @endif
                                    @endif

	                   </td>

	                   <td>
	                         	
	                         	 @if(!empty($attendance['oct']))
                                        @if(is_array($attendance['oct']))
                                            @foreach($attendance['oct'] as $status)
                                                @if($status == 1)
                                                   <?php $present++; ?>
                                                   @elseif($status == 0)
                                                   <?php $absent++;?>
                                                   @endif
                                                @endforeach
                                                <?php
                                                $oct = round(($present/($present+$absent)*100));
                                                echo $oct;
                                                echo '%';
                                            $present = 0;
                                            $absent = 0;
                                            ?>
                                        @endif
                                        @endif

	                   </td>

	                   <td>
	                      
	                       @if(!empty($attendance['nov']))
                                @if(is_array($attendance['nov']))
                                    @foreach($attendance['nov'] as $status)
                                        @if($status == 1)
                                           <?php $present++; ?>
                                           @elseif($status == 0)
                                           <?php $absent++;?>
                                           @endif
                                        @endforeach
                                        <?php
                                        $nov = round(($present/($present+$absent)*100));
                                        echo $nov;
                                        echo '%';
                                    $present = 0;
                                    $absent = 0;
                                    ?>
                                @endif
                                @endif

	                   </td>

	                   <td>
	                       
	                       @if(!empty($attendance['dec']))
                                @if(is_array($attendance['dec']))
                                    @foreach($attendance['dec'] as $status)
                                        @if($status == 1)
                                           <?php $present++; ?>
                                           @elseif($status == 0)
                                           <?php $absent++;?>
                                           @endif
                                        @endforeach
                                        <?php
                                        $dec = round(($present/($present+$absent)*100));
                                        echo $dec;
                                        echo '%';
                                    $present = 0;
                                    $absent = 0;
                                    ?>
                                @endif
                                @endif 
                        </td>
                            	<?php $over_all_percent = round(($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec)/($count*100)*100)?>
                    	<td style="color:white" bgcolor="<?php
                                                    if($over_all_percent >= 80)
                                                    {echo "green";}
                                                    else
                                                    {
                                                        echo "red";
                                                    }
                                                    ?>"> 
                    		{{$over_all_percent}}% 
                    	</td>


                           
                    	</tr>
                    	@endforeach
                    	</table>
		