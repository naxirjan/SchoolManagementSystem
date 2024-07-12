@extends('master/master')

@section('title')
Add Class
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
                <li class="active">Add Class</li>

                   
                
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
                    Add Class
                    

                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                     @if(session('insert_message_success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>

                        <strong>
                             {{session('insert_message_success')}}
                        </strong>
                        </div>
                    @elseif(session('insert_message_fail'))
                       <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>

                        <strong>
                             {{session('insert_message_fail')}}
                        </strong>
                        </div>
                    
                    @endif

                    {!! Form::open(array("url"=>"super_admin/add_class_process", "method"=>"post","class"=>"form-horizontal",'id'=>'add_classes_form',"role"=>"form")) !!}


                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Class Name</label>
                        <div class="col-sm-5">
                             <span class="badge badge-info">Note:Class Name Like: Class 1</span>
                           
                            {!! Form::text("class_name", NULL, array('id'=>'class_name',"placeholder"=>"Enter Class Name", "class"=>"form-control")) !!}
                            @if($errors->has("class_name"))
                        
                            <span class="badge badge-danger">{{$errors->first("class_name")}}</span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    
                     <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Class Description</label>
                        <div class="col-sm-5">
                            {!! Form::textarea('class_description', NULL, ['id'=>'class_description',"class"=>"form-control","placeholder"=>"Enter Class Description","rows"=>10]) !!}
                            @if($errors->has("class_description"))
                           
                            <span class="badge badge-danger">{{$errors->first("class_description")}}</span>
                            @endif
                        </div>
                         <div class="col-sm-4"></div> 
                    </div>
                    
                    
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Class Status</label>
                        <div class="col-sm-9">
                            <label class="control-label no-padding-right">
                                {!! Form::radio('class_status', '1',true,['class'=>'ace']); !!}
                                <span class="lbl">&nbsp;Active</span>
                            </label>
                                &nbsp;
                                &nbsp;
                            <label class="control-label no-padding-right">
                                {!! Form::radio('class_status', '0',false,['class'=>'ace']); !!}
                                <span class="lbl">&nbsp;Inactive</span>
                            </label>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                        <div class="col-sm-9">
                        {!! Form::submit("Add Class", array("class"=>"btn btn-primary")) !!} 
                        </div>
                    </div>  
                    {!! Form::close() !!}
                </div>
            </div>



        </div><!-- /.page-content -->

    </div>
</div><!-- /.main-content -->
<div class="space-30"></div>
<!-- jquery validation -->
<script>
    $(document).ready(function(){
        
         userForm_1 = $("#add_classes_form").validate({
              rules: {
                class_name: {
                    required: true,
                }, 
                class_description: {
                  required: true,                 
                },
                },
                messages: {
                class_name: {
                required:'<span class="badge badge-danger">Please enter class name</span>',
                },
                class_description: {
                required:'<span  class="badge badge-danger">Please enter class description</span>',
                },
                }, 
         });
       
    });

</script>
<!-- jquery validation -->

@endsection