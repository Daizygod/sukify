<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Album
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $release_date
 * @property string|null $cover
 * 
 * @property Collection|Track[] $tracks
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Album extends Model
{
	protected $table = 'albums';
	public $timestamps = false;

	protected $casts = [
		'release_date' => 'datetime'
	];

	protected $fillable = [
		'name',
		'release_date',
		'cover'
	];

	public function tracks()
	{
		return $this->belongsToMany(Track::class, 'albums_tracks');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'users_liked_albums');
	}
}
