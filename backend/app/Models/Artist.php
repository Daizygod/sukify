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
 * Class Artist
 * 
 * @property int $id
 * @property string $name
 * @property string|null $avatar
 * @property string|null $background
 * 
 * @property Collection|Track[] $tracks
 *
 * @package App\Models
 */
class Artist extends Model
{
	protected $table = 'artists';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'avatar',
		'background'
	];

	public function tracks()
	{
		return $this->belongsToMany(Track::class, 'tracks_artists');
	}

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
//            $model->updated_by = is_object(Auth::guard(config('app.guards.web'))->user()) ? Auth::guard(config('app.guards.web'))->user()->id : 1;
//            $model->updated_by = 1;
        });

        static::updating(function ($model) {
//            $model->updated_by = is_object(Auth::guard(config('app.guards.web'))->user()) ? Auth::guard(config('app.guards.web'))->user()->id : 1;
//            $model->updated_by = 1;
        });
    }
}
