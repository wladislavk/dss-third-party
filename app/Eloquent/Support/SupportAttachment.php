<?php namespace Ds3\Eloquent\Support;

use Illuminate\Database\Eloquent\Model;

class SupportAttachment extends Model
{
    protected $table = 'dental_support_attachment';
    protected $fillable = ['ticket_id', 'response_id', 'filename'];
    protected $primaryKey = 'id';

    public static function insertData($data)
    {
        $supportAttachment = new SupportAttachment();

        foreach ($data as $attribute => $value) {
            $supportAttachment->$attribute = $value;
        }

        try {
            $supportAttachment->save();
        } catch (QueryException $e) {
            return null;
        }

        return $supportAttachment->id;
    }
}
