@extends('layouts.main')

@section('title', 'TV Radio')

@section('content')

<script type="text/javascript" src="https://content.jwplatform.com/libraries/i511f6Xb.js"></script>
<script>jwplayer.key='YOUR_KEY';</script>

<!-- Play -->
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $data->name }}</h3>
            </div>

            @if ($data->channel == 'tv')
                <div id="player">Loading the player...</div>
                <script type="text/javascript">
                    var playerInstance = jwplayer("player");
                    playerInstance.setup({
                        androidhls: true,
                        hlshtml: true,
                        file: "{{ $data->stream }}",
                        image: "{{ asset('logo/'.$data->image) }}",
                        title:"{{ $data->name }}",
                        width: '80%',
                    });
                </script>
            @else
                Radio coming soon
            @endif 
        </div>
        <!-- /.box -->  
    </div>
</div>
@endsection