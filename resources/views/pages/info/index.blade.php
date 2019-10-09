@extends('layouts.main')

@section('content')
<div class="container-fluid main-container">
    <div class="row">
        @include('components.menu')
    </div>

    <div class="row">
        <div class="col-md-12">
            <h3>Info</h3>
            <form class="form-inline" method="GET" action="{{ URL::route('info.search') }}">
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
                    @foreach($infos as $info)
                        <tr>
                            <td>{{ $info->id }}</td>
                            <td>{{ $info->nama }}</td>
                            <td>
                                <a class="btn btn-small btn-success" href="{{ URL::to('info/' . $info->id . '/edit') }}">Edit</a>
                                {{ Form::open(array('url' => 'info/' . $info->id, 'class' => 'pull-right', 'onsubmit' => 'return ConfirmDelete()')) }}
                                    {{ Form::hidden('_method', 'DELETE') }}
                                    {{ Form::submit('Delete', array('class' => 'btn btn-small btn-warning')) }}
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $infos->links() }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-success" href="{{ URL::to('info/create') }}">Tambah</a>
            <a class="btn btn-primary" href="{{ URL::to('info/export') }}">Export</a>
            <a class="btn btn-primary" href="{{ URL::to('info/create') }}">Export Relation</a>
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
