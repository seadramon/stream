@extends('layouts.main')

@section('content')
<div class="container-fluid main-container">
    <div class="row">
        @include('components.menu')
    </div>

    <div class="row">
        <div class="col-md-8">
            <h3>Keyword</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (isset($keyword))
                {!! Form::model($keyword, ['url'=>URL::route('keyword.update', $id), 'autocomplete'=>'off', 'files' => true, 'method' => 'PUT']) !!}
                {!! Form::hidden('id', null) !!}
            @else
                {!! Form::open(['url'=>URL::route('keyword.store'), 'autocomplete'=>'off', 'files' => true]) !!}
            @endif
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    {!! Form::text('nama', null, ['class'=>'form-control', 'placeholder'=>'nama', 'required']) !!}
                </div>

                <div class="form-group">
                    <label for="medicine">Medicine</label><br>
                    @if (count($medicine) > 0)
                        @foreach ($medicine as $key => $value)
                            @if (isset($keyword))
                                @if (in_array($key, $keyword->medicine()->get()->pluck('id')->toArray()))
                                    {!! Form::checkbox('medicine[]', $key, true) !!} {{ $value }} <br>
                                @else
                                    {!! Form::checkbox('medicine[]', $key) !!} {{ $value }} <br>
                                @endif
                            @else
                                {!! Form::checkbox('medicine[]', $key) !!} {{ $value }} <br>
                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="form-group">
                    <label for="info">Info</label><br>
                    @if (count($info) > 0)
                        @foreach ($info as $key => $value)
                            @if (isset($keyword))
                                @if (in_array($key, $keyword->info()->get()->pluck('id')->toArray()))
                                    {!! Form::checkbox('info[]', $key, true) !!} {{ $value }} <br>
                                @else
                                    {!! Form::checkbox('info[]', $key) !!} {{ $value }} <br>
                                @endif
                            @else
                                {!! Form::checkbox('info[]', $key) !!} {{ $value }} <br>
                            @endif
                        @endforeach
                    @endif
                </div>
                <input type="submit" class="btn btn-info" value="submit">
            {{ Form::close() }} 
        </div><br><br>
    </div>
</div>
@endsection
