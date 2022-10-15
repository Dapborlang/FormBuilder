<!--formbuilder created by RDMarwein -->
@extends('layouts.app')
@section('script')
<link href="{{ asset('rdmarwein/formgen/css/select2.min.css') }}" rel="stylesheet">
<script src="{{ asset('rdmarwein/formgen/js/select2.full.min.js') }}"></script>
@if(isset($attribute['css']))  
  @foreach($attribute['css'] as $item)
    <link href="{{ asset($item) }}" rel="stylesheet">
  @endforeach
@endif
@if(isset($attribute['script']))  
  @foreach($attribute['script'] as $item)
    <script src="{{ asset($item['uri']) }}" @if($item['defer']) defer @endif></script>
  @endforeach
@endif
<script>

	$(function () {
		$("select").select2();
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
    <form method="POST" action="{{ url('/') }}/{{$formMaster->route}}/{{$formMaster->id}}/{{$model->id}}" target="">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="card bg-secondary text-white">
            <div class="card-header bg-info">{{$formMaster->header}}</div>
            <div class="card-body">
                <div class="row">
                @foreach($columns as $key=>$item)
                    @if(!in_array($item,$exclude) && $item!='id' && $item!='created_at' && $item!='updated_at')
                        @php
                        if(array_key_exists('customF',$columns))
                            {
                                $title=$key;
                            }
                            else
                            {
                                $title=ucwords(str_replace('_',' ',$item));
                            }
                        @endphp
                        @if(isset($attribute['type'][$item]) && $attribute['type'][$item]=="hidden")
                    <div class="sr-only">
                        <div class="col-sm-6">
                            <input type="{{$attribute['type'][$item]}}" class="form-control" id="{{$item}}" name="{{$item}}" value="{{$model-> $item}}">
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
                                            $det = explode("()", $select[$item][2]);
                                            $detail=$det[0];
                                        @endphp
                                        <option value="{{$data->$val}}">@if(sizeof($det)>1){{$data->$detail()}}@else{{$data->$detail}}@endif</option>
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
                                @endif
                            </div>
                        </div>
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
