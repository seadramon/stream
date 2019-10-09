@extends('layouts.main')

@section('content')
<div class="container-fluid main-container">
    <div class="row">
        @include('components.menu')
    </div>

    <div class="row">
        <div class="col-md-12">
            <h3>Tips</h3>
            <form class="form-inline" method="GET" action="{{ URL::route('tips.search') }}">
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="nama" name="nama" class="form-control" id="nama">
                </div>
                <input type="submit" class="btn btn-info" value="cari">
            </form> 
        </div><br><br><br>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif                
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tipss as $tips)
                        <tr>
                            <td>{{ $tips->id }}</td>
                            <td>{{ $tips->nama }}</td>
                            <td>
                                <a class="btn btn-small btn-success" href="{{ URL::to('tips/' . $tips->id . '/edit') }}">Edit</a>
                                {{ Form::open(array('url' => 'tips/' . $tips->id, 'class' => 'pull-right', 'onsubmit' => 'return ConfirmDelete()')) }}
                                    {{ Form::hidden('_method', 'DELETE') }}
                                    {{ Form::submit('Delete', array('class' => 'btn btn-small btn-warning')) }}
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $tipss->links() }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-success" href="{{ URL::to('tips/create') }}">Tambah</a>
            <a class="btn btn-primary" href="{{ URL::to('tips/export') }}">Export</a>
        </div><br><br>
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
