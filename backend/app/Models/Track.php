<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Track
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $release_date
 * @property int $type
 * @property int $counter
 * @property string $cover_file
 * @property string $file
 * @property string $video_file
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 * @property int $artist_id
 * 
 * @property Artist $artist
 * @property Collection|Artist[] $artists
 *
 * @package App\Models
 */
class Track extends Model
{
	protected $table = 'tracks';
    public $timestamps = false;

	protected $casts = [
		'release_date' => 'datetime',
		'type' => 'int',
		'counter' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'artist_id' => 'int',
		'created_at' => 'int',
		'updated_at' => 'int'
	];

	protected $dates = [
		'release_date'
	];

	protected $fillable = [
		'name',
		'release_date',
		'type',
		'counter',
		'cover_file',
		'file',
		'video_file',
		'created_by',
		'updated_by',
		'artist_id'
	];

    public static $types_array = [
        1 => 'single',
        2 => 'only in album',
        3 => 'single and album'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = is_object(Auth::guard(config('app.guards.web'))->user()) ? Auth::guard(config('app.guards.web'))->user()->id : 1;
            $model->updated_by = is_object(Auth::guard(config('app.guards.web'))->user()) ? Auth::guard(config('app.guards.web'))->user()->id : 1;
            $model->created_at = Carbon::now('UTC')->timestamp;
            $model->updated_at = Carbon::now('UTC')->timestamp;
            $model->type = 1;
            $model->counter = 0;
            $model->video_file = "";
            $model->artist_id = 1;
        });

        static::updating(function ($model) {
            $model->updated_by = is_object(Auth::guard(config('app.guards.web'))->user()) ? Auth::guard(config('app.guards.web'))->user()->id : 1;
            #TODO check UPDATE, if it work on update form or it unnecessary cause of Laravel default
            $model->updated_at = Carbon::now('UTC')->timestamp;
        });
    }

	public function artist()
	{
		return $this->belongsTo(Artist::class);
	}

	public function artists()
	{
		return $this->belongsToMany(Artist::class, 'tracks_artists');
	}
}
