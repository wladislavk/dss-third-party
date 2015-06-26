<?php
namespace Ds3\Repositories;

use Ds3\Contracts\ChairsInterface;
use Ds3\Eloquent\Resource;

class ChairsRepository implements ChairsInterface
{
    public function getResource($where, $whereId = null, $order = null, $orderName = null, $limit = null, $offset = null)
    {
        $resource = new Resource();

        if (!empty($where)) {

            foreach ($where as $attribute => $value) {
                $resource = $resource->where($attribute, $value);
            }
        }

        if (!empty($whereId)) {

            foreach ($whereId as $attribute => $value) {
                $resource = $resource->where($attribute, $value);
            }
        }

        if (!empty($order)) {
             $resource = $resource->orderBy($order);
        }

        if (!empty($orderName)) {
             $resource = $resource->orderBy($orderName);
        }

        if (!empty($limit)) {
            $resource = $resource->take($limit);
        }

        if (!empty($offset)) {
            $resource = $resource->skip($offset);
        }

        return $resource->get();
    }

    public function updateData($where, $values)
    {
        $resource = new Resource();

        foreach ($where as $attribute => $value) {
            $resource = $resource->where($attribute, $value);
        }

        $resource = $resource->update($values);

        return $resource;
    }

    public function insertData($data)
    {
        $resource = new Resource();

        foreach ($data as $attribute => $value) {
            $resource->$attribute = $value;
        }

        $resource->save();

        return $resource;
    }

    public function deleteData($where, $whereId)
    {
        $resource = new Resource();

        $resourceDelete = $resource->where('docid', '=', $where)
                                   ->where('id', '=', $whereId)
                                   ->delete();

        return $resourceDelete;
    }
}
