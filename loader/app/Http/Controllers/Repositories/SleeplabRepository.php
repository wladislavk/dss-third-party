<?php
namespace Ds3\Repositories;

use Illuminate\Support\Facades\DB;

use Ds3\Contracts\SleeplabInterface;
use Ds3\Eloquent\Sleeplab;

class SleeplabRepository implements SleeplabInterface
{
    public function getSleeplabs($where, $order = null)
    {
        $sleeplabs = new Sleeplab();

        foreach ($where as $attribute => $value) {
            $sleeplabs = $sleeplabs->where($attribute, '=', $value);
        }

        if (!empty($order)) {
            $sleeplabs = $sleeplabs->orderBy($order);
        }

        return $sleeplabs->get();
    }

    public function updateData($sleeplabId, $values)
    {
        $sleeplab = Sleeplab::where('sleeplabid', '=', $sleeplabId)->update($values);

        return $sleeplab;
    }

    public function insertData($data)
    {
        $sleeplab = new Sleeplab();

        foreach ($data as $attribute => $value) {
            $sleeplab->$attribute = $value;
        }

        $sleeplab->save();

        return $sleeplab->sleeplabid;
    }

    public function deleteData($sleeplabid)
    {
        $slleplab = Sleeplab::where('sleeplabid', '=', $sleeplabid)->delete();

        return $slleplab;
    }

    public function getSleepLabTypeHolder($where, $letter = null, $order = null, $dir = null, $limit = null, $offset = null)
    {
        $sleeplabs = new Sleeplab();

        if (!empty($where)) {
            foreach ($where as $attribute => $value) {
                $sleeplabs = $sleeplabs->where($attribute, $value);
            }
        }

        if (!empty($letter)) {
            $sleeplabs = $sleeplabs->whereRaw("company like ? ", array($letter . '%'));
        }

        if (!empty($order)) {
            $sleeplabs = $sleeplabs->orderBy($order, $dir);
        }

        if (!empty($limit)) {
            $sleeplabs = $sleeplabs->take($limit);
        }

        if (!empty($offset)) {
            $sleeplabs = $sleeplabs->skip($offset);
        }

        return $sleeplabs->get();
    }
}
