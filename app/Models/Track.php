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
 * @property int $artist_id
 * @property string|null $ui_background_color
 * 
 * @property Artist $artist
 *
 * @package App\Models
 */
class Track extends Model
{
	protected $table = 'tracks';

	protected $casts = [
		'type' => 'int',
		'counter' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'artist_id' => 'int'
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
		'artist_id',
        'ui_background_color'
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
        });

        static::updating(function ($model) {
            $model->updated_by = is_object(Auth::guard(config('app.guards.web'))->user()) ? Auth::guard(config('app.guards.web'))->user()->id : 1;
            #TODO check UPDATE, if it work on update form or it unnecessary cause of Laravel default
            //$model->updated_at = time();
        });
    }

	public function artist()
	{
		return $this->belongsTo(Artist::class);
	}
}
