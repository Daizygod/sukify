<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersLikedAlbum
 * 
 * @property int $user_id
 * @property int $album_id
 * @property int $created_at
 * 
 * @property Album $album
 * @property User $user
 *
 * @package App\Models
 */
class UsersLikedAlbum extends Model
{
	protected $table = 'users_liked_albums';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'album_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'album_id'
	];

	public function album()
	{
		return $this->belongsTo(Album::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
