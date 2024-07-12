<?php

	header("Content-type: application/vnd-ms-excel");
	$report_month = str_replace(' ','_', $month_name);
	header("Content-Disposition: attachment; filename=Monthly_Combine_Report_$report_month.xls");
	header('Cache-Control: no-cache, no-store, must-revalidate');
	header('Pragma: no-cache');
	header('Expires: 0');

	if(isset($school_name))
	{
		?>
			<table border="2px solid black" width="100%"style="font-size: 12px; font-family: Arial Black;">
				<tr>
                	<td bgcolor="#FFA888" colspan="40" rowspan="2"><h2 align="left">Month: <?php echo $month_name;?></h2></td>
                </tr>	
			</table>
			<br/>
			<table border="1px solid black" width="100%" style="font-size: 12px; font-family: Arial Black;">
            	<tr>
                	<td bgcolor="gray" colspan="40" style="font-size: 14px; color: white">Monthly Combine Attendance (Summary)</td>
                </tr>
            	<tr>
                	<td bgcolor="#0f8070" colspan="4" style="color:white;">School Name</td>
                	<td colspan="36"><?php echo $school_name;?></td>
                </tr>
                <tr>
                	<td bgcolor="#0f8070" colspan="4" style="color:white;">Class Name</td>
                	<td colspan="36"><?php echo $class_name;?></td>
                </tr>
                <tr>
                	<td bgcolor="#0f8070" colspan="4" style="color:white;">Class Teachers</td>
                	<td colspan="36">
	                	<?php
	                        $name = "";

	                        foreach ($teachers as $key => $value)
	                        {
	                            if($value->middle_name == '')
	                            {
	                                $name .= $value->first_name.' '.$value->last_name.', ';
	                            }
	                            else
	                            {
	                                $name .= $value->first_name.' '.$value->middle_name.' '.$value->last_name.', ';
	                            }
	                        }

	                        echo rtrim($name,', ');
	                    ?>
                    </td>
                </tr>
                <tr>
                	<td bgcolor="#0f8070" colspan="4" style="color:white;">Total Students</td>
                	<td align="left" colspan="36"><?php echo $total_students;?></td>
                </tr>
                <tr>
                	<td bgcolor="#0f8070" colspan="4" style="color:white;">Month</td>
                	<td align="left" colspan="36"><?php echo ' '.$month_name;?></td>
                </tr>
            </table>
            <br/>
            <table border="1px solid black" width="100%" style="font-size: 12px; font-family: Arial Black;">
            	<tr>
                	<td bgcolor="#3d2ca5" colspan="40" style="font-size: 14px; color: white">Monthly Combine Attendance (Detail)</td>
                </tr>
            	<tr>
            		<th bgcolor="#e3e4e5" colspan="4">Name</th>
            		<th bgcolor="#e3e4e5" colspan="2">Gender</th>
            		<?php

            			for($i=1;$i<=$total_month_days;$i++)
            			{
            				?>
            				<th bgcolor="#e3e4e5" style="font-size: 13px"><?php echo $i;?></th>
            				<?php
            			}
            		?>
            		<th bgcolor="#e3e4e5">Total Present Days</th>
            		<th bgcolor="#e3e4e5">Total Absent Days</th>
            		<th bgcolor="#e3e4e5">Percentage</th>
            	</tr>
            	
            	<?php
            		foreach ($attendance as $key => $value) 
                    {
                    	?>
                    	<tr>
	                    	<td colspan="4"><?php echo $value['full_name'];?></td>
	                    	<td colspan="2" align="center"><?php echo $value['gender'];?></td>
	                		<?php
	                            if(is_array($value['student_attendance']))
	                            {
	                                $total_present_days = 0;
	                                $total_absent_days = 0;
	                                $total_working_days = 0;
	                                
	                                foreach ($value['student_attendance'] as $key1 => $status) 
	                                {

	                                    if($status === "Friday")
	                                    {
	                                        ?>
	                                        	<td style="color: #be9204; font-size: 11px">Weekend</td>
	                                        <?php
	                                    }
	                                    else if($status !== 0 && $status !== 1 && $status !== 'Friday' )
	                                    {
	                                        ?>
	                                        	<td style="color: #555555; font-size: 11px"><?php echo $status;?></td>
	                                        <?php
	                                    }
	                                    else if($status === 0)
	                                    {
	                                        $total_absent_days++;
	                                        $total_working_days++;
	                                        ?>
	                                        <td style="color:#ff0000; font-size: 11px">Absent</td>
	                                        <?php
	                                    }
	                                    elseif($status === 1)
	                                    {
	                                        $total_present_days++;
	                                        $total_working_days++;
	                                        ?>
	                                        <td style="color: #079639; font-size: 11px">Present</td>
	                                        <?php
	                                    }
	                                }
	                            }
	                        ?>
	                    	<td align="center"><?php echo $total_present_days; ?></td>
	                        <td align="center"><?php echo $total_absent_days; ?></td>
	                        <td align="center"><?php echo round(($total_present_days * 100)/$total_working_days,2).' %'; ?></td>
                    	</tr>
                    	<?php
                    }
            	?>
            </table>
		<?php
	}
?>