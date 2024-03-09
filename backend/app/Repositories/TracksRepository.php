<?php
namespace App\Repositories;
use App\Models\Track;
use App\Models\UsersLikedTrack;
use App\Repositories\Interfaces\TracksRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Collection;

class TracksRepository implements TracksRepositoryInterface
{
    protected int|null $user_id;
    const CURSOR_PAGINATE_ITEMS = 20;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    public function paginate(\Illuminate\Database\Eloquent\Builder $query): CursorPaginator
    {
        return $query->cursorPaginate(self::CURSOR_PAGINATE_ITEMS);
    }
    public function getById(int $id): Track
    {
        return Track::find($id);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function search(string $search): \Illuminate\Database\Eloquent\Builder
    {
        return Track::where('name', 'LIKE', "%{$search}%")
            ->with('artists')
//            ->with('albums')
            ->orderBy('counter', 'desc')
            ->orderBy('id', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function userFav(): \Illuminate\Database\Eloquent\Builder
    {
        $allUserFavTracksIds = UsersLikedTrack::where(['user_id' => $this->user_id])->pluck('track_id')->toArray();
        return Track::whereIn('id', $allUserFavTracksIds)
            ->with('artists')
//            ->with('albums')
            ->orderBy('counter', 'desc')
            ->orderBy('id', 'desc');
    }
}