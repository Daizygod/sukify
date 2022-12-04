@extends('layout')

@section('content')

    <style>
        @media (min-width: 1200px) {
            .col-lg-4 {
                width: unset !important;
            }
        }
        .audio-track {
            width: 100%;
            height: 5px;
            background-color: #dddddd;
            margin: 20px 0
        }

        .time {
            width: 0;
            height: 5px;
            transition: all 1.5s linear;
            background-color: #474747
        }

        .track_name {
            color: white;
            font-weight: bold;
        }

        .track_name_play {
            color: #1ED760;
            font-weight: bold;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function(){ // Аналог $(document).ready(function(){

            let treck; // Переменная с индексом трека
            // Событие перед загрузкой страницы
            treck = 0; // Присваиваем переменной ноль

        let audio = document.getElementById("audio");    // Берём элемент audio
        let time = document.querySelector(".time");      // Берём аудио дорожку
        let btnPlay = document.getElementById("btnPlay");   // Берём кнопку проигрывания
        let btnPause = document.getElementById("btnPause"); // Берём кнопку паузы
        let btnPrev = document.getElementById("btnPrev");   // Берём кнопку переключения предыдущего трека
        let btnNext = document.getElementById("btnNext");   // Берём кнопку переключение следующего трека

        let playerCover = document.getElementById("player_cover");
        let track_name = document.getElementById("track_name_0");

        // Массив с названиями песен
        let playlist = [];

        @php
            $playlist = json_encode($tracks);
        @endphp
        playlist = JSON.parse('<?= $playlist ?>');

        function switchTreck (numTreck) {
            // Меняем значение атрибута src
            audio.src = playlist[numTreck]["src"];
            // Назначаем время песни ноль
            audio.currentTime = 0;
            playerCover.src = playlist[numTreck]["cover"];
            // Включаем песню
            audio.play();
        }

        btnPlay.addEventListener("click", function() {
            audio.play(); // Запуск песни
            alert(treck);
            track_name = document.getElementById("track_name_" + playlist[0]["id"]);
            track_name.className = "track_name_play";
            // Запуск интервала
            audioPlay = setInterval(function() {
                // Получаем значение на какой секунде песня
                let audioTime = Math.round(audio.currentTime);
                // Получаем всё время песни
                let audioLength = Math.round(audio.duration)
                // Назначаем ширину элементу time
                time.style.width = (audioTime * 100) / audioLength + '%';
                // Сравниваем, на какой секунде сейчас трек и всего сколько времени длится
                // И проверяем что переменная treck меньше четырёх
                if (audioTime == audioLength && treck < '<?= $count ?>') {
                    track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                    track_name.className = "track_name";
                    treck++; // То Увеличиваем переменную
                    track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                    track_name.className = "track_name_play";
                    switchTreck(treck); // Меняем трек
                    // Иначе проверяем тоже самое, но переменная treck больше или равна четырём
                } else if (audioTime == audioLength && treck >= '<?= $count ?>') {
                    track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                    track_name.className = "track_name";
                    treck = 0; // То присваиваем treck ноль
                    track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                    track_name.className = "track_name_play";
                    switchTreck(treck); //Меняем трек
                }
            }, 10)
        });

        btnPause.addEventListener("click", function() {
            audio.pause(); // Останавливает песню
            clearInterval(audioPlay) // Останавливает интервал
        });

        btnPrev.addEventListener("click", function() {
            // Проверяем что переменная treck больше нуля
            if (treck > 0) {
                track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                track_name.className = "track_name";
                treck--; // Если верно, то уменьшаем переменную на один
                track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                track_name.className = "track_name_play";
                switchTreck(treck); // Меняем песню.
            } else { // Иначе
                alert('<?= $count ?>')
                track_name = document.getElementById("track_name_" + playlist[0]["id"]);
                track_name.className = "track_name";
                treck = '<?= $count ?>'; // Присваиваем три
                track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                track_name.className = "track_name_play";
                switchTreck(treck); // Меняем песню
            }
        });

        btnNext.addEventListener("click", function() {
            // Проверяем что переменная treck больше трёх
            if (treck < '<?= $count ?>') { // Если да, то
                console.log("track_name_" + treck);
                track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                track_name.className = "track_name";
                treck++; // Увеличиваем её на один
                track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                track_name.className = "track_name_play";
                switchTreck(treck); // Меняем песню
            } else { // Иначе
                track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                track_name.className = "track_name";
                treck = 0; // Присваиваем ей ноль
                track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                track_name.className = "track_name_play";
                switchTreck(treck); // Меняем песню
            }
        });

        });
    </script>
<body>
@php
    echo '<div style="background: #121212; width: 100%; height: 100em">';
    echo '<div style="display: flex;align-items: flex-start;flex-direction: column;">';
    foreach ($tracks as $track) {
        echo '<div style="display: flex; margin-bottom: 2em">' . '<img width="40em"src="' . $track['cover'] . '">'
        . '<div style="margin-left: 1.5em; display: flex;flex-direction: column;"><div id="track_name_' . $track['id'] . '" class="track_name">' . $track['name']
        . '</div><div style="color: #9b9b9b;">' . $track['artist'] . '</div></div>'
        . '</div>';
    }
    echo '</div>';
    foreach ($tracks as $track) {
        echo '<audio id="audio" src="' . $track['src'] . '" controls></audio>';
        break;
    }
    echo '<div id="controls">
    <div class="audio-track"><div class="time"></div></div>
    <div><img id="player_cover" width="40em"src="' . $tracks[0]['cover'] . '"></div>
    <button id="btnPlay" class="play">Play</button>
    <button id="btnPause" class="pause">Pause</button>
    <button id="btnPrev" class="prev">&#60;prev</button>
    <button id="btnNext" class="next">next&#62;</button>
    </div>';
    echo '</div>';
    //    $gridData = [
    //        'dataProvider' => $dataProvider,
    //        'title' => 'Tracks',
    //        'useFilters' => true,
    //        'rowsFormAction' => false,
    //        'columnFields' => [
    //            'id',
    //            [
    //                'attribute' => 'artist_id',
    //                'label' => 'Artist',
    //                'value' => function ($row) {
    //                    $artist = \App\Models\Artist::where('id', $row->artist_id)->first();
    //                    if ($artist) {
    //                        #TODO route to view artist (after create view page)
    //                        $result = $artist->name;
    //                        //$result = "<a href=" . url('page') . ">" . $artist->name . "</a>";
    //                    } else {
    //                        $result = "Not found";
    //                    }
    //                    return $result;
    //                }
    //            ],
    //            'name',
    //            [
    //                'attribute' => 'release_date',
    //                'label' => 'Released', // Column label.
    //                'value' => function ($row) { // You can set 'value' as a callback function to get a row data value dynamically.
    //                    return date('d.m.Y', strtotime($row->release_date));
    //                },
    //                'format' => 'html', // To render column content without lossless of html tags, set 'html' formatter.
    //            ],
    //            [
    //                'attribute' => 'type',
    //                'label' => 'Type',
    //                'value' => function ($row) {
    //                    return \App\Models\Track::$types_array[$row->type];
    //                }
    //            ],
    //            [
    //                'attribute' => 'counter',
    //                'label' => 'Streams',
    //            ],
    //            //'photo_cover',
    //            [
    //                'attribute' => 'cover_file',
    //                'label' => 'photo_cover',
    //                'value' => function ($row) {
    //                    if (!is_null($row->cover_file) && !empty($row->cover_file) && $row->cover_file != '') {
    //                        return '<img width="100em"src="' . $row->cover_file . '">';
    //                    } else {
    //                        return '<b style="color: #f66;">NOT FOUND</b>';
    //                    }
    //                },
    //                'format' => 'html',
    //            ],
    //            [
    //                'attribute' => 'file',
    //                'label' => 'file',
    //                'value' => function ($row) {
    //                    if (!is_null($row->file) && !empty($row->file) && $row->file != '') {
    //                        return '<audio controls>
    //                            <source src="' . $row->file . '" type="audio/mp3">
    //                        </audio>';
    //                    } else {
    //                        return '<b style="color: #f66;">NOT FOUND</b>';
    //                    }
    //                    return $result;
    //                },
    //                'format' => 'html',
    //            ],
    //            [
    //                'attribute' => 'created_by',
    //                'label' => 'Created_by',
    //                'value' => function ($row) {
    //                    $user = \App\Models\User::where('id', $row->created_by)->first();
    //                    if ($user) {
    //                        #TODO route to view users (after create view page)
    //                        $result = $user->name;
    //                        //$result = "<a href=" . url('page') . ">" . $artist->name . "</a>";
    //                    } else {
    //                        $result = "Not found";
    //                    }
    //                    return $result;
    //                }
    //            ],
    //            'created_at',
    //            'updated_at',
    //            [ // Set Action Buttons.TODO:
    //            'class' => Itstructure\GridView\Columns\ActionColumn::class, // REQUIRED.
    //            'actionTypes' => [ // REQUIRED.
    //                'view' => function ($data) {
    //                    return route('tracks.show', $data);
    //                },
    //                'edit' => function ($data) {
    //                    return route('tracks.edit', $data);
    //                },
    //                [
    //                    'class' => Itstructure\GridView\Actions\Delete::class, // REQUIRED
    //                    'url' => function ($data) {
    //                        return '/admin/pages/' . $data->id . '/delete';
    //                    },
    //                    'htmlAttributes' => [
    //                        'target' => '_blank',
    //                        'style' => 'color: yellow; font-size: 16px;',
    //                        'onclick' => 'return window.confirm("Sure to delete?");'
    //                    ]
    //                ]
    //            ]
    //        ]
    //        ]
    //    ];
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

    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

</div>
</body>
@endsection
