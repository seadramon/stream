@extends('layouts.main')

@section('content')
<div class="container-fluid main-container">
    <div class="row">
        @include('components.menu')
    </div>

    <div class="row">
        <div class="col-md-8">
            <h3>Tips</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (isset($tips))
                {!! Form::model($tips, ['url'=>URL::route('tips.update', $id), 'autocomplete'=>'off', 'files' => true, 'method' => 'PUT']) !!}
                {!! Form::hidden('id', null) !!}
            @else
                {!! Form::open(['url'=>URL::route('tips.store'), 'autocomplete'=>'off', 'files' => true]) !!}
            @endif
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    {!! Form::text('nama', null, ['class'=>'form-control', 'placeholder'=>'nama', 'required']) !!}
                </div>
                <div class="form-group">
                    <label for="nama">Description:</label>
                    {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>'desctiption', 'required']) !!}
                </div>
                <input type="submit" class="btn btn-info" value="submit">
            {{ Form::close() }} 
        </div><br><br>
    </div>
</div>
@endsection
