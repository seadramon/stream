@extends('layouts.main')

@section('title', 'TV Radio')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
		    <div class="box box-primary">
		        <div class="box-header with-border">
		          <h3 class="box-title">Add</h3>
		        </div>
		        @foreach($errors->tvradio_store->all() as $error)
			        <p class="alert alert-danger">{{$error}}</p>
			    @endforeach
			    
			    @if(null !== Session::get('failed'))
			        <p class="alert alert-danger">{{ Session::get('failed') }}</p>
			    @endif
		        <!-- /.box-header -->
		        <!-- form start -->
		        @if (isset($tvradio))
	                {!! Form::model($tvradio, ['url'=>URL::route('tvradio.update', $id), 'autocomplete'=>'off', 'files' => true, 'method' => 'PUT']) !!}
	                {!! Form::hidden('id', null) !!}
	            @else
	                {!! Form::open(['url'=>URL::route('tvradio.store'), 'autocomplete'=>'off', 'files' => true]) !!}
	            @endif
		      		<div class="box-body">
		        		<div class="form-group">
		          			<label for="key">Key</label>
		          			<!-- <input type="text" name="key" class="form-control" id="key" placeholder="Key"> -->
		          			{!! Form::text('key', null, ['class'=>'form-control', 'placeholder'=>'Key']) !!}
		        		</div>
		        		<div class="form-group">
		          			<label for="name">Name</label>
		          			{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Name']) !!}
		        		</div>
		        		<div class="form-group">
		          			<label for="stream">Stream</label>
		          			{!! Form::text('stream', null, ['class'=>'form-control', 'placeholder'=>'Stream URL']) !!}
		        		</div>
		        		<div class="form-group">
		          			<label for="bgcolor">Background Color</label>
		          			{!! Form::text('bgcolor', null, ['class'=>'form-control', 'id'=>'color', 'placeholder'=>'Background Color']) !!}
		        		</div>
		        		<div class="form-group">
		          			<label for="position">Position</label>
		          			{!! Form::number('position', null, ['class'=>'form-control', 'placeholder'=>'Position']) !!}
		        		</div>
		        		<div class="form-group">
		          			<label for="status">Channel</label>
		          			{!! Form::select('channel', ['tv'=>'TV', 'radio'=>'Radio'], null, ['class'=>'form-control']) !!}
		        		</div>
		        		<div class="form-group">
		          			<label for="status">Status</label>
		          			{!! Form::select('status', ['1'=>'Enable', '0'=>'Disable'], null, ['class'=>'form-control']) !!}
		        		</div>
		        		<div class="form-group">
		          			<label for="exampleInputFile">Image</label>
		          			<input type="file" name="image" class="form-control">
		        		</div>
		      		</div>
		      		<!-- /.box-body -->

		      		<div class="box-footer">
		        		<button type="submit" class="btn btn-primary">Submit</button>
		        		<a href="{{ URL::to('tvradio') }}" class="btn btn-danger">Cancel</a>
		      		</div>
		        {{ Form::close() }}
		    </div>
		    <!-- /.box -->	
		</div>
	</div>
@endsection