<?php
   
        header("Content-Type:application/vnd.ms-excel; charset=utf-8");
        header("Content-type:application/x-msexcel; charset=utf-8");
        $file_name = "Date_Range_Average_Report_From_".str_replace(' ', '_',date('d F Y',strtotime($date_from)))."_To_".str_replace(' ', '_',date('d F Y',strtotime($date_to)));
        header("Content-Disposition: attachment; filename=$file_name.xls");
               
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);

?>

                           <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="{{public_path('/assets/css/bootstrap.css')}}" />
        <link rel="stylesheet" href="{{public_path('/assets/css/font-awesome.css')}}" />
                          <!-- bootstrap & fontawesome -->
       
<table>
  <tbody style="text-align:center;">
    <tr bgcolor="#f78952">
      <td colspan="7" bgcolor="#CD853F;">
            <h2 align="center"><b>Date</b> From: {{date('d F Y',strtotime($date_from))}} To: {{date('d F Y',strtotime($date_to))}}</h2>
      </td>
    </tr> 
</tbody>
</table>


<table>
    <tbody style="text-align:center;">

        <tr bgcolor="#696969">
            <td colspan="7" class="text-warning" style="padding: 10px;margin: 10px;">
                <h4 align="center" style="color: white;"><b>Attendance Information (Summary)</b></h4>
            </td>
           </tr>
        <tr>
            <th bgcolor="#7c7c80" style="color:white" colspan="3" align="left"><b> School Name </b></th>
            <td colspan="7" align="left"> <b>{{$school_name}}  </td>
        </tr>

        <tr>
            <th bgcolor="#7c7c80"  align="left" colspan="3" style="color:white"><b> Teachers</b></th>
            <td  align="left" colspan="7"> 
              <b>
             <?php

                $output = "";
                $seperator = " , ";
                foreach ($school_teachers as $teacher) {
                  $output .= $teacher->first_name." ".$teacher->last_name.$seperator;
                }
                $strlen = strlen($output);
                echo substr($output,0,$strlen-2);
            ?>
          </b>
            </td>
        </tr>
 
       <tr>
            <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b>Date</b></th>
            <td align="left" colspan="7"><b>From: {{date('d F Y',strtotime($date_from))}} To: {{date('d F Y',strtotime($date_to))}}</td>
        </tr>


    </tbody>
</table>
<br /><br />
 <table>
                      <thead>
                        <tr>
                          <th style="color:white;background-color: #3d2ca5;text-align: center;"><b>Class Name</b></th>
                          <th style="color:white;background-color: #3d2ca5;text-align: center;"><b>Total Students</b></th>
                          <th style="color:white;background-color: #3d2ca5;text-align: center;"><b>Total Days</b></th>
                          <th style="color:white;background-color: #3d2ca5;text-align: center;"><b>Present Students</b></th>
                          <th style="color:white;background-color: #3d2ca5;text-align: center;"><b>Absent Students</b></th>
                          <th style="color:white;background-color: #3d2ca5;text-align: center;"><b>Average Present</b></th>
                          <th style="color:white;background-color: #3d2ca5;text-align: center;"><b>Average Absent</b></th>
                        </tr>
                      </thead>

                      <tbody>
                          @if(!empty($all_attendance))
                              @foreach($all_attendance as $key => $attendance)
                                  <?php 
                                  $total_working_days   = $attendance['total_working_days'];
                                  $present  = $attendance['present_days'];
                                  $absent    = $attendance['absent_days'];
                                  ?>
                                                
                            <tr style="text-align: center;">
                                <td>
                                    <b>{{$attendance['class']}}</b>
                                </td>
                                <td >
                                    <b>{{$attendance['total_class_students']}}</b>
                                </td>
                                <td >
                                    <b>{{$attendance['total_working_days']}}</b>
                                </td>
                                <td>
                                    <b>{{$attendance['present_days']}}</b>
                                </td>
                                <td >
                                    <b>{{$attendance['absent_days']}}</b>
                                </td>
                                <td style="background-color:green;color: white;">
                                    {{($present/$total_working_days)}}
                                </td>
                                <td style="background-color:red;color: white;">
                                    {{($absent/$total_working_days)}}
                                </td>
                            </tr>                                                
                            @endforeach
                        @endif
                          </tbody>
                      </table>
 
