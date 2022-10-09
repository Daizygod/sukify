<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Track
 *
 * @property int $id
 * @property string $name
 * @property int $artist_id
 * @property Carbon $release_date
 * @property int $type
 * @property int $counter
 * @property string $cover_file
 * @property string $file
 * @property string $video_file
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
        'cover_file' => 'string',
        'file' => 'string',
        'video_file' => 'string',
		//'photo_cover_id' => 'int',
		//'file_id' => 'int',
		//'video_id' => 'int',
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
        'cover_file' => 'string',
        'file' => 'string',
        'video_file' => 'string',
		//'photo_cover_id',
		//'file_id',
		//'video_id',
		'created_by',
		'updated_by'
	];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = is_object(Auth::guard(config('app.guards.web'))->user()) ? Auth::guard(config('app.guards.web'))->user()->id : 1;
            $model->updated_by = is_object(Auth::guard(config('app.guards.web'))->user()) ? Auth::guard(config('app.guards.web'))->user()->id : 1;
        });

        static::updating(function ($model) {
            $model->updated_by = is_object(Auth::guard(config('app.guards.web'))->user()) ? Auth::guard(config('app.guards.web'))->user()->id : 1;
            #TODO check UPDATE, if it work on update form or it unnecessary cause of Laravel default
            //$model->updated_at = time();
        });
    }


    public static $types_array = [
        1 => 'single',
        2 => 'only in album',
        3 => 'single and album'
    ];
}
