<?php

namespace DentalSleepSolutions\Eloquent\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *     definition="EligibleResponse",
 *     type="object",
 *     required={"id", "claimid", "response", "event_type", "adddate", "ip_address", "reference_id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="claimid", type="string"),
 *     @SWG\Property(property="response", type="string"),
 *     @SWG\Property(property="event_type", type="string"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="reference_id", type="string")
 * )
 *
 * @todo: for some reason $response property is detected as having type "stdClass"
 *
 * Class EligibleResponse
 *
 * @property int $id
 * @property string $claimid
 * @property string $response
 * @property string $event_type
 * @property string $adddate
 * @property string $ip_address
 * @property string $reference_id
 * @mixin \Eloquent
 */
class EligibleResponse extends Model
{
    protected $table = 'dental_eligible_response';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * Add new record
     *
     * @param array $data
     * @return int
     */
    public static function add($data)
    {
        $response = new EligibleResponse();
        $response->response = $data['response'];
        $response->reference_id = $data['reference_id'];
        $response->event_type = $data['event_type'];
        $response->adddate = Carbon::now();
        $response->ip_address = $data['ip_address'];
        $response->save();

        return $response->id;
    }

    /**
     * Accessor for response property
     *
     * @return \stdClass
     */
    public function getResponseAttribute()
    {
        return json_decode($this->attributes['response']);
    }
}
