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
            height: 4px;
            background-color: #5e5e5e;
            border-radius: 2px;
            margin: 20px 0;
            grid-column: 2 / 3;
            grid-row: 2;
        }

        .time {
            width: 0;
            height: 4px;
            transition: all 1.5s linear;
            background-color: #ffffff;
            border-radius: 2px;
        }

        .track_name, #player-current-track-name {
            color: white;
            font-weight: bold;
        }

        .track_name_play {
            color: #1ED760;
            font-weight: bold;
        }

        #controls {
            position: fixed;
            width: 100%;
            bottom: 0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 1fr);
            background: #181818;
        }

        .player-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            grid-column: 2 / 3;
            grid-row: 1;
        }

        .track-information {
            display: flex;
            /*text-align: center;*/
            grid-column: 1 / 2;
            grid-row: 1 / 3;
            padding-bottom: 1em;
            padding-top: 1em;
            padding-left: 1em;
        }

        .track-list-artist, #player-current-track-artist {
            color: #9b9b9b;
        }

        .track-list-info {
            margin-left: 1.5em;
            display: flex;
            flex-direction: column;
        }

        .player-track-list {
            display: flex;
            margin-bottom: 2em
        }

        .player-current-track-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-left: 1em;
        }

        .play, .play-next, .play-prev {
            background: none;
            border: unset;
            padding: unset;
        }

        .play:active {
            transform: scale(.92);
        }
        /*-----------------------------------------*/
        /*----------spotify clone  start-----------*/
        /*-----------------------------------------*/
        .top-container {
            display: grid;
            /*grid-template-columns: repeat(2, 1fr);*/
            /*grid-template-rows: repeat(2, 1fr);*/
            grid-template-columns: 1fr 3fr;
            grid-template-rows: 1fr 90px;
        }

        .main-view-tracklist {
            grid-column: 2;
            grid-row: 1;
            background: #0c5460;
        }

        .navigation-bar {
            grid-column: 1;
            grid-row: 1;
            background: #dd1044;
        }

        .now-playing-bar {
            display: block;
            grid-column: 1;
            grid-row: 2;
            background: #1ED760;
        }

        .now-playing-bar {
            display: block;
            grid-column: 1 / span 2;
            grid-row: 2;
            background: #1ED760;
        }

    </style>

    <style>
        /*.top-container {*/
        /*    display: grid;*/
        /*!*    grid-template-areas:*!*/
        /*!*"top-bar top-bar"*!*/
        /*!*"nav-bar main-view"*!*/
        /*!*"now-playing-bar now-playing-bar";*!*/
        /*    grid-template-columns: auto 1fr;*/
        /*    grid-template-rows: auto 1fr auto;*/
        /*    height: 100%;*/
        /*    min-height: 100%;*/
        /*    position: relative;*/
        /*    width: 100%;*/
        /*}*/
        /*.top-bar {*/
        /*    grid-area: main-view;*/
        /*    height: 64px;*/
        /*    min-width: 0;*/
        /*    pointer-events: none;*/
        /*    z-index: 2;*/
        /*}*/

        /*.nav-bar {*/
        /*    background-color: #000;*/
        /*    display: flex;*/
        /*    flex-direction: column;*/
        /*    grid-area: nav-bar;*/
        /*    min-height: 0;*/
        /*    position: relative;*/
        /*    !*width: calc(var(--nav-bar-width) + 9px);*!*/
        /*    z-index: 3;*/
        /*}*/
        /*.now-playing-bar {*/
        /*    !*grid-area: now-playing-bar;*!*/
        /*    width: 100%;*/
        /*    z-index: 4;*/
        /*}*/
        /*.main-view {*/
        /*    -webkit-box-orient: vertical;*/
        /*    -webkit-box-direction: normal;*/
        /*    display: -webkit-box;*/
        /*    display: -ms-flexbox;*/
        /*    display: flex;*/
        /*    -ms-flex-direction: column;*/
        /*    flex-direction: column;*/
        /*    grid-area: main-view;*/
        /*    min-height: 0;*/
        /*    overflow: hidden;*/
        /*    position: relative;*/
        /*    width: 100%;*/
        /*}*/

    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function(){ // Аналог $(document).ready(function(){

        let treck; // Переменная с индексом трека
        treck = 0; // Присваиваем переменной ноль
        let playButton = false;

        let audio = document.getElementById("audio");    // Берём элемент audio
        let time = document.querySelector(".time");      // Берём аудио дорожку
        let btnPlay = document.getElementById("btnPlay");   // Берём кнопку проигрывания
        let btnPrev = document.getElementById("btnPrev");   // Берём кнопку переключения предыдущего трека
        let btnNext = document.getElementById("btnNext");   // Берём кнопку переключение следующего трека

        let playerCover = document.getElementById("player_cover");
        let track_name = document.getElementById("track_name_0");

        let player_track_name = document.getElementById("player-current-track-name");
        let player_track_artist = document.getElementById("player-current-track-artist");

        let playIconSVG = document.getElementById("playButtonSvg");
        let pauseIconSVG = document.getElementById("pauseButtonSvg");
        // Массив с названиями песен
        let playlist = [];

        @php
            //$playlist = json_encode($tracks);
        @endphp

        playlist = JSON.parse('<?= json_encode($tracks) ?>');
        console.log(playlist);

        function switchTreck (numTreck) {
            // Меняем значение атрибута src
            audio.src = playlist[numTreck]["src"];
            // Назначаем время песни ноль
            audio.currentTime = 0;
            playerCover.src = playlist[numTreck]["cover"];
            // Включаем песню
            audio.play();
        }

        function changeFeedbackUI(prevTrack, nextTrack) {
            track_name = document.getElementById("track_name_" + playlist[prevTrack]["id"]);
            track_name.className = "track_name";

            track_name = document.getElementById("track_name_" + playlist[nextTrack]["id"]);
            track_name.className = "track_name_play";

            player_track_name.innerHTML = playlist[nextTrack]["name"];
            player_track_artist.innerHTML = playlist[nextTrack]["artist"];
        }

        function pauseOrPlayTrack(pause = false) {
            if (pause) {
                playButton = true;
            } else {
                playButton = !playButton;
            }
            if (playButton) {
                playIconSVG.style.display = "none";
                pauseIconSVG.style.display = "block";

                audio.play(); // Запуск песни
                track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                track_name.className = "track_name_play";

                player_track_name.innerHTML = playlist[treck]["name"];
                // Запуск интервала
                audioPlay = setInterval(function () {
                    // Получаем значение на какой секунде песня
                    let audioTime = Math.round(audio.currentTime);
                    // Получаем всё время песни
                    let audioLength = Math.round(audio.duration)
                    // Назначаем ширину элементу time
                    time.style.width = (audioTime * 100) / audioLength + '%';
                    // Сравниваем, на какой секунде сейчас трек и всего сколько времени длится
                    // И проверяем что переменная treck меньше четырёх
                    if (audioTime == audioLength && treck < '<?= $count ?>') {
                        changeFeedbackUI(treck, treck + 1);
                        treck++; // То Увеличиваем переменную
                        switchTreck(treck); // Меняем трек
                        // Иначе проверяем тоже самое, но переменная treck больше или равна четырём
                    } else if (audioTime == audioLength && treck >= '<?= $count ?>') {
                        changeFeedbackUI(treck, treck + 1);
                        treck = 0; // То присваиваем treck ноль
                        switchTreck(treck); //Меняем трек
                    }
                    navigator.mediaSession.metadata = new MediaMetadata({
                        title: playlist[treck]["name"],
                        artist: playlist[treck]["artist"],
                        album: playlist[treck]["name"],
                        artwork: [
                            { src: playlist[treck]["src"],   sizes: '96x96',   type: 'image/png' }
                        ]
                    });
                }, 10)
            } else {
                playIconSVG.style.display = "block";
                pauseIconSVG.style.display = "none";
                audio.pause(); // Останавливает песню
                clearInterval(audioPlay) // Останавливает интервал
            }
        }

        function prevTrack() {
            playIconSVG.style.display = "none";
            pauseIconSVG.style.display = "block";
            playButton = true;
            // Проверяем что переменная treck больше нуля
            if (treck > 0) {
                changeFeedbackUI(treck, treck-1);
                treck--; // Если верно, то уменьшаем переменную на один
                switchTreck(treck); // Меняем песню.
            } else { // Иначе
                changeFeedbackUI(treck, '<?= $count ?>');
                treck = '<?= $count ?>'; // Присваиваем три
                switchTreck(treck); // Меняем песню
            }
            navigator.mediaSession.metadata = new MediaMetadata({
                title: playlist[treck]["name"],
                artist: playlist[treck]["artist"],
                album: playlist[treck]["name"],
                artwork: [
                    { src: playlist[treck]["src"],   sizes: '96x96',   type: 'image/png' }
                ]
            });
        }

        btnPlay.addEventListener("click", function() {
            pauseOrPlayTrack();
        });

        function nextTrack() {
            playIconSVG.style.display = "none";
            pauseIconSVG.style.display = "block";
            playButton = true;
            // Проверяем что переменная treck больше трёх
            if (treck < '<?= $count ?>') { // Если да, то
                changeFeedbackUI(treck, treck + 1);
                treck++; // Увеличиваем её на один
                switchTreck(treck); // Меняем песню
            } else { // Иначе
                changeFeedbackUI(treck, 0);
                treck = 0; // Присваиваем ей ноль
                switchTreck(treck); // Меняем песню
            }
            navigator.mediaSession.metadata = new MediaMetadata({
                title: playlist[treck]["name"],
                artist: playlist[treck]["artist"],
                album: playlist[treck]["name"],
                artwork: [
                    { src: playlist[treck]["src"], sizes: '96x96',   type: 'image/png' },
                    { src: playlist[treck]["src"], sizes: '128x128', type: 'image/png' },
                    { src: playlist[treck]["src"], sizes: '192x192', type: 'image/png' },
                    { src: playlist[treck]["src"], sizes: '256x256', type: 'image/png' },
                    { src: playlist[treck]["src"], sizes: '384x384', type: 'image/png' },
                    { src: playlist[treck]["src"], sizes: '512x512', type: 'image/png' },
                ]
            });
        }

        btnPrev.addEventListener("click", function() {
            prevTrack();
        });

        navigator.mediaSession.setActionHandler(
            'play',
                () => {
                    pauseOrPlayTrack();
                }
        );

        navigator.mediaSession.setActionHandler(
            'pause',
                () => {
                    pauseOrPlayTrack();
                }
        );

        navigator.mediaSession.setActionHandler(
            'previoustrack',
                () => {
                    prevTrack();
                }
        );

        btnNext.addEventListener("click", function() {
            nextTrack();
        });

        navigator.mediaSession.setActionHandler(
            'nexttrack',
                () => {
                    nextTrack()
                }
            );
        });

    </script>
<body>
@php
    echo '<div class="top-container">
            <div class="top-bar">
            </div>
            <div class="navigation-bar">
            </div>
            <div class="now-playing-bar">
                <footer class="now-playing-bar-footer">
                    <div class="now-player-container">
                        <div class="now-player-info-container">
                            <div class="now-player-info">
                                <div class="now-playing-cover">

                                </div>
                                <div class="now-playing-info">

                                </div>
                                <button>
                                    <svg role="img" height="16" width="16" aria-hidden="true" viewBox="0 0 16 16" class="Svg-sc-ytk21e-0 uPxdw"><path d="M15.724 4.22A4.313 4.313 0 0012.192.814a4.269 4.269 0 00-3.622 1.13.837.837 0 01-1.14 0 4.272 4.272 0 00-6.21 5.855l5.916 7.05a1.128 1.128 0 001.727 0l5.916-7.05a4.228 4.228 0 00.945-3.577z"></path></svg>
                                </button>
                            </div>
                        </div>
                        <div class="player-actions">
                        </div>
                        <div class="player-controls">
                        </div>
                    </div>
                </footer>
            </div>
            <div class="main-view-tracklist">
            ';
    foreach ($tracks as $track) {
        echo '<div class="player-track-list">' . '<img width="40em"src="' . $track['cover'] . '">'
        . '<div class="track-list-info"><div id="track_name_' . $track['id'] . '" class="track_name">' . $track['name']
        . '</div><div class="track-list-artist">' . $track['artist'] . '</div></div>'
        . '</div>';
    }
    echo '
            </div>
    </div>';

    echo '<div style="background: #121212; width: 100%; height: 100em">';
    echo '<div style="display: flex;align-items: flex-start;flex-direction: column;">';
    foreach ($tracks as $track) {
        echo '<div class="player-track-list">' . '<img width="40em"src="' . $track['cover'] . '">'
        . '<div class="track-list-info"><div id="track_name_' . $track['id'] . '" class="track_name">' . $track['name']
        . '</div><div class="track-list-artist">' . $track['artist'] . '</div></div>'
        . '</div>';
    }

    echo '</div>';
    foreach ($tracks as $track) {
        echo '<audio id="audio" src="' . $track['src'] . '" controls></audio>';
        break;
    }
    echo '<div id="controls">
        <div class="track-information">
            <img id="player_cover" width="55px" height="55px" src="' . $tracks[0]['cover'] . '">
            <div class="player-current-track-info">
                <div id="player-current-track-name">' . $track['name'] . '</div>
                <div id="player-current-track-artist">' . $track['artist'] . '</div>
            </div>
        </div>
        <div class="player-buttons">
            <button id="btnPrev" class="play-prev">
                <svg
                    id="prevButtonSvg"
                    version="1.1"
                    baseProfile="full"
                    width="40"
                    height="40"
                    xmlns="http://www.w3.org/2000/svg">14.273
                    <polygon points="28.386,28.155 14.273,20.006 28.386,11.858" style="fill:#bababa;" />
                    <rect x="12.742" y="12" width="4" height="15.5" rx="1" style="fill:#bababa;" />
                </svg>
            </button>
            <button id="btnPlay" class="play">
                <svg
                    id="playButtonSvg"
                    version="1.1"
                    baseProfile="full"
                    width="40"
                    height="40"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="20" fill="white"/>
                    <polygon points="14.273,28.155 28.386,20.006 14.273,11.858" style="fill:black;" />
                </svg>
                <svg
                    id="pauseButtonSvg"
                    style="display:none"
                    version="1.1"
                    baseProfile="full"
                    width="40"
                    height="40"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="20" fill="white"/>
                    <rect x="13.276" y="12" width="4" height="15.5" rx="1" />
                    <rect x="22.742" y="12" width="4" height="15.5" rx="1" />
                </svg>
            </button>
            <button id="btnNext" class="play-next">
                <svg
                    id="nextButtonSvg"
                    version="1.1"
                    baseProfile="full"
                    width="40"
                    height="40"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon points="14.273,28.155 28.386,20.006 14.273,11.858" style="fill:#bababa;" />
                    <rect x="25.742" y="12" width="4" height="15.5" rx="1" style="fill:#bababa;" />
                </svg>
            </button>
        </div>
        <div class="audio-track">
            <div class="time"></div>
        </div>
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
