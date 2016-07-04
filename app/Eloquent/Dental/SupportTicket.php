<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\SupportTicket as Resource;
use DentalSleepSolutions\Contracts\Repositories\SupportTickets as Repository;
use DB;

class SupportTicket extends Model implements Resource, Repository
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
