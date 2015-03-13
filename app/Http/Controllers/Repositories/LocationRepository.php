<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\LocationInterface;
use Ds3\Eloquent\Location;

class LocationRepository implements LocationInterface
{
    public function findLocation($id)
    {
        return Location::find($id);
    }

    public function get($where)
    {
        $locations = new Location();

        foreach ($where as $attribute => $value) {
            $locations = $locations->where($attribute, '=', $value);
        }

        return $locations->get();
    }

    public function updateData($id, $values)
    {
        $location = Location::where('id', '=', $id)->update($values);

        return $location;
    }

    public function insertData($data)
    {
        $location = new Location();

        foreach ($data as $attribute => $value) {
            $location->$attribute = $value;
        }

        try {
            $location->save();
        } catch (QueryException $e) {
            return null;
        }

        return $location->id;
    }
}
