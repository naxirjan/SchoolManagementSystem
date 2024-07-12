<div class="col-xs-12">
                          

<?php 
if(!empty($message))
{
?>
<br />
<div class="alert alert-success" >
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <b>
        <?php
            
            if($count==1){
                $count=$count." School ";
            }
            else if($count>1)
            {
                $count=$count." Schools";
            }

        echo " ".$holiday_name." ( Holiday ) Has Been Assigned To ".$count." Successfully!...";
        
        ?>
    </b>
    <br>
</div>
<?php
$count=0;
}
?>


                        @if(!empty($all_schools))


                        {!! Form::open(array("url"=>"/super_admin/assign_holiday_school_process",'id'=>'school_holiday_form',"method"=>"post","class"=>"form-horizontal","role"=>"form")) !!}
                        <hr />
                        <input type="hidden" id="holiday-id" value="<?php echo $holidays[0]['id']?>">
                        <input type="hidden" id="holiday-name" value="<?php echo $holidays[0]['title'];?>" />
                        
                        <!--Box One-->
                        <div class="col-xs-6 col-sm-5 pricing-box">
                            <div class="widget-box widget-color-blue">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter" id="school-header">  
                                        <?php
                                        $flag=false;
                                                  if (!empty($all_schools))
                                                  { 
                                                    foreach($all_schools as $key => $school)
                                                    {
                                                    if(! array_key_exists($key,$all_holidays))
                                                     { 
                                                       
                                                       $flag=false;
                                                    
                                                    }
                                                    else
                                                    {
                                                        $flag=true;
                                                    }
                                                    }
                                                  }

                                                    if($flag==true)
                                                    {
                                                        echo "<b>No School To Assign ".$holiday_name." Holiday!...</b>";
                                                    } 
                                                    else
                                                    {
                                                        echo "<b>Schools</b>";
                                                    }
                                              ?>
                                    </h5>
                                 </div>
                                <div class="widget-body">
                                    <input type="text" id="search_school" class="form-control search-query" placeholder="Search School">
                                    <div class="widget-main">
                                        
                                        <ul class="list-unstyled spaced2" id="all-schools">
                                           
                                            <?php
                                                  if (!empty($all_schools))
                                                  { 
                                                    foreach($all_schools as $key => $school)
                                                    {
                                                     if(! array_key_exists($key,$all_holidays))
                                                     { 
                                                       ?>
                                                        <li id='schools-row<?php echo $key;?>' data-order='<?php echo $key;?>'>
                                                            <label>
                                                            <input  school_id='<?php echo $key;?>' school_name='<?php echo $school;?>' type="checkbox" name='schools'  value="<?php echo $key;?>" class="ace ace-checkbox-2" >
                                                            <span class="lbl"> 
                                                                <b>
                                                                    <?php echo $school;?>   
                                                                </b> 
                                                            </span>
                                                    </label>
                                                             
                                                        </li>
                                                    <?php 
                                                    }
                                                    }
                                                  } 
                                              ?>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--Box One-->

                        <!--Box Two Buutons-->
                        <div class="center col-xs-6 col-sm-2 ">
                            <br />
                            <button class="btn btn-sm btn-success btn-block" id="btn-add-all">
                                <span class="bigger-110 no-text-shadow">Add All</span>
                            </button>

                                                                                                    

                            <button class="btn btn-sm btn-success btn-block" id="btn-add" style="display:none;">
                                <span class="bigger-110 no-text-shadow">Add</span>
                            </button>
                            <br />
                            <hr />

                            <button class="btn removeall  btn-sm btn-danger btn-block" id="btn-remove-all">
                                <span class="bigger-110 no-text-shadow">Remove All</span>
                            </button>

                            <button class="btn btn-sm btn-danger btn-block" id="btn-remove" style="display:none;">
                                <span class="bigger-110 no-text-shadow">Remove</span>
                            </button>

                            <br />
                            <hr />
                            <button class="btn btn-primary btn-block btn-sm" id="btn-assign-holiday" style="display:none;">
                                <span class="bigger-110 no-text-shadow">Assign Holiday</span>
                            </button>
                            <br /> <br />

                        </div>
                        <!--Box Two-->


                        <!--Box Three-->
                        <div class="col-xs-6 col-sm-5 pricing-box">
                            <div class="widget-box widget-color-blue">
                                <div class="widget-header">
                                    <h5 id="holiday-school-header" class="widget-title bigger lighter">
                                        <b>
                                           <?php
                                            
                                            if(isset($holiday_schools[0]->title))
                                            {    
                                               echo 'Holiday Assigned To Schools';
                                            }
                                            else
                                            {
                                                echo 'Holiday Has Not Assigned To Any School';
                                            }
                                        ?>
                                        </b>
                                    </h5>
                                </div>
                                
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <ul class="list-unstyled spaced2" id="holiday-school">        
                                        <?php
                                            if(isset($holiday_schools))
                                            {
                                                foreach($holiday_schools as $holiday_school)
                                                {  
                                                    ?>
                                                    <li data-order='<?php echo $holiday_school->sms_school_id;?>' id="schools-row<?php echo $holiday_school->sms_school_id;?>">
                                                        <label>
                                                            <input disabled school_id='<?php echo $holiday_school->sms_school_id?>' school_name='<?php echo $holiday_school->school;?>' type="checkbox" name='schools' value="<?php  echo $holiday_school->sms_school_id;?>"  class="ace ace-checkbox-2" >
                                                            <span class="lbl"> 
                                                                <b>
                                                                    <?php echo $holiday_school->school;?>  
                                                                </b> 
                                                            </span>
                                                    </label>
                                                    </li>
                                                    <input type="hidden" name="previous-holiday-school-ids" value="<?php echo $holiday_school->sms_school_id;?>" />
                                                    <?php
                                                }
                                            }
                                        ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Box Three-->   

                        {!! Form::close() !!}

                        @else
                            <br />
                                <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="ace-icon fa fa-times"></i>
                                </button>
                                <b>No Schools To Assign {{$holiday_name}} Holiday!...</b>
                            </div>

                        @endif

                    </div>