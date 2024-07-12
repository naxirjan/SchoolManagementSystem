<?php
use App\Sms_holiday;
?>
@extends('master/master')

@section('title')
View Holidays
@endsection

@section('page_content')

<!-- Main Content -->
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
                <li class="active">View Holidays</li>
            </ul><!-- /.breadcrumb -->



            <!-- /section:basics/content.searchbox -->
        </div>

        <!-- Page Content -->
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
                    View Holidays

                </h1>
            </div>
            
            <!-- Data Updated message  -->
            @if(session('holiday_success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                <b>{{session('holiday_success')}}</b>
            </div>
            @endif
            
            <!-- Data Not Updated message  -->
            
            @if(session('holiday_fail'))

            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                <b>{{session('holiday_fail')}}</b>
            </div>
            @endif



            <div class="row">
                <div class="col-xs-12">
                     <div style="overflow-x:auto;">
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="hidden"></th>
                                <th>Holiday Title</th>
                                <th class="hidden-480">Holiday Created By</th>
                                <th>Holiday Start Date </th>
                                <th>Holiday End Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(!empty($holidays))
                            @forelse($holidays as $holiday)
                            <tr>
                                <td class="hidden"> {{$holiday->id}}</td>
                                <td> {{$holiday->title }} </td>
                                <td class="hidden-480">
                                    <?php




                                $user_data = Sms_holiday::get_user_detail_and_role_types_by_user_id($holiday->sms_role_user_id);
					                  ?>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">
                                            {{ucwords($user_data[0]->first_name)}}
                                            &nbsp;<small class="blue"><b> ( {{ucwords($user_data[0]->role_type)}} )</b></small>
                                        </span>
                                    </div>

                                </td>
                                <td>{{date('d F Y',strtotime($holiday->start_date)) }}</td>
                                <td>{{date('d F Y',strtotime($holiday->end_date)) }}</td>
                                                                <td>
                                    <span class="<?php if($holiday->status == 1)echo " label label-sm label-success"; else echo "label label-sm label-danger" ?>">
                                        <?php if($holiday->status == 1)echo "Active"; else echo "Inactive";?> </span>
                                </td>

                                <td>
                                    <a class="btn btn-xs btn-info" href="/admin/view_holiday_detail/{{$holiday->id }}" title="View Detail">
                                        <i class="ace-icon fa fa-eye bigger-130"></i>
                                    </a>
                                    <?php    
                                    if($role_user_id == $holiday->sms_role_user_id)
                                    {
                                        ?>
                                            |<a class="btn btn-xs btn-info" href="/admin/edit_holiday/{{$holiday->id }}" title="Edit">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                    
                                        <?php
                                    }
                                     ?>                                  
                                </td>
                            </tr>
                            @empty
                            @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
                </div><!-- /.span -->
            </div>

        </div>
        <!-- End page content -->

    </div>
</div>
<!-- End Main Content -->

<div class="space-20"></div>
@endsection