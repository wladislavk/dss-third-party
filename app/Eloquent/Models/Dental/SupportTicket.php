<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="SupportTicket",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="title", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="body", type="string"),
 *     @SWG\Property(property="category_id", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="attachment", type="string"),
 *     @SWG\Property(property="viewed", type="integer"),
 *     @SWG\Property(property="creator_id", type="integer"),
 *     @SWG\Property(property="create_type", type="integer"),
 *     @SWG\Property(property="company_id", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\SupportTicket
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $userid
 * @property int|null $docid
 * @property string|null $body
 * @property int|null $category_id
 * @property \Carbon\Carbon|null $adddate
 * @property int|null $status
 * @property string|null $ip_address
 * @property string|null $attachment
 * @property int|null $viewed
 * @property int|null $creator_id
 * @property int|null $create_type
 * @property int|null $company_id
 * @mixin \Eloquent
 */
class SupportTicket extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_support_tickets';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const CREATED_AT = 'adddate';

    const DSS_TICKET_STATUS_OPEN = 0;
    const DSS_TICKET_STATUS_REOPENED = 1;
    const DSS_TICKET_STATUS_CLOSED = 2;
}
