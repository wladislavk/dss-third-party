<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SupportTicket;
use Prettus\Repository\Eloquent\BaseRepository;

class SupportTicketRepository extends BaseRepository
{
    public function model()
    {
        return SupportTicket::class;
    }

    /**
     * @param int $docId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getNumber($docId)
    {
        return $this->model->select(\DB::raw('COUNT(id) AS total'))
            ->from(\DB::raw("
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
            ->addBinding(SupportTicket::DSS_TICKET_STATUS_CLOSED, 'select')
            ->first();
    }
}
