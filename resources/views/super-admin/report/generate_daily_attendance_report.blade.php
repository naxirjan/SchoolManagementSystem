
<?php
    
        header("Content-Type:application/vnd.ms-excel; charset=utf-8");
        header("Content-type:application/x-msexcel; charset=utf-8");
        $attendance_date = str_replace(' ','_', $attendance_day);
        header("Content-Disposition: attachment; filename=Daily_Report_$attendance_date.xls;");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);

?>

                           <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="{{public_path('/assets/css/bootstrap.css')}}" />
        <link rel="stylesheet" href="{{public_path('/assets/css/font-awesome.css')}}" />
                          <!-- bootstrap & fontawesome -->
        


<table>
  <tr>
    <td colspan="7" bgcolor="#f5bb80"><h2 align="center"> <b><?php echo $attendance_day ?>&nbsp; </b></h2></td>
  </tr> <tr></tr>

  <tbody style="text-align:center;">
    <tr bgcolor="#1829a1" >
        <td colspan="7" class="text-warning">
            <h5 style="color:white" align="center"><b>Attendance Information For {{$school_name}} ( {{$class_name}} ) (Summary)</b> </h5>
        </td>
       </tr> 

    <tr>
        <th bgcolor="#7c7c80" style="color:white" colspan="3" align="left"><b> School Name </b></th>
        <td colspan="3" align="left"> {{$school_name}}  </td>
    </tr>

    <tr>
        <th bgcolor="#7c7c80" style="color:white"  align="left" colspan="3"><b> Class Name </b></th>
        <td  align="left" colspan="3"> {{$class_name}}  </td>
    </tr>

    <tr>
        <th bgcolor="#7c7c80"  align="left" colspan="3" style="color:white"><b> Teachers</b></th>
        <td  align="left" colspan="3"> <?php
                $seperator = " , ";
                $output = ""; 
            ?>
            @foreach($class_teachers as $class_teacher)
              <?php $output.=$class_teacher.$seperator;?>
                    
            @endforeach
            <?php echo trim($output,$seperator);?>
        </td>
    </tr>

    <tr>
        <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Attendance Taken By</b></th>
        <td colspan="3" align="left"> 
              {{$attendance_taken_by}}
        </td>
    </tr>

    <tr>
        <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Total Students</b></th>
        <td  colspan="3" align="left"> {{$all_students}}   </td>
    </tr>

   
    
    <tr>
        <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Present Students</b></th>
        <td colspan="3" align="left"> {{$present_students}} &nbsp; ({{$present_students/$all_students*100}})%   </td>
    </tr>

    
    <tr>
        <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Absent Students</b></th>
        <td colspan="3" align="left"> {{$absent_students}} &nbsp; ({{$absent_students/$all_students*100}})%  </td>
    </tr>
 
   
    <tr>
        <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b>Attendance Date</b></th>
        <td colspan="3" align="left"> {{$attendance_day}}&nbsp;  </td>
    </tr>
</tbody>
</table> 
<br/>
<table>
  <tr>
    <td colspan="7" bgcolor="#1829a1"> 
      <h5 style="color:white" align="center"><b>Attendance Information For {{$school_name}} ( {{$class_name}} ) (Detail)</b></h5>
    </td>
   </tr>
</table>

<table border="2">   
  <thead>
    <tr bgcolor="gray" style="color: white;">
      <th  align="center">#</th>
      <th  align="center">Full Name</th>
      <th align="center">Gender</th>
      <th align="center">Status</th>
      
    </tr>                 
  </thead>
  <tbody>
    <?php $count = 1; ?>
    @foreach($all_student_data as $student_data)

    <tr align="left">
        <td  align="center"><?php echo $count++;?></td>
        <td  align="center">{{$student_data['full_name']}} </td>
        <td  align="center"> {{$student_data['gender']}}</td>
        <td  align="center" bgcolor="<?php if($student_data['status'] == 1) {echo "lightgreen";}else{ echo "#da0b31";}?>"> 
          <?php
          if($student_data['status'] == 1)
          {
            echo "Present";
          }

          else if($student_data['status'] == 0)
          {
            echo "<span style='color:white;'>Absent<br />";
            if(!empty($student_data['absent_reason']))
            {
              echo $student_data['absent_reason']."</span>";
            }
          }
          ?>  
        </td>
       
    </tr>

    @endforeach
  </tbody>
</table>

