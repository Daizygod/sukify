<?php
namespace App\Services;
use App\Models\Track;
use App\Services\Interfaces\TracksServiceInterface;
use Carbon\Carbon;

class TracksService implements TracksServiceInterface
{
    protected int|null $user_id;
    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }
    public function toResponse(array $items): \Illuminate\Support\Collection
    {
        $user_id = $this->user_id;
        return collect($items)
            ->map(function ($track) use ($user_id) {
                $track->file2 = env('APP_URL') . "/storage/" . $track->file;
                $track->file = env('APP_URL') . "/api/getaudio/" . str_replace('.', '/', $track->file);
                $track->cover_file = env('APP_URL') . "/storage/" . $track->cover_file;
                $track->cover512px = $track->cover512px;
                $track->cover384px = $track->cover384px;
                $track->cover256px = $track->cover256px;
                $track->cover192px = $track->cover192px;
                $track->cover128px = $track->cover128px;
                $track->cover96px = $track->cover96px;
//            foreach (Track::coverResizeSquareSizes as $size) {
//                $track->covers[$size] = $track->generateCoverPathForSize($size);
//            }
                //FIXME
                $track->duration = $track->duration ?? random_int(30, 300);
                $track->album = ["id" => 12, "name" => $track->name];
                setlocale(LC_TIME, 'ro_RO.UTF-8');
                $track->added_at = Carbon::now('UTC')->subMinutes(random_int(1, 87600));
//                $track->added_at = Carbon::createFromTimestamp(1687705261, 'UTC');


                if (Carbon::now('UTC')->diffInMonths($track->added_at) > 1) {
                    $track->added_at = $track->added_at->locale(app()->getLocale())->translatedFormat('d M. o');
                } else {
                    $track->added_at = $track->added_at->locale(app()->getLocale())->diffForHumans();
                }
//            $track->added_at = Carbon::createFromTimestamp(Carbon::now('UTC')->subSeconds(rand(10, 172800))->timestamp, 'UTC')->locale('ru')->diffForHumans();
                $track->liked = $track->hasLikeFromUser($user_id);
                return $track;
            });
    }
}