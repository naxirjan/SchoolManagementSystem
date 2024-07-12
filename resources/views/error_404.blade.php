@extends('master/master_404_500')

@section('title')
File Not Found
@endsection



@section('page_content')
<center>
	<h1 class="red" style="font-size: 50px; font-weight: bolder;">
	<b>Not Found !...</b>
	</h1>
	<h3>The Requested URL <b>(<?php echo $link; ?>)</b> Was Not Found On This Server</h3>
	<h4><a href="javascript:history.back()" class="btn btn-info"><b>Go Back</b></a></h4>
</center>
@endsection


