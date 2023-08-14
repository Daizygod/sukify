<div class="player-track-list-track">
    <div class="track-list-track-number">
        <div class="track-list-action-play">
            <span class="track-number">{{ $number }}</span>
            <button id="play_track_{{  $track->id }}" class="play_track_button">
                <svg height="24" width="24" aria-hidden="true" class="play_track_icon" viewBox="0 0 24 24" data-encore-id="icon">
                    <path d="M7.05 3.606l13.49 7.788a.7.7 0 010 1.212L7.05 20.394A.7.7 0 016 19.788V4.212a.7.7 0 011.05-.606z"></path>
                </svg>
            </button>
        </div>
    </div>
    <div class="track-list-track-primary">'
        <img class="player-track-list-cover" width="40" height="40" src="{{
    (env("APP_DEBUG") ? str_replace('http://localhost:8000', env('APP_URL'), $track->cover_file) : $track->cover_file
    }}">
{{--        TODO REMOVE THIS SHISH--}}
        <div class="track-list-info">
            <div id="track_name_{{ $track->id }}" class="track_name">{{ $track->name }}</div>
            <div class="track-list-artist">{{$track->artist->name }}</div></div>
    </div>
</div>