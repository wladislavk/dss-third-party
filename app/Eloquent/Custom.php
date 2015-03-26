<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    protected $table = 'dental_custom';
    protected $fillable = ['title', 'description', 'docid', 'status'];
    protected $primaryKey = 'customid';

    public static function get($customId)
    {
        $custom = Custom::where('customid', '=', $customId)->first();

        return $custom;
    }

    public static function getTotalRecords($docId)
    {
        $totalRecords = Custom::where('docid', '=', $docId)
            ->orderBy('title')
            ->get();

        return $totalRecords;
    }

    public static function updateData($customId, $values)
    {
        $custom = Custom::where('customid', '=', $customId)->update($values);

        return $custom;
    }

    public static function insertData($data)
    {
        $custom = new Custom();

        foreach ($data as $attribute => $value) {
            $custom->$attribute = $value;
        }

        $custom->save();

        return $custom->customid;
    }
}
