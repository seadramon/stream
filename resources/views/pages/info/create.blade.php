@extends('layouts.main')

@section('content')
<div class="container-fluid main-container">
    <div class="row">
        @include('components.menu')
    </div>

    <div class="row">
        <div class="col-md-8">
            <h3>Info</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (isset($info))
                {!! Form::model($info, ['url'=>URL::route('info.update', $id), 'autocomplete'=>'off', 'files' => true, 'method' => 'PUT']) !!}
                {!! Form::hidden('id', null) !!}
            @else
                {!! Form::open(['url'=>URL::route('info.store'), 'autocomplete'=>'off', 'files' => true]) !!}
            @endif
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    {!! Form::text('nama', null, ['class'=>'form-control', 'placeholder'=>'nama', 'required']) !!}
                </div>
                <div class="form-group">
                    <label for="nama">Description:</label>
                    {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>'desctiption', 'required']) !!}
                </div>

                <div class="form-group">
                    <label for="keyword">Keyword :</label><br>
                    @if (count($keyword) > 0)
                        @foreach ($keyword as $key => $value)
                            @if (isset($medicine))
                                @if (in_array($key, $medicine->keyword()->get()->pluck('id')->toArray()))
                                    {!! Form::checkbox('keyword[]', $key, true) !!} {{ $value }} <br>
                                @else
                                    {!! Form::checkbox('keyword[]', $key) !!} {{ $value }} <br>
                                @endif
                            @else
                                {!! Form::checkbox('keyword[]', $key) !!} {{ $value }} <br>
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
