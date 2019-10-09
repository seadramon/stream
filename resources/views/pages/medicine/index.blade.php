@extends('layouts.main')

@section('content')
<div class="container-fluid main-container">
    <div class="row">
        @include('components.menu')
    </div>

    <div class="row">
        <div class="col-md-12">
            <h3>Medicine</h3>
            <form class="form-inline" method="GET" action="{{ URL::route('medicine.search') }}">
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
                    @foreach($medicines as $medicine)
                        <tr>
                            <td>{{ $medicine->id }}</td>
                            <td>{{ $medicine->nama }}</td>
                            <td>
                                <a class="btn btn-small btn-success" href="{{ URL::to('medicine/' . $medicine->id . '/edit') }}">Edit</a>
                                {{ Form::open(array('url' => 'medicine/' . $medicine->id, 'class' => 'pull-right', 'onsubmit' => 'return ConfirmDelete()')) }}
                                    {{ Form::hidden('_method', 'DELETE') }}
                                    {{ Form::submit('Delete', array('class' => 'btn btn-small btn-warning')) }}
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $medicines->links() }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-success" href="{{ URL::to('medicine/create') }}">Tambah</a>
            <a class="btn btn-primary" href="{{ URL::to('medicine/export') }}">Export</a>
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
