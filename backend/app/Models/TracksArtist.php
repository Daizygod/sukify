<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TracksArtist
 * 
 * @property int $track_id
 * @property int $artist_id
 * 
 * @property Artist $artist
 * @property Track $track
 *
 * @package App\Models
 */
class TracksArtist extends Model
{
	protected $table = 'tracks_artists';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'track_id' => 'int',
		'artist_id' => 'int'
	];

	public function artist()
	{
		return $this->belongsTo(Artist::class);
	}

	public function track()
	{
		return $this->belongsTo(Track::class);
	}
}
