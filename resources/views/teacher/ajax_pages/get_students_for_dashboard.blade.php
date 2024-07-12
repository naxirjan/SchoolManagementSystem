

@if(!@empty($students))

<h4 class="text-center">
{{ $class_students }}  
<hr />  
</h4>
<div style="overflow:auto;height: 300px;">
<table id="simple-table" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Student Image</th>
            <th>Student Full Name</th>           
            <th>Gender</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <?php

        $image = "storage/".$students_image_path."/".$student->student_image;  

        ?>
        <tr>
            <td>
            @if($student->student_image!='student_icon.jpg')
            <img class="img-responsive" alt="No Image" src="{{ asset($image) }}"  style="border-radius:50%;width: 50px;height: 50px;">
            @else
            <img class="img-responsive" alt="No Image" src="{{asset('storage/dumy_image/student_icon.jpg')}}"  style="border-radius:50%;width: 50px;height: 50px;">
            @endif
            </td>           
            <td>
                <?php

                    if(!isset($student->middle_name))
                    {
                        ?>
                            {{ $student->first_name.' '.$student->last_name }}
                        
                        <?php
                    }
                    else
                    {
                        ?>
                        {{ $student->first_name.' '.$student->middle_name.' '.$student->last_name }}
                        <?php
                    }
                
                ?>    
            </td>
            <td>{{ $student->gender }}</td> 
        </tr> 
        @endforeach
    </tbody>
</table>
</div>

@endif



