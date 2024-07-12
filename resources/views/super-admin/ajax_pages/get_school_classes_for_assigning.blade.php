<hr />
@if(!empty($message))
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
                <b>
    <?php 
            if($count==1)
            {
                $count=$count." Class Has";
            }
            else if($count>1)
            {
                $count=$count." Classes Have";
            }
            echo $count." Been Assigned To ".$school_name[0]->school." Successfully!...";
        ?>
</b>
<br>
</div>
@endif

<span id="show_message"></span>
<input type="hidden" id="school-name" value="<?php echo $school_name[0]->school;?>" />

<!--Box One-->
<div class="col-xs-12 col-sm-4 ">
    <div class="widget-box widget-color-blue">
        <div class="widget-header">
            <h5 class="widget-title bigger lighter" id="classes-header">
                <?php 
                    if(isset($all_classes))
                    {
                     ?>
                    <b>Classes</b>
                    <?php    
                    }
                    else
                    {
                      ?>
                    <b>No Classes To Assign</b>
                        <?php    
                    }

            ?>
            </h5>
        </div>

        <div class="widget-body">
            <input type="text" id="search_class" class="form-control search-query" placeholder="Search Class To Assign">
            <div class="widget-main" id="scroll_bar">
                <ul class="list-unstyled spaced2" id="all-classes">
                    <?php
                        $i=0;
                      if (isset($all_classes))
                      {
                        foreach($all_classes as $key => $class)
                        {
                        if(! array_key_exists($key,$all_school_classes)){    
                         $i++;
                      ?>
                    <li id='classes-row<?php echo $key;?>' data-order='<?php echo $key;?>'>
                        <label><input class='ace ace-checkbox-2' class_id='<?php echo $key;?>' class_name='<?php echo $class;?>' type="checkbox" name='classes' value="<?php echo $key;?>" />
                        <span class='lbl'>&nbsp;<b><?php echo $class;?></b></span></label>
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
    <div class="col-xs-12 col-sm-4 ">
    <br />
    <button class="btn btn-sm btn-success btn-block" id="btn-add-all">
        <span class="bigger-110 no-text-shadow">Add All</span>
    </button>

    <button class="btn btn-sm btn-success btn-block" id="btn-add" style="display:none;">
        <span class="bigger-110 no-text-shadow">Add</span>
    </button>
    <br />
    <hr />

    <button class="btn removeall  btn-sm btn-danger btn-block" id="btn-remove-all" style="display:none;">
        <span class="bigger-110 no-text-shadow">Remove All</span>
    </button>

    <button class="btn btn-sm btn-danger btn-block" id="btn-remove" style="display:none;">
        <span class="bigger-110 no-text-shadow">Remove</span>
    </button>

    <br />
    <hr />
    <button style="display: none;" class="btn btn-primary btn-block btn-sm" id="btn-assign-classes">
        <span class="bigger-140 no-text-shadow" >Assign Classes</span>
    </button>
    <br /> <br />

</div>
<!--Box Two-->

<!--Box Three-->
<div class="col-xs-12 col-sm-4 ">
    <div class="widget-box widget-color-blue">
        <div class="widget-header">
            <h5 id="school-classes-header" class="widget-title bigger lighter">
                <b>
                    <?php 
                        if(isset($school_classes[0]->school))
                        {   
                            echo  $school_name[0]->school.' ( Classes )';
                        }
                        else
                        {
                            echo $school_name[0]->school.' ( Has No Classes )';
                        }
                        ?>
                </b>
            </h5>
        </div>
        <div class="widget-body">

            <div class="widget-main" id="scroll_bar">
                <ul class="list-unstyled spaced2" id="school-classes">
                    <?php
                        if(isset($school_classes))
                        {
                            foreach($school_classes as $school_class)
                            {
                                ?>
                    <li data-order='<?php echo $school_class->class_id;?>' id="classes-row<?php echo $school_class->class_id;?>">
                        <label><input class='ace ace-checkbox-2' disabled class_id='<?php echo $school_class->class_id;?>' class_name='<?php echo $school_class->class;?>' type="checkbox" name='classes' value="<?php echo $school_class->class_id;?>" />
                        <span class='lbl'>&nbsp;<b><?php echo $school_class->class;?></b></span></label>
                    </li>
                    <input type="hidden" name="previous-school-classes-ids" value="<?php echo $school_class->class_id;?>" />
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
