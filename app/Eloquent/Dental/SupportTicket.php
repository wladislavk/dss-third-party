<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\SupportTicket as Resource;
use DentalSleepSolutions\Contracts\Repositories\SupportTickets as Repository;
use DB;

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
 *     @SWG\Property(property="category", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="attachment", type="string"),
 *     @SWG\Property(property="viewed", type="integer"),
 *     @SWG\Property(property="creator", type="integer"),
 *     @SWG\Property(property="create", type="integer"),
 *     @SWG\Property(property="company", type="integer")
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereCreateType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereViewed($value)
 * @mixin \Eloquent
 */
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
 *     @SWG\Property(property="category", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="attachment", type="string"),
 *     @SWG\Property(property="viewed", type="integer"),
 *     @SWG\Property(property="creator", type="integer"),
 *     @SWG\Property(property="create", type="integer"),
 *     @SWG\Property(property="company", type="integer")
 * )
 */
/**
 * @SWG\Definition(
 *     definition="SupportTicket",
 *     type="object",
 * 
 * )
 */
class SupportTicket extends AbstractModel implements Resource, Repository
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

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    private $ticketStatuses = [
        'DSS_TICKET_STATUS_OPEN'     => 0,
        'DSS_TICKET_STATUS_REOPENED' => 1,
        'DSS_TICKET_STATUS_CLOSED'   => 2
    ];

    public function getNumber($docId = 0)
    {
        return $this->select(DB::raw('COUNT(id) AS total'))
            ->from(DB::raw("
                    (
                        SELECT t.id
                        FROM dental_support_tickets t
                        LEFT JOIN dental_support_responses r ON r.ticket_id = t.id
                        WHERE t.docid = ?
                            AND (
                                (
                                    r.viewed = 0
                                    AND r.response_type = 0
                                )
                                OR (
                                    t.viewed = 0
                                    AND t.create_type = 0
                                )
                                OR (
                                    t.status = ?
                                    AND r.viewed = 0
                                    AND r.response_type = 0
                                    AND r.body != ''
                                )
                            )
                        GROUP BY t.id
                    ) AS derived_table
                "))
            ->addBinding($docId, 'select')
            ->addBinding($this->ticketStatuses['DSS_TICKET_STATUS_CLOSED'], 'select')
            ->first();
    }
}
