<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Filemanager extends Model
{
    protected $table = 'filemanager';
    protected $fillable = ['docid', 'name', 'type', 'size', 'ext'];
    protected $primaryKey = 'id';

    public static function insertData($data)
    {
        $filemanager = new Filemanager();

        foreach ($data as $attribute => $value) {
            $filemanager->$attribute = $value;
        }

        $filemanager->save();

        return $filemanager->id;
    }
}
