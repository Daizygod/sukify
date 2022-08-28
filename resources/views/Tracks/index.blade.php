<!DOCTYPE html>
<html>
<head>
    <title>Sukify</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
@php
    $gridData = [
        'dataProvider' => $dataProvider,
        'title' => 'Tracks',
        'useFilters' => true,
        'rowsFormAction' => false,
        'columnFields' => [
            'id',
            [
                'attribute' => 'artist_id',
                'label' => 'Artist',
                'value' => function ($row) {
                    $artist = \App\Models\Artist::where('id', $row->artist_id)->first();
                    if ($artist) {
                        #TODO route to view artist (after create view page)
                        $result = $artist->name;
                        //$result = "<a href=" . url('page') . ">" . $artist->name . "</a>";
                    } else {
                        $result = "Not found";
                    }
                    return $result;
                }
            ],
            'name',
            [
                'attribute' => 'release_date',
                'label' => 'Released', // Column label.
                'value' => function ($row) { // You can set 'value' as a callback function to get a row data value dynamically.
                    return date('d.m.Y', strtotime($row->release_date));
                },
                'format' => 'html', // To render column content without lossless of html tags, set 'html' formatter.
            ],
            [
                'attribute' => 'type',
                'label' => 'Type',
                'value' => function ($row) {
                    return \App\Models\Track::$types_array[$row->type];
                }
            ],
            [
                'attribute' => 'counter',
                'label' => 'Streams',
            ],
            'photo_cover_id',
            [
                'attribute' => 'created_by',
                'label' => 'Created_by',
                'value' => function ($row) {
                    $user = \App\Models\User::where('id', $row->created_by)->first();
                    if ($user) {
                        #TODO route to view users (after create view page)
                        $result = $user->name;
                        //$result = "<a href=" . url('page') . ">" . $artist->name . "</a>";
                    } else {
                        $result = "Not found";
                    }
                    return $result;
                }
            ],
            'created_at',
            'updated_at'
        ]
    ];
@endphp
<div class="container">

    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('tracks') }}">Sukify</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ route('tracks.create') }}">Create Track</a>
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
