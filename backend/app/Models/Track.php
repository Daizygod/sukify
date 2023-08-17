<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Track
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $release_date
 * @property int $counter
 * @property string $cover_file
 * @property string $file
 * @property string|null $video_file
 * 
 * @property Collection|Album[] $albums
 * @property Collection|Playlist[] $playlists
 * @property Collection|Artist[] $artists
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Track extends Model
{
	protected $table = 'tracks';
	public $timestamps = false;

	protected $casts = [
		'release_date' => 'datetime:Y-m-d',
		'counter' => 'int'
	];

	protected $fillable = [
		'name',
		'release_date',
		'counter',
		'cover_file',
		'file',
		'video_file'
	];

	public function albums()
	{
		return $this->belongsToMany(Album::class, 'albums_tracks');
	}

	public function playlists()
	{
		return $this->belongsToMany(Playlist::class, 'playlists_tracks');
	}

	public function artists()
	{
		return $this->belongsToMany(Artist::class, 'tracks_artists');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'users_liked_tracks');
	}

    public function hasLikeFromUser($user_id)
    {
        return $this->users()->where(['user_id' => $user_id])->count() > 0;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            //
        });

        static::updating(function ($model) {
            //
        });
    }
}
