<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic;

/**
 * Class Track
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $release_date
 * @property int $counter
 * @property string|null $cover_file
 * @property string $file
 * @property string|null $video_file
 * @property string|null $color
 * @property bool $single
 * @property int $duration
 * @property int|null $album_id
 * 
 * @property Album|null $album
 * @property Collection|Playlist[] $playlists
 * @property Collection|Artist[] $artists
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Track extends Model
{
	protected $table = 'tracks';
	public $timestamps = false;

	protected $casts = [
		'release_date' => 'datetime:Y-m-d',
		'counter' => 'int',
		'single' => 'bool',
		'duration' => 'int',
		'album_id' => 'int'
	];

	protected $fillable = [
		'name',
		'release_date',
		'counter',
		'cover_file',
		'file',
		'video_file',
		'color',
		'single',
		'duration',
		'album_id'
	];

	public function album()
	{
		return $this->belongsTo(Album::class);
	}

	public function playlists()
	{
		return $this->belongsToMany(Playlist::class, 'playlists_tracks');
	}

	public function artists()
	{
		return $this->belongsToMany(Artist::class, 'tracks_artists');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'users_liked_tracks');
	}

    public function hasLikeFromUser($user_id)
    {
        return $this->users()->where(['user_id' => $user_id])->count() > 0;
    }

    const coverResizeSquareSizes = [
        512, 384, 256, 192, 128, 96
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {

        });

        static::updated(function ($model) {

        });

        static::creating(function ($model) {
            if (!is_null($model->cover_file)) {
                $model->saveCoverInDifferentSizes($model->cover_file);
            }
        });

        static::updating(function ($model) {
            if ($model->getOriginal("cover_file") != $model->cover_file
                && !is_null($model->getOriginal("cover_file"))) {
                $model->deleteCoverInDifferentSizes($model->getOriginal("cover_file"));
            }
            if ($model->getOriginal("cover_file") != $model->cover_file
                && !is_null($model->cover_file)) {
                $model->saveCoverInDifferentSizes($model->cover_file);
            }
        });

        static::deleting(function ($model) {
            if (!is_null($model->cover_file)) {
                $model->deleteCoverInDifferentSizes($model->cover_file);
            }
        });
    }

//    public function getCoversAttribute() {
//
//        $covers = new \stdClass();
//
//        foreach (Track::coverResizeSquareSizes as $size) {
//            $method = "getCover" . $size . "pxAttribute";
//            $covers->$size = $this->$method;
//        }
//
//        return $covers;
//    }

    public function getCover512pxAttribute() {
        return $this->generateCoverPathForSize(512);
    }

    public function getCover384pxAttribute() {
        return $this->generateCoverPathForSize(384);
    }

    public function getCover256pxAttribute() {
        return $this->generateCoverPathForSize(256);
    }

    public function getCover192pxAttribute() {
        return $this->generateCoverPathForSize(192);
    }

    public function getCover128pxAttribute() {
        return $this->generateCoverPathForSize(128);
    }

    public function getCover96pxAttribute() {
        return $this->generateCoverPathForSize(96);
    }

    public function saveCoverInDifferentSizes(string $cover_file) {
        Log::info("cover_path : $cover_file");
        $originalCoverPath = public_path("storage/$cover_file");
        Log::info("public_path : $originalCoverPath");

        $pathInfo = pathinfo($originalCoverPath);

        $fileName = $pathInfo['filename'];
        $fileExtension = $pathInfo['extension'];
        Log::info("file_name : $fileName ; ext : $fileExtension");

        $image = ImageManagerStatic::make($originalCoverPath);
        foreach (Track::coverResizeSquareSizes as $size) {
            $newPath = $fileName . "_" . $size . "px" . "." . $fileExtension;
            $image->resize($size, $size);

            $image->save(public_path("storage/" . "images" . Carbon::now()->format('Ym') . '/' . $newPath));
        }
    }

    public function deleteCoverInDifferentSizes(string $cover_file)
    {
        $originalCoverPath = public_path("storage/" . $cover_file);

        $pathInfo = pathinfo($originalCoverPath);

        $fileName = $pathInfo['filename'];
        $fileExtension = $pathInfo['extension'];

        $pathWithoutExt = mb_substr($originalCoverPath, 0, strlen($originalCoverPath) - (strlen($fileExtension) + 1));

        foreach (Track::coverResizeSquareSizes as $size) {
            $path = $pathWithoutExt . "_" . $size . "px" . "." . $fileExtension;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }

    public function generateCoverPathForSize($size) {
        $originalCoverPath = public_path("storage/" . $this->cover_file);
        $pathInfo = pathinfo($originalCoverPath);
        return mb_substr($this->cover_file, 0, strlen($this->cover_file) - (strlen($pathInfo['extension']) + 1)) . "_" . $size . "px" . "." . $pathInfo['extension'];
    }
}
