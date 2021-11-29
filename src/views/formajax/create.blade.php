<!--formbuilder created by RDMarwein -->
@extends('layouts.app')
@section('script')
<link href="{{ asset('rdmarwein/formgen/css/select2.min.css') }}" rel="stylesheet">
<script src="{{ asset('rdmarwein/formgen/js/select2.full.min.js') }}"></script>
<script src="{{ asset('rdmarwein/formgen/js/ajaxsubmit.js') }}"></script>
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
		$("#{{($attribute['master_key'])}}").change(function()
        {
            if($(this).val()=="")
            {
                $("#finalizeBtn").prop( "disabled", true );
            }
            setTable();
        });

        function setTable()
        {
            var tableId=$("#{{($attribute['master_key'])}}").val();
            if(tableId!="")
            {
                var urlData="{{ url('/') }}/formgen/{{$formMaster->id}}/index/"+tableId+"?column={{($attribute['master_key'])}}";
                var urlFinalize="{{ url('/') }}/finalize/{{$formMaster->id}}/"+tableId;
                $("#table-data").attr("url", urlData);
                $("#finalize").attr("action", urlFinalize);
                $.get(urlData, function(data){
                    $("#table-data").html(data);
                    $("#finalizeBtn").prop( "disabled", false );
                });
            }		
        }
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
    <form id="form" method="POST" action="{{ url('/') }}/formgen/{{$formMaster->id}}" target="">
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
                        @if(isset($attribute['type'][$item]) && $attribute['type'][$item]=="hidden")
                          <input type="{{$attribute['type'][$item]}}"  id="{{$item}}" name="{{$item}}" @if(isset($attribute['value'][$item])) value="{{$attribute['value'][$item]}}" @endif>
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

    <br>
	<div class="card">
		<div class="card-body" style="width:100%; height: 40vh; overflow:auto;">	
			<div id="table-data"></div>
		</div>
		<div class="card-footer">
		<form id="finalize" action="" method="POST">
			{{ csrf_field() }}
			<!-- Table to finalize -->
			<input type="hidden" name="field" value="Sanction Order">
			<input type="hidden" name="redirect" id="redirect" value="">
			<button id="finalizeBtn" type="submit" class="btn btn-info" disabled>Finalize</button>
		</form>
		</div>
	</div>
</div>
@endsection
