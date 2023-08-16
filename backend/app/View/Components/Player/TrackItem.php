<?php

namespace App\View\Components\Player;

use Illuminate\View\Component;

class TrackItem extends Component
{
    public $number;
    public $track;

    public function __construct($number, $track)
    {
        $this->number = $number;
        $this->track = $track;
        $this->track->file = env('APP_URL') . "/storage/" .  $this->track->file;
        $this->track->cover_file = env('APP_URL') . "/storage/" .  $this->track->cover_file;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        //TODO $this->track_name  Кадиллак кадилла...
        return view('components.player.track-item');
    }
}
