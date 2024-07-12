@extends('master/master')

@section('title')
View School Classes
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
                <li class="active">View School Classes</li>
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
                <h1>
                    View School Classes

                </h1>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    
                 <div class="tab-content no-border padding-24">
				  <div id="faq-tab-1" class="tab-pane fade in active">
                    <div id="faq-list-1" class="panel-group accordion-style1 accordion-style2">
                         <?php $i=1;?>
                            @if(!empty($school_classes))
                                @foreach($school_classes as $school_name => $schools)
                                    <div class="panel panel-default">
                                    <div class="panel-heading" >
                                
                                        <a style="background-color:#438eb9;color:white" href="#faq-<?php echo $i;?>" data-parent="#faq-list-1" data-toggle="collapse" class="accordion-toggle collapsed">
                                            <i class="ace-icon fa fa-chevron-left pull-right" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-left"></i>
                                            <i class="ace-icon fa fa-university bigger-150"></i>
                                            &nbsp;  <b>{{$school_name}}</b> 
                                        </a>
                                            
                                    </div>

                                      
                                   <!--breadcrumbs-->
                                        <div class="panel-collapse collapse in" style="" aria-expanded="true" id="faq-<?php echo $i;?>">
                                            <div class="panel-body breadcrumbs" >
                                                @if(is_array($schools))
                                                    @foreach($schools as $class_id =>$classes)
                                                        
                                                <ul id="list-school-classes" class="col-sm-12 col-xs-12 list-unstyled list-striped pricing-table-header">
                                                    
                                                <li>&nbsp;
                                                    <i class="ace-icon menu-icon glyphicon glyphicon-home bigger-100"></i>
                                                    &nbsp;
                                                    <b>{{$classes[0]}}</b>
                                                    <!-- Note: $classes[1] Has School ID value-->
                                                    
                                                    &nbsp;
                                                   
                                                    <?php $count_students=0; ?>
                                                     @foreach($all_class_students as $all_class_student)
                                                       @if(is_array($all_class_student))
                                                         @foreach($all_class_student as $key => $class_student)
                                                            @if($class_student->class==$classes[0] && $class_student->school==$school_name)
                                                            <?php $count_students++; ?>
                                                            @endif
                                                            
                                                         @endforeach     
                                                    @endif
                                                    @endforeach 
                                                    
                                                    <?php 
                                                    
                                                    if($count_students>=1)
                                                    {
                                                        ?>
                                                    <p class="pull-right">
                                                        <span class="">
                                                             <b>Total Students</b>
                                                            <span class="badge badge-warning"><b><?php echo $count_students;?></b></span>
                                                              
                                                        </span>
                                                        &nbsp;&nbsp; | &nbsp;&nbsp;
                                                         <!--NOTE:
                                                            $classes[0] = Class Name 
                                                            $classes[1] = School ID
                                                            $classes[2] = Class ID
                                                        -->
                                                        <a id="add_students_link" href="/admin/view_class_students/{{$classes[1]}}/{{$classes[2]}}" class_id='{{$classes[1]}}' style="text-decoration:none;" class="green ">

                                                            <i class="ace-icon fa fa-eye bigger-150"></i>
                                                             <b>View Students</b>

                                                        </a>
                                                         &nbsp;&nbsp; | &nbsp;&nbsp;
                                                        
                                                        <a id="add_students_link" href="/admin/add_students_to_school_class/{{$classes[1]}}/{{$classes[2]}}" class_id='{{$classes[1]}}' style="text-decoration:none;" class="blue ">
                                                           <i class="ace-icon fa fa-users bigger-130"></i>
                                                             <b>Promote Students To Next Class</b>
                                                           
                                                        </a>
                                                        &nbsp; | &nbsp;

                                                         <a school_id="{{$classes[1]}}"  school_name="{{$school_name}}" class_name="{{$classes[0]}}" class_id="{{$class_id}}" id="assign_teachers" href=""  style="text-decoration:none;" class="blue ">
                                                           <i class="ace-icon fa fa-user bigger-130"></i>
                                                             <b>Class Teacher</b>
                                                        
                                                        </a>
                                                            &nbsp;
                                                     
                                                        </p>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                    
                                                    <p class="pull-right">
                                                        <a school_id="{{$classes[1]}}"  school_name="{{$school_name}}" class_name="{{$classes[0]}}" class_id="{{$class_id}}" id="assign_teachers" href=""  style="text-decoration:none;" class="blue ">
                                                           <i class="ace-icon fa fa-user bigger-130"></i>
                                                             <b>Class Teacher</b>
                                                            &nbsp;
                                                        </a>
                                                    </p>
                                                    <?php } ?>

                                                </li>
                                                </ul>
											        @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                <?php $i++;?>
                                @endforeach    
                            @else
                            <div class="alert alert-block alert-danger">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
                                    <b>{{session('myuser_schools')[2]['school_name']}} Has No Classes!...</b>
									
                            </div>
                            @endif 
                    </div>


                     <!-- Modal -->
        <div class="modal fade" id="modalTeachers" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
               
              </div>
              <div class="modal-body" id="all_teachers">
                      
                     

                                        
             

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="assign_role_button" style="display: none;" class="btn btn-primary">Assign Teacher</button>
              </div>
            </div>
          </div>
        </div>


                </div>
                 </div>			
                    
                </div>
            </div>

        </div><!-- /.page-content -->

    </div>
</div><!-- /.main-content -->

<div class="space-30"></div>
<script type="text/javascript">
    
$(document).ready(function(){

      $(document).on('change','input[name="teacher"]',function() {      
             var role_user_id=[];

                 $.each($("input[name='teacher']:checked"), function(){
                role_user_id.push($(this).val());
            });  


            if(role_user_id.length >= 1 )
            {
                 $("#assign_role_button").show();
            }
            else if(role_user_id.length == 0 )
            {
                $("#assign_role_button").hide();
            }

            });
       
      $("#assign_role_button").click(function(){
                
                var role_user_id=[];

                 $.each($("input[name='teacher']:checked"), function(){
                role_user_id.push($(this).val());
             });  

                  var school_id = $('#school_id').val();
                  var class_id = $('#class_id').val();
                  var school_name = $('#school_name').val();
                  var class_name = $('#class_name').val();
                  var school_teacher  = $('#school_teacher').val();

                  $.ajax({
                    url:'assign_teachers_to_class',
                    type:"POST",
                    data:{
                    _token:'{{csrf_token()}}',
                    role_user_id:role_user_id,
                    school_id:school_id,
                    class_id:class_id,
                    school_name:school_name,
                    class_name:class_name,
                    },
                    success:function(data)
                      {
                         $("#modalTeachers").modal('show');
                         $('#all_teachers ').html(data);
                      },
                    });

           }); 



         $(document).on('click','#assign_teachers',function(e) {    
            e.preventDefault();
                
                $("#modal-title").html($(this).attr('school_name'));
                $("#modal-header").html($(this).attr('school_name')+" Teachers");
                $("#modal-school_teachers").html("Assign Teachers To "+$(this).attr('class_name'));


                var school_id = $(this).attr('school_id');
                var class_id = $(this).attr('class_id');         
                var school_name =$(this).attr('school_name');
                var class_name =$(this).attr('class_name');


                    $.ajax({
                    url:'get_teachers_by_school_id',
                    type:"POST",
                    data:{
                    _token:'{{csrf_token()}}',
                    school_id:school_id,
                    class_id:class_id,
                    class_name:class_name,
                    school_name:school_name
                    },

                    success:function(data)
                      {
                        console.log(data);
                         $("#modalTeachers").modal('show');
                         $('#all_teachers ').html(data);  
                      },
                    error: function(XMLHttpRequest, textStatus, errorThrown)
                     { 
                            alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                     }

                    });


                });

        });
</script>

@endsection