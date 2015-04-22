<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class PlaceService extends Model
{
    protected $table = 'dental_place_service';
    protected $fillable = ['place_service', 'description', 'sortby', 'status'];
    protected $primaryKey = 'place_serviceid';
    //public $timestamps = false;

    public static function get($where = null)
    {
        $placeServices = new PlaceService();

        if (!empty($where)) {
            foreach ($where as $attribute => $value) {
                $placeServices = $placeServices->where($attribute, '=', $value);
            }
        }

        $placeServices = $placeServices->orderBy('sortby');

        return $placeServices->get();
    }
}
