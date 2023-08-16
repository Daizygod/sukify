<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Artist
 * 
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property int $photo_wall_id
 * @property int $photo_cover_id
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Track[] $tracks
 *
 * @package App\Models
 */
class Artist extends Model
{
	protected $table = 'artists';

	protected $casts = [
		'country_id' => 'int',
		'photo_wall_id' => 'int',
		'photo_cover_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'country_id',
		'photo_wall_id',
		'photo_cover_id',
		'created_by',
		'updated_by'
	];

	public function tracks()
	{
		return $this->belongsToMany(Track::class, 'tracks_artists');
	}
}
