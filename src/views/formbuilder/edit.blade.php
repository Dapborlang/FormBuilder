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
    <form method="POST" action="{{ url('/') }}/formbuilder/{{$formMaster->id}}/{{$model->id}}" target="">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
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
                                    <option value="{{$model-> $item}}">({{$model-> $item}}) NO CHANGES</option>
                                        @foreach($select[$item][0] as $data)
                                        @php
                                            $val=$select[$item][1];
                                            $det=$select[$item][2];
                                        @endphp
                                            <option value="{{$data->$val}}">{{$data->$det}}</option>
                                        @endforeach
                                    </select>
                                    @else
                                        @if(!isset($attribute['type'][$item]))
                                            <input type="text" class="form-control  form-control-sm" id="{{$item}}" name="{{$item}}" @if(isset($attribute) && array_key_exists($item, $attribute)) {{$attribute[$item]}} @endif value="{{$model-> $item}}">
                                        @elseif($attribute['type'][$item]=='textarea')
                                            <textarea class="form-control " id="{{$item}}" name="{{$item}}" @if(isset($attribute) && array_key_exists($item, $attribute)) {{$attribute[$item]}} @endif>{{$model-> $item}}</textarea>
                                        @else
                                            <input type="{{$attribute['type'][$item]}}" class="form-control  form-control-sm" id="{{$item}}" name="{{$item}}" @if(isset($attribute) && array_key_exists($item, $attribute)) {{$attribute[$item]}} @endif value="{{$model-> $item}}">
                                        @endif
                                    @endif
                                </div>
                            </div>
					    @endif
                    @endif
                @endforeach
                </div>
                <div class="card-footer">
                    <div class="offset-md-5">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
