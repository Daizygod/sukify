@extends('layout')

@section('content')
<body>
<div class="container">

    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('tracks') }}">Tracks</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('tracks') }}">View All tracks</a></li>
        </ul>
    </nav>
    <script>
        $( document ).ready(function() {
            $("#artist_id").select2({
                ajax: {
                    type: "get",
                    url: "{{route('getAjax')}}",
                    data: function(params) {
                        return {
                            search: params.term
                        }
                    },
                    dataType: 'json',
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                }
            });
        });
    </script>
    {!! Form::open([
        'url' => isset($track) ? route('tracks.update', $track) : route('tracks.store'),
        'method' => 'post',
        'id' => 'pohyi_chestno_kakoy_blyat_tut_id',
        'role' => 'form',
        //'class' => 'form-control',
        'enctype' => 'multipart/form-data'
    ]) !!}
    @isset($track)
        @method('PUT')
    @endisset
    <div class="form_grid" style="text-align: center">
        <div>
            {!! Form::label('name', null, ['class' => 'control-label']) !!}
            {!! Form::text('name', isset($track->name) ? $track->name : null, ['class' => 'form-control']); !!}
        </div>
        <div>
            {!! Form::label('artist', null, ['class' => 'control-label']) !!}
            {!!
                //TODO: in future need to be added more than 1 artist (multi seleceting nad in db change integer to json)
                Form::select('artist_id', isset($track->artist_id) ? \App\Models\Artist::where(['id' => $track->artist_id])->pluck('name')->toArray()
                : \App\Models\Artist::select('artists.name')
                ->leftjoin('tracks', 'tracks.artist_id', '=', 'artists.id')
                ->groupBy('artists.name', 'artists.id')
                ->orderByRaw('SUM(tracks.counter) DESC')
                ->pluck('name')
                ->take(10)
                ->toArray(), (isset($track->artist_id) && $track->artist_id != 0) ? $track->artist_id : 1,
                [
                    'class' => 'form-control',
                    'id' => 'artist_id',
                    'multiple' => false
                ]);
            !!}
        </div>
        <div>
            {!! Form::label('release_date', null, ['class' => 'control-label']) !!}
            {!! Form::date('release_date', isset($track->release_date) ? $track->release_date : null, ['class' => 'form-control']); !!}
        </div>
        <div>
            {!! Form::label('type', null, ['class' => 'control-label']) !!}
            {!! Form::select('type', \App\Models\Track::$types_array, isset($track->type) ? $track->type : 1, ['class' => 'form-control']); !!}
        </div>
        <?php
        if (!isset($track->id)) { ?>
        <div>
            {!! Form::label('counter', null, ['class' => 'control-label']) !!}
            {!! Form::number('counter', isset($track->counter) ? $track->counter : 1, ['class' => 'form-control']); !!}
        </div>
        <?php
        } ?>
        <div>

            {!! Form::label('photo_cover_id', null, ['class' => 'control-label']) !!}
            {!! Form::number('photo_cover_id', isset($track->photo_cover_id) ? $track->photo_cover_id : 1, ['class' => 'form-control']); !!}
        </div>
        <div>
            {!! Form::label('file_id', null, ['class' => 'control-label']) !!}
            {!! Form::number('file_id', isset($track->file_id) ? $track->file_id : 1, ['class' => 'form-control']); !!}
        </div>
        <div>
            {!! Form::label('video_id', null, ['class' => 'control-label']) !!}
            {!! Form::number('video_id', isset($track->video_id) ? $track->video_id : 1, ['class' => 'form-control']); !!}
        </div>
    </div>
    {!! Form::submit('Save', ['class' => 'btn btn-success', 'style' => 'width: 100%']); !!}
    {!! Form::close(); !!}
    </div>
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

</div>
</body>
@endsection
