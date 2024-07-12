@extends('master/master')

@section('title')
Holiday Detail
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

                <li class="active">Holiday Detail</li>
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
                    Holiday Detail

                </h1>
            </div>

            <div class="row">
                <div class="col-xs-12">

                    <div >
                        <div id="user-profile-1" class="user-profile row">
                            <div class="col-xs-12 col-sm-2"></div>

                            <div class="col-xs-12 col-sm-8">
                                <div class="space-12"></div>
                               
                                <div class="profile-user-info profile-user-info-striped">

                           
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Holiday ID </div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{$holidays['id']}}</span>
                                        </div>
                                    </div>


                                  
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Holiday Title </div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click"> {{$holidays['title']}} </span>
                                        </div>
                                    </div>



                                   
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Holiday Start Date </div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click" id="age">{{date('d F Y',strtotime($holidays['start_date']))}}</span>
                                        </div>
                                    </div>


                                    
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Holiday End Date </div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click" id="age">{{date('d F Y',strtotime($holidays['end_date']))}}</span>
                                        </div>
                                    </div>

                                   
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Holiday Description </div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click" id="signup">{{$holidays['description']}}</span>
                                        </div>
                                    </div>

                                
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Created Date</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                                {{date('d F Y',strtotime($holidays['created_at']))}}

                                            </span>
                                        </div>
                                    </div>

                                   
                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Updated Date</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                                {{date('d F Y',strtotime($holidays['updated_at']))}}
                                            </span>
                                        </div>
                                    </div>


                                    <!--Status-->
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Holiday Status </div>

                                        <div class="profile-info-value">
                                            @if($holidays['status']==1)
                                            <span class="editable editable-click">
                                                Active
                                            </span>
                                            @elseif($holidays['status']==0)
                                            <span class="editable editable-click">
                                                Inactive
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Holiday Created By </div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                                {{ucwords($user_data[0]->first_name)}}
                                                &nbsp;<small class="blue"><b> ( {{ucwords($user_data[0]->role_type)}} )</b></small>
                                            </span>
                                        </div>
                                    </div>

                                     <?php if(!empty($get_holiday_assigned_schools)){?>
                                     <div class="profile-info-row">
                                        <div class="profile-info-name"> Assigned Holidays To Schools</div>

                                        <div class="profile-info-value">
                                            <span class="editable editable-click">
                                               
                                                    
                                                <?php 

                                                foreach($get_holiday_assigned_schools as $schools)
                                                    { 
                                                        ?>
                                                        <?php echo $schools->school; ?>
                                                        <br />
                                                        <?php
                                                     }
                                                ?>
                                                
                                                
                                            </span>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                    <!--Back button-->
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