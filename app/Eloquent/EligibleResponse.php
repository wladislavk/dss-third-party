<?php

namespace DentalSleepSolutions\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *     definition="EligibleResponse",
 *     type="object",
 *     required={"id", "claimid", "response", "event", "adddate", "ip", "reference"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="claimid", type="string"),
 *     @SWG\Property(property="response", type="string"),
 *     @SWG\Property(property="event", type="string"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="reference", type="string")
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereClaimid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereEventType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereResponse($value)
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
        $response = new static;
        $response->response = $data['response'];
        $response->reference_id = $data['reference_id'];
        $response->event_type = $data['event_type'];
        $response->adddate = Carbon::now();
        $response->ip_address = $data['ip_address'];
        $response->save();

        return $response->id;
    }

    /**
     * Get latest record for reference_id / event_type pair.
     *
     * @param string $reference_id
     * @param string|array $event_type
     * @return static|null
     */
    public static function getWhere($reference_id, $event_type)
    {
        $query = self::where('reference_id', $reference_id)->orderBy('adddate', 'DESC');

        if (is_array($event_type)) {
            return $query->whereIn('event_type', $event_type)->first();
        }

        return $query->where('event_type', $event_type)->first();
    }

    /**
     * Accessor for response property
     *
     * @return StdObject
     */
    public function getResponseAttribute()
    {
        return json_decode($this->attributes['response']);
    }
}
