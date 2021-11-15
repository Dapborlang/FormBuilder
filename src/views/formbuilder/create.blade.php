<!--formbuilder created by RDMarwein -->
@extends('layouts.app')
@section('script')
<link href="{{ asset('rdmarwein/formbuilder/css/select2.min.css') }}" rel="stylesheet">
<script src="{{ asset('rdmarwein/formbuilder/js/select2.full.min.js') }}"></script>
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
                                    @if(!isset($attribute['type'][$item]))
                                        <input type="text" class="form-control @if(isset($attribute['class'][$item])) {{$attribute['class'][$item]}} @endif form-control-sm" id="{{$item}}" name="{{$item}}" @if(isset($attribute['value'][$item])) value="{{$attribute['value'][$item]}}" @endif @if(isset($attribute['placeholder'][$item])) placeholder="{{$attribute['placeholder'][$item]}}" @endif >
                                    @elseif($attribute['type'][$item]=='textarea')
                                        <textarea class="form-control @if(isset($attribute['class'][$item])) {{$attribute['class'][$item]}} @endif" id="{{$item}}" name="{{$item}}" @if(isset($attribute['placeholder'][$item])) placeholder="{{$attribute['placeholder'][$item]}}" @endif>
                                          @if(isset($attribute['value'][$item])) {{$attribute['value'][$item]}} @endif
                                        </textarea>
                                    @else
                                        <input type="{{$attribute['type'][$item]}}" class="form-control @if(isset($attribute['class'][$item])) {{$attribute['class'][$item]}} @endif form-control-sm" id="{{$item}}" name="{{$item}}" @if(isset($attribute['value'][$item])) value="{{$attribute['value'][$item]}}" @endif @if(isset($attribute['placeholder'][$item])) placeholder="{{$attribute['placeholder'][$item]}}" @endif>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
                </div>
                <div class="card-footer">
                    <div class="offset-md-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
