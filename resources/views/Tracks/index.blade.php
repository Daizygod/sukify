<!DOCTYPE html>
<html>
<head>
    <title>Shark App</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
@php
    $gridData = [
        'dataProvider' => $dataProvider,
        'title' => 'Tracks',
        'useFilters' => true,
        'rowsFormAction' => '/tracks/create',
        'columnFields' => [
            'id',
            'name',
            'artist_id',
            'release_date',
            'type',
            'counter',
            'photo_cover_id',
            'file_id',
            'video_id',
            'created_at',
            'created_by'
        ]
    ];
@endphp
<div class="container">

    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('tracks') }}">shark Alert</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('tracks') }}">View All sharks</a></li>
            <li><a href="{{ URL::to('tracks/create') }}">Create a shark</a>
        </ul>
    </nav>

    @gridView($gridData)
    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

</div>
</body>
</html>
