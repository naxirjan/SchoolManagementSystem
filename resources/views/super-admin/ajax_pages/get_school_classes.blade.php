<div class="form-group">
<label class="col-sm-3 control-label no-padding-right" for="district_operation">Class Name</label>
<div class="col-sm-5">
    {!! Form::select('school_classes',$school_classes,old('school_classes'),['id'=>"school_classes","class"=>"form-control"]) !!}
    @if($errors->has("school_classes"))
    <span class="badge badge-danger">{{$errors->first("school_classes")}}</span>
    @endif
</div>
<div class="col-sm-4"></div>
</div>