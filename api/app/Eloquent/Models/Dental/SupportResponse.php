<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="SupportResponse",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="ticket_id", type="integer"),
 *     @SWG\Property(property="responder_id", type="integer"),
 *     @SWG\Property(property="body", type="string"),
 *     @SWG\Property(property="response_type", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="viewed", type="integer"),
 *     @SWG\Property(property="attachment", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse
 *
 * @property int $id
 * @property int|null $ticket_id
 * @property int|null $responder_id
 * @property string|null $body
 * @property int|null $response_type
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $viewed
 * @property string|null $attachment
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse whereResponderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse whereResponseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse whereViewed($value)
 */
class SupportResponse extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'ticket_id',
        'responder_id',
        'body',
        'response_type',
        'adddate',
        'ip_address',
        'viewed',
        'attachment',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_support_responses';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const CREATED_AT = 'adddate';
}
