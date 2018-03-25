<?php
namespace Ds3\Repositories;

use Illuminate\Support\Facades\DB;

use Ds3\Contracts\CustomInterface;
use Ds3\Eloquent\Custom;

class CustomRepository implements CustomInterface
{
    public function deleteData($customid)
    {
        $custom = Custom::where('customid', '=', $customid)->delete();

        return $custom;
    }

    public function getCustomTypeHolder($where, $order = null, $limit = null, $offset = null)
    {
        $customs = new Custom;

        if (!empty($where)) {
            foreach ($where as $attribute => $value) {
                $customs = $customs->where($attribute, $value);
            }
        }

        if (!empty($order)) {
            $customs = $customs->orderBy($order);
        }

        if (!empty($limit)) {
            $customs = $customs->take($limit);
        }

        if (!empty($offset)) {
            $customs = $customs->skip($offset);
        }

        return $customs->get();
    }

    public function updateData($customId, $values)
    {
        $custom = Custom::where('customid', '=', $customId)->update($values);

        return $custom;
    }

    public function insertData($data)
    {
        $custom = new Custom();

        foreach ($data as $attribute => $value) {
            $custom->$attribute = $value;
        }

        $custom->save();

        return $custom->customid;
    }
}
