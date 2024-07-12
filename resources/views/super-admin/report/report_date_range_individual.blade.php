<?php
   
        header("Content-Type:application/vnd.ms-excel; charset=utf-8");
        header("Content-type:application/x-msexcel; charset=utf-8");
        $file_name = "Date_Range_Individual_Report_".str_replace(' ', '_', $date_from)."_To_".str_replace(' ', '_', $date_to);
        header('Content-Disposition: attachment; filename="'.$file_name.'.xls"');
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
            <h2 align="center"><b>{{ $attendance['date_range']}}&nbsp;</b></h2>
      </td>
    </tr>
    <tr></tr>
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
            <td colspan="7" align="left"> {{ $attendance['school_name']}}  </td>
        </tr>

        <tr>
            <th bgcolor="#7c7c80" style="color:white"  align="left" colspan="3"><b> Class Name </b></th>
            <td  align="left" colspan="7"> {{ $attendance['class_name']  }}  </td>
        </tr>

     
        <tr>
            <th bgcolor="#7c7c80"  align="left" colspan="3" style="color:white"><b> Teachers</b></th>
            <td  align="left" colspan="7"> 
              <?php

                  $output = "";
                  $seperator = " , ";
                  foreach ($attendance['teachers'] as $key => $value) {
                    $output .= $value->teacher_names."".$seperator;
                    
                  }
                  $stllen = strlen($output);
                  echo substr($output,0,$stllen-2);
                

                ?>
            
            </td>
        </tr>
 
        <tr >
            <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Total Students</b></th>
            <td  align="left"> {{ $attendance['total_students'] }} </td>
        </tr>

      
        <tr>
            <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b>Attendance Dates</b></th>
            <td align="left"> {{ $attendance['date_range'] }}  </td>
        </tr>


    </tbody>
</table>


<?php
  $start_date = NULL;
  $end_date =  NULL;
?>
@foreach($attendance['total_range_days'] as $key=>$date)
 
  <?php
      
      $day = date('l',strtotime($date));

      
      if($day == $attendance['weekend']){
		  
		   if($date >= $start_date && $date <= $end_date && $day == $attendance['weekend']){
                continue;
            }
        ?>
          
          <table>
            <tbody style="text-align:center;">
              <tr></tr>
                <tr bgcolor="#660033">
                    <td colspan="7" class="text-warning" style="padding: 2px; text-align: center;">
                        <h5 style="color:white"><b>Date:</b> {{ date("d F Y",strtotime($date)) }} (Detail)</h5>
                    </td>
                </tr>  
               </tbody>
          </table>
    
         <table>
          <tbody style="text-align:center;">
             <tr >
                <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Date </b></th>
                <td  align="left"> {{ date("d F Y",strtotime($date.' ')) }} </td>
            </tr> 
            <tr >
                <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Status </b></th>
                <td  align="left"> Weekend Holiday  </td>
            </tr> 
            <tr >
                <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Description </b></th>
                <td  align="left"> This is a {{ $attendance['weekend'] }} that is school weekend off day </td>
            </tr> 
        </tbody>
        </table>
        <?php

      }
      else
      {
          foreach ($attendance['attendance_detail'] as $key => $attendance_detail_per_day) {
              foreach ($attendance_detail_per_day as $key => $attendance_detail_per_day_values) {

                  if($attendance_detail_per_day_values['date'] ==  $date){

                    ?>
                      <table>
                        <tbody style="text-align:center;">
                          <tr></tr>
                            <tr bgcolor="#660033">
                                <td colspan="7" class="text-warning" style="padding: 2px; text-align: center;">
                                    <h5 style="color:white"><b>Date:</b> {{ date("d F Y",strtotime($date)) }} (Detail)</h5>
                                </td>
                            </tr>  
                           </tbody>
                      </table>

                       <table>
                          <tbody style="text-align:center;">
                             
                             <tr >
                                <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Date </b></th>
                                <td  align="left"> {{ date("d F Y",strtotime($date)) }} </td>
                            </tr> 
                            <tr >
                                <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Attendance Taken </b></th>
                                <td  align="left"> {{ $attendance_detail_per_day_values['attendance_taken_by'] }}  </td>
                            </tr> 
                            <tr >
                                <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Total Students </b></th>
                                <td  align="left"> {{ $attendance_detail_per_day_values['class_total_students'] }} </td>
                            </tr> 
                            <tr>
                                <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Present </b></th>
                                <td  align="left">{{ $attendance_detail_per_day_values['present_students'] }}
                                                  &nbsp;&nbsp;&nbsp;
                                                  <?php 
                                                    $Persant = (int) $attendance_detail_per_day_values['present_students'];
                                                    echo "(".round(($Persant/$attendance_detail_per_day_values['class_total_students']*100))."%)";

                                                  ?> 
                                </td>
                            </tr> 
                            <tr >
                                <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Absent </b></th>
                                <td  align="left"> {{ $attendance_detail_per_day_values['absent_students'] }} 
                                                      &nbsp;&nbsp;&nbsp;
                                                    <?php 
                                                          $absent = (int) $attendance_detail_per_day_values['absent_students'];
                                                          echo "(".round(($absent/$attendance_detail_per_day_values['class_total_students']*100))."%)";
                                                    ?> 
                                </td>
                            </tr> 
                            <tr >
                                <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Attendance Taken </b></th>
                                <td  align="left"> {{ $attendance_detail_per_day_values['attendance_taken_by'] }}  </td>
                            </tr>
                        </tbody>
                        </table>  
                        <br />
                        <table border="2">
                          
                           <thead align="center">
                              <tr>
                                   <th style="text-align: center; color: white;"  bgcolor="#7c7c80">#</th>
                                   <th style="text-align: center; color: white;" bgcolor="#7c7c80">Full Name</th>
                                   <th style="text-align: center; color: white;" bgcolor="#7c7c80">Gender</th>
                                   <th style="text-align: center; color: white;" bgcolor="#7c7c80">Status</th>
                                   
                              </tr>

                                
                                      
                           </thead>
                            <tbody>
                              <?php $no = 1; ?>
                                @foreach ($attendance_detail_per_day_values['students_info'] as $key => $value)
                              
                                  <tr align="center">
                                      <td align="center">{{ $no++ }}</td>
                                      <td align="center">{{$value->first_name }} {{$value->last_name }} </td>
                                      <td align="center"> {{$value->gender}}</td>
                                      <td align="center" bgcolor="
                                          <?php
                                            if($value->attendance_status == 1){
                                                  echo 'lightgreen';
                                            }else{
                                                  echo '#da0b31';
                                            } 
                                                     
                                          ?> 

                                      ">
                                          <?php
                                            if($value->attendance_status == 1){
                                                  echo "<span>Present</span>";
                                            }else{

                                              echo "<span style='color:white;'>Absent</span>";
                                              echo "<br />";

                                              if(!empty($value->resion)){
                                                echo "<span style='color:white;'>".$value->resion."</span>";
                                               }

                                            }
                                                
                                             
                                          ?> 
                                      </td>
                                      
                                    </tr>
                              
                                  @endforeach
                               </tbody>

                      </table> 



                    <?php  
                    break 2;
                  }

              }
          }

		  $months = array(
				'January'=>1,
				'February'=>2,
				'March'=>3,
				'April'=>4,
				'May'=>5,
				'June'=>6,
				'July'=>7,
				'August'=>8,
				'September'=>9,
				'October'=>10,
				'November'=>11,
				'December'=>12,
		   );	

          foreach($attendance['holiday_recored'] as $key=>$holidays){
                foreach($holidays as $value){
                    if($date == $value['date'] ){

						if( date('n',strtotime($value['date'])) < $months[date('F',strtotime($end_date))] ){
							break 2;
					    }
                        if($start_date == $value['start_date'] && $end_date == $value['end_date']){
                          break 2;
                        }
                        ?>
                          <table>
                          <tbody style="text-align:center;">
                            <tr></tr>
                              <tr bgcolor="#660033">
                                  <td colspan="7" class="text-warning" style="padding: 2px; text-align: center;">
                                      <h5 style="color:white"><b>Date:</b> {{ date("d F Y",strtotime($date)) }}
                                      <b> To </b>
                                      <b>End: Date: </b> {{ date("d F Y",strtotime($value['end_date'])) }}
                                       (Detail)
                                      </h5>
                                  </td>
                              </tr>  
                             </tbody>
                          </table>
                           <table >
                            <tbody style="text-align:center;">
                             
                              <tr >
                                  <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Dates </b></th>
                                  <td  align="left"> 
                                    <b>{{ date("d F Y",strtotime($value['start_date'])) }}
                                     To 
                                    {{ date("d F Y",strtotime($value['end_date'])) }}</b>
                                  </td>
                              </tr> 
                              <tr >
                                  <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Status </b></th>
                                  <td  align="left"> Officale Holiday  </td>
                              </tr> 
                              <tr >
                                  <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Holiday Title </b></th>
                                  <td  align="left"> {{ $value['title'] }} </td>
                              </tr> 
                              <tr >
                                  <th bgcolor="#7c7c80" colspan="3" align="left" style="color:white"><b> Holiday Description </b></th>
                                  <td  align="left">{{ $value['description'] }}</td>
                              </tr>
                          </tbody>
                          </table>
                          <?php  
                          $start_date = $value['start_date'];
                          $end_date   = $value['end_date'];
                          break 2;

                    }
                }
          }




      }


  ?>

@endforeach

</table>



