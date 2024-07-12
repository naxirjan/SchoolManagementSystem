@extends('master/master')

@section('title')
Edit School
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
                <li class="active">Edit School</li>
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
                    Edit School 

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
                    {!! Form::open(array("url"=>"/super_admin/edit_school_process","id"=>"edit_school_form","method"=>"post","class"=>"form-horizontal","role"=>"form")) !!}  
                     {!! Form::hidden('id', $school['id']) !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="district_operation">District Operation</label>
                        <div class="col-sm-5">
                            {!! Form::select('district_operation',$district_operations,$school['district_operation_id'], ['id'=>"district_operation","class"=>"form-control"]) !!}
                            @if($errors->has("district_operation"))
                           
                            <span class="badge badge-danger">{{$errors->first("district_operation")}}</span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="school">School Name</label>
                        <div class="col-sm-5">
                            {!! Form::text("school", $school['school'], array("placeholder"=>"Enter School Name",'id'=>"school","class"=>"form-control")) !!}
                            {!! Form::hidden('school_old',$school['school']) !!}
                            @if($errors->has("school"))
                          
                            <span class="badge badge-danger">{{$errors->first("school")}}</span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="email">School Email</label>
                        <div class="col-sm-5">
                            {!! Form::text("email",$school['email'], array("placeholder"=>"Enter School Email",'id'=>"email","class"=>"form-control")) !!}
                            @if($errors->has("email"))
                          
                            <span class="badge badge-danger">{{$errors->first("email")}}</span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="school_number">School Number</label>
                        <div class="col-sm-5">
                            {!! Form::text("school_number",$school['phone_number'], array("placeholder"=>"Enter School Phone Number",'id'=>"school_number","class"=>"form-control")) !!}
                            @if($errors->has("school_number"))
                          
                            <span class="badge badge-danger">{{$errors->first("school_number")}}</span>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="school_address">School Address</label>
                        <div class="col-sm-5">
                             {!! Form::textarea("school_address",$school['address'], array('id'=>'school_address',"placeholder"=>"Enter School Address","rows"=>2,"class"=>"form-control")) !!}
                            @if($errors->has("school_address"))
                            <label id="school_address-error2" class="error" for="school_address">
                              
                                <span class="badge badge-danger">
                                {{$errors->first("school_address")}}
                                </span>
                            </label>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="school_description">School Description</label>
                        <div class="col-sm-5">
                             {!! Form::textarea("school_description",$school['school_description'], array('id'=>'school_description',"placeholder"=>"Enter School Description","rows"=>10,"class"=>"form-control")) !!}
                            @if($errors->has("school_description"))
                            <label id="school_description-error2" class="error" for="school_description">
                               <span class="badge badge-danger">{{$errors->first("school_description")}}</span>
                            </label>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>    
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">School Status</label>
                        <div class="col-sm-9">
                            @if($school['status'] == 1)
                            <label class="control-label no-padding-right">
                                {!! Form::radio('school_status', '1',true,['class'=>'ace']); !!}
                                <span class="lbl">&nbsp;Active</span>
                            </label>
                            &nbsp;
                            &nbsp;
                            <label class="control-label no-padding-right">
                                {!! Form::radio('school_status', '0',false,['class'=>'ace']); !!}
                                <span class="lbl">&nbsp;Inactive</span>
                            </label>
                            @else
                            <label class="control-label no-padding-right">
                                {!! Form::radio('school_status', '1',false,['class'=>'ace']); !!}
                                <span class="lbl">&nbsp;Active</span>
                            </label>
                            &nbsp;
                            &nbsp;
                            <label class="control-label no-padding-right">
                                {!! Form::radio('school_status', '0',true,['class'=>'ace']); !!}
                                <span class="lbl">&nbsp;Inactive</span>
                            </label>
                            @endif
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                        <div class="col-sm-9">
                            {!! Form::submit("Update School", array("class"=>"btn btn-primary")) !!}
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
    $(document).ready(function() {
        //alert("working");
        userForm_1 = $("#edit_school_form").validate({
            rules: {
                district_operation: {
                    required: true,
                },
                school: {
                    required: true,
                },
                email: {
                    required: true,
                },
                school_number: {
                    required: true,
                },
                school_address: {
                    required: true,
                },
                school_description: {
                    required: true,
                },
            },
            messages: {
                district_operation: {
                    required: '<span class="badge badge-danger">Please select district operation</span>',
                },
                school: {
                    required: '<span class="badge badge-danger">Please enter school name</span>',
                },
                email: {
                    required: '<span class="badge badge-danger">Please enter school email</span>',
                },
                school_number: {
                    required: '<span class="badge badge-danger">Please enter school number</span>',
                },
                school_address: {
                    required: '<span class="badge badge-danger">Please enter school address</span>',
                },
                school_description: {
                    required: '<span class="badge badge-danger">Please enter school description</span>',
                },
            },
        });


        

    });
</script>




@endsection