<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersLikedTrack
 * 
 * @property int $user_id
 * @property int $track_id
 * @property int $created_at
 * 
 * @property Track $track
 * @property User $user
 *
 * @package App\Models
 */
class UsersLikedTrack extends Model
{
	protected $table = 'users_liked_tracks';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'track_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'track_id'
	];

	public function track()
	{
		return $this->belongsTo(Track::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
