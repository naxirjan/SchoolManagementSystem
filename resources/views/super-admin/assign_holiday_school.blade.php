@extends('master/master')

@section('title')
Assign Holiday To School
@endsection

@section('page_content')
<div class="main-content">
    <div class="main-content-inner">
        <!-- #section:basics/content.breadcrumbs -->
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try {
                    ace.settings.check('breadcrumbs', 'fixed')
                } catch (e) {}
            </script>

            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="/">Home</a>
                </li>
                <li class="active">Assign Holiday To School</li>
            </ul><!-- /.breadcrumb -->



            <!-- /section:basics/content.searchbox -->
        </div>

        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content">
            <!-- #section:settings.box -->
            <div class="ace-settings-container" id="ace-settings-container">
                <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                    <i class="ace-icon fa fa-cog bigger-130"></i>
                </div>

                <div class="ace-settings-box clearfix" id="ace-settings-box">
                    <div class="pull-left width-50">
                        <!-- #section:settings.skins -->
                        <div class="ace-settings-item">
                            <div class="pull-left">
                                <select id="skin-colorpicker" class="hide">
                                    <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                    <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                    <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                    <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                </select>
                            </div>
                            <span>&nbsp; Choose Skin</span>
                        </div>

                        <!-- /section:settings.skins -->

                        <!-- #section:settings.navbar -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                            <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                        </div>

                        <!-- /section:settings.navbar -->

                        <!-- #section:settings.sidebar -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                            <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                        </div>

                        <!-- /section:settings.sidebar -->

                        <!-- #section:settings.breadcrumbs -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                            <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                        </div>

                        <!-- /section:settings.breadcrumbs -->

                        <!-- #section:settings.rtl -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                            <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                        </div>

                        <!-- /section:settings.rtl -->

                        <!-- #section:settings.container -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                            <label class="lbl" for="ace-settings-add-container">
                                Inside
                                <b>.container</b>
                            </label>
                        </div>

                        <!-- /section:settings.container -->
                    </div><!-- /.pull-left -->

                    <div class="pull-left width-50">
                        <!-- #section:basics/sidebar.options -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
                            <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
                            <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
                            <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                        </div>

                       
                    </div>
                </div>
            </div>

            <!-- /section:settings.box -->
            <div class="page-header">
                <h1>
                    Assign Holiday To School

                </h1>
            </div><!-- /.page-header -->


                <div class="container-fluid">
                        <div class="row">
                              <!-- AJax Response -->
                        <p id="result_assign_classes_to_school"> </p>
                                 <!-- AJax Response -->
                            <div class="col-xs-12">
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-8">
                                    <div class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Holiday Title </div>
                                            <div class="profile-info-value">
                                            <span class="editable editable-click">{{$holidays[0]['title']}}</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Holiday Start Date</div>
                                         <div class="profile-info-value">
                                            <span class="editable editable-click">
                                             <?php echo date('d F Y',strtotime($holidays[0]['start_date'])); ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Holiday End Date</div>
                                         <div class="profile-info-value">
                                            <span class="editable editable-click">
                                              <?php echo date('d F Y',strtotime($holidays[0]['end_date'])); ?>
                                            </span>
                                        </div>
                                    </div>
                                        
                                      <div class="profile-info-row">
                        <div class="profile-info-name" style="background-color: white"> &nbsp;&nbsp;&nbsp;</div>
                        <div class="profile-info-value">
                            <span class="editable editable-click">
                                <a href="javascript:history.back()" style="float:right">
                                <button class="btn btn-xl btn-info">
                                    <i class="ace-icon fa fa-arrow-left icon-on-left"></i>
                                    Back
                                </button>
                                </a>
                            </span>
                        </div>
				</div>     
                                </div>
                                <div class="col-xs-12 col-sm-2"></div>
                            </div>
                          </div>
                         </div>

                
                <div class="row" id="get_holidays_for_assigning">
                  
                  @include('../super-admin/ajax_pages/get_holidays_for_assigning')  
                </div>
            </div>


        </div><!-- /.page-content -->

    </div>
</div>
<div class="space-30"></div><!-- /.main-content -->
<script type="text/javascript">
    $(document).ready(function(){

    /*Promote Class Students*/
        $("#all-schools").css({height:"300px",overflow:"auto"});
        $("#holiday-school").css({height:"335px",overflow:"auto"});
    /*Promote Class Students*/


     /*To show btn-add on checkbox's change event*/
        $(document).on('change',"ul#all-schools input[name='schools']",function() {
           
            var checked=[];
              $.each($("#all-schools input[name='schools']:checked"), function(){
            checked.push($(this).val());

            });  

            if(checked.length >= 1 )
            {
                 $('#btn-add').show();
            }
            else if(checked.length == 0 )
            {
                $('#btn-add').hide();
            }


        });

         /*To show btn-remove on checkbox's change event*/
           
            $(document).on('change',"ul#holiday-school input[name='schools']",function() {
           
            var checked=[];
              $.each($("#holiday-school input[name='schools']:checked"), function(){
            checked.push($(this).val());

            });  

            if(checked.length >= 1 )
            {
                 $('#btn-remove').show();
            }
            else if(checked.length == 0 )
            {
                $('#btn-remove').hide();
            }


        });


            /*Search Student*/
        $("#search_school").on("keyup", function() 
        {
             var value = $(this).val().toLowerCase();
            
               $("#all-schools li").filter(function() 
                {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });             
            });
         /* Assign Holidays To All School*/    
         $(document).on('click','#btn-add-all',function(e) {
         	e.preventDefault();
              var schools = [];
                  
               $("#search_school ").hide();     
                $("#all-schools").css("height","335px");   
             $.each($("#all-schools input[name='schools']"), function(){
                
            
            schools.push("<li disabled data-order='"+$(this).attr('school_id')+"' id='schools-row"+$(this).attr('school_id')+"'><label><input school_name='"+$(this).attr('school_name')+"' school_id='"+$(this).attr('school_id')+"' type='checkbox'  class='ace ace-checkbox-2' name='schools' value='"+$(this).val()+"'/>"+" <span class='lbl'><b>"+$(this).attr('school_name')+"</b></span></label></li>");
                $('ul#all-schools>#schools-row'+$(this).attr('school_id')).remove();
               $('#btn-assign-holiday').show();
               $('#btn-add').hide();             
                });
              $('#holiday-school').append(schools);
             $('#holiday-school-header').html("<b>"+'Holiday  Assigned To Schools</b>');
             if($('ul#all-schools li').length==0)
                    {
                        $('#school-header').html("<b> No Schools To Assign</b>");   
                    }   
         });
         /* Assign Holidays To All School*/   

        /*Assign Individually Schools To Holiday*/    
        $(document).on('click','#btn-add',function(e) {
        		e.preventDefault();
            var holiday_schools = [];
            $.each($("#all-schools input[name='schools']:checked"), function(){
               
                holiday_schools.push("<li data-order='"+$(this).attr('school_id')+"' id='schools-row"+$(this).attr('school_id')+"'><label><input school_name='"+$(this).attr('school_name')+"' school_id='"+$(this).attr('school_id')+"' type='checkbox' class='ace ace-checkbox-2' name='schools' value='"+$(this).val()+"'/>"+" <span class='lbl'> <b>"+$(this).attr('school_name')+"</b></span><label></li>");
                $('ul#all-schools>#schools-row'+$(this).attr('school_id')).remove();
                $('#btn-assign-holiday').show();
                
                if($('ul#all-schools li').length==0)
                {
                 $('#btn-add').hide();
                }
                });
                $('#holiday-school').append(holiday_schools);
                $('#holiday-school-header').html("<b>"+'Holiday Assigned To Schools</b>');
                if($('ul#all-schools li').length==0)
                   {
                      $('#school-header').html("<b> No Schools To Assign</b>");   
                   }

            
            /*Sort ul-all-Schools list items*/
            var items = $('ul#holiday-school>li');
            items.sort(function(a, b){
                return +$(a).data('order') - +$(b).data('order');
            });
            items.appendTo('ul#holiday-school');
            /*Sort ul-all-Schools list items*/    
            });

          /* To Remove All School To Holiday */    
        $(document).on('click','#btn-remove-all',function(e) {
            e.preventDefault();
             $('#btn-assign-holiday').hide();
             $("#holiday-school").css("height","335px");   
            


            var holiday_schools = [];            
            $.each($("#holiday-school input[name='schools']:enabled"), function(){
            holiday_schools.push("<li data-order='"+$(this).attr('school_id')+"' id='schools-row"+$(this).attr('school_id')+"'><label><input school_name='"+$(this).attr('school_name')+"' school_id='"+$(this).attr('school_id')+"' class='ace ace-checkbox-2' type='checkbox' name='schools' value='"+$(this).val()+"'/>"+" <span class='lbl'> <b>"+$(this).attr('school_name')+"</b></span></li>");
                 $('ul#holiday-school>#schools-row'+$(this).attr('school_id')).remove();
                 //$('#btn-assign-holiday').show();
            });
            $('#all-schools').append(holiday_schools);
                 if($('ul#holiday-school li').length==0)
                    {
                        $('#holiday-school-header').html("<b>"+'Holiday Has Not Assigned To Any School</b>');
                     }
                    
                if($('ul#all-schools li').length!=0)
                    {
                        $('#school-header').html("<b>Schools</b>");
                     }
                          


             
            
            /*Sort ul-all-schools list items*/
            var items = $('ul#all-schools>li');
            items.sort(function(a, b){
                return +$(a).data('order') - +$(b).data('order');
            });
            items.appendTo('ul#all-schools');
            /*Sort ul-all-Schools list items*/
            });  
             /*To Remove All Schools From Holiday School*/ 

         /*To Remove Individually School From holiday School*/ 
        $(document).on('click','#btn-remove',function(e) {
            e.preventDefault();
                var schools = [];  
               
                $.each($("#holiday-school input[name='schools']:checked"), function(){
                   schools.push("<li data-order='"+$(this).attr('school_id')+"' id='schools-row"+$(this).attr('school_id')+"'><label><input school_name='"+$(this).attr('school_name')+"' school_id='"+$(this).attr('school_id')+"' class='ace ace-checkbox-2' type='checkbox' name='schools' value='"+$(this).val()+"'/>"+" <span class='lbl'> <b>"+$(this).attr('school_name')+"</b></span></li>");
              
                    $('ul#holiday-school>#schools-row'+$(this).attr('school_id')).remove();
                    //$('#btn-assign-holiday').show();
                    if($('ul#holiday-school li').length==0)
                    {
                         $('#btn-remove').hide();
                     }
                });

                 $('#all-schools').append(schools);
                 if($('ul#holiday-school li').length == 0)
                    {
                      $('#btn-assign-holiday').hide();
                      $('#holiday-school-header').html("<b>"+'Holiday Has Not Assigned To Any School</b>');   
                    } 
                $('#school-header').html("<b>Schools</b>"); 
                
            /*Sort ul-all-schools list items*/
            var items = $('ul#all-schools>li');
            items.sort(function(a, b){
                return +$(a).data('order') - +$(b).data('order');
            });
            items.appendTo('ul#all-schools');
            /*Sort ul-all-school list items*/
            }); 
            /*To Remove Individually Schools From Holiday School*/             
        
            $(document).on('click','#btn-assign-holiday',function(e){
            	e.preventDefault();
                if($('ul#holiday-school li').length >= 0)
                { 

                 var previous_school_ids = [];
                 var new_school_ids = [];          
                
         /*To Get Previous School IDs Of Current School Which School Ids Have Already Assigned To School*/
            $.each($("input[name='previous-holiday-school-ids']"), function(){
                previous_school_ids.push($(this).val());       
            });    
                
                //To Get New School IDs Which Will Be Assigned To School    
                 $.each($("#holiday-school input[name='schools']"), function(){
                    new_school_ids.push($(this).val());
                 });

                  if(previous_school_ids.length<new_school_ids.length)
                  {
                
                     $.ajax({
                    url:'holiday_assign_school_process',
                    type:"POST",
                    data:{
                    _token:'{{csrf_token()}}',
                    new_school_ids:new_school_ids,
                    previous_school_ids:previous_school_ids,
                    holiday_id:$('#holiday-id').val(),
                    holiday_title:$('#holiday-name').val(),
                    },
                    success:function(data)
                      {
                      
                        if(data.message=='fail')
                        {
                            $('#result_assign_classes_to_school').html('Holiday Has Not Been Assigned To Schools');
                        }
                        else
                        {
                            $("#get_holidays_for_assigning").html(data)
                        }

                      }
                                    
                    });
                  }
                }
            });
         });
</script>
@endsection