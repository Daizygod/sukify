<?php
namespace App\Services\Interfaces;

use App\Models\Track;
interface TracksServiceInterface
{
    public function toResponse(array $items): \Illuminate\Support\Collection;
}