<!--Formbuilder created by RDMarwein -->
@extends('layouts.app')
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
	<div class="card">
		<div class="card-header bg-info">{{$formMaster->header}}</div>
		<div class="card-body">	
			<div style="width:100%; height: 450px; overflow:auto;">
			<table class="table table-hover">
				<tr>
					<th>Sl No.</th>
						@php
						  $master=$attribute['master_key'];
							$title=ucwords(str_replace('_',' ',$master));
						@endphp
							<th>{{$title}}</th>
					<th>Option</th>
				</tr>
				@foreach($model->unique($master) as $item1)
				<tr>
					<td>{{$loop->iteration}}</td>
					@foreach($columns as $item)
						@if($item==$master)	
							@if(array_key_exists($item, $select))
								@php 
									$val=$select[$item][0];
									$val=array_values(array_slice((explode('\\',$val)), -1))[0];
									$det=$select[$item][1];
								@endphp		
								<td>@if(isset($item1-> $val-> $det)){{ $item1-> $val-> $det }}@endif</td>
							@else
							  <td>{{$item1->$item}}</td>
							@endif
						@endif
					@endforeach
					<td>
							<a class="btn btn-info" href="{{ url('/') }}/formgen/{{$formMaster->id}}/{{$item1-> $master}}">View</a>
					</td>
				</tr>
				@endforeach
			</table>	
			</div>		
		</div>
	</div>
</div>
@endsection