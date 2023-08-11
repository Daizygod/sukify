@extends('layout')

@section('content')


    <style>
        @media (min-width: 1200px) {
            .col-lg-4 {
                width: unset !important;
            }
        }

        @font-face {
            font-family: CircularSp-Cyrl-Bold;
            src: url('/fonts/CircularSp-Cyrl-Bold.ttf');
        }

        @font-face {
            font-family: CircularSp-Bold;
            src: url('/fonts/CircularSp-Bold.ttf');
        }

        @font-face {
            font-family: CircularSp-Cyrl-Book;
            src: url('/fonts/CircularSp-Cyrl-Book.ttf');
        }

        @font-face {
            font-family: CircularSp-Book;
            src: url('/fonts/CircularSp-Book.ttf');
        }

        html {
            height: 100%;
            overflow: hidden;
        }

        body {
            height: 100%;
        }

        .min-h-screen {
            height: 100%;
        }

        :root {
            --nav-bar-width: 367px;
            --button-size: 32px;
            --scrollbar-horizontal-size: 16px;
            --scrollbar-vertical-size: 16px;
            --row-height: 56px;
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
            /*font-weight: bold;*/
            font-family: CircularSp-Cyrl-Bold, CircularSp-Bold;
            font-size: 1.1em;
        }

        .track_name_play {
            color: #1ED760;
            font-weight: bold;
            font-family: CircularSp-Cyrl-Bold, CircularSp-Bold;
            font-size: 1.1em;
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

        #player-current-track-artist {
            color: #9b9b9b;
        }

        .player-track-list-track {
            display: grid;
            grid-template-columns: [index] 16px [first] 6fr [var1] 4fr [var2] 3fr [last] minmax(120px, 1fr);
            padding: 0 16px;
            grid-gap: 16px;
            height: 56px;
            border-radius: 4px;
            -moz-user-select: none;
            -khtml-user-select: none;
            user-select: none;
            height: var(--row-height);
            min-height: var(--row-height);
        }

        .track-list-track-number {
            display: flex;
            grid-column: 1;
            align-items: center;
            -moz-user-select: none;
            -khtml-user-select: none;
            user-select: none;

        }

        .track-list-action-play {
            height: 16px;
            width: 16px;
            min-height: 16px;
            min-width: 16px;
            display: inline-block;
            position: relative;
        }

        .track-number {
            color: white;
            position: absolute;
            font-size: 1em;
            font-weight: 400;
            top: -4px;
            right: 0.25em;
        }

        .play_track_button {
            /*display: flex;*/
            display: none;
            justify-content: center;
            text-align: center;
            pointer-events: none;
            background: transparent;
            border: 0;
            width: 100%;
            height: 100%;
            padding: 0;
        }

        .play_track_icon {
            fill: white;
            width: 16px;
            height: 16px;
        }

        .player-track-list-track:hover {
            background-color: hsla(0,0%,100%,.1);
        }

        .player-track-list-track:hover > .track-list-track-number > .track-list-action-play > span {
            display: none;
        }

        .player-track-list-track:hover > .track-list-track-number > .track-list-action-play > .play_track_button {
            display: flex;
        }

        .now-playing-cover:hover > .now-playing-cover-button {
            opacity: unset;
        }

        .now-playing-cover-button:hover {
            background: rgba(0,0,0,.8);
            color: #fff;
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
            cursor: default;
        }

        .player-track-list-track:active {
            background-color: hsla(0,0%,100%,.3);
        }

        .track-list-track-primary {
            display: flex;
            grid-column: 2;
            align-items: center;
            -moz-user-select: none;
            -khtml-user-select: none;
            user-select: none;
        }

        .track-list-info {
            column-gap: 8px;
            display: grid;
            grid-template:
        "title title"
        "badges subtitle"/auto 1fr;
            -moz-user-select: none;
            -khtml-user-select: none;
            user-select: none;
        }

        .track-list-artist {
            color: #9b9b9b;
            grid-area: subtitle;
            grid-column-start: badges;
            -moz-user-select: none;
            -khtml-user-select: none;
            user-select: none;
            font-family: CircularSp-Cyrl-Book, CircularSp-Book;
        }

        .player-track-list-cover {
            margin-right: 16px;
            -moz-user-select: none;
            -khtml-user-select: none;
            user-select: none;
        }

        .track_name, .track_name_play {
            grid-area: title;
            justify-self: start;
            font-family: CircularSp-Cyrl-Bold, CircularSp-Bold;
            font-size: 1.1em;
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
            grid-template-columns: auto 1fr;
            grid-template-rows: 1fr 90px;
            height: 100%;
        }

        .main-view-tracklist {
            grid-column: 2;
            grid-row: 1;
            display: flex;
            flex-direction: column;
            background: #121212;
            overflow: auto;
            padding-top: 300px;
        }

        .main-view-tracklist::-webkit-scrollbar-thumb {
            /*//height: 35px;*/
            /*//min-height: 40px;*/
            /*//max-height: 50px;*/
            background: hsla(0,0%,100%,.3);
            transition: background-color .2s;
        }

        .main-view-tracklist::-webkit-scrollbar-thumb:hover {
            background: hsla(0,0%,100%,.5);
        }

        .main-view-tracklist::-webkit-scrollbar-track {
            background: transparent;
        }

        .main-view-tracklist::-webkit-scrollbar {
            /*width: var(--scrollbar-vertical-size);*/
            width: 10px;
            height: 10px;
        }

        /*::-webkit-scrollbar {*/
        /*    width: var(--scrollbar-vertical-size);*/
        /*}*/

        /*!* Track *!*/
        /*::-webkit-scrollbar-track {*/
        /*    background: #f1f1f1;*/
        /*}*/

        /*!* Handle *!*/
        /*::-webkit-scrollbar-thumb {*/
        /*    background: #888;*/
        /*}*/

        /*!* Handle on hover *!*/
        /*::-webkit-scrollbar-thumb:hover {*/
        /*    background: #555;*/
        /*}*/

        .navigation-bar {
            /*grid-column: 1;*/
            /*grid-row: 1;*/
            /*background: #dd1044;*/
            /*display: flex;*/
            /*flex: 1;*/
            /*flex-direction: column;*/
            /*min-height: 0;*/
            /*padding-top: 24px;*/
            /*user-select: none;*/
            /*width: 100%;*/
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            background-color: #000;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            grid-column: 1;
            grid-row: 1;
            min-height: 0;
            position: relative;
            width: calc(var(--nav-bar-width) + 9px);
            z-index: 3;
        }

        .now-playing-bar {
            display: block;
            position: relative; /* My own*/
            grid-column: 1 / span 2;
            grid-row: 2;
            background: #1ED760;
            z-index: 3;
        }

        .now-playing-bar-footer {
            display: flex;
            flex-direction: column;
            height: auto;
            user-select: none;
            border: 0;
            margin: 0;
            padding: 0;
            min-width: 620px;
            background-color: #000;
        }

        .now-player-container {
            display: flex;
            align-items: center;
            flex-direction: row;
            height: 90px;
            justify-content: space-between;
            padding: 0 16px;
        }
        /*---1---*/
        .now-player-info-container {
            min-width: 180px;
            width: 30%;
        }
        .now-player-info {
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -webkit-box-pack: start;
            -ms-flex-pack: start;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: row;
            flex-direction: row;
            justify-content: flex-start;
            position: relative;
            -webkit-transform: translateX(0);
            transform: translateX(0);
            -webkit-transition: -webkit-transform .25s cubic-bezier(.3,0,0,1);
            transition: -webkit-transform .25s cubic-bezier(.3,0,0,1);
            transition: transform .25s cubic-bezier(.3,0,0,1);
            transition: transform .25s cubic-bezier(.3,0,0,1),-webkit-transform .25s cubic-bezier(.3,0,0,1);
        }

        .now-player-info.collapsed {
            -webkit-transform: translateX(-72px);
            transform: translateX(-72px);
        }

        .now-playing-cover {
            position: relative;
        }
        #player_cover {
            background-color: #000;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: contain;
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }
        .now-playing-cover-button {
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            background: rgba(0,0,0,.7);
            border-radius: 500px;
            border-width: 0;
            color: #b3b3b3;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            height: 24px;
            justify-content: center;
            line-height: 24px;
            opacity: 0;
            padding: 0;
            position: absolute;
            top: 5px;
            width: 24px;
            z-index: 1;
            right: 5px;
        }

        .now-playing-big-cover-button {
            bottom: 35%;
            left: 35%;
            position: absolute;
            right: 35%;
            top: 35%;
        }

        .big-cover-img {
            background-color: #000;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: contain;
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }

        .now-playing-big-cover {
            isolation: isolate;
            position: relative;
            width: 100%;
            will-change: height;
            z-index: 2;
            -webkit-transform: translateY(0);
            transform: translateY(0);
            -webkit-transition: -webkit-transform .25s cubic-bezier(.3,0,0,1);
            transition: -webkit-transform .25s cubic-bezier(.3,0,0,1);
            transition: transform .25s cubic-bezier(.3,0,0,1);
            transition: transform .25s cubic-bezier(.3,0,0,1),-webkit-transform .25s cubic-bezier(.3,0,0,1);
        }

        .now-playing-big-cover:hover > .now-playing-cover-button {
            opacity: unset;
        }

        #button_favourite {
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            align-items: center;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: center;
            color: #1ed760;
            background-color: transparent;
            border: none;
            height: 32px;
            min-width: 32px;
            width: 32px;
            cursor: default;
        }

        .top-bar-list {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-box-flex: 1;
            cursor: default;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: flex-end;
            -ms-flex: 1;
            flex: 1;
            -ms-flex-direction: column;
            flex-direction: column;
            min-height: 0;
            padding-top: 24px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            width: 100%;
        }

        .bar_resizer {
            background: linear-gradient(hsla(0,0%,100%,.3),hsla(0,0%,100%,.3)) no-repeat 50%/1px 100%;
            height: 100%;
            inset-inline-end: -4.5px;
            right: -4.5px;
            width: 9px;
            cursor: col-resize;
            opacity: 0;
            position: absolute;
        }

        .bar-resizer:active {
            cursor: col-resize;
        }

        .now-playing-big-cover.before-show-big-cover {
            z-index: -1;
            -webkit-transform: translateY(calc(var(--nav-bar-width) + 9px));
            transform: translateY(calc(var(--nav-bar-width) + 9px));
            -webkit-transition: -webkit-transform .25s cubic-bezier(.3,0,0,1);
            transition: -webkit-transform .25s cubic-bezier(.3,0,0,1);
            transition: transform .25s cubic-bezier(.3,0,0,1);
            transition: transform .25s cubic-bezier(.3,0,0,1),-webkit-transform .25s cubic-bezier(.3,0,0,1);
        }

        .now-playing-big-cover.collapsed {
            z-index: -1;
            /*padding: 0 !important;*/
            /*margin: 0 !important;*/
            -webkit-transform: translateY(calc(var(--nav-bar-width) + 9px));
            transform: translateY(calc(var(--nav-bar-width) + 9px));
        }
        .now-playing-big-cover.collapsed > div {
             /*padding: 0 !important;*/
             /*margin: 0 !important;*/
         }

        /*---2---*/
        .now-playing-info-track {
            display: grid;
            align-items: center;
            column-gap: 8px;
            margin: 0 14px;
            grid-template: 1fr/1fr;
        }

        .now-playing-track-name-container {
            --trans-x: 0px;
            display: flex;
            padding-inline-end: 12px;
            padding-inline-start: 6px;
            white-space: nowrap;
            width: fit-content;
        }

        .now-playing-track-artist-container {
            --trans-x: 0px;
            display: flex;
            padding-inline-end: 12px;
            padding-inline-start: 6px;
            white-space: nowrap;
            width: fit-content;
        }

        #now_playing_track_name {
            /*font-size: 1.5rem;*/
            /*font-weight: 400;*/
            color: #fff;

            font-family: CircularSp-Cyrl-Book, CircularSp-Book;
            font-size: 1.1em;
        }

        #now_playing_track_artist {
            /*font-size: 1.1rem;*/
            /*font-weight: 400;*/
            color: #b3b3b3;
            font-family: CircularSp-Cyrl-Book, CircularSp-Book;
        }

        .player-actions {
            max-width: 722px;
            width: 40%;
        }
        .now-playing-cover.collapsed {
            -webkit-transform: translateX(-72px);
            transform: translateX(-72px);
            /*flex-grow: 0.00001;*/
            padding: 0;
            margin: 0;
        }
        /*---3---*/
        .player-controls {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 30%;
        }

        .player-controls-buttons {
            display: flex;
            flex-flow: row nowrap;
            width: 100%;
            gap: 16px;
            margin-bottom: 8px;
        }

        .player-controls-left {
            display: flex;
            flex: 1;
            gap: 8px;
            justify-content: flex-end;
            -webkit-box-pack: end;
        }

        .button-shuffle {
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            align-items: center;
            background: transparent;
            border: none;
            color: hsla(0,0%,100%,.7);
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            height: var(--button-size);
            justify-content: center;
            min-width: var(--button-size);
            position: relative;
            width: var(--button-size);
        }

        .button-shuffle::after {
            background-color: currentcolor;
            border-radius: 50%;
            bottom: 0;
            content: "";
            display: block;
            height: 4px;
            left: 50%;
            position: absolute;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%);
            width: 4px;
        }

        .button-shuffle:hover {
            color: #fff;
        }

        .button-prev {
            --button-size: var(--button-size);
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            align-items: center;
            background: transparent;
            border: none;
            color: hsla(0,0%,100%,.7);
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            height: var(--button-size);
            justify-content: center;
            min-width: var(--button-size);
            position: relative;
            width: var(--button-size);
        }

        .button-prev:hover {
            color: #fff;
        }

        #control_track {
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            align-items: center;
            background-color: #fff;
            border: none;
            border-radius: var(--button-size);
            color: #000;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            height: var(--button-size);
            justify-content: center;
            min-width: var(--button-size);
            position: relative;
            -webkit-transition: none 33ms cubic-bezier(.3,0,.7,1);
            transition: none 33ms cubic-bezier(.3,0,.7,1);
            -webkit-transition-property: all;
            transition-property: all;
            width: var(--button-size);
        }

        #control_track:hover {
            -webkit-transform: scale(1.06);
            transform: scale(1.06);
            -webkit-transition: none 33ms cubic-bezier(.3,0,0,1);
            transition: none 33ms cubic-bezier(.3,0,0,1);
            -webkit-transition-property: all;
            transition-property: all;
        }

        #control_track:active {
            -webkit-transform: scale(.99);
            transform: scale(.99);
            -webkit-transition: none;
            transition: none;
        }

        .button-next {
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            align-items: center;
            background: transparent;
            border: none;
            color: hsla(0,0%,100%,.7);
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            height: var(--button-size);
            justify-content: center;
            min-width: var(--button-size);
            position: relative;
            width: var(--button-size);
        }

        .button-next:hover {
            color: #fff;
        }

        .button-repeat {
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            align-items: center;
            background: transparent;
            border: none;
            color: hsla(0,0%,100%,.7);
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            height: var(--button-size);
            justify-content: center;
            min-width: var(--button-size);
            position: relative;
            width: var(--button-size);
        }

        .button-repeat:hover {
            color: #fff;
        }

        .player-controls-right {
            display: flex;
            -webkit-box-flex: 1;
            flex: 1;
            gap: 8px;
        }

        #controls {
            display:none;
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

        let defaultTransitionSec = 5;

        let audio1 = document.getElementById("audio1");    // Берём элемент audio
        let mainAudio = audio1;
        let audio2 = document.getElementById("audio2");    // Берём второй элемент audio
        let time = document.querySelector(".time");      // Берём аудио дорожку
        let btnPlay = document.getElementById("control_track");   // Берём кнопку проигрывания
        let btnPrev = document.getElementById("control_prev_track");   // Берём кнопку переключения предыдущего трека
        let btnNext = document.getElementById("control_next_track");   // Берём кнопку переключение следующего трека

        let playerCover = document.getElementById("player_cover");
        let bigPlayerCover = document.getElementById("big_player_cover");
        let track_name = document.getElementById("track_name_0");

        let player_track_name = document.getElementById("now_playing_track_name");
        let player_track_artist = document.getElementById("now_playing_track_artist");

        let pauseIconSVG = document.getElementById("playButtonSvg");
        let playIconSVG = document.getElementById("pauseButtonSvg");

        let inTransition = false;
        // Массив с названиями песен
        let playlist = [];

        @php
            //$playlist = json_encode($tracks);
        @endphp

        playlist = JSON.parse('<?= json_encode($tracks) ?>');

        function isPlaying(audioElement) { return !audioElement.paused; }

        function switchTreck(numTreck) {
            // Меняем значение атрибута src
            if (mainAudio == audio1) {
                audio2.pause();
            } else if (mainAudio == audio2) {
                audio1.pause();
            }
            mainAudio.src = playlist[numTreck]["src"];
            // Назначаем время песни ноль
            mainAudio.currentTime = 0;
            // Включаем песню
            mainAudio.play();
        }

        function changeFeedbackUI(prevTrack, nextTrack) {
            track_name = document.getElementById("track_name_" + playlist[prevTrack]["id"]);
            track_name.className = "track_name";

            track_name = document.getElementById("track_name_" + playlist[nextTrack]["id"]);
            track_name.className = "track_name_play";

            player_track_name.innerHTML = playlist[nextTrack]["name"];
            player_track_artist.innerHTML = playlist[nextTrack]["artist"];

            playerCover.src = playlist[nextTrack]["cover"];
            bigPlayerCover.src = playlist[nextTrack]["cover"];
        }

        function audioPlayAsync() {
            let currentAudio = audio1;
            if(isPlaying(audio2)) {
                currentAudio = audio2;
            }
            if (isPlaying(audio1) && isPlaying(audio2)) {
                inTransition = true;
            } else if (isPlaying(audio1) || isPlaying(audio2)) {
                inTransition = false;
            }
            // Получаем значение на какой секунде песня
            let audioTime = Math.round(currentAudio.currentTime);
            // Получаем всё время песни
            let audioLength = Math.round(currentAudio.duration);
            // Назначаем ширину элементу time
            time.style.width = (audioTime * 100) / audioLength + '%';

            if (true) {
                if (audioTime == (audioLength - defaultTransitionSec) && treck < '<?= $count ?>' && !inTransition) {
                    inTransition = true;
                    changeFeedbackUI(treck, treck + 1);
                    treck++; // То Увеличиваем переменную
                    // Меняем трек
                    if (isPlaying(audio1) || isPlaying(audio2)) {
                        let nowAudio = audio1;
                        let nextAudio = audio2;
                        let nowAudioVolume = 1;
                        let nextAudioVolume = 0;
                        let transition = defaultTransitionSec;
                        let volumeStep = 100 / (transition * 10000);
                        if(isPlaying(audio2)) {
                            nowAudio = audio2;
                            nextAudio = audio1;
                        }
                        nextAudio.src = playlist[treck]["src"];
                        nextAudio.currentTime = 0;
                        nextAudio.volume = 0;
                        nextAudio.play();
                        let resultArray = [];

                        let audioPlay2 = setInterval( function() {
                            let audioTime = Math.round(nowAudio.currentTime * 10) / 10;
                            let audioLength = Math.round(nowAudio.duration * 10) / 10;
                            if (audioTime > audioLength - transition) {
                                if (nowAudioVolume > 0) {
                                    nowAudioVolume -= volumeStep;
                                    nowAudio.volume = Math.round(nowAudioVolume * 10) / 10;
                                } else {
                                    nowAudioVolume = 0;
                                    nowAudio.volume = 0;
                                }
                                if (nextAudioVolume > 1) {
                                    nextAudioVolume = 1;
                                    nextAudioVolume.volume = 1;
                                } else if (nextAudioVolume < 1 || !isPlaying(nowAudio)) {
                                    nextAudioVolume += volumeStep;
                                    nextAudio.volume = Math.round(nextAudioVolume * 10) / 10;
                                }
                            }
                            resultArray.push({'current': nowAudioVolume, 'next': nextAudioVolume});
                            if (nowAudioVolume == 0 && nextAudioVolume == 1) {
                                clearInterval(audioPlay2);
                                mainAudio = nextAudio;
                                inTransition = false;
                                console.table(resultArray);
                            }
                        }, 10);
                    }
                    // Иначе проверяем тоже самое, но переменная treck больше или равна
                } else if (audioTime == (audioLength - defaultTransitionSec) && treck >= '<?= $count ?>' && !inTransition) {
                    inTransition = true;
                    changeFeedbackUI(treck, 0);
                    treck = 0; // То присваиваем treck ноль
                    // Меняем трек
                    if (isPlaying(audio1) || isPlaying(audio2)) {
                        let nowAudio = audio1;
                        let nextAudio = audio2;
                        let nowAudioVolume = 1;
                        let nextAudioVolume = 0;
                        let transition = defaultTransitionSec;
                        let volumeStep = 100 / (transition * 10000);
                        if(isPlaying(audio2)) {
                            nowAudio = audio2;
                            nextAudio = audio1;
                        }
                        nextAudio.src = playlist[treck]["src"];
                        nextAudio.currentTime = 0;
                        nextAudio.volume = 0;
                        nextAudio.play();

                        let audioPlay2 = setInterval( function() {
                            let audioTime = Math.round(nowAudio.currentTime * 10) / 10;
                            let audioLength = Math.round(nowAudio.duration * 10) / 10;
                            if (audioTime > audioLength - transition) {
                                if (nowAudioVolume > 0) {
                                    nowAudioVolume -= volumeStep;
                                    nowAudio.volume = Math.round(nowAudioVolume * 10) / 10;
                                } else {
                                    nowAudioVolume = 0;
                                    nowAudio.volume = 0;
                                }
                                if (nextAudioVolume > 1) {
                                    nextAudioVolume = 1;
                                    nextAudioVolume.volume = 1;
                                } else if (nextAudioVolume < 1 || !isPlaying(nowAudio)) {
                                    nextAudioVolume += volumeStep;
                                    nextAudio.volume = Math.round(nextAudioVolume * 10) / 10;
                                }
                            }
                            if (nowAudioVolume == 0 && nextAudioVolume == 1) {
                                clearInterval(audioPlay2);
                                mainAudio = nextAudio;
                                inTransition = false;
                            }
                        }, 10);
                    }
                    // Иначе проверяем тоже самое, но переменная treck больше или равна
                }
            } else {
                // Сравниваем, на какой секунде сейчас трек и всего сколько времени длится
                // И проверяем что переменная treck меньше
                if (audioTime == audioLength && treck < '<?= $count ?>') {
                    changeFeedbackUI(treck, treck + 1);
                    treck++; // То Увеличиваем переменную
                    switchTreck(treck); // Меняем трек
                    // Иначе проверяем тоже самое, но переменная treck больше или равна
                } else if (audioTime == audioLength && treck >= '<?= $count ?>') {
                    changeFeedbackUI(treck, treck + 1);
                    treck = 0; // То присваиваем treck ноль
                    switchTreck(treck); //Меняем трек
                }
            }
            navigator.mediaSession.playbackState = 'playing';
            navigator.mediaSession.metadata = new MediaMetadata({
                title: playlist[treck]["name"],
                artist: playlist[treck]["artist"],
                album: playlist[treck]["name"],
                artwork: [
                    { src: "http://192.168.0.10:80/storage/images202212/tape96.png",   sizes: '96x96',   type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape128.png', sizes: '128x128', type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape192.png', sizes: '192x192', type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape256.png', sizes: '256x256', type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape384.png', sizes: '384x384', type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape512.png', sizes: '512x512', type: 'image/png' },
                ]
            });
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
                mainAudio.play(); // Запуск песни
                //audio1.play(); // Запуск песни
                track_name = document.getElementById("track_name_" + playlist[treck]["id"]);
                track_name.className = "track_name_play";

                player_track_name.innerHTML = playlist[treck]["name"];
                // Запуск интервала
                audioPlay = setInterval(audioPlayAsync, 10)
            } else {
                navigator.mediaSession.playbackState = 'paused';
                playIconSVG.style.display = "block";
                pauseIconSVG.style.display = "none";
                audio2.pause(); // Останавливает песню
                audio1.pause(); // Останавливает песню
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
            //navigator.mediaSession.playbackState = 'playing';
            navigator.mediaSession.metadata = new MediaMetadata({
                title: playlist[treck]["name"],
                artist: playlist[treck]["artist"],
                album: playlist[treck]["name"],
                artwork: [
                    { src: "http://192.168.0.10:80/storage/images202212/tape96.png",   sizes: '96x96',   type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape128.png', sizes: '128x128', type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape192.png', sizes: '192x192', type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape256.png', sizes: '256x256', type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape384.png', sizes: '384x384', type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape512.png', sizes: '512x512', type: 'image/png' },
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
            //navigator.mediaSession.playbackState = 'playing';
            navigator.mediaSession.metadata = new MediaMetadata({
                title: playlist[treck]["name"],
                artist: playlist[treck]["artist"],
                album: playlist[treck]["name"],
                artwork: [
                    { src: "http://192.168.0.10:80/storage/images202212/tape96.png",   sizes: '96x96',   type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape128.png', sizes: '128x128', type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape192.png', sizes: '192x192', type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape256.png', sizes: '256x256', type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape384.png', sizes: '384x384', type: 'image/png' },
                    { src: 'http://192.168.0.10:80/storage/images202212/tape512.png', sizes: '512x512', type: 'image/png' },
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
    <script>

        document.addEventListener('DOMContentLoaded', function() { // Аналог $(document).ready(function(){

            // resize nav bar
            const navBar = document.getElementById("navigationBar");
            let resizeNavBar = document.getElementById("resize_bar");

            document.addEventListener('mouseup', removeResizeBarEvents);

            function removeResizeBarEvents() {
                document.removeEventListener('mousemove', onMouseMove);
                resizeNavBar.onmouseup = null;
            }

            function onMouseMove(event) {
                let navBarNewWidth = event.pageX;
                if (navBarNewWidth >= 120 && navBarNewWidth <= 384) {
                    navBar.style.setProperty('--nav-bar-width', event.pageX + 'px');
                }
            }

            resizeNavBar.onmousedown = function(event) {
                document.addEventListener('mousemove', onMouseMove);
            }
            resizeNavBar.ondragstart = function() {
                return false;
            };
            // resizeNavBar.ondragenter = function() {
            //     return false;
            // };
            // resizeNavBar.ondragover = function() {
            //     return false;
            // };
            // resizeNavBar.ondragleave = function() {
            //     return false;
            // };
            // expand cover
            let BigCoverExpanded = false;

            let cover = document.getElementById("now_player_info");
            let coverBtn = document.getElementById("collapse_cover");

            let bigCover = document.getElementById("now_playing_big_cover");
            let bigCoverBtn = document.getElementById("collapse_big_cover");

            function collapseCover() {
                BigCoverExpanded = !BigCoverExpanded;
                if (!BigCoverExpanded) {
                    bigCover.classList.add('collapsed');
                    cover.classList.remove('collapsed');
                    setTimeout(() => { bigCover.style.display = "none"; }, 250); //TODO do await
                } else {
                    bigCover.style.display = "unset";
                    bigCover.classList.remove('collapsed');
                    bigCover.classList.add('before-show-big-cover');
                    setTimeout(() => { bigCover.classList.remove('before-show-big-cover'); }, 250); //TODO do await
                    cover.classList.add('collapsed');
                }
            }
            coverBtn.addEventListener('click', collapseCover);
            bigCoverBtn.addEventListener('click', collapseCover);
        });
        </script>
<body>
@php
    echo '<div class="top-container">
            <div class="top-bar">
            </div>
            <nav id="navigationBar" class="navigation-bar">
                <div class="top-bar-list">
                    <div class="now-playing-big-cover collapsed" style="display: none" id="now_playing_big_cover">
                        <div style="width: auto; height: auto; padding-bottom: 100%;">
                            <img id="big_player_cover" class="big-cover-img" draggable="false" src="' . $tracks[0]['cover'] . '">
                        </div>
                        <button type="button" class="now-playing-cover-button" id="collapse_big_cover">
                            <svg role="img" height="16" width="16" aria-hidden="true" viewBox="0 0 16 16" data-encore-id="icon" class="Svg-sc-ytk21e-0 uPxdw" fill="currentColor">
                                <path d="M.47 4.97a.75.75 0 011.06 0L8 11.44l6.47-6.47a.75.75 0 111.06 1.06L8 13.56.47 6.03a.75.75 0 010-1.06z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="resize_bar" class="bar_resizer" style="z-index: 1;">
                    <label class="hidden-visually">Изменить размер главной панели навигации
                        <input id="resizeNavBarInput" class="" type="range" min="120" max="384" step="10" value="384">
                    </label>
                </div>
            </nav>
            <div class="now-playing-bar">

                <footer class="now-playing-bar-footer">
                    <div class="now-player-container">
                        <div class="now-player-info-container">
                            <div class="now-player-info" id="now_player_info">
                                <div class="now-playing-cover" id="now_playing_cover">
                                    <div style="width: 56px;height: 56px; position: relative;" aria-hidden="true">
                                        <img id="player_cover" width="55px" height="55px" src="' . $tracks[0]['cover'] . '">
                                    </div>
                                    <button class="now-playing-cover-button" id="collapse_cover">
                                        <svg role="img" height="16" width="16" aria-hidden="true" viewBox="0 0 16 16" data-encore-id="icon" class="Svg-sc-ytk21e-0 uPxdw" fill="currentColor">
                                            <path d="M.47 11.03a.75.75 0 001.06 0L8 4.56l6.47 6.47a.75.75 0 101.06-1.06L8 2.44.47 9.97a.75.75 0 000 1.06z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="now-playing-info-track">
                                    <div class="now-playing-track-name-container">
                                        <div class="now-playing-track-name">
                                            <span id="now_playing_track_name">
                                            ' . $tracks[0]['name'] . '
                                            </span>
                                        </div>
                                    </div>
                                    <div class="now-playing-track-artist-container">
                                        <div class="now-playing-track-artist">
                                            <span id="now_playing_track_artist">
                                            ' . $tracks[0]['artist'] . '
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <button id="button_favourite">
                                    <svg role="img" height="16" width="16" aria-hidden="true" viewBox="0 0 16 16" fill="currentcolor">
                                    <path d="M15.724 4.22A4.313 4.313 0 0012.192.814a4.269 4.269 0 00-3.622 1.13.837.837 0 01-1.14 0 4.272 4.272 0 00-6.21 5.855l5.916 7.05a1.128 1.128 0 001.727 0l5.916-7.05a4.228 4.228 0 00.945-3.577z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="player-controls">
                            <div class="player-controls-buttons">
                                <div class="player-controls-left">
                                    <button id="control_shuffle" role="switch" aria-checked="false" class="button-shuffle">
                                        <svg role="img" height="16" width="16" aria-hidden="true" viewBox="0 0 16 16" fill="currentcolor">
                                            <path d="M13.151.922a.75.75 0 10-1.06 1.06L13.109 3H11.16a3.75 3.75 0 00-2.873 1.34l-6.173 7.356A2.25 2.25 0 01.39 12.5H0V14h.391a3.75 3.75 0 002.873-1.34l6.173-7.356a2.25 2.25 0 011.724-.804h1.947l-1.017 1.018a.75.75 0 001.06 1.06L15.98 3.75 13.15.922zM.391 3.5H0V2h.391c1.109 0 2.16.49 2.873 1.34L4.89 5.277l-.979 1.167-1.796-2.14A2.25 2.25 0 00.39 3.5z"></path><path d="M7.5 10.723l.98-1.167.957 1.14a2.25 2.25 0 001.724.804h1.947l-1.017-1.018a.75.75 0 111.06-1.06l2.829 2.828-2.829 2.828a.75.75 0 11-1.06-1.06L13.109 13H11.16a3.75 3.75 0 01-2.873-1.34l-.787-.938z"></path>
                                        </svg>
                                    </button>
                                    <button id="control_prev_track" class="button-prev">
                                        <svg role="img" height="16" width="16" aria-hidden="true" viewBox="0 0 16 16" fill="currentcolor">
                                            <path d="M3.3 1a.7.7 0 01.7.7v5.15l9.95-5.744a.7.7 0 011.05.606v12.575a.7.7 0 01-1.05.607L4 9.149V14.3a.7.7 0 01-.7.7H1.7a.7.7 0 01-.7-.7V1.7a.7.7 0 01.7-.7h1.6z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <button id="control_track" class="button-control">
                                    <svg id="playButtonSvg" style="display: none" role="img" height="16" width="16" aria-hidden="true" viewBox="0 0 16 16" fill="currentcolor">
                                        <path d="M2.7 1a.7.7 0 00-.7.7v12.6a.7.7 0 00.7.7h2.6a.7.7 0 00.7-.7V1.7a.7.7 0 00-.7-.7H2.7zm8 0a.7.7 0 00-.7.7v12.6a.7.7 0 00.7.7h2.6a.7.7 0 00.7-.7V1.7a.7.7 0 00-.7-.7h-2.6z"></path>
                                    </svg>
                                    <svg id="pauseButtonSvg" role="img" height="16" width="16" aria-hidden="true" viewBox="0 0 16 16" fill="currentcolor">
                                        <path d="M3 1.713a.7.7 0 011.05-.607l10.89 6.288a.7.7 0 010 1.212L4.05 14.894A.7.7 0 013 14.288V1.713z"></path>
                                    </svg>
                                </button>
                                <div class="player-controls-right">
                                    <button id="control_next_track" class="button-next">
                                        <svg role="img" height="16" width="16" aria-hidden="true" viewBox="0 0 16 16" fill="currentcolor">
                                            <path d="M12.7 1a.7.7 0 00-.7.7v5.15L2.05 1.107A.7.7 0 001 1.712v12.575a.7.7 0 001.05.607L12 9.149V14.3a.7.7 0 00.7.7h1.6a.7.7 0 00.7-.7V1.7a.7.7 0 00-.7-.7h-1.6z"></path>
                                        </svg>
                                    </button>
                                    <button id="control_repeat" role="checkbox" aria-checked="false" class="button-repeat">
                                        <svg role="img" height="16" width="16" aria-hidden="true" viewBox="0 0 16 16" fill="currentcolor">
                                            <path d="M0 4.75A3.75 3.75 0 013.75 1h8.5A3.75 3.75 0 0116 4.75v5a3.75 3.75 0 01-3.75 3.75H9.81l1.018 1.018a.75.75 0 11-1.06 1.06L6.939 12.75l2.829-2.828a.75.75 0 111.06 1.06L9.811 12h2.439a2.25 2.25 0 002.25-2.25v-5a2.25 2.25 0 00-2.25-2.25h-8.5A2.25 2.25 0 001.5 4.75v5A2.25 2.25 0 003.75 12H5v1.5H3.75A3.75 3.75 0 010 9.75v-5z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="playback">
                            </div>
                        </div>
                        <div class="player-actions">
                        </div>
                    </div>
                </footer>
            </div>
            <div class="main-view-tracklist">
            ';
    foreach ($tracks as $key => $track) {
        echo '<div class="player-track-list-track">'
        . '<div class="track-list-track-number"><div class="track-list-action-play">'
        . '<span class="track-number">' . $key+1 . '</span>'
        . '<button id="play_track_' . $track['id'] . '" class="play_track_button">'
        . '<svg height="24" width="24" aria-hidden="true" class="play_track_icon" viewBox="0 0 24 24" data-encore-id="icon"><path d="M7.05 3.606l13.49 7.788a.7.7 0 010 1.212L7.05 20.394A.7.7 0 016 19.788V4.212a.7.7 0 011.05-.606z"></path></svg>'
        . '</div>'
        . '</div>'
        . '<div class="track-list-track-primary">'
        . '<img class="player-track-list-cover" width="40" height="40" src="' . $track['cover'] . '">'
        . '<div class="track-list-info"><div id="track_name_' . $track['id'] . '" class="track_name">' . $track['name'] . '</div>'
        . '<div class="track-list-artist">' . $track['artist'] . '</div></div>'
        . '</div>'
        . '</div>';
    }
    echo '
            </div>
    </div>';

//    echo '<div style="background: #121212; width: 100%; height: 100em">';
//    echo '<div style="display: flex;align-items: flex-start;flex-direction: column;">';
//    foreach ($tracks as $track) {
//        echo '<div class="player-track-list-track">' . '<img width="40em"src="' . $track['cover'] . '">'
//        . '<div class="track-list-info"><div id="track_name_' . $track['id'] . '" class="track_name">' . $track['name']
//        . '</div><div class="track-list-artist">' . $track['artist'] . '</div></div>'
//        . '</div>';
//    }
//
//    echo '</div>';
    foreach ($tracks as $track) {

        break;
    }
    echo '<div id="controls">
        <div class="audio-track">
            <div class="time"></div>
        </div>
    </div>';
    echo '</div>';

   echo '<audio id="audio1" src="' . $tracks[0]['src'] . '" controls></audio>';
   echo '<audio id="audio2" src="' . $tracks[1]['src'] . '" controls></audio>';
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
{{--<div class="container">--}}

{{--    <nav class="navbar navbar-inverse">--}}
{{--        <div class="navbar-header">--}}
{{--            <a class="navbar-brand" href="{{ URL::to('tracks') }}">Sukify</a>--}}
{{--        </div>--}}
{{--        <ul class="nav navbar-nav">--}}
{{--            <li><a href="{{ route('tracks.create') }}">Create Track</a>--}}
{{--        </ul>--}}
{{--    </nav>--}}

{{--    <!-- will be used to show any messages -->--}}
{{--    @if (Session::has('message'))--}}
{{--        <div class="alert alert-info">{{ Session::get('message') }}</div>--}}
{{--    @endif--}}

{{--</div>--}}
{{--</body>--}}
@endsection
