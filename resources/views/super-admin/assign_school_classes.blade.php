@extends('master/master')

@section('title')
Assign Classes To School
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
                <li class="active">Assign Classes To School</li>
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

                        <!-- /section:basics/sidebar.options -->
                    </div><!-- /.pull-left -->
                </div><!-- /.ace-settings-box -->
            </div><!-- /.ace-settings-container -->

            <!-- /section:settings.box -->
            <div class="page-header">
                <h1>Assign Classes To School</h1>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <!--Alert Box For All Messages(like: Assign Classes/Remove Classes)-->
                    <p id="result_assign_classes_to_school"></p>
                    
                    <!--Alert Box If No School Is Selected -->
                     <div class="alert alert-danger" id="div_no_school_selected" style="display:none">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <b>Please Select Any School!...</b>
                        <br>
                    </div> 

                
                    {!! Form::open(array("url"=>"super_admin/assign_school_classes_process", "method"=>"post","class"=>"form-horizontal",'id'=>'assign_school_classes_form',"role"=>"form")) !!}

                    <?php
                    $get_schools=array(''=>'-- Select School --');
                    foreach($schools as $school){
                    $get_schools[$school['id']]=$school['school'];
                    }
                    ?>
                    
              
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="schools">School Name</label>
                        <div class="col-sm-9">
                          {!! Form::select('school', $get_schools,'NULL',array('id'=>'schools',"class"=>"col-xs-10 col-sm-6")) !!}
                            @if($errors->has("school"))
                            <br /><br />
                            <span class="badge badge-danger">{{$errors->first("school")}}</span>
                            @endif
                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                    

                </div>
            </div>
            <div class="row" id="view_school_classes"></div>

        </div><!-- /.page-content -->

    </div>
</div><!-- /.main-content -->
<div class="space-20"></div>
	
<script>
        
    $(document).ready(function(){

        /*Search Class To Assign*/
        $(document).on("keyup",'#search_class', function() 
        {
             var value = $(this).val().toLowerCase();
            
               $("#all-classes li").filter(function() 
                {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                }); 
            
            });
        
        
        
          
        /*To Hide Result Div For All Messages(like: Assign Classes/Remove Classes) */ 
        $('#div_assign_classes_to_school').hide();
        
        /*Selectbox To Select School*/
        $("#schools").change(function(){

       
            
          if($(this).val()!='')
          {
              
            $('#div_no_school_selected').hide();
            $("#view_school_classes").show();  
              
            $.ajax({
            url:'get_school_assigned_classes',
            type:"POST",
            data:{
                _token:'{{csrf_token()}}',
                school_id:$('#schools').val()
                },
            success:function(data){
            $('#view_school_classes').html(data);
            }             
            });
      
          }
          else
          {
             //alert('Please Select Any School!...');  
          $('#div_no_school_selected').show();
          $("#view_school_classes").hide();

         
          }
            
            
            
        });
        /*Selectbox To Select School*/
            
        /*To show btn-add on checkbox's change event*/
        $(document).on('change',"ul#all-classes input[name='classes']",function() {
            if($(this).is(":checked")) 
            {

               $('#btn-add').show();
            }
        });
        
        /*To show btn-remove on checkbox's change event*/
        $(document).on('change',"ul#school-classes input[name='classes']",function() {
            if($(this).is(":checked")) 
            {

               $('#btn-remove').show();
            }
        });
        
        
        /*To Assign Individually Classes To School*/    
        $(document).on('click','#btn-add',function() {
          
             /*To Show Assign Classes Button*/
            $("#btn-assign-classes").show();
      
            /*To Hide Add Classes Button*/
            $("#btn-add").hide();
            

            $("#btn-remove-all").show();

            /*To Hide SearchBar*/
             $("#search_class").hide();
            
            var school_classes = [];
            
           
            $.each($("#all-classes input[name='classes']:checked"), function(){
               
                school_classes.push("<li data-order='"+$(this).attr('class_id')+"' id='classes-row"+$(this).attr('class_id')+"'><label><input class='ace ace-checkbox-2' class_name='"+$(this).attr('class_name')+"' class_id='"+$(this).attr('class_id')+"' type='checkbox' class='ace ace-checkbox-2' name='classes' value='"+$(this).val()+"'/>"+"<span class='lbl'>&nbsp;<b>"+$(this).attr('class_name')+"</b></span></label></li>");
                $('ul#all-classes>#classes-row'+$(this).attr('class_id')).remove();
            
            });
            $('#school-classes').append(school_classes);
            if($('ul#all-classes li').length==0)
            {
                  $('#classes-header').html("<b> No Classes To Assign</b>");   
            }
            
            /*Sort ul-all-classes list items*/
            var items = $('ul#school-classes>li');
            items.sort(function(a, b){
                return +$(a).data('order') - +$(b).data('order');
            });
            items.appendTo('ul#school-classes');
            /*Sort ul-all-classes list items*/
            
        });    
        /*To Assign Individually Classes To School*/    
       
         /*To Assign All Classes To School*/    
         $(document).on('click','#btn-add-all',function() {
           
             
             /*To show assign classes button*/
             $("#btn-assign-classes").show();

             
             /*To Hide SearchBar*/
             $("#search_class").hide();
             
             
            $("#btn-remove-all").show();

             $("#all-classes").css("height","335px");
             
              var classes = [];
             
             $.each($("#all-classes input[name='classes']"), function(){
                
                classes.push("<li data-order='"+$(this).attr('class_id')+"' id='classes-row"+$(this).attr('class_id')+"'><label><input class_name='"+$(this).attr('class_name')+"' class_id='"+$(this).attr('class_id')+"' type='checkbox' class='ace ace-checkbox-2' name='classes' value='"+$(this).val()+"'/>"+" <span class='lbl'>&nbsp;<b>"+$(this).attr('class_name')+"</b></span><label></li>");
                $('ul#all-classes>#classes-row'+$(this).attr('class_id')).remove();
            
            });
            
              $('#school-classes').append(classes);
             $('#school-classes-header').html("<b>"+$('#school-name').val()+' Classes</b>');
             
             if($('ul#all-classes li').length==0)
                {
                  $('#classes-header').html("<b> No Classes To Assign</b>");   
                }
         });
         /*To Assign All Classes To School*/   
            
            
        /*To Remove Individually Classes From School Classes*/    
        $(document).on('click','#btn-remove',function() {

            /*To Hide Remove Classes Button*/
            $("#btn-remove").hide();
            
            /*To show assign classes button*/
            $("#btn-assign-classes").show();
            
            /*To Show SearchBar*/
             $("#search_class").show();
            
                var classes = [];            
                $.each($("#school-classes input[name='classes']:checked"), function(){

                    classes.push("<li data-order='"+$(this).attr('class_id')+"' id='classes-row"+$(this).attr('class_id')+"'><label><input class_name='"+$(this).attr('class_name')+"' class_id='"+$(this).attr('class_id')+"' type='checkbox'class='ace ace-checkbox-2' name='classes' value='"+$(this).val()+"'/>"+"<span class='lbl'>&nbsp;<b>"+$(this).attr('class_name')+"</b></span></label></li>");
                    $('ul#school-classes>#classes-row'+$(this).attr('class_id')).remove();

                });
                
                $('#all-classes').append(classes);
                $('#classes-header').html("<b>Classes</b>");    
                if($('ul#school-classes li').length==0)
                {
                  $('#school-classes-header').html("<b>"+$('#school-name').val()+' ( Has No Classes</b>');
                  $("#btn-remove-all").hide();   
                }


                if($("#school-classes input[name='classes']:enabled").length==0)
                {
                  $("#btn-remove-all").hide(); 
                  $("#btn-assign-classes").hide();  
                }
           
            /*Sort ul-all-classes list items*/
            var items = $('ul#all-classes>li');
            items.sort(function(a, b){
                return +$(a).data('order') - +$(b).data('order');
            });
            items.appendTo('ul#all-classes');
            /*Sort ul-all-classes list items*/
           
        });  
        /*To Remove Individually Classes From School Classes*/     
      
        /*To Remove All Classes To School*/    
        $(document).on('click','#btn-remove-all',function() {
            
            /*To show assign classes button*/
            $("#btn-assign-classes").show();
            
            /*To Show SearchBar*/
             $("#search_class").show();
            
            $("#btn-remove-all").hide();

            $("#btn-assign-classes").hide();


            $("#all-classes").css("height","300px");
            
            var school_classes = [];            
            $.each($("#school-classes input[name='classes']:enabled"), function(){
            school_classes.push("<li data-order='"+$(this).attr('class_id')+"' id='classes-row"+$(this).attr('class_id')+"'><label><input class_name='"+$(this).attr('class_name')+"' class_id='"+$(this).attr('class_id')+"' type='checkbox' class='ace ace-checkbox-2' name='classes' value='"+$(this).val()+"'/>"+" <span class='lbl'>&nbsp;<b>"+$(this).attr('class_name')+"</b></span></label></li>");
                $('ul#school-classes>#classes-row'+$(this).attr('class_id')).remove();
            });
            $('#all-classes').append(school_classes);
            //$('#school-classes-header').html("<b>"+$('#school-name').val()+' ( Has No Classes )</b>');
            $('#classes-header').html("<b>Classes</b>"); 
            
            /*Sort ul-all-classes list items*/
            var items = $('ul#all-classes>li');
            items.sort(function(a, b){
                return +$(a).data('order') - +$(b).data('order');
            });
            items.appendTo('ul#all-classes');
            /*Sort ul-all-classes list items*/
            });  
         /*To Remove All Classes To School*/ 
            
            
        /*Assign Classes Process To School*/        
        $(document).on('click','#btn-assign-classes',function() {
            
          /*To Check else if school-classes li's length is >1 (Means 1 Or More Than 1 Classes In School-Classes side)*/
          if($('ul#school-classes li').length>=1)
          {
            var previous_class_ids = [];
            var new_class_ids = [];    
             
             
            /*To Get Previous Class IDs Of Current School Which Class Ids Have Already Assigned To School*/
            $.each($("input[name='previous-school-classes-ids']"), function(){
                previous_class_ids.push($(this).val())       
            });    
                
            /*To Get New Classes IDs Which Will Be Assigned To School*/    
             $.each($("#school-classes input[name='classes']"), function(){
                new_class_ids.push($(this).val());
             });
               
             /*To check if previous-classes-ids-length is less than than new-classes-ids*/
              if(previous_class_ids.length<new_class_ids.length)
              {
              
                /*jQuery Ajax*/
                $.ajax({
                url:'assign_classes_to_school',
                type:"POST",
                data:{
                    _token:'{{csrf_token()}}',
                    previous_class_ids:previous_class_ids,
                    new_class_ids:new_class_ids,
                    school_id:$('#schools').val(),
                    school_name:$('#school-name').val()
                    },
                success:function(data){
                
                    if(data.message=='fail')
                    {
                        $("#result_assign_classes_to_school").addClass("alert alert-danger").html("Not Assigned");
                    }
                    else
                    {
                        $("#btn-assign-classes").hide();
                        $("#view_school_classes").html(data);
                    }
                }             
                });
                /*jQuery Ajax*/
              }
          }
            
          
         
        
        
        });    
        /*Assign Classes Process To School*/ 
            
        
        
    });//document ready        
    
</script>    
@endsection

