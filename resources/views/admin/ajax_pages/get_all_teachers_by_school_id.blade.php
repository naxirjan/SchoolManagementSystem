<div class="container-fluid">
      <div class="row">
             <div class="col-sm-12">
                        <h4 class="blue" id="modal-header">
                            <b> 
                                 {{$school_name}} &nbsp;Teachers
                            </b>
                        </h4>
                        <div class="space-8"></div>
                        <div id="faq-list-2" class="panel-group accordion-style1 accordion-style2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                     <a style="background-color:#438eb9;color:white" href="#faq-2-1" data-parent="#faq-list-2" data-toggle="collapse" class="accordion-toggle collapsed">
                                          <i class="pull-right ace-icon fa fa-chevron-left" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-left"></i>
                                          <i class="menu-icon fa fa-exchange"></i>
                                          &nbsp;
                                          <span id="modal-school_teachers">
                                               <b>
                                                  Assign Teachers To {{$class_name}}
                                              </b>
                                          </span>
                                      </a>
                                </div>
                                <div class="panel-collapse collapse" id="faq-2-1">
                                    <div class="panel-body" id="scroll_bar">
                                    
                                    <?php $flag = true; ?> 


                               <!-- Check If The UnAssigned Array Teacher Key Has Not Exist In The Assigned Array Then Dont Display The Similiar Key Value  -->

                                       @if(!empty($school_teachers))
                                       @foreach($school_teachers as $key => $school_teacher)
                                          @if(!array_key_exists($key,$class_school_teachers))
                                            <ul id="list-school-teacher" class="col-sm-12 col-xs-12 list-unstyled list-striped pricing-table-header">
                                                  <li style="padding:0px;"> 
                                                      <b>     
                                                        <label>&nbsp;&nbsp;
                                                          <input name="teacher" class="ace ace-checkbox-2" type="checkbox" value="{{$key}}">
                                                              <span class="lbl">&nbsp; 
                                                                {{ ucwords($school_teacher) }}
                                                                <?php $flag = false; ?> 
                                                              </span>
                                                        </label>
                                                      </b>     
                                                  </li>
                                              </ul>
                                           @endif   
                                       @endforeach 
                                        @if($flag == true)
                                         <b> 
                                            <p class="text-center">&nbsp;&nbsp;&nbsp;<?php echo "All Teachers Are Already Assigned";?> 
                                            </p> 
                                        </b>
                                       @endif 
                                       @else
                                      
                                        @if($flag == true)
                                           
                                                  <b> 
                                                      <p class="text-center">&nbsp;&nbsp;&nbsp; {{$school_name}} &nbsp;Has No Teachers 
                                                      </p> 
                                                  </b>
 
                                       @endif

                                        @endif       
                                  </div>
                                </div>
                              </div>
                              <div class="space-8"></div>
                              <div class="space-8"></div>
                              <div class="space-8"></div>
                              <div class="space-8"></div>
                              <div class="space-8"></div>
                              <div class="space-8"></div>
                              <div class="space-8"></div>



                                    <!-- Tab 2 -->
                         <h4 class="blue" id="modal-header">
                              <b>
                               {{$school_name}}&nbsp;{{$class_name}}&nbsp;Teachers 
                              </b>
                          </h4>

                         <div class="space-8"></div>


                        <div class="panel panel-default">
                               <div class="panel-heading">
                                      <a style="background-color:#438eb9;color:white" href="#faq-2-2" data-parent="#faq-list-2" data-toggle="collapse" class="accordion-toggle collapsed">
                                             <i class="pull-right ace-icon fa fa-chevron-left" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-left"></i>
                                             <i class="ace-icon fa fa-user bigger-130"></i>
                                              &nbsp;
                                              <span id="modal-school_teachers">
                                                  
                                                  <b>View {{$class_name}} Teachers</b>
                                              </span>
                                       </a>
                               </div>

                               <div class="panel-collapse collapse" id="faq-2-2">
                                    <div class="panel-body" id="scroll_bar">

                                          <?php $flag_2 = true; ?>
                                          <!-- Check If The Assigned Array Teacher Key Has Exist In The UnAssigned Array Then Dont Display The Similiar Key Value  -->
                                          @if(!empty($school_teachers))
                                             @foreach($school_teachers as $key => $school_teacher)
                                                @if(array_key_exists($key,$class_school_teachers))
                                                    <ul id="list-school-teacher" class="col-sm-12 col-xs-12 list-unstyled list-striped pricing-table-header">
                                                         <li style="padding:0px;">
                                                             <b>
                                                                <label>&nbsp;&nbsp;
                                                                    <span class="lbl">&nbsp;&nbsp;
                                                                       <b>{{ucwords($school_teacher)}}</b>
                                                                       <?php $flag_2 = false; ?>
                                                                    </span>
                                                               </label>
                                                             </b>
                                                         </li>
                                                      </ul>
                                                  @endif
                                               @endforeach
                                               @else
                                               @endif
                                               <?php 
                                                   if($flag_2 == true)
                                                     {

                                                       ?>
                                                          <b> 
                                                             <p class="text-center">&nbsp;&nbsp;&nbsp;{{$school_name}}&nbsp; [{{$class_name}}] Has No Class Teachers
                                                             </p>
                                                          </b>
                                                        <?php 
                                                     }
                                                 ?>             
                                    </div>
                               </div>
                         </div>
                      </div>
             </div>
       </div>
</div>

@if(!empty($school_teacher))
    <input type="hidden" id="school_id" value="{{$school_id}}">
    <input type="hidden" id="class_id" value="{{$class_id}}">
    <input type="hidden" id="school_name" value="{{$school_name}}">
    <input type="hidden" id="class_name" value="{{$class_name}}">
    <input type="hidden" id="school_teacher" value="{{$school_teacher}}">
@endif
