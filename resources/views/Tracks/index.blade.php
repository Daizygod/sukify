@extends('layout')

@section('content')

    <style>
        @media (min-width: 1200px) {
            .col-lg-4 {
                width: unset !important;
            }
        }
    </style>
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
            //'photo_cover',
            [
                'attribute' => 'cover_file',
                'label' => 'photo_cover',
                'value' => function ($row) {
                    if (!is_null($row->cover_file) && !empty($row->cover_file) && $row->cover_file != '') {
                        return '<img width="100em"src="' . $row->cover_file . '">';
                    } else {
                        return '<b style="color: #f66;">NOT FOUND</b>';
                    }
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'file',
                'label' => 'file',
                'value' => function ($row) {
                    if (!is_null($row->file) && !empty($row->file) && $row->file != '') {
                        return '<audio controls>
                            <source src="' . $row->file . '" type="audio/mp3">
                        </audio>';
                    } else {
                        return '<b style="color: #f66;">NOT FOUND</b>';
                    }
                    return $result;
                },
                'format' => 'html',
            ],
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
            'updated_at',
            [ // Set Action Buttons.TODO:
            'class' => Itstructure\GridView\Columns\ActionColumn::class, // REQUIRED.
            'actionTypes' => [ // REQUIRED.
                'view' => function ($data) {
                    return route('tracks.show', $data);
                },
                'edit' => function ($data) {
                    return route('tracks.edit', $data);
                },
                [
                    'class' => Itstructure\GridView\Actions\Delete::class, // REQUIRED
                    'url' => function ($data) {
                        return '/admin/pages/' . $data->id . '/delete';
                    },
                    'htmlAttributes' => [
                        'target' => '_blank',
                        'style' => 'color: yellow; font-size: 16px;',
                        'onclick' => 'return window.confirm("Sure to delete?");'
                    ]
                ]
            ]
        ]
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
@endsection
