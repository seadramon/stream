@extends('layouts.main')

@section('title', 'TV Radio')

@section('content')
	<!-- /.row -->
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
            	<h3 class="box-title">List</h3>

              	<div class="box-tools">
                	<div class="input-group input-group-sm" style="width: 150px;">
	                  	<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

	                  	<div class="input-group-btn">
	                    	<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
	                  	</div>
                	</div>
              	</div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
	            <table class="table table-hover">
	                <tr>
                  		<th>ID</th>
                  		<th>Key</th>
                  		<th>Name</th>
                  		<th>Created</th>
                  		<th>Action</th>
	                </tr>
	                @foreach($data as $row)
		                <tr>
		                  	<td>{{ $row->id }}</td>
		                  	<td>{{ $row->key }}</td>
		                  	<td>{{ $row->name }}</td>
		                  	<td>{{ $row->created_at }}</td>
		                  	<td>
                                <a class="btn btn-small btn-primary" href="{{ URL::to('tvradio/play/'. $row->id) }}">Play</a>
		                  		<a class="btn btn-small btn-success" href="{{ URL::to('tvradio/' . $row->id . '/edit') }}">Edit</a>
                                {{ Form::open(array('url' => 'tvradio/' . $row->id, 'class' => 'pull-right', 'onsubmit' => 'return ConfirmDelete()')) }}
                                    {{ Form::hidden('_method', 'DELETE') }}
                                    {{ Form::submit('Delete', array('class' => 'btn btn-small btn-danger')) }}
                                {{ Form::close() }}
		                  	</td>
		                  	<!-- <span class="label label-success">Approved</span> -->
		                </tr>
		            @endforeach
	            </table>
	            {{ $data->links() }}
            </div>
            <!-- /.box-body -->
            <br><br>
            &nbsp;&nbsp;<a href="{{ URL::to('tvradio/create') }}" class="btn btn-primary">Create</a><br><br>
        </div>
          <!-- /.box -->
    </div>
</div>

<!-- Export -->
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Export</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['url'=>URL::route('tvradio.export'), 'autocomplete'=>'off', 'files' => true]) !!}
                <div class="box-body">
                    <div class="form-group">
                        <label for="status">Channel</label>
                        {!! Form::select('channel', ['all'=>'All', 'tv'=>'TV', 'radio'=>'Radio'], null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            {{ Form::close() }}
        </div>
        <!-- /.box -->  
    </div>
</div>

<script>

function ConfirmDelete() {
    var x = confirm("Are you sure you want to delete?");
    if (x)
        return true;
    else
        return false;
}

</script>
@endsection