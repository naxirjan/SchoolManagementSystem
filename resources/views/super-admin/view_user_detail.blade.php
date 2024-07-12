@extends('master/master')

@section('title')
User Detail
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
                <li class="active">User Detail</li>
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
                    User Detail
                </h1>
            </div><!-- /.page-header -->

            {{--dd($user_info['0']['profile_image'])--}}

            <div class="row">
                <div class="col-xs-12 col-sm-3 center">
                    <div>
                        <!--profile.picture -->
                        <span class="profile-picture" style="border-radius:50%;border:1px solid black">
                            <img id="avatar" class="img-responsive" alt="User Profile" src="{{asset('storage/user_profile_images')}}/{{$user_info['0']['profile_image']}}" width="200" height="200" style="border-radius:50%;">
                        </span>
                        <!--profile.picture -->
                        <div class="space-4"></div>

                        <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                            <div class="inline position-relative">
                                <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                    <?php
                                        if($user_info['0']['middle_name'] == "")
                                        {
                                            ?>
                                    <span class="white">{{ucfirst($user_info['0']['first_name'])}}&nbsp;{{ucfirst($user_info['0']['last_name'])}}</span>
                                    <input type="hidden" id="user_name" value="<?php echo ucfirst($user_info['0']['first_name']).' '.ucfirst($user_info['0']['last_name']) ?>">
                                    <?php
                                        }
                                        else
                                        {
                                            ?>
                                    <span class="white">{{ucfirst($user_info['0']['first_name'])}}&nbsp;{{ucfirst($user_info['0']['middle_name'])}}&nbsp;{{ucfirst($user_info['0']['last_name'])}}</span>
                                    <input type="hidden" id="user_name" value="<?php echo ucfirst($user_info['0']['first_name']).' '.ucfirst($user_info['0']['middle_name']).' '.ucfirst($user_info['0']['last_name']) ?>">
                                    <?php
                                        }
                                    ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="space-6"></div>

                    @if(count($user_roles))
                    <!--User Roles-->
                    <div class="col-sm-12 infobox-container">
                        <div class="space-3"></div>

                        <h3 class="blue">
                            Assigned Roles
                        </h3>

                        @foreach ($user_roles as $user)
                        <center>
                            <div class="infobox infobox-green">
                                <div class="infobox-icon">
                                    <i class="ace-icon fa fa-lock"></i>
                                </div>
                                <div class="infobox-data">
                                    <h4>{{ucwords($user->role_type)}}</h4>
                                </div>
                            </div>
                        </center>
                        @endforeach
                        <div class="space-20"></div>
                    </div>
                    <!--User Roles-->
                    @endif
                </div>

                <div class="col-xs-12 col-sm-7">
                    <div class="space-12"></div>

                    <!--User Profile Information-->
                    <div class="profile-user-info profile-user-info-striped">

                        <!--First Name-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> First Name </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{ucfirst($user_info['0']['first_name'])}}
                                </span>
                            </div>
                        </div>

                        <!--Last Name-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Middle Name </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{ucfirst($user_info['0']['middle_name'])}}
                                </span>
                            </div>
                        </div>

                        <!--Surname-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Last Name </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click" id="age">
                                    {{ucfirst($user_info['0']['last_name'])}}
                                </span>
                            </div>
                        </div>


                        <!--Email-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Email </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click" id="age">
                                    {{ucfirst($user_info['0']['email'])}}
                                </span>
                            </div>
                        </div>

                        <!--Gender-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Gender </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click" id="signup">
                                    {{ucfirst($user_info['0']['gender'])}}
                                </span>
                            </div>
                        </div>

                        <!--Contact Number-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Contact Number </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click" id="signup">
                                    {{ucfirst($user_info['0']['contact_number'])}}
                                </span>
                            </div>
                        </div>

                        <!--Address-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Home Address </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click" id="signup">
                                    {{ucfirst($user_info['0']['address'])}}
                                </span>
                            </div>
                        </div>

                        <!--Created Date-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Created Date </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click" id="signup">
                                    {{date('d F Y',strtotime($user_info['0']['created_at']))}}

                                </span>
                            </div>
                        </div>

                        <!--Updated Date:-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Updated Date </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click" id="signup">
                                    {{date('d F Y',strtotime($user_info['0']['updated_at']))}}
                                </span>
                            </div>
                        </div>

                        <!--Qualification-->
                        <div class="profile-info-row">
                            <div class="profile-info-name">Qualification</div>

                            <div class="profile-info-value">
                                <span class="editable editable-click">

                                    {{$qualification['0']->degree_title}}

                                </span>
                            </div>
                        </div>

                        <!--Status-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Account Status </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    @if($user_info['0']['status'] == 1)
                                    Active
                                    @else
                                    Inactive
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!--Account Created By-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Account Created By </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{ucfirst($created_by['0']->first_name)}}&nbsp;{{ucfirst($created_by['0']->last_name)}}&nbsp;&nbsp;&nbsp;

                                    <small class="blue"><b> ({{ucfirst($created_by['0']->role_type)}})</b></small>
                                </span>
                            </div>
                        </div>
                        <!--Account Created By-->
                        <?php
                        if($user_schools)
                        {
                            foreach ($user_schools as $key => $value) 
                            {
                                if($key == 2)
                                {
                                    ?>
                        <!--Admin Schools-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Admin Schools </div>
                            <div class="profile-info-value">
                                <?php
                                                foreach ($value as $school) 
                                                {
                                                    ?>
                                <span class="editable editable-click">
                                    <?php echo $school; ?>

                                </span>
                                <br />
                                <?php
                                                }
                                            ?>

                            </div>
                        </div>
                        <!--Admin Schools-->
                        <?php
                                }
                                else if($key == 3)
                                {
                                    ?>
                        <!--Teacher Schools-->
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Teacher Schools </div>
                            <div class="profile-info-value">
                                <?php
                                                foreach ($value as $school) 
                                                {
                                                    ?>
                                <span class="editable editable-click">
                                    <?php echo $school; ?>

                                </span>
                                <br />
                                <?php
                                                }
                                            ?>

                            </div>
                        </div>
                        <!--Teacher Schools-->
                        <?php
                                }
                            }
                        }
                        ?>
                        <div class="profile-info-row">
                            <div class="profile-info-name" style="background-color: white"> &nbsp;&nbsp;&nbsp;</div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    <a href="/super_admin/view_users" style="float:right">
                                        <button class="btn btn-xl btn-info">
                                            <i class="ace-icon fa fa-arrow-left icon-on-left"></i>
                                            Back
                                        </button>
                                    </a>
                                </span>
                            </div>
                        </div>
                        {{--dd($user_roles)--}}
                    </div>
                </div>
            </div>

            <!-- Roles Active or Inactive START-->
            <?php
if($user_id != session('user_id'))
{
?>
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">

                    <div class="tab-content no-border padding-24">
                        <div id="faq-tab-1" class="tab-pane fade in active">
                            <div id="faq-list-1" class="panel-group accordion-style1 accordion-style2">
                                <?php $i=1;?>
                                <!--Panel Body Starts-->
                                @if($user_roles)
                                @foreach($user_roles as $role)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <a style="background-color:#438eb9;color:white" href="#faq-<?php echo $i;?>" data-parent="#faq-list-1" data-toggle="collapse" class="accordion-toggle collapsed">
                                            <i class="ace-icon fa fa-chevron-left pull-right" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-left"></i>
                                            <i class="ace-icon fa fa-cog bigger-150"></i>
                                            &nbsp; <b>Role: {{$role->role_type}}</b>
                                        </a>
                                    </div>
                                    <!--breadcrumbs-->
                                    <div class="panel-collapse collapse" id="faq-<?php echo $i;?>">
                                        <div class="panel-body breadcrumbs">
                                            @if($role->role_id == 1)
                                            <ul id="message_for_super_admin" class="col-sm-12 col-xs-12 list-unstyled list-striped pricing-table-header"></ul>
                                            <ul id="list-super-admin" class="col-sm-12 col-xs-12 list-unstyled list-striped pricing-table-header">
                                                <li>
                                                    <div class="radio">
                                                        <label>
                                                            <input class="ace" type="radio" role_user_id="<?php echo $role->role_user_id;?>" name="super_admin" value="super_admin_active" <?php if($role->status == 1) {echo "checked";}?>/> <span class="lbl"> Active</span>
                                                        </label>
                                                        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
                                                        <label>
                                                            <input class="ace" type="radio" role_user_id="<?php echo $role->role_user_id;?>" name="super_admin" value="super_admin_inactive" <?php if($role->status == 0) {echo "checked";}?>/> <span class="lbl"> Inactive</span>
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                            @else
                                            @foreach($user_schools_without_status as $key => $school)
                                            @if($role->role_id == $school->role_id)
                                            @if($role->role_id == 2)
                                            <ul id="message_for_school_admin" class="col-sm-12 col-xs-12 list-unstyled list-striped pricing-table-header"></ul>
                                            <ul id="list_school_admin" class="col-sm-12 col-xs-12 list-unstyled list-striped pricing-table-header">
                                                <li>
                                                    <i class="ace-icon menu-icon glyphicon glyphicon-home bigger-100"></i>
                                                    {{$school->school}}
                                                    <span style="float:right; margin-top: -10px; margin-right: 15px;">
                                                        <div class="radio">
                                                            <label>
                                                                <input class="ace" type="radio" school_role_user_id="<?php echo $school->sms_school_role_user_id;?>" admin_school_name="<?php echo $school->school;?>" name="school_status_<?php echo $school->sms_school_role_user_id;?>" value="school_admin_active" <?php if($school->status == 1) {echo "checked";}?>/><span class="lbl"> Active</span>
                                                            </label>
                                                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
                                                            <label>
                                                                <input class="ace" type="radio" school_role_user_id="<?php echo $school->sms_school_role_user_id;?>" admin_school_name="<?php echo $school->school;?>" name="school_status_<?php echo $school->sms_school_role_user_id;?>" value="school_admin_inactive" <?php if($school->status == 0) {echo "checked";}?>/><span class="lbl"> Inactive</span>
                                                            </label>
                                                        </div>
                                                    </span>
                                                </li>
                                            </ul>
                                            @elseif($role->role_id == 3)
                                            <ul id="message_for_school_teacher" class="col-sm-12 col-xs-12 list-unstyled list-striped pricing-table-header"></ul>
                                            <ul id="list-teacher_schools" class="col-sm-12 col-xs-12 list-unstyled list-striped pricing-table-header">
                                                <li>
                                                    <i class="ace-icon menu-icon glyphicon glyphicon-home bigger-100"></i>
                                                    {{$school->school}}
                                                    <span style="float:right; margin-top: -10px; margin-right: 15px;">
                                                        <div class="radio">
                                                            <label>
                                                                <input class="ace" type="radio" school_role_user_id="<?php echo $school->sms_school_role_user_id;?>" teacher_school_name="<?php echo $school->school;?>" name="school_status_<?php echo $school->sms_school_role_user_id;?>" value="school_teacher_active" <?php if($school->status == 1) {echo "checked";}?>/><span class="lbl"> Active</span>
                                                            </label>
                                                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
                                                            <label>
                                                                <input class="ace" type="radio" school_role_user_id="<?php echo $school->sms_school_role_user_id;?>" teacher_school_name="<?php echo $school->school;?>" name="school_status_<?php echo $school->sms_school_role_user_id;?>" value="school_teacher_inactive" <?php if($school->status == 0) {echo "checked";}?>/><span class="lbl"> Inactive</span>
                                                            </label>
                                                        </div>
                                                    </span>
                                                </li>
                                            </ul>
                                            @endif
                                            @endif
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <?php $i++;?>
                                @endforeach
                                @else
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    <b>No Any Role Assigned To User!...</b>
                                    <br>
                                </div>
                                @endif
                                <!--Panel Body End-->


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1"></div>
            </div>
            <?php
}
?>
            <!-- Roles Active or Inactive END-->


        </div>



    </div>
</div><!-- /.main-content -->

<script type="text/javascript">
    $(document).ready(function() {

        $('input:radio[name="super_admin"]').change(function() {

            var user_name = $('#user_name').val();

            if (this.checked && this.value == 'super_admin_active') {
                var role_user_id = $(this).attr("role_user_id");
                $.ajax({
                    url: 'super_admin_active_or_deactive',
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        role_user_id: role_user_id,
                        user_name: user_name,
                        flag: 'active'
                    },
                    success: function(response) {
                        $('#message_for_super_admin').css('margin-top', 10);
                        $('#message_for_super_admin').html(response);
                        $('#message_for_super_admin').css('margin-bottom', -10);
                    }
                });
            }
            if (this.checked && this.value == 'super_admin_inactive') {
                var role_user_id = $(this).attr("role_user_id");

                $.ajax({
                    url: 'super_admin_active_or_deactive',
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        role_user_id: role_user_id,
                        user_name: user_name,
                        flag: 'inactive'
                    },
                    success: function(response) {
                        $('#message_for_super_admin').css('margin-top', 10);
                        $('#message_for_super_admin').html(response);
                        $('#message_for_super_admin').css('margin-bottom', -10);
                    }
                });
            }
        });

        $('input[type=radio]').change(function() {

            var user_name = $('#user_name').val();

            if (this.checked && this.value == 'school_admin_active') {
                var school_role_user_id = $(this).attr("school_role_user_id");
                var school_name = $(this).attr("admin_school_name");
                //$('ul #message_for_school_admin').css('margin-top',10);
                $.ajax({
                    url: 'active_or_inactive_school_for_admin_or_teacher',
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        school_role_user_id: school_role_user_id,
                        school_name: school_name,
                        user_name: user_name,
                        flag: 'active'
                    },
                    success: function(response) {
                        $('#message_for_school_admin').css('margin-top', 10);
                        $('#message_for_school_admin').html(response);
                        $('#message_for_school_teacher').css('margin-bottom', -10);
                    }
                });

            } else if (this.checked && this.value == 'school_admin_inactive') {
                var school_role_user_id = $(this).attr("school_role_user_id");
                var school_name = $(this).attr("admin_school_name");
                $.ajax({
                    url: 'active_or_inactive_school_for_admin_or_teacher',
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        school_role_user_id: school_role_user_id,
                        school_name: school_name,
                        user_name: user_name,
                        flag: 'inactive'
                    },
                    success: function(response) {
                        $('#message_for_school_admin').css('margin-top', 10);
                        $('#message_for_school_admin').html(response);
                        $('#message_for_school_teacher').css('margin-bottom', -10);
                    }
                });
            } else if (this.checked && this.value == 'school_teacher_active') {
                var school_role_user_id = $(this).attr("school_role_user_id");
                var school_name = $(this).attr("teacher_school_name");
                $.ajax({
                    url: 'active_or_inactive_school_for_admin_or_teacher',
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        school_role_user_id: school_role_user_id,
                        school_name: school_name,
                        user_name: user_name,
                        flag: 'active',
                        teacher: "teacher"
                    },
                    success: function(response) {
                        $('#message_for_school_teacher').css('margin-top', 10);
                        $('#message_for_school_teacher').html(response);
                        $('#message_for_school_teacher').css('margin-bottom', -10);
                    }
                });
            } else if (this.checked && this.value == 'school_teacher_inactive') {
                var school_role_user_id = $(this).attr("school_role_user_id");
                var school_name = $(this).attr("teacher_school_name");
                $.ajax({
                    url: 'active_or_inactive_school_for_admin_or_teacher',
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        school_role_user_id: school_role_user_id,
                        school_name: school_name,
                        user_name: user_name,
                        flag: 'inactive',
                        teacher: "teacher"
                    },
                    success: function(response) {
                        $('#message_for_school_teacher').css('margin-top', 10);
                        $('#message_for_school_teacher').html(response);
                        $('#message_for_school_teacher').css('margin-bottom', -10);
                    }
                });
            }
        });
    });
</script>
@endsection