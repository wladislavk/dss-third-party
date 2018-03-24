<?php
namespace Ds3\Eloquent\Letter;

use Illuminate\Database\Eloquent\Model;

class LetterTemplatesCustom extends Model
{
    protected $table = 'dental_letter_templates_custom';
    protected $fillable = ['name', 'body', 'docid'];
    protected $primaryKey = 'id';

    public static function get($ed)
    {
        $letterTemplatesCustom = LetterTemplatesCustom::where('id', '=', $ed)->first();

        return $letterTemplatesCustom;
    }

    public static function updateData($docId, $id, $values)
    {
        $letterTemplatesCustom = LetterTemplatesCustom::where('docid', '=', $docId)
            ->where('id', '=', $id)
            ->update($values);

        return $letterTemplatesCustom;
    }

    public static function insertData($data)
    {
        $letterTemplatesCustom = new LetterTemplatesCustom();

        foreach ($data as $attribute => $value) {
            $letterTemplatesCustom->$attribute = $value;
        }

        $letterTemplatesCustom->save();

        return $letterTemplatesCustom->id;
    }
}
