<?php
	header("Content-type: application/vnd-ms-excel");
    $file_name = "Student_Report_(".$student_name.")_From_".str_replace(' ', '_', $date_from)."_To_".str_replace(' ', '_', $date_to);
    header('Content-Disposition: attachment; filename="'.$file_name.'.xls"');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
?>
	<table border="2px solid black" width="100%"style="font-size: 12px; font-family: Arial Black;">
		<tr>
        	<td bgcolor="#FFA888" colspan="<?php echo count($dates)+9; ?>" rowspan="2">
        		<h2 align="left">Date: <?php 
        			echo 'From '.date('d F Y',strtotime($date_from)).' To '.date('d F Y',strtotime($date_to));
                    ?>
                </h2>
            </td>
        </tr>	
	</table>
	<br/>
	<table border="1px solid black" width="100%" style="font-size: 12px; font-family: Arial Black;">
        <tr>
            <td bgcolor="gray" colspan="<?php echo count($dates)+9; ?>" style="font-size: 14px; color: white">
                Student Report (Summary)
            </td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Student Name</td>
            <td colspan="<?php echo count($dates)+5 ;?>"><?php echo $student_name; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Guardian Name</td>
            <td colspan="<?php echo count($dates)+5 ;?>"><?php echo $gaurdian_name; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Guardian Cell#</td>
            <td colspan="<?php echo count($dates)+5 ;?>" align='left'><?php echo '0'.$gaurdian_contact_number; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Gender</td>
            <td colspan="<?php echo count($dates)+5 ;?>"><?php echo $gender; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Date of Birth</td>
            <td colspan="<?php echo count($dates)+5 ;?>" align='left'><?php echo $date_of_birth; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Address</td>
            <td colspan="<?php echo count($dates)+5 ;?>"><?php echo $address; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">School Name</td>
            <td colspan="<?php echo count($dates)+5 ;?>"><?php echo $school_name; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Class Name</td>
            <td colspan="<?php echo count($dates)+5 ;?>"><?php echo $class_name; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Class Teachers</td>
            <td colspan="<?php echo count($dates)+5 ;?>">
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
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Date</td>
            <td align="left" colspan="<?php echo count($dates)+5; ?>">
                <b><?php
                    echo 'From '.date('d F Y',strtotime($date_from)).' To '.date('d F Y',strtotime($date_to));
                ?></b>
            </td>
        </tr>
        
        <?php
            $total_working_days = 0;
            $total_present_days = 0;
            $total_absent_days  = 0;
            $total_holidays     = 0;
            $total_weekends     = 0;
            $percentage         = 0;

            if(!empty($attendance))
            {
                foreach ($attendance as $key => $value) 
                {
                    foreach($value['student_attendance'] as $date => $status)
                    {
                        if($status === "Friday")
                        {
                            $total_weekends++;
                        }
                        else if($status === 0)
                        {
                            $total_working_days++;
                            $total_absent_days++;   
                        }
                        elseif($status === 1)
                        {
                            $total_working_days++;
                            $total_present_days++;
                        }
                        else if($status !== 0 && $status !== 1 && $status !== 'Friday' )
                        {
                            $total_holidays++;
                        }
                    }
                }

                $percentage = round(($total_present_days * 100)/$total_working_days,2).' %';
            }
        ?>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Total School Days</td>
            <td align="left" colspan="<?php echo count($dates)+5 ;?>"><?php echo $total_working_days; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Total Present Days</td>
            <td align="left" colspan="<?php echo count($dates)+5 ;?>"><?php echo $total_present_days; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Total Absent Days</td>
            <td align="left" colspan="<?php echo count($dates)+5 ;?>"><?php echo $total_absent_days; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Weekends</td>
            <td align="left" colspan="<?php echo count($dates)+5 ;?>"><?php echo $total_weekends; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Holidays</td>
            <td align="left" colspan="<?php echo count($dates)+5 ;?>"><?php echo $total_holidays; ?></td>
        </tr>
        <tr>
            <td bgcolor="#0f8070" colspan="4" style="color:white;">Percentage</td>
            <td align="left" colspan="<?php echo count($dates)+5 ;?>"><?php echo $percentage; ?></td>
        </tr>
    </table>
    <br/>
    <table border="1px solid black" width="100%" style="font-size: 12px; font-family: Arial Black;">
        <tr>
            <td bgcolor="#3d2ca5" colspan="<?php echo count($dates)+9;?>" style="font-size: 14px; color: white">Student Report (Detail)</td>
        </tr>
        <tr>
            <th bgcolor="#e3e4e5" colspan="4">Name</th>
            <th bgcolor="#e3e4e5" colspan="2">Gender</th>
            <?php
                foreach($dates as $date_key => $date_value)
                { 
                    ?>
                    <th bgcolor="#e3e4e5" style="font-size: 13px">
                        <b><?php echo date("M-d",strtotime($date_key));?></b>
                    </th>
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
                    <td colspan="4"><?php echo $value['full_name']; ?></td>
                    <td colspan="2" align="center"><?php echo $value['gender']; ?></td>
                    <?php
                        if(is_array($value['student_attendance']))
                        {
                            foreach ($value['student_attendance'] as $key1 => $status) 
                            {
                                if($status === "Friday")
                                {
                                    ?>
                                    <td style="color: #be9204; font-size: 11px">Weekend</td>
                                    <?php
                                }
                                else if($status === 0)
                                {
                                    ?>
                                    <td style="color:#ff0000; font-size: 11px">Absent</td>
                                    <?php
                                }
                                elseif($status === 1)
                                {
                                    ?>
                                    <td style="color: #079639; font-size: 11px">Present</td>
                                    <?php
                                }
                                else if($status !== "")
                                {
                                    ?>
                                    <td style="color: #555555; font-size: 11px"><?php echo $status; ?></td>
                                    <?php
                                }
                            }
                        }
                    ?>
                    <td align="center"><?php echo $total_present_days; ?></td>
                    <td align="center"><?php echo $total_absent_days; ?></td>
                    <td align="center"><?php echo $percentage; ?></td>
                </tr>
                <?php
            }
        ?>
    </table>