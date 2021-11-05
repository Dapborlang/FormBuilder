<!--formbuilder created by RDMarwein -->
@extends('layouts.app')
@section('script')
<link href="{{ asset('rdmarwein/formbuilder/css/select2.min.css') }}" rel="stylesheet">
<script src="{{ asset('rdmarwein/formbuilder/js/select2.full.min.js') }}"></script>
<script>
$(document).ready(function()
{
 	function getUrlData(urlToFetch)
  	{
  		var jSON;
	  	$.ajax({
	        url: "{{ url('/') }}/"+urlToFetch,
	        type: 'GET',
	        async: false,
	        data: {
	        },
	        success: function(data)
	        {
	        	jSON=data;
	        }
	    });
	    return jSON;
	}

	
	$(function () {
		$("select").select2();
	});
});
</script>
@endsection
@section('content')
<div class="container-fluid">
    @if(session()->has('message'))
	    <div class="alert alert-success">
	        {{ session()->get('message') }}
	    </div>
	@endif
    <form method="POST" action="{{ url('/') }}/formbuilder/{{$formMaster->id}}" target="">
        {{ csrf_field() }}
        <div class="card bg-secondary text-white">
            <div class="card-header bg-info">{{$formMaster->header}}</div>
            <div class="card-body">
                <div class="row">
                @foreach($columns as $item)
                    @if(!in_array($item,$exclude) && $item!='id' && $item!='created_at' && $item!='updated_at')
                        @php
                            $title=ucwords(str_replace('_',' ',$item));
                        @endphp
                        @if(array_key_exists($item, $master))
                            <div class="col-sm-6 col-xl-4" id="{{$item}}1">
                                <div class="form-group">
                                    <label for="{{$master[$item][2]}}">{{ucwords(str_replace('_',' ',$master[$item][2]))}}</label>
                                    <select type="text" class="form-control" id="{{$master[$item][2]}}">
                                        <option value="">--Select {{ucwords(str_replace('_',' ',$master[$item][2]))}}--</option>
                                        @foreach($master[$item][0] as $data)
                                        @php
                                            $val=$master[$item][1];
                                            $det=$master[$item][2];
                                        @endphp
                                            <option value="{{$data->$val}}">{{$data->$det}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4" id="{{$item}}2">
                                <div class="form-group">
                                    <label for="{{$item}}">{{ucwords(str_replace('_',' ',$master[$item][3]))}}</label>
                                    <select type="text" class="form-control" id="{{$item}}" name="{{$item}}">
                                        <option value="">--Select {{$title}}--</option>
                                    </select>
                                </div>
                            </div>
					    @else
                            <div class="col-sm-6 col-xl-4" id="{{$item}}1">
                                <div class="form-group">
                                    <label for="{{$item}}">{{$title}}</label>
                                    @if(array_key_exists($item, $select))
                                    <select class="form-control" id="{{$item}}" name="{{$item}}">
                                    <option value="">--Select {{$title}}--</option>
                                        @foreach($select[$item][0] as $data)
                                        @php
                                            $val=$select[$item][1];
                                            $det=$select[$item][2];
                                        @endphp
                                            <option value="{{$data->$val}}">{{$data->$det}}</option>
                                        @endforeach
                                    </select>
                                    @else
                                    <input type="text" class="form-control @if(isset($class) && array_key_exists($item, $class)) {{$class[$item]}} @endif form-control-sm" id="{{$item}}" name="{{$item}}" @if(isset($attribute) && array_key_exists($item, $attribute)) {{$attribute[$item]}} @endif>
                                    @endif
                                </div>
                            </div>
					    @endif
                    @endif
                @endforeach
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
