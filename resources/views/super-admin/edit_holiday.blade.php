@extends('master/master')

@section('title')
Edit Holiday
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
                <li class="active">Edit Holiday</li>
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
                    Edit Holiday
                </h1>
            </div><!-- /.page-header -->

            @if(session('holiday_success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                <b>{{session('holiday_success')}}</b>
            </div>
            @endif

            @if(session('holiday_fail'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                <b>{{session('holiday_fail')}}</b>
            </div>
            @endif


            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">

                        {!! Form::open(array("url"=>"/super_admin/update_holiday/","method"=>"post","class"=>"form-horizontal","role"=>"form",'id'=>'edit_holiday_form')) !!}

                        {!! Form::hidden("id",$holiday[0]['id']) !!} 
                        <?php date_default_timezone_set("Asia/Karachi");?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Date Range </label>
                            <div class="col-sm-5" id="div-date-range">

                                <input class="form-control" type="text" name="daterangepicker" id="id_date_range_picker_1" />
                                @if($errors->has("daterangepicker"))
                                <span class="badge badge-danger">Please enter holiday date range</span>
                                @endif
                                <input type="hidden" id="start" value="{{$holiday[0]['start_date']}}">
                                <input type="hidden" id="end" value="{{$holiday[0]['end_date']}}">

                            </div>
                            <div class="col-sm-4"></div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Holiday Title</label>
                            <div class="col-sm-5">
                                {!! Form::text("title",$holiday[0]['title'],array('id'=>'title',"placeholder"=>"Enter Holiday Title", "class"=>"form-control")) !!}
                                @if($errors->has("title"))
                               
                                <span class="badge badge-danger">{{$errors->first("title")}}</span>
                                @endif
                            </div>
                            <div class="col-sm-4"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Holiday Description </label>
                            <div class="col-sm-5">
                                {!! Form::textarea("description",$holiday[0]['description'],array('id'=>'description',"placeholder"=>"Enter Holiday Description","rows"=>10,"class"=>"form-control")) !!}
                                @if($errors->has("description"))
                             
                                <span class="badge badge-danger">{{$errors->first("description")}}</span>
                                @endif
                            </div>
                            <div class="col-sm-4"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Holiday Status </label>
                            <div class="col-sm-9">
                                <div class="radio" name="status">
                                    <label>
                                        <input name="status" value="1" type="radio" class="ace" <?php if($holiday[0]['status']==1) echo "checked" ;?> />
                                        <span class="lbl"> Active </span>
                                    </label>
                                    <label>
                                        <input name="status" value="0" type="radio" class="ace" <?php if($holiday[0]['status']==0) echo "checked" ;?> />
                                        <span class="lbl"> Inactive</span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                            <div class="col-sm-9">
                                <input type="hidden" name="holiday_id" value="{{ $holiday[0]['id'] }}" />
                                {!! Form::submit("Update Holiday", array('id'=>'btn-update',"class"=>"btn btn-primary")) !!}
                            </div>
                        </div>



                        {!! Form::close() !!}

                    </div><!-- /.col -->
                </div>
            </div>




        </div><!-- /.page-content -->

    </div>
</div><!-- /.main-content -->
<div class="space-20"></div>



<!-- jquery validation -->
<script>
    $(document).ready(function() {

        userForm_1 = $("#edit_holiday_form").validate({
            rules: {
                daterangepicker: {
                    required: true,
                },
                title: {
                    required: true,
                },
                description: {
                    required: true,
                },
            },
            messages: {
                daterangepicker: {
                    required: '<span class="badge badge-danger">Please enter holiday date range</span>',
                },
                title: {
                    required: '<span class="badge badge-danger">Please enter holiday title</span>',
                },
                description: {
                    required: '<span class="badge badge-danger">Please enter holiday description</span>',
                },
            },
        });

    });
</script>
<!-- jquery validation -->


<!-- jquery validation -->
<script type="text/javascript">
    jQuery(function($) {

        $('input[name=daterangepicker]').daterangepicker({
            'applyClass': 'btn-sm btn-success',
            'cancelClass': 'btn-sm btn-default',
            locale: {
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
            }
        })

        $('#id_date_range_picker_1').val($('#start').val() + ' - ' + $('#end').val());




        $('#edit_holiday_form').submit(function() {

            if (($('#id_date_range_picker_1_error').html() != '')) {
                $('.daterangepicker').hide();

            }

        });

        $('#id_date_range_picker_1').click(function() {
            $('.daterangepicker').show();
        });

        $('.applyBtn').click(function() {
            $('#div-date-range span').hide();
        });

    });
</script>

@endsection