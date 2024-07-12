<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		
        <title>HSAMS >> @yield('title')</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />


		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="{{asset('../assets/css/bootstrap.css')}}" />
		<link rel="stylesheet" href="{{asset('../assets/css/font-awesome.css')}}" />
        <link rel="stylesheet" href="{{asset('../assets/css/jquery-ui.custom.css')}}" />
		<link rel="stylesheet" href="{{asset('../assets/css/chosen.css')}}" />
		<link rel="stylesheet" href="{{asset('../assets/css/datepicker.css')}}" />
		<link rel="stylesheet" href="{{asset('../assets/css/daterangepicker.css')}}" />
        
        <link rel="stylesheet" href="{{asset('../assets/css/colorbox.css')}}" />

		
		<link rel="icon" type="image/png"  href="https://cdn4.iconfinder.com/data/icons/e-learning-2-4/66/142-512.png" />
		 
		
		<!--FOR MONTH PICKER-->
		<link href="{{asset('../assets/monthpicker/monthpicker.css')}}" rel="stylesheet" type="text/css">
		
		<!--FOR MULTISELECT DROPDOWN-->
		<link rel="stylesheet" href="{{asset('../assets/css/bootstrap-multiselect.css')}}" />
		
		<!-- text fonts -->
		<link rel="stylesheet" href="{{asset('../assets/css/ace-fonts.css')}}" />
		<!-- ace styles -->
		<link rel="stylesheet" href="{{asset('../assets/css/ace.css')}}" class="ace-main-stylesheet" id="main-ace-style" />
		
	
        
		<!-- ace settings handler -->
		<script src="{{asset('../assets/js/ace-extra.js')}}"></script>


		
		
        
           <!--Templete JQuery & Bootstrap-->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='{{asset('../assets/js/jquery.js')}}'>"+"<"+"/script>");
		</script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='{{asset('../assets/js/jquery.mobile.custom.js')}}'>"+"<"+"/script>");
		</script>
		<script src="{{asset('../assets/js/bootstrap.js')}}"></script>
        
        <!--JQuery Validation-->
        		<script src="{{asset('../assets/js/jquery.validate.js')}}"></script>
        <!--Templete JQuery & Bootstrap-->
        
        


         <style>
            .error{
                display: block;
            }
            
               
             #id-input-file-2-error span{
                 margin-top: 11px;
             }
             #qualification-error span
             {
                 margin-top: 10px;
             }
             
             
             
             #list-school-classes :first-child
             {
                 margin-top: 10px;
             }

              #list-school-teacher :first-child
             {
                 margin-top: 10px;
             }

             

            
             
             /*Assign School Classes*/
              #all-classes
             {
                  height: 300px;
                  overflow: auto;
             }
             #school-classes
             {
                  height: 335px;
                  overflow: auto;
                 
             }
             /*Assign School Classes*/
             
             
             #search_student,#search_class
             {
                background: transparent;
                border: none;
                border-bottom: 1px solid #b1afaf;
                text-align: center;
            }
			 #all-schools,#scroll_bar
             {
             	height:250px;
             	overflow:auto;
             }

             #holiday-school
             {
             	height:250px;
             	overflow:auto;
             }
             #search_school
             {
             	background:transparent;
             	border:none;
             	border-bottom:1px solid #b1afaf;
             	text-align:center;
             }
            
         
            
        </style>
	</head>

	<body class="no-skin">
  
        
        <!--Adding Header-->
        @include('../sections.header') 
    
        
		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

            <!--Adding Super Admin Sidebar-->
			@if(session("role_id")==1)
            @include('super-admin/require/super-admin-sidebar') 
            <!--Adding Super Admin Sidebar-->
            
            <!--Adding Admin Sidebar-->
            @elseif(session("role_id")==2)
            @include('admin/require/admin-sidebar') 
            <!--Adding Admin Sidebar-->
            
            <!--Adding Teacher Sidebar-->
            @elseif(session("role_id")==3)
            @include('teacher/require/teacher-sidebar') 
            @endif
            <!--Adding Teacher Sidebar-->
            
            <!--Adding Main Page Content-->
            @yield('page_content')		  	
            
            
 <!--Datatable Script-->

            
            <!--Adding Footer-->
            @include('../sections.footer')
            
		</div><!-- /.main-container -->

        
        
		<!--JQUEYR STICKY TABLE-->
		<link rel="stylesheet" href="{{asset('../assets/stickytable/jquery.stickytable.css')}}">
		<script src="{{asset('../assets/stickytable/jquery.stickytable.js')}}"></script>        

        
        
        <!-- jQuery School Classes -->
		<script src="{{asset('../assets/js/bootstrap-multiselect.js')}}"></script>
		<script src="{{asset('../assets/js/jquery.bootstrap-duallistbox.js')}}"></script>
		<script src="{{asset('../assets/js/jquery.raty.js')}}"></script>
		<script src="{{asset('../assets/js/select2.js')}}"></script>
		<script src="{{asset('../assets/js/typeahead.jquery.js')}}"></script>

        <!--Bootstrap-->
         <link rel="stylesheet" href="{{asset('../assets/css/bootstrap.min.css')}}" />

		<!-- page specific plugin scripts -->
		<script src="{{asset('../assets/js/dataTables/jquery.dataTables.js')}}"></script>
		<script src="{{asset('../assets/js/dataTables/jquery.dataTables.bootstrap.js')}}"></script>
		<script src="{{asset('../assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js')}}"></script>
		<script src="{{asset('../assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js')}}"></script>

        
               <!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				$('#dynamic-table').dataTable({
                order:[[0,'desc']],
                });
            });

            jQuery(function($) {
				$('#dynamic-table_district_Operation').dataTable({
                order:[[0,'asc']],
                });
            });

            jQuery(function($) {
				$('.dynamic-table,#dynamic-table-classes,#dynamic-table-schools').dataTable({
                order:[[0,'asc']],
                });
            });

		</script>
		
		<!--MuLti Select JQUERY-->
		<script type="text/javascript">
			$('.multiselect').multiselect({
			 enableFiltering: true,
			 buttonClass: 'btn btn-white btn-primary',
			 templates: {
				button: '<button type="button" class="multiselect dropdown-toggle form-control" data-toggle="dropdown"></button>',
				ul: '<ul class="multiselect-container dropdown-menu"></ul>',
				filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
				filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default btn-white btn-grey multiselect-clear-filter" type="button"><i class="fa fa-times-circle red2"></i></button></span>',
				li: '<li><a href="javascript:void(0);"><label></label></a></li>',
				divider: '<li class="multiselect-item divider"></li>',
				liGroup: '<li class="multiselect-item group"><label class="multiselect-group"></label></li>'
			 }
			});
			$('.multiselect').parent('div').removeClass('btn-group');
		</script>
		<!--MuLti Select JQUERY-->
		
        
        <!-- page specific plugin scripts -->

		<script src="{{asset('../assets/js/jquery-ui.custom.js')}}"></script>
		 <script src="{{asset('../assets/js/jquery.ui.touch-punch.js')}}"></script>
		<script src="{{asset('../assets/js/jquery.easypiechart.js')}}"></script>
		<script src="{{asset('../assets/js/jquery.sparkline.js')}}"></script>
		<script src="{{asset('../assets/js/flot/jquery.flot.js')}}"></script>
		<script src="{{asset('../assets/js/flot/jquery.flot.pie.js')}}"></script>
		<script src="{{asset('../assets/js/flot/jquery.flot.resize.js')}}"></script>
        <script src="{{asset('../assets/js/x-editable/bootstrap-editable.js')}}"></script>
		<script src="{{asset('../assets/js/x-editable/ace-editable.js')}}"></script> 

		<!-- ace scripts -->
		<script src="{{asset('../assets/js/ace/elements.scroller.js')}}"></script>
		<script src="{{asset('../assets/js/ace/elements.colorpicker.js')}}"></script>
		<script src="{{asset('../assets/js/ace/elements.fileinput.js')}}"></script>
		<script src="{{asset('../assets/js/ace/elements.typeahead.js')}}"></script>
		<script src="{{asset('../assets/js/ace/elements.wysiwyg.js')}}"></script>
		<script src="{{asset('../assets/js/ace/elements.spinner.js')}}"></script>
		<script src="{{asset('../assets/js/ace/elements.treeview.js')}}"></script>
		<script src="{{asset('../assets/js/ace/elements.wizard.js')}}"></script>
		<script src="{{asset('../assets/js/ace/elements.aside.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.ajax-content.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.touch-drag.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.sidebar.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.sidebar-scroll-1.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.submenu-hover.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.widget-box.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.settings.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.settings-rtl.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.settings-skin.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.widget-on-reload.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.searchbox-autocomplete.js')}}"></script>
        
        
        <!--  Date Picker Plugin  -->
		<script src="{{asset('../assets/js/chosen.jquery.js')}}"></script>
		<script src="{{asset('../assets/js/date-time/bootstrap-datepicker.js')}}"></script>
		<script src="{{asset('../assets/js/date-time/moment.js')}}"></script>
		<script src="{{asset('../assets/js/date-time/daterangepicker.js')}}"></script>
		<script src="{{asset('../assets/js/jquery.autosize.js')}}"></script>
		<script src="{{asset('../assets/js/jquery.inputlimiter.1.3.1.js')}}"></script>
		<script src="{{asset('../assets/js/jquery.maskedinput.js')}}"></script>

        <script src="{{asset('../assets/js/jquery.colorbox.js')}}"></script>
        
     <!--  Date Picker Plugin  -->


         <script type="text/javascript">
        jQuery(function($) {


            $('#id-input-file-1 , #id-input-file-2').ace_file_input({
                no_file: 'No File ...',
                btn_choose: 'Choose',
                btn_change: 'Change',
                droppable: false,
                onchange: null,
                thumbnail: false, //| true | large
                whitelist: 'gif|png|jpg|jpeg',
                //blacklist:'exe|php'
                //onchange:''
                //
            });


            /*Date Picker*/

            $('.date-picker').datepicker({
                    autoclose: true,
                    todayHighlight: true
                })
                //show datepicker when clicking on the icon
                .next().on(ace.click_event, function() {
                    $(this).prev().focus();

                });


        });
    </script>

        
        <!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
						size: size
					});
				})
			
				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html',
									 {
										tagValuesAttribute:'data-values',
										type: 'bar',
										barColor: barColor ,
										chartRangeMin:$(this).data('min') || 0
									 });
				});
			
			/*Remove From Live*/
			  //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
			  //but sometimes it brings up errors with normal resize event handlers
			 /* $.resize.throttleWindow = false;
			
			  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
			  var data = [
				{ label: "social networks",  data: 38.7, color: "#68BC31"},
				{ label: "search engines",  data: 24.5, color: "#2091CF"},
				{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
				{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
				{ label: "other",  data: 10, color: "#FEE074"}
			  ]
			  function drawPieChart(placeholder, data, position) {
			 	  $.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt:0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne", 
						labelBoxBorderColor: null,
						margin:[-30,15]
					}
					,
					grid: {
						hoverable: true,
						clickable: true
					}
				 })
			 }
			 drawPieChart(placeholder, data);
		
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 //placeholder.data('chart', data);
			 //placeholder.data('draw', drawPieChart);
			
			
			  //pie chart tooltip example
			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;
			
			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}
				
			 });*/
			 /*Remove From Live*/
			
				/////////////////////////////////////
				$(document).one('ajaxloadstart.page', function(e) {
					$tooltip.remove();
				});
			
			
			
			
				var d1 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d1.push([i, Math.sin(i)]);
				}
			
				var d2 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d2.push([i, Math.cos(i)]);
				}
			
				var d3 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.2) {
					d3.push([i, Math.tan(i)]);
				}
				


				/*Remove From Live*/
			
				/*var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
				$.plot("#sales-charts", [
					{ label: "Domains", data: d1 },
					{ label: "Hosting", data: d2 },
					{ label: "Services", data: d3 }
				], {
					hoverable: true,
					shadowSize: 0,
					series: {
						lines: { show: true },
						points: { show: true }
					},
					xaxis: {
						tickLength: 0
					},
					yaxis: {
						ticks: 10,
						min: -2,
						max: 2,
						tickDecimals: 3
					},
					grid: {
						backgroundColor: { colors: [ "#fff", "#fff" ] },
						borderWidth: 1,
						borderColor:'#555'
					}
				});
			*/
			/*Remove From Live*/

				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			
				$('.dialogs,.comments').ace_scroll({
					size: 300
			    });
				
				
				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				});
			
				$('#tasks').sortable({
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'draggable-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer',
					stop: function( event, ui ) {
						//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
						$(ui.item).css('z-index', 'auto');
					}
					}
				);
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
			
			
				//show the dropdowns on top or bottom depending on window height and menu position
				$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
					var offset = $(this).offset();
			
					var $w = $(window)
					if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
						$(this).addClass('dropup');
					else $(this).removeClass('dropup');
				});
			
			})
		</script>

        
      
        
		<!-- the following scripts are used in demo only for onpage help and you don't need them -->
		<link rel="stylesheet" href="{{asset('../assets/css/ace.onpage-help.css')}}" />
		<link rel="stylesheet" href="{{asset('../docs/assets/js/themes/sunburst.css')}}" />

		<script type="text/javascript"> ace.vars['base'] = '..'; </script>
		<script src="{{asset('../assets/js/ace/elements.onpage-help.js')}}"></script>
		<script src="{{asset('../assets/js/ace/ace.onpage-help.js')}}"></script>
		<script src="{{asset('../docs/assets/js/rainbow.js')}}"></script>
		<script src="{{asset('../docs/assets/js/language/generic.js')}}"></script>
		<script src="{{asset('../docs/assets/js/language/html.js')}}"></script>
		<script src="{{asset('../docs/assets/js/language/css.js')}}"></script>
		<script src="{{asset('../docs/assets/js/language/javascript.js')}}"></script>
		<!--FOR MONTH PICKER JS-->
		<script src="{{asset('../assets/monthpicker/monthpicker.min.js')}}"></script>
	</body>
</html>
