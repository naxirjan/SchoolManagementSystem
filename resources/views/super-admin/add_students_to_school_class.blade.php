@extends('master/master')

@section('title')
Add Students To Class
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
                <li class="active">Add Students To Class</li>
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
                <h1>Add Students To Class</h1>
            </div>
            
            <!--Alert If No School Is Selected-->
            <div class="alert alert-block alert-danger" id="alert_no_school_is_selected" style="display:none;">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                <b>Please Select Any School!...</b>
            </div>
            <!--Alert If No School Is Selected-->
            
            
            <!--Alert If School Has No Classes-->
            <div class="alert alert-block alert-danger" id="alert_no_school_classes" style="display:none;">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                <span id="no_school_classes_message"></span>
            </div>
            <!--Alert If School Has No Classes-->
            
            
             <!--Alert If Class Students Promoted or Not-->
            <p id="message_class_students_promoted"></p>
           <!--Alert If Class Students Promoted or Not-->
           
            
            
            
            <!--Show School Name/Class Name & Promote Schools/Classes -->
           
            <div class="row">
                <div class="col-xs-12">
                   
                   <div class="col-sm-2"></div>
                   <div class="col-sm-8">
                   <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> School Name </div>

                            <div class="profile-info-value">
                                <span class="dark" id="get_school_name">
                                <b>{{$school_information['school']}}</b>
                                </span>
                                <input type="hidden" id="previous_school_id" value="{{$school_information['id']}}" />
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> Class Name </div>

                            <div class="profile-info-value">
                                <span class="dark" id="get_class_name">
                                <b>{{$class_information['class']}}</b>
                                </span>
                                   <input type="hidden" id="previous_class_id" value="{{$class_information['id']}}" />
                           
                            </div>
                        </div>
                       @if(!empty($schools))
                        <div class="profile-info-row">
                            <div class="profile-info-name">
                                Promote To School
                            </div>

                            <div class="profile-info-value">
                                 <select class="form-control" id="schools" style="color:#333333;font-weight:bold;font-size:13px;">
                                     <option value="">-- Select School --</option>
                                     @foreach($schools as $school)
                                      <option get_school_name="{{$school['school']}}" value="{{$school['id']}}">{{$school['school']}}</option>
                                    
                                     @endforeach
                                </select> 
                                <input type="hidden" id="school_name" value="{{$school['school']}}" />
                            </div>
                        </div>
                       @endif
                        <div class="profile-info-row" id="div_school_classes" style="display:none;">
                                <div class="profile-info-name">
                                    Promote To Class
                                </div>
                                <div class="profile-info-value">
                                    <select class="form-control" id="school_classes_by_school_id" style="color:#333333;font-weight:bold;font-size:13px;">
                                    </select>    
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
                    <!--Schhol & Class IDs-->
                       <input type="hidden" id="school_id" value="{{$school_information['id']}}" />
                       <input type="hidden" id="class_id" value="{{$class_information['id']}}" />
                    </div>
                   <div class="col-sm-2"></div>
                </div>
            </div>
           
            
            
           
            
            <!--View Class Students-->
            <div  class="row" id="show_students_buttons_promote_boxes" style="display:none;">
               
                
            </div> 
             <!--View Class Students-->
            
        </div>
        <!-- /.page-content -->

    </div>
</div><!-- /.main-content -->
<div class="space-20"></div>
	
<script>
       
       
    
    $(document).ready(function(){

        
        /*Promote Class Students*/
            $("#current_class_students").css({height:"300px",overflow:"auto"});
            $("#promote_to_class_students").css({height:"335px",overflow:"auto"});
        /*Promote Class Students*/

        
        /*Search Student*/
        $("#search_student").on("keyup", function() 
        {
             var value = $(this).val().toLowerCase();
            
               $("#current_class_students li").filter(function() 
                {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                }); 
            
            });     
        

        
        
        /*School Selectbox To get classes by school id*/
        $("#schools").change(function(){
        
        school_name = $("#schools option[value='"+$("#schools").val()+"']").text();
        class_name  = $("#school_classes_by_school_id option[value='"+$("#school_classes_by_school_id").val()+"']").text();   
        
         $("#promote_to_class_students_header").html("<b>Promote To: ("+school_name+"</b>");   
           
        if($(this).val()!='')
          {
              
            /*Hide Alert (No School Selected)*/
            $('#alert_no_school_is_selected').hide();  
              
            $.ajax({
            url:'get_classes_by_school_id',
            type:"POST",
            data:{
                _token:'{{csrf_token()}}',
                school_id:$('#schools').val()
                },
            success:function(data){
            
            if(data=='no classes')
            {
                $('#alert_no_school_classes').show();
                $("#no_school_classes_message").html("<b>"+school_name+" Has No Classes!...</b>");
                $("#div_school_classes").hide();
                $("#show_students_buttons_promote_boxes").hide();
            }   
            else
            {
                $("#div_school_classes").show();    
                $('#school_classes_by_school_id').html(data);
                $('#alert_no_school_classes').hide();
            }    
           
            
            }             
            });
      
          }
          else
          {
             //alert('Please Select Any School!...');  
            $('#alert_no_school_is_selected').show();
            $("#alert_no_school_classes").hide();  
            $("#show_students_buttons_promote_boxes").hide();  
          }
            
            
            
        });
         /*Selectbox To get classes by school id*/
            
        
        /*Class Select Box To Get Students*/
          $("#school_classes_by_school_id").change(function(){
              
            var school_name = $("#schools option[value='"+$("#schools").val()+"']").text();
            var class_name  = $("#school_classes_by_school_id option[value='"+$("#school_classes_by_school_id").val()+"']").text();   
        
            var previous_school_id = $('#previous_school_id').val();
            var previous_class_id  = $("#previous_class_id").val();
              
              
            if($("#schools").val()==previous_school_id && $("#school_classes_by_school_id").val()=='')
            {
                $("#alert_no_school_classes").show();
                $("#no_school_classes_message").html("<b>Please Select The Class To Promote!..</b>");
                
                $("#show_students_buttons_promote_boxes").hide();  
            }
              
            else if($("#schools").val()!=previous_school_id && $("#school_classes_by_school_id").val()=='')
            {
                $("#alert_no_school_classes").show();
                $("#no_school_classes_message").html("<b>Please Select The Class To Promote!..</b>");
                
                $("#show_students_buttons_promote_boxes").hide();  
            }  
            
            else if($("#schools").val()==previous_school_id && $("#school_classes_by_school_id").val()==previous_class_id)
            {
                $("#alert_no_school_classes").show();
                $("#no_school_classes_message").html("<b>You Need To Promote Students To The Next Class Not To The Previous Class!..</b>");
                $("#show_students_buttons_promote_boxes").hide();
            }
            
            else
            {
            $("#alert_no_school_classes").hide();    
                
            school_name = $("#schools option[value='"+$("#schools").val()+"']").text();
            class_name  = $("#school_classes_by_school_id option[value='"+$("#school_classes_by_school_id").val()+"']").text();
                
            /*$("#promote_to_class_students_header").html("<b>Promote To: ("+school_name+" &rArr; "+class_name+"</b>");  
           */
            
             /*jQuery Ajax*/
                $.ajax({
                url:'get_class_students_for_promoting',
                type:"POST",
                data:{
                    _token:'{{csrf_token()}}',
                    new_school_id:$('#schools').val(),
                    new_class_id:$('#school_classes_by_school_id option:selected').attr('class_id'),
                    new_class_school_id:$("#school_classes_by_school_id").val(),
                    new_school_name:school_name,
                    new_class_name:class_name,
                    previous_school_id:previous_school_id,
                    previous_class_id:previous_class_id
                    },
                success:function(data){
                    $('#show_students_buttons_promote_boxes').show();
                    $('#show_students_buttons_promote_boxes').html(data);
                    
                }             
                });
            /*jQuery Ajax*/
            
            
            
            }
              
          });
         /*Class Select Box To Get Students*/
        
        
        /*To show btn-add on checkbox's change event*/
        $(document).on('change',"ul#current_class_students input[name='students']",function() {
            if($(this).is(":checked")) 
            {

               $('#btn-add').show();
            }
        });
        /*To show btn-add on checkbox's change event*/
        
        
        /*To show btn-remove on checkbox's change event*/
        $(document).on('change',"ul#promote_to_class_students input[name='students']",function() {
            if($(this).is(":checked")) 
            {

               $('#btn-remove').show();
            }
        });
        /*To show btn-remove on checkbox's change event*/
     
        
        /*To Promote Individually Students To New School/Class*/    
        $(document).on('click','#btn-add',function() {
          
            /*Show Promote Button*/
            $("#btn-promote-class-students").show();
          
             $("#btn-add").hide();
            
            var current_classes_students = [];
            
            /*Get checkboxes values and store in array*/
            $.each($("#current_class_students input[name='students']:checked"), function(){
               current_classes_students.push("<li data-order='"+$(this).attr('student_id')+"' id='student-row"+$(this).attr('student_id')+"'><label><input  student_name='"+$(this).attr('student_name')+"' student_id='"+$(this).attr('student_id')+"' type='checkbox' class='ace ace-checkbox-2' name='students' value='"+$(this).val()+"'/>"+" <span class='lbl'><b> "+$(this).attr('student_name')+"</b></span></li><label>");
                $('ul#current_class_students>#student-row'+$(this).attr('student_id')).remove();
            
            });
            
            /*Set array with li in promote-to-class-students*/
            $('#promote_to_class_students').append(current_classes_students);
            
            /*Check If current-class-students are=0 then show message*/
            if($('ul#current_class_students li').length==0)
            {
                $('#current_class_students_header').html("<b> No Students To Promote</b>");
                $("#search_student").hide();
                $("#btn-add").hide();
        
            }
            
            /*Sort ul-promote_to_class_students list items*/
            var items = $('ul#promote_to_class_students>li');
            items.sort(function(a, b){
                return +$(a).data('order') - +$(b).data('order');
            });
            items.appendTo('ul#promote_to_class_students');
            /*Sort ul-promote_to_class_students list items*/
            
            
        
            
        });    
        /*To Assign Individually Classes To School*/    
       
       
        /*To Promote All Students To New School/Class*/    
        $(document).on('click','#btn-add-all',function() {
          
             $("#btn-promote-class-students").show();
             $("#search_student").hide();
            
            $("#current_class_students").css("height","335px");

            $("#btn-add").hide();
            
            var current_classes_students = [];
            
            /*Get Checkboxes Values*/
            $.each($("#current_class_students input[name='students']"), function(){
               
                current_classes_students.push("<li data-order='"+$(this).attr('student_id')+"' id='student-row"+$(this).attr('student_id')+"'><label><input student_name='"+$(this).attr('student_name')+"' student_id='"+$(this).attr('student_id')+"' type='checkbox' class='ace ace-checkbox-2' name='students' value='"+$(this).val()+"'/>"+" <span class='lbl'>&nbsp;<b>"+$(this).attr('student_name')+"</b></span></li><label>");
                $('ul#current_class_students>#student-row'+$(this).attr('student_id')).remove();
            
            });
            
            $('#promote_to_class_students').append(current_classes_students);
            if($('ul#current_class_students li').length==0)
            {
                  $('#current_class_students_header').html("<b> No Students To Promote</b>");   
            }
            
            /*Sort ul-all-classes list items*/
            var items = $('ul#promote_to_class_students>li');
            items.sort(function(a, b){
                return +$(a).data('order') - +$(b).data('order');
            });
            items.appendTo('ul#promote_to_class_students');
            /*Sort ul-all-classes list items*/
            
        });    
        /*To Promote All Students To New School/Class*/      
       
        
         /*To Remove Individually Students From Promote To Class Students*/    
        $(document).on('click','#btn-remove',function() {

           
            $("#current_class_students").css("height","335px");
            
            var promote_to_class_students = [];            
                $.each($("#promote_to_class_students input[name='students']:checked"), function(){

                    promote_to_class_students.push("<li data-order='"+$(this).attr('student_id')+"' id='student-row"+$(this).attr('student_id')+"'><label><input student_name='"+$(this).attr('student_name')+"' student_id='"+$(this).attr('student_id')+"' type='checkbox' class='ace ace-checkbox-2' name='students' value='"+$(this).val()+"'/>"+" <span class='lbl'>&nbsp;<b>"+$(this).attr('student_name')+"</b></span></label></li>");
                    $('ul#promote_to_class_students>#student-row'+$(this).attr('student_id')).remove();

                });
                
            
                /*Set array with li in current-class-students*/
                $('#current_class_students').append(promote_to_class_students);
               
                $('#current_class_students_header').html("<b>Students ("+$('#get_school_name').html()+" &rArr; "+$("#get_class_name").html()+")</b>");    
                
               
            
                /*Check If current-class-students are=0 then show message*/
                /*if($('ul#promote_to_class_students li').length==0)
                {
                    $("#btn-promote-class-students").hide();
                    $("#search_student").show();
                    $("#btn-remove").hide();
                    
                }*/
            
                if($("ul#promote_to_class_students input[name='students']:enabled").length==0)
                {
                    $("#btn-remove-all").hide();
                     $("#btn-promote-class-students").hide();
                    $("#search_student").show();
                    $("#btn-remove").hide();
                    $("#btn-add").hide();
                    
                }
            
           
                /*Sort ul-current_class_students list items*/
                var items = $('ul#current_class_students>li');
                items.sort(function(a, b){
                    return +$(a).data('order') - +$(b).data('order');
                });
                items.appendTo('ul#current_class_students');
                /*Sort ul-all-classes list items*/
           
        });  
        /*To Remove Individually Students From Promote To Class Students*/    
   
   
          /*To Remove All Students From Promote To Class Students*/    
        $(document).on('click','#btn-remove-all',function() 
        {
            $("#btn-promote-class-students").hide();
            
            $("#search_student").show();
            
            $("#current_class_students").css("height","300px");   
            
            var promote_to_class_students = [];            
                $.each($("#promote_to_class_students input[name='students']"), function(){

                    promote_to_class_students.push("<li data-order='"+$(this).attr('student_id')+"' id='student-row"+$(this).attr('student_id')+"'><label><input student_name='"+$(this).attr('student_name')+"' student_id='"+$(this).attr('student_id')+"' type='checkbox' class='ace ace-checkbox-2' name='students' value='"+$(this).val()+"'/>"+"<span class='lbl'>&nbsp;<b>"+$(this).attr('student_name')+"</b></span></label></li>");
                    $('ul#promote_to_class_students>#student-row'+$(this).attr('student_id')).remove();

                });
                
            
                /*Set array with li in current-class-students*/
                $('#current_class_students').append(promote_to_class_students);
               
                $('#current_class_students_header').html("<b>Students ("+$('#get_school_name').html()+" &rArr; "+$("#get_class_name").html()+")</b>");    
                
           
                /*Sort ul-current_class_students list items*/
                var items = $('ul#current_class_students>li');
                items.sort(function(a, b){
                    return +$(a).data('order') - +$(b).data('order');
                });
                items.appendTo('ul#current_class_students');
                /*Sort ul-all-classes list items*/
           
        });  
        /*To Remove All Students From Promote To Class Students*/    
   
        
          /*To Promote Class Students Process */        
        $(document).on('click','#btn-promote-class-students',function() {
            
            /*To Check else if promote_to_class_students li's length is >1 (Means 1 Or More Than 1 Students In Class Student SIde side)*/
            
        if($('ul#promote_to_class_students li').length>=1)
          {
          
            var promote_to_class_students = [];    
             /*Get School Name & Class Name From Selectboxes To Show In Header */
              school_name = $("#schools option[value='"+$("#schools").val()+"']").text();
              class_name  = $("#school_classes_by_school_id option[value='"+$("#school_classes_by_school_id").val()+"']").text();
            
              previous_school_id = $('#previous_school_id').val();
              previous_class_id  = $("#previous_class_id").val();
            
              
              
            /*To Get Previous Class Students IDs Which Will Be Promoted*/    
             $.each($("#promote_to_class_students input[name='students']:enabled"), function(){
                promote_to_class_students.push($(this).val());
             });
               
            /*jQuery Ajax*/
                $.ajax({
                url:'promote_class_students',
                type:"POST",
                data:{
                    _token:'{{csrf_token()}}',
                    promote_to_class_students:promote_to_class_students,
                    new_school_id:$('#schools').val(),
                    new_class_id:$('#school_classes_by_school_id option:selected').attr('class_id'),
                    new_class_school_id:$("#school_classes_by_school_id").val(),
                    new_school_name:school_name,
                    new_class_name:class_name,
                    previous_school_id:previous_school_id,
                    previous_class_id:previous_class_id
                    },
                success:function(data){
                    
                    if(data.message=='fail')
                    {
                        $("#show_message").html("Not Promoted");
                    }
                    else
                    {
                        $('#show_students_buttons_promote_boxes').html(data);
                    }
                }             
                });
            /*jQuery Ajax*/
               
              
          }
            
          
         
        
        
        });    
        /*To Promote Class Students Process */ 
      
        
        
        
    });//document ready        
    
</script>    
@endsection

