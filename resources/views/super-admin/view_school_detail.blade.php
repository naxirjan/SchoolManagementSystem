@extends('master/master')

@section('title')
School Detail
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

                <li class="active">School Detail</li>
            </ul><!-- /.breadcrumb -->

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
                                <div class="dropdown dropdown-colorpicker"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="btn-colorpicker" style="background-color:#438EB9"></span></a>
                                    <ul class="dropdown-menu dropdown-caret">
                                        <li><a class="colorpick-btn selected" href="#" style="background-color:#438EB9;" data-color="#438EB9"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#222A2D;" data-color="#222A2D"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#C6487E;" data-color="#C6487E"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#D0D0D0;" data-color="#D0D0D0"></a></li>
                                    </ul>
                                </div>
                            </div>
                            <span>&nbsp; Choose Skin</span>
                        </div>

                        <!-- /section:settings.skins -->

                        <!-- #section:settings.navbar -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar">
                            <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                        </div>

                        <!-- /section:settings.navbar -->

                        <!-- #section:settings.sidebar -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar">
                            <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                        </div>

                        <!-- /section:settings.sidebar -->

                        <!-- #section:settings.breadcrumbs -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs">
                            <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                        </div>

                        <!-- /section:settings.breadcrumbs -->

                        <!-- #section:settings.rtl -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl">
                            <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                        </div>

                        <!-- /section:settings.rtl -->

                        <!-- #section:settings.container -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container">
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
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover">
                            <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact">
                            <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight">
                            <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                        </div>

                        <!-- /section:basics/sidebar.options -->
                    </div><!-- /.pull-left -->
                </div><!-- /.ace-settings-box -->
            </div><!-- /.ace-settings-container -->


            <div class="page-header">
                <h1>
                    School Detail

                </h1>
            </div>

            <div class="row">
                <div class="col-xs-12">

                    <div class="">
                        <div id="user-profile-1" class="user-profile row">
                            <div class="col-xs-12 col-sm-2"></div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="space-12"></div>
                                <!--School Information-->
                                <div class="profile-user-info profile-user-info-striped">

                                    <!--School Name-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Name</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{ucfirst($school[0]->school)}}</span>
                                        </div>
                                    </div>

                                    <!--School Email-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Email</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click" id="age">{{$school[0]->email}}</span>
                                        </div>
                                    </div>
                                    <!--School Phone-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Phone</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{ucfirst($school[0]->phone_number)}}</span>
                                        </div>
                                    </div>
                                    <!--District Operation-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">District Operation</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                                {{ucfirst($school[0]->district_operation_full_name)}}

                                            </span>
                                        </div>
                                    </div>
                                    <!--Created Date-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Created Date</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click" id="age">{{date("d F Y",strtotime($school[0]->created_at) )}}</span>
                                        </div>
                                    </div>

                                    <!--Updated Date-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Updated Date</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click" id="age">{{date("d F Y",strtotime($school[0]->updated_at) )}}</span>
                                        </div>
                                    </div>

                                    <!--School Address-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Address </div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{ucwords($school[0]->address)}}</span>
                                        </div>
                                    </div>
                                    <!--School Description-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Description</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                                {{ucwords($school[0]->school_description)}}
                                            </span>
                                        </div>
                                    </div>
                                    <!--Status-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Status</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                                @if($school[0]->status==1)
                                                Active
                                                @else
                                                Inactive
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <!--Back button-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name" style="background-color: white"> &nbsp;&nbsp;&nbsp;</div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                                <a href="/super_admin/view_schools" style="float:right">
                                                    <button class="btn btn-xl btn-info">
                                                        <i class="ace-icon fa fa-arrow-left icon-on-left"></i>
                                                        Back
                                                    </button>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-10"></div>
                            </div>
                            <div class="col-xs-12 col-sm-2"></div>
                        </div>
                    </div>



                    <!-- PAGE CONTENT ENDS -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="space-30"></div>

@endsection