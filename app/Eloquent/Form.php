<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'dental_forms';
    protected $fillable = ['docid', 'patientid', 'formtype', 'ip_address'];
    protected $primaryKey = 'formid';

    public static function insertData($data)
    {
        $form = new Form();

        foreach ($data as $attribute => $value) {
            $form->$attribute = $value;
        }

        $form->save();

        return $form->formid;
    }
}
