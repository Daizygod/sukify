<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Playlist
 * 
 * @property int $id
 * @property string $name
 * @property string|null $cover
 * @property int|null $created_by
 * 
 * @property User|null $user
 * @property Collection|Track[] $tracks
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Playlist extends Model
{
	protected $table = 'playlists';
	public $timestamps = false;

	protected $casts = [
		'created_by' => 'int'
	];

	protected $fillable = [
		'name',
		'cover',
		'created_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	public function tracks()
	{
		return $this->belongsToMany(Track::class, 'playlists_tracks');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'users_liked_playlists');
	}
}
