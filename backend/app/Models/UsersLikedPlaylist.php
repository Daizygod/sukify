<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersLikedPlaylist
 * 
 * @property int $user_id
 * @property int $playlist_id
 * @property int $created_at
 * 
 * @property Playlist $playlist
 * @property User $user
 *
 * @package App\Models
 */
class UsersLikedPlaylist extends Model
{
	protected $table = 'users_liked_playlists';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'playlist_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'playlist_id'
	];

	public function playlist()
	{
		return $this->belongsTo(Playlist::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
