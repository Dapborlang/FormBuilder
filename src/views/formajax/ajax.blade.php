<!--Formbuilder created by RDMarwein -->
@extends('layouts.blank')
@section('script')
@endsection
@section('content')
<div class="container-fluid">
	@if(session()->has('message'))
	    <div class="alert alert-success">
	        {{ session()->get('message') }}
	    </div>
	@endif
	@if(session()->has('fail-message'))
	    <div class="alert alert-danger">
	        {{ session()->get('fail-message') }}
	    </div>
	@endif
		<table class="table table-hover">
			<tr>
			<th>Sl No.</th>
			@foreach($columns as $item)
				@if(!in_array($item,$exclude))
				@php
					$title=ucwords(str_replace('_',' ',$item));
				@endphp
					@if(array_key_exists($item, $master))
						<th>{{ucwords(str_replace('_',' ',$master[$item][1]))}}</th>
					@else
						<th>{{$title}}</th>
					@endif
				@endif
			@endforeach
				<th>Option</th>
			</tr>
			@foreach($table as $item1)
			<tr>
				<td>{{$loop->iteration}}</td>
				@foreach($columns as $item)
					@if(!in_array($item,$exclude))	
						@if(array_key_exists($item, $select))
							@php 
								$val=$select[$item][0];
								$val=array_values(array_slice((explode('\\',$val)), -1))[0];;
								$det=$select[$item][1];
							@endphp		
							<td>@if(isset($item1-> $val-> $det)){{ $item1-> $val-> $det }}@endif</td>
						@elseif(array_key_exists($item, $master))	
							@php 
								$val=$master[$item][0];
								$val=array_values(array_slice((explode('\\',$val)), -1))[0];;
								$det=$master[$item][1];
							@endphp		
							<td>@if(isset($item1-> $val-> $det)){{ $item1-> $val-> $det }}@endif</td>
						@else	
						@php
							$item_data=$item.'_edit';
							if(method_exists($item1, $item_data))
							{
								$data_value=$item1-> $item_data();
							}
							else
							{
								$data_value=$item1->$item;
							}
						@endphp
							<td>{{$data_value}}</td>	
						@endif
					@endif
				@endforeach
				<td><form method="POST" action="{{ url('/') }}/frmbuilder/delete/{{$model->id}}/{{$item1->id}}">
						@method('DELETE')
						@csrf
						<button class="btn btn-danger">Delete</button>
					</form></td>
			</tr>
			@endforeach
		</table>	
</div>
@endsection