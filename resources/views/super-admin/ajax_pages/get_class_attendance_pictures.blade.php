<?php

if(!empty($class_attendance_pictures))
{
?>    
<hr />
<div class="profile-user-info profile-user-info-striped">
    <div class="profile-info-row">
        <div class="profile-info-name" style="background-color:#87b87f"></div>

        <div class="profile-info-value">
            <span class="editable editable-click "><b>Class Attendance picture was taken</b></span>
        </div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name" style="background-color:#d15b47"></div>

        <div class="profile-info-value">
            <span class="editable editable-click"><b>Class Attendance picture was not taken</b></span>
        </div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name" style="background-color:#428bca"></div>

        <div class="profile-info-value">
            <span class="editable editable-click"><b>Class Attendance picture was deleted</b></span>
        </div>
    </div>
</div>    
<br />
<div class="widget-box widget-color-blue2">
    <div class="widget-header">
                                <h4 class="widget-title lighter smaller"><b>Class Attendance Pictures</b></h4>
                            </div>
    <div class="widget-body">
            <ul class="ace-thumbnails clearfix">
                                      
                            <?php
                                    
                                foreach($class_attendance_pictures as $pictures)
                                {  
                                      ?>
                                        <li style="margin-top:10px;"> 
                                        <div style="width:214px;">
                                         
                                                <?php
                                            $dir='storage/schools/'.$images_path;
                                            $files = array_diff(scandir($dir), array(".","..","..."));
                                        
                                        if(!empty($pictures['class_image']))
                                        {
                                                if(in_array($pictures['class_image'],$files))
                                                {
                                            ?>
                                             
                                                <h3 class="center btn  btn-block btn-success">
                                                    <b>
                                                        <?php echo date("d F, Y",strtotime($pictures['created_date']));?>
                                                    </b>
                                                        
                                                </h3>
                                                <div class="text">
                                                    <div class="inner">
                                                        <a target="_blank" href="{{asset('storage/schools/'.$images_path.'/'.$pictures['class_image'])}}" >
                                                            <i class="ace-icon fa fa-search-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php
                                                }   
                                                else
                                                {
                                             ?>    
                                                <h2 class="center btn btn-block btn-primary">
                                                    <b><?php echo date("d F, Y",strtotime($pictures['created_date']));?></b></h2>
                                                <div class="text">
                                                    <div class="inner">
                                                        <a href="{{asset('storage/dumy_image/nopicture.jpg')}}" data-rel="colorbox">
                                                            <i class="ace-icon fa fa-search-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php
                                        }
                                        }
                                        else
                                        {
                                        ?>    
                                            <h2 class="center btn btn-block btn-danger">
                                                <b><?php echo date("d F, Y",strtotime($pictures['created_date']));?></b>
                                            </h2>
                                            <div class="text">
                                                <div class="inner">
                                                    <a href="{{asset('storage/dumy_image/nopicture.jpg')}}" data-rel="colorbox">
                                                        <i class="ace-icon fa fa-search-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        </div> 
                                            
                                            
                                         <ul class="list-unstyled spaced center">
                                        <li>
                                            
                                            <span class="btn btn-xs btn-light">
                                                <b>Present:<?php echo $pictures['present'];?></b>
                                            </span>   
                                            
                                            <span class="btn btn-xs btn-grey">
                                                <b>Absent:<?php echo $pictures['absent'];?></b>
                                            </span>
                                            
                                        </li>
                                       </ul>
                                        </li>
                                <?php
                                }
                            ?>        
        </ul>
            
    </div>    
</div>
    
<?php
}
else
{
    ?>
    <hr />
    <h3 class="alert alert-danger"><b>Attendance was not taken!...</b></h3>

    <?php
}
?>    

	<script type="text/javascript">
			jQuery(function($) {
	var $overflow = '';
	var colorbox_params = {
		reposition:true,
		scalePhotos:true,
		scrolling:false,
		close:'&times;',
		maxWidth:'100%',
		maxHeight:'100%',
		onOpen:function(){
			$overflow = document.body.style.overflow;
			document.body.style.overflow = 'hidden';
		},
		onClosed:function(){
			document.body.style.overflow = $overflow;
		},
		onComplete:function(){
			$.colorbox.resize();
		}
	};

	$('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
	//$("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");//let's add a custom loading icon
	
	
	$(document).one('ajaxloadstart.page', function(e) {
		$('#colorbox, #cboxOverlay').remove();
   });
                
                
})

    </script>
