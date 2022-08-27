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
            <a class="navbar-brand" href="{{ URL::to('tracks') }}">shark Alert</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('tracks') }}">View All sharks</a></li>
            <li><a href="{{ URL::to('tracks/create') }}">Create a shark</a>
            <li><a href="{{ route('tracks.create') }}">Create Track</a>
        </ul>
    </nav>
    {!! Form::open([
        'url' => route('tracks.store'),
        'method' => 'post',
        'id' => 'pohyi_chestno_kakoy_blyat_tut_id',
        'role' => 'form',
        'class' => 'indus_zaebal',
        'enctype' => 'multipart/form-data'
    ]) !!}
    <div style="display: flex; flex-direction: column; align-items: center;">
    {!! Form::text('name', 'Дежавю'); !!}
    {!! Form::number('artist_id', 1); !!}
    {!! Form::date('release_date'); !!}
    {!! Form::number('type', 1); !!}
    {!! Form::number('counter', 1); !!}
    {!! Form::number('photo_cover_id', 1); !!}
    {!! Form::number('file_id', 1); !!}
    {!! Form::number('video_id', 1); !!}
    {!! Form::number('created_by', 1); !!}
    {!! Form::number('updated_by', 1); !!}
    {!! Form::date('created_at'); !!}
    {!! Form::date('updated_at'); !!}
    {!! Form::submit('Click Me!'); !!}
    {!! Form::close(); !!}
    </div>
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

</div>
</body>
</html>
