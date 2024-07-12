<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>HSAMS >> Forgot Password</title>

    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

<link rel="icon" type="image/png"  href="https://cdn4.iconfinder.com/data/icons/e-learning-2-4/66/142-512.png" />
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/font-awesome.css" />

    <!-- page specific plugin styles -->

    <!-- text fonts -->
    <link rel="stylesheet" href="../assets/css/ace-fonts.css" />
    <!-- ace styles -->
    <link rel="stylesheet" href="../assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
    <!-- ace settings handler -->
    <script src="../assets/js/ace-extra.js"></script>
     <style>
        .error{
            display: block;
        }        
    </style>

</head>

<body class="no-skin">
    <!-- #section:basics/navbar.layout -->
    <div id="navbar" class="navbar navbar-default">
        <script type="text/javascript">
            try {
                ace.settings.check('navbar', 'fixed')
            } catch (e) {}
        </script>

        <div class="navbar-container" id="navbar-container">
            <div class="navbar-header pull-left">
                <!-- #section:basics/navbar.layout.brand -->
                <a href="/" class="navbar-brand">
                    <small>
                        <i class="menu-icon  fa fa-users"></i>
                        &nbsp;
                        <span class="bolder">HSAMS - </span>
                        Hidaya Schools Attendance Management System
                    </small>
                </a>

                <!-- /section:basics/navbar.layout.brand -->

                <!-- #section:basics/navbar.toggle -->

                <!-- /section:basics/navbar.toggle -->
            </div>


            <!-- /section:basics/navbar.dropdown -->
        </div><!-- /.navbar-container -->
    </div>

    <!-- /section:basics/navbar.layout -->
    <div class="main-container" id="main-container">
        <script type="text/javascript">
            try {
                ace.settings.check('main-container', 'fixed')
            } catch (e) {}
        </script>

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
                        <li>
                            <a href="/">Login</a>
                        </li>
                        <li>
                            <span>Forgot Password</span>
                        </li>

                    </ul><!-- /.breadcrumb -->


                    <!-- /section:basics/content.searchbox -->
                </div>


                <div class="page-content">
                    <div class="page-header">
                        <h1>
                            Forgot Password
                            <small>
                                <i class="icon-double-angle-right"></i>
                                <b id="forgot_pass_text">Please Enter Your Email Address To Verify</b>
                            </small>
                        </h1>
                    </div>


                    <div class="row">
                        <div class="col-xs-12">
                            <div id="email_not_found"></div>
                            @if(session('forgot_password_fail_message'))
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="ace-icon fa fa-times"></i>
                                </button>
                                <strong>
                                    {{ session('forgot_password_fail_message') }}
                                </strong>
                                <br>
                            </div>
                            @endif
                            {!! Form::open(array("url"=>"forgot_password_login", 'id'=>"forgot_form","method"=>"post","class"=>"form-horizontal","role"=>"form")) !!}
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email Address</label>
                                <div class="col-sm-5">
                                    {!! Form::text("email", NULL, array("placeholder"=>"Enter Your Email",'id'=>"email","class"=>"form-control")) !!}
                                    <input type="hidden" name="email_address" value="" id="hidden_email"> 
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group" id="btn_email_div">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <button type="button" name="verify_email" id="verify_email" class="btn btn-info">Verify Email</button>
                                </div>
                            </div>
                            <div id="password_fields" style="display: none">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">New Password </label>
                                    <div class="col-sm-5">
                                        {!! Form::password("password", array("placeholder"=>"Enter Your New Password",'id'=>"password","class"=>"form-control")) !!}
                                        @if($errors->has("password"))
                                        <span class="badge badge-danger">{{$errorrors->first("password")}}</span> 
                                        @endif
                                    </div>
                                    <div class="col-sm-4"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Confirm Password </label>
                                    <div class="col-sm-5">
                                        {!! Form::password("confirm_password", array("placeholder"=>"Confirm Your New Password",'id'=>"confirm_password","class"=>"form-control")) !!}
                                        @if($errors->has("confirm_password"))
                                        <span class="badge badge-danger">
                                            {{$errorrors->first("confirm_password")}}
                                        </span> 
                                        @endif
                                    </div>
                                    <div class="col-sm-4"></div>
                                </div>
                                <div class="form-group" id="btn_email_div">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                        {!! Form::submit("Reset Password", array("class"=>"btn btn-primary")) !!}
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div><!-- /.col -->
                    </div>
                </div>                              
            </div>
        </div>
        <!-- /.main-content -->



        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script type="text/javascript">
        window.jQuery || document.write("<script src='../assets/js/jquery.js'>" + "<" + "/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.js'>" + "<" + "/script>");
    </script>
    <script src="../assets/js/bootstrap.js"></script>

     <!--JQuery Validation-->
    <script src="{{asset('../assets/js/jquery.validate.js')}}"></script>
    <!-- jquery validation -->
    
    <script type="text/javascript" language="javascript">
    $(document).ready(function(event){
        
        var forgot_password_validator = $("#forgot_form").validate({
            rules: {
                password:{
                    required:true,
                    minlength:8,
                    maxlength:20
                },
                confirm_password:{
                    required:true,
                    equalTo:"#password",
                },
            },
            messages: {
                password:{
                    required: "<span class='badge badge-danger'>Please enter password</span>",
                    minlength:"<span class='badge badge-danger'>Minimum Length is 8 </span>",
                    maxlength:"<span class='badge badge-danger'>Maximum length is 20 </span>",
                },
                confirm_password:{
                    required:"<span class='badge badge-danger'>Please enter confirm password</span>",
                    equalTo:"<span class='badge badge-danger'>Confirm password must match with password </span>",
                },
            }
        });
    });
    </script>
    <!-- jquery validation -->




    <!--Forgot Password-->

    <script type="text/javascript">
        $(document).ready(function(){

            $("#verify_email").click(function (){

                $("#email_not_found").html('');

                var email = $("#email").val();

                if(email != "")
                {
                    $("#email_not_found").html('');
                    $.ajax({
                        url:'forgot_password_verify_email',
                        type:"POST",
                        data:{
                            _token:'{{csrf_token()}}',
                            email:email
                            },
                        success:function(response){
                            if(response === "email_exists")
                            {
                                $('#hidden_email').val(email);
                                $('#email').attr("disabled","true");
                                $("#email_not_found").html('');
                                $('#btn_email_div').css("display","none");
                                $('#password_fields').css("display","block");
                                $('#forgot_pass_text').html("Please Enter New Password To Reset Password");
                            }
                            else if(response === "email_not_exists")
                            {
                              $("#email_not_found").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><b>Incorrect Email Address! Please Enter Correct Email Address!...</b></div>');  
                            }
                            else if(response.message=='fail')
                            {
                                $("#email_not_found").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><b>'+response.result+'</b></div>');     
                            }
                        }   
                    });
                }
                else
                {
                    $("#email_not_found").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><b>Please Enter Email Address!...</b></div>');  
                }
            });

            /*$("#reset_password").click(function (){
            
                var email           = $("#email").val();
                var password        = $("#password").val();
                var confirm_pass    = $("#confirm_password").val();

                if(password === confirm_pass)
                {
                    alert(email);
                    alert(password);
                    alert(confirm_pass);    
                }
            
            });*/
        });


    </script>





    <!-- page specific plugin scripts -->

    <!-- ace scripts -->
    <script src="../assets/js/ace/elements.scroller.js"></script>
    <script src="../assets/js/ace/elements.colorpicker.js"></script>
    <script src="../assets/js/ace/elements.fileinput.js"></script>
    <script src="../assets/js/ace/elements.typeahead.js"></script>
    <script src="../assets/js/ace/elements.wysiwyg.js"></script>
    <script src="../assets/js/ace/elements.spinner.js"></script>
    <script src="../assets/js/ace/elements.treeview.js"></script>
    <script src="../assets/js/ace/elements.wizard.js"></script>
    <script src="../assets/js/ace/elements.aside.js"></script>
    <script src="../assets/js/ace/ace.js"></script>
    <script src="../assets/js/ace/ace.ajax-content.js"></script>
    <script src="../assets/js/ace/ace.touch-drag.js"></script>
    <script src="../assets/js/ace/ace.sidebar.js"></script>
    <script src="../assets/js/ace/ace.sidebar-scroll-1.js"></script>
    <script src="../assets/js/ace/ace.submenu-hover.js"></script>
    <script src="../assets/js/ace/ace.widget-box.js"></script>
    <script src="../assets/js/ace/ace.settings.js"></script>
    <script src="../assets/js/ace/ace.settings-rtl.js"></script>
    <script src="../assets/js/ace/ace.settings-skin.js"></script>
    <script src="../assets/js/ace/ace.widget-on-reload.js"></script>
    <script src="../assets/js/ace/ace.searchbox-autocomplete.js"></script>

    <!-- inline scripts related to this page -->

    <!-- the following scripts are used in demo only for onpage help and you don't need them -->
    <link rel="stylesheet" href="../assets/css/ace.onpage-help.css" />
    <link rel="stylesheet" href="../docs/assets/js/themes/sunburst.css" />

    <script type="text/javascript">
        ace.vars['base'] = '..';
    </script>
    <script src="../assets/js/ace/elements.onpage-help.js"></script>
    <script src="../assets/js/ace/ace.onpage-help.js"></script>
    <script src="../docs/assets/js/rainbow.js"></script>
    <script src="../docs/assets/js/language/generic.js"></script>
    <script src="../docs/assets/js/language/html.js"></script>
    <script src="../docs/assets/js/language/css.js"></script>
    <script src="../docs/assets/js/language/javascript.js"></script>
</body>

</html>