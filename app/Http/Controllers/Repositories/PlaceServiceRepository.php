<?php
namespace Ds3\Repositories;

use Ds3\Contracts\PlaceServiceInterface;
use Ds3\Eloquent\PlaceService;

class PlaceServiceRepository implements PlaceServiceInterface
{
    public function getPlaceService($order)
    {
        $placeServices = PlaceService::orderBy($order)->get();

        return $placeServices;
    }
}
