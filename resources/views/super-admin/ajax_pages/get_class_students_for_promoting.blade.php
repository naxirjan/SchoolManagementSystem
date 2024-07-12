               <hr />
@if(!empty($message))
<div class="alert alert-block alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <span><b>
            <?php echo $count;?> Promoted To (
            <?php echo $new_school_name;?> &rArr;
            <?php echo $new_class_name;?>) Successfully!...</b></span>
            <?php $count=0;?>
</div>
@endif

<span id="show_message"></span>
                <!--Box One-->
                <div class="col-xs-6 col-sm-5 pricing-box">
                    <div class="widget-box widget-color-blue">
                        <div class="widget-header">
                            <h5 class="widget-title bigger lighter" id="current_class_students_header">
                                <?php 

                            
                                    if(!empty($previous_class_students))
                                    {
                                     ?>
                                        <b>Students
                                        ({{$school_information['school']}}&nbsp;&rArr;&nbsp;{{$class_information['class']}})
                                        </b>
                                            <?php    
                                    }
                                    else
                                    {
                                        ?>
                                        <b>No Students To Promote</b>
                                    <?php    
                                        }
                                        ?>
                            </h5>
                        </div>

                        <div class="widget-body">
                            <input type="text" id="search_student" class="form-control search-query" placeholder="Search Student To Promote">
                            <div class="widget-main" id="scroll_bar" style="height: 370px;">
                                
                                
                                <ul class="list-unstyled spaced2" id="current_class_students" >
                                    <?php

                                    if (!empty($previous_class_students))
                                    {
                                        foreach($previous_class_students as $student)
                                        {
                                       ?>
                                        <li id='student-row<?php echo $student->id;?>' data-order='<?php echo $student->id;?>'>
                                            <label><input student_id='<?php echo $student->id;?>' student_name='<?php echo $student->first_name.' '.$student->middle_name.' '.$student->last_name;?>' type="checkbox" class='ace ace-checkbox-2' name='students' value="<?php echo $student->id;?>" />
                                            <span class="lbl">
                                                <b><?php echo $student->first_name;?>&nbsp;<?php echo $student->middle_name;?> &nbsp;<?php echo $student->last_name;?></b>
                                            </span>
                                        </label>
                                        </li>
                                        <?php 
                                        }
                                    }

                                    ?>
                                </ul>
                            </div>

                        </div>
                    </div>
</div>
                <!--Box One-->
            
            
                <!--Box Two Buttons-->
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
                    <button class="btn btn-primary btn-block btn-sm" id="btn-promote-class-students" style="display:none;">
                        <span class="bigger-140 no-text-shadow">Promote</span>
                    </button>
                    <br /> <br />

                </div>
                <!--Box Two-->
    
                
                <!--Box Three-->
                <div class="col-xs-6 col-sm-5 pricing-box">
                    <div class="widget-box widget-color-blue">
                        <div class="widget-header">
                            <h5 id="promote_to_class_students_header" class="widget-title bigger lighter">
                                <b>Students
                                    ({{$new_school_name}}&nbsp;&rArr;&nbsp;
                                    {{$new_class_name}})
                                        </b>
                            </h5>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main" id="scroll_bar" style="height: 409px;">
                                <ul class="list-unstyled spaced2" id="promote_to_class_students">
                                    <?php

                                    if (!empty($new_class_students))
                                    {
                                        foreach($new_class_students as $student)
                                        {
                                       ?>
                                        <li id='student-row<?php echo $student->id;?>' data-order='<?php echo $student->id;?>'>
                                            <label>
                                                <input student_id='<?php echo $student->id;?>' student_name='<?php echo $student->first_name.' '.$student->middle_name.' '.$student->last_name;?>' type="checkbox" class='ace ace-checkbox-2' name='students' value="<?php echo $student->id;?>" disabled />
                                            <span class="lbl">
                                                <b><?php echo $student->first_name;?>&nbsp;<?php echo $student->middle_name;?> &nbsp;<?php echo $student->last_name;?></b>
                                            </span>
                                        </label>
                                        </li>
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
