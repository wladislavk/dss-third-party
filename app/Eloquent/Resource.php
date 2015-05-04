<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'dental_resources';
    protected $fillable = ['name', 'rank', 'docid'];
    protected $primaryKey = 'id';

    public static function get($where, $orders = null)
    {
        $resource = new Resource();

        foreach ($where as $attribute => $value) {
            $resource = $resource->where($attribute, '=', $value);
        }

        if (!empty($orders)) {
            foreach ($orders as $order) {
                $resource = $resource->orderBy($order);
            }
        }

        return $resource->get();
    }

    public static function getSelCheck($docId, $name, $ed)
    {
        $selCheck = Resource::where('docid', '=', $docId)
            ->where('name', '=', $name)
            ->where('id', '!=', $ed)
            ->get();

        return $selCheck;
    }

    public static function updateData($ed, $values)
    {
        $resource = Resource::where('id', '=', $ed)->update($values);

        return $resource;
    }

    public static function insertData($data)
    {
        $resource = new Resource();

        foreach ($data as $attribute => $value) {
            $resource->$attribute = $value;
        }

        $resource->save();

        return $resource->id;
    }
}
