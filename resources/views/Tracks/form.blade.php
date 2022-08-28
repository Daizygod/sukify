<!DOCTYPE html>
<html>
<head>
    <title>Shark App</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
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
    {!! Form::open([
        'url' => route('tracks.store'),
        'method' => 'post',
        'id' => 'pohyi_chestno_kakoy_blyat_tut_id',
        'role' => 'form',
        //'class' => 'form-control',
        'enctype' => 'multipart/form-data'
    ]) !!}
    <div style="display: flex; justify-content: center; width: 100%; text-align: center">
    <div style="justify-content: space-between; height: 60em;margin: unset; width: 22em; display: flex; flex-direction: column; align-items: flex-start;">
    {!! Form::label('name', null, ['class' => 'control-label']) !!}
    {!! Form::text('name', 'Дежавю', ['class' => 'form-control']); !!}
    {!!
        Form::select('artist_id', \App\Models\Artist::select('artists.name')
        ->leftjoin('tracks', 'tracks.artist_id', '=', 'artists.id')
        ->groupBy('artists.name', 'artists.id')
        ->orderByRaw('SUM(tracks.counter) DESC')
        ->pluck('name')
        ->take(10)
        ->toArray(), 1, ['class' => 'form-control']);
    !!}

        {!! Form::label('release_date', null, ['class' => 'control-label']) !!}
    {!! Form::date('release_date', (string)date('d.m.Y',time()), ['class' => 'form-control']); !!}
        {!! Form::label('type', null, ['class' => 'control-label']) !!}
    {!! Form::select('type', \App\Models\Track::$types_array, 1, ['class' => 'form-control']); !!}
        {!! Form::label('counter', null, ['class' => 'control-label']) !!}
    {!! Form::number('counter', 1, ['class' => 'form-control']); !!}
        {!! Form::label('photo_cover_id', null, ['class' => 'control-label']) !!}
    {!! Form::number('photo_cover_id', 1, ['class' => 'form-control']); !!}
        {!! Form::label('file_id', null, ['class' => 'control-label']) !!}
    {!! Form::number('file_id', 1, ['class' => 'form-control']); !!}
        {!! Form::label('video_id', null, ['class' => 'control-label']) !!}
    {!! Form::number('video_id', 1, ['class' => 'form-control']); !!}
    {!! Form::submit('Save', ['class' => 'form-control']); !!}
    {!! Form::close(); !!}
    </div>
    </div>
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

</div>
</body>
</html>