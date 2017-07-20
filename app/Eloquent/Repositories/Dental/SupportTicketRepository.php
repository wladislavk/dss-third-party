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
}
