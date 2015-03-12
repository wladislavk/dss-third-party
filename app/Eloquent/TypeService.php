<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class TypeService extends Model
{
    protected $table = 'dental_type_service';
    protected $fillable = ['type_service', 'description', 'sortby', 'status'];
    protected $primaryKey = 'type_serviceid';

    public static function get()
    {
        $typeService = TypeService::where('status', '=', 1)
            ->orderBy('sortby')
            ->get();

        return $typeService;
    }
}
