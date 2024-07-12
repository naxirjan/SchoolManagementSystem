@extends('master/master_404_500')

@section('title')
Something Went Wrong
@endsection



@section('page_content')
<center>
	<h1 class="red" style="font-size: 50px; font-weight: bolder;">
	<b>Sorry, Something Went Wrong !...</b>
	</h1>
	<h3>Please Try Again</h3>
	<h4><a class="btn btn-info" href="javascript:history.back()"><b>Go Back</b></a></h4>
</center>

@endsection
