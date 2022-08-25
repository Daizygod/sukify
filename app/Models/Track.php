<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Track
 * 
 * @property int $id
 * @property string $name
 * @property int $artist_id
 * @property Carbon $release_date
 * @property int $type
 * @property int $counter
 * @property int $photo_cover_id
 * @property int $file_id
 * @property int $video_id
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Track extends Model
{
	protected $table = 'tracks';

	protected $casts = [
		'artist_id' => 'int',
		'type' => 'int',
		'counter' => 'int',
		'photo_cover_id' => 'int',
		'file_id' => 'int',
		'video_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'release_date'
	];

	protected $fillable = [
		'name',
		'artist_id',
		'release_date',
		'type',
		'counter',
		'photo_cover_id',
		'file_id',
		'video_id',
		'created_by',
		'updated_by'
	];
}
