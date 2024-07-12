@extends('master/master')

@section('title')
Edit Qualification
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
                <li class="active">Edit Qualification</li>
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
								Edit Qualification
							</h1>
						</div><!-- /.page-header -->
           			<div class="container-fluid"> 
				 <div class="row">
                        <div class="col-xs-12">
							<!-- @if(session('qualification'))
                            <h3 class=" text-center alert alert-success"><b>{{session('qualification')}}</b></h3>
                            @endif
                            
                            @if(session('qualification_fail'))
                            <h3 class="text-center alert alert-danger"><b>{{session('qualification_fail')}}</b></h3>
                            @endif         -->                  
                                                      
              {!! Form::open(array("url"=>"/super_admin/update_qualification/","method"=>"post","class"=>"form-horizontal","role"=>"form",'id'=>'edit_qualification_form')) !!}			
               
              	        <div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Degree Title</label>
                                <div class="col-sm-5">
                         {!! Form::hidden("id",$qualifications[0]['id']) !!} 
                                    
		                 {!! Form::text("degree_title",$qualifications[0]['degree_title'],array('id'=>'degree_title',"placeholder"=>"Enter Degree Title", "class"=>"form-control")) !!}    
                                    @if($errors->has("degree_title"))
                                        
                                        <span class="badge badge-danger">{{$errors->first("degree_title")}}</span>		
                                     @endif
                                </div>
                            <div class="col-sm-4"></div>
							</div>
							<div class="form-group">
					          <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Degree Description </label>
                           <div class="col-sm-5">
	                       {!! Form::textarea("degree_description",$qualifications[0]['degree_description'],array('id'=>'degree_description',"placeholder"=>"Enter Degree Description","rows"=>10,"class"=>"form-control")) !!}
                         @if($errors->has("degree_description"))
                                    <span class="badge badge-danger">{{$errors->first("degree_description")}}</span>			
                                    @endif
								</div>
                            <div class="col-sm-4"></div>    
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Degree Status </label>
                                	<div class="col-sm-9">
                                		<div class="radio" name="status">
													<label>
														<input name="status" value="1" type="radio" class="ace" <?php if($qualifications[0]['status'] == 1) echo "checked";?> />
														<span class="lbl"> Active </span>
													</label>
													<label>
														<input name="status" value="0" type="radio" class="ace" <?php if($qualifications[0]['status'] == 0) echo "checked";?> />
														<span class="lbl"> Inactive</span>
													</label>
										</div> 
  									</div>
  							  </div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                <div class="col-sm-9"> 
                                    <input type="hidden" name="qual_id" value="{{ $qualifications[0]['id'] }}"/>
  									{!! Form::submit("Update Qualification", array('id'=>'btn-update',"class"=>"btn btn-primary")) !!}      
								</div>
							</div>


                    		<div class="form-group">
								<div class="text-center">
									
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
    $(document).ready(function(){
        
         userForm_1 = $("#edit_qualification_form").validate({
              rules: {
                degree_title: {
                required: true,
                },
                degree_description: {
                  required: true,                 
                },
                },
                messages: {
                degree_title: {
                required:'<span class="badge badge-danger">Please enter qualification title</span>',
                },
                 degree_description: {
                required:'<span class="badge badge-danger">Please enter qualification description</span>',
                },    
                }, 
         });
       
    });

</script>  
  
<!-- jquery validation -->

@endsection