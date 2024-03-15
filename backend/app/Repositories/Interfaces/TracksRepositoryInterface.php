<?php
namespace App\Repositories\Interfaces;

use App\Models\Track;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Collection;

interface TracksRepositoryInterface
{
    public function paginate(\Illuminate\Database\Eloquent\Builder $query): CursorPaginator;
    public function getById(int $id): Track;
    public function search(string $search): \Illuminate\Database\Eloquent\Builder;
    public function userFav(): \Illuminate\Database\Eloquent\Builder;
}