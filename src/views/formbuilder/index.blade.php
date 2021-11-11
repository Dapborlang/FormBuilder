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
				@foreach($columns as $item)
					@if(!in_array($item,$exclude))
					@php
						$title=ucwords(str_replace('_',' ',$item));
					@endphp
						<th>{{$title}}</th>
					@endif
				@endforeach
					<th>Option</th>
				</tr>
				
			</table>	
			</div>		
		</div>
	</div>
</div>
@endsection