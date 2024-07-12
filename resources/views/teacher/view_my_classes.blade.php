@extends('master/master')

@section('title')
View My Classes
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
                <li class="active">View My Classes</li>
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
                    View My Classes

                </h1>
            </div>
            <div class="row">
                <div class="col-sm-12">
                 <div class="tab-content no-border padding-24">
                  <div id="faq-tab-1" class="tab-pane fade in active">
                    <div id="faq-list-1" class="panel-group accordion-style1 accordion-style2">
                         
                          <?php $i=1;?>
                            @if($all_classes) 
                                 @foreach($all_classes as $class_school_id => $class)
                                    <div class="panel panel-default">
                                      <div class="panel-heading" >
                                        <a style="background-color:#438eb9;color:white" href="#faq-<?php echo $i;?>" data-parent="#faq-list-1" data-toggle="collapse" class="accordion-toggle collapsed">
                                            <i class="ace-icon fa fa-chevron-left pull-right" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-left"></i>
                                            <i class="ace-icon fa fa-university bigger-150"></i>
                                            &nbsp;  <b>{{$class}}</b> 
                                        </a>        
                                    </div>

                                      
                                   <!--breadcrumbs-->
                                        <div class="panel-collapse collapse" id="faq-<?php echo $i;?>">
                                            <div class="panel-body breadcrumbs" >
                                               

                                                @if(array_key_exists($class_school_id,$all_class_students))
                                                
                                                <table  class="dynamic-table table table-striped table-bordered table-hover">
                                                 <thead>
                                                     <tr>
                                                        <th class="hidden"></th>
                                                        <th>Image</th>
                                                        <th>Full Name</th>
                                                        <th>Gender</th>
                                                        <th>View Profile</th>
                                                     </tr>
                                                 </thead>
                                                 <tbody>


                                                    @foreach($all_class_students as $all_class_student)
                                                    @if(is_array($all_class_student))
                                                    @foreach($all_class_student as $class_student)
                                                    @if($class_school_id == $class_student['class_school_id'])
                                                    
                                                     <tr>
                                                        <td class="hidden"></td>
                                                        <td align="center"> 
                                                         @if($class_student['image']!='student_icon.jpg')
                                   <img class="img-responsive" alt="No Image" src="{{asset($class_student['student_image_path'])}}"  style="border-radius:50%;width: 50px;height: 50px;">
                                    @else
                                    <img class="img-responsive" alt="No Image" src="{{asset('storage/dumy_image/student_icon.jpg')}}"  style="border-radius:50%;width: 50px;height: 50px;">
                                    @endif   
                                                         </td>
                                                        




                                                        <td> 
                                                           {{$class_student['first_name'].' '.$class_student['last_name'] }}  
                                                        </td>
                                                        <td> {{$class_student['gender']}} </td>
                                                        <td>
                                                           
                                                            <a class="green"  href="/teacher/view_student_detail/{{$class_student['student_id']}}">
                                                               <button title="View Detail" class="btn btn-xs btn-info">
                                                                    <i class="ace-icon fa fa-eye bigger-120"></i>
                                                                </button>
                                                             </a>
                                                        </td>
                                                     </tr>
                                                     @endif
                                                     @endforeach
                                                     @endif
                                                     @endforeach
                                                     
                                                 </tbody>
                                            </table>  
                                            @else
                                            <p class="text-center"> <b>No Students In {{$class}}</b> </p>
                                                @endif
                                            

                                            </div>
                                        </div>
                                    </div>
                                <?php $i++;?>
                                @endforeach    
                            @else
                       <div class="alert alert-danger" >
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="ace-icon fa fa-times"></i>
                            </button>
                            <b> You Are Not Assigned To Any Class !...</b>
                            <br>
                        </div>
                    @endif  
                           
                    </div>



                </div>
                 </div>         
            
                </div>
            </div>

        </div><!-- /.page-content -->

    </div>
</div><!-- /.main-content -->

<div class="space-30"></div>

@endsection