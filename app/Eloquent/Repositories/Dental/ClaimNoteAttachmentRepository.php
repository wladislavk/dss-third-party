<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ClaimNoteAttachment;
use Prettus\Repository\Eloquent\BaseRepository;

class ClaimNoteAttachmentRepository extends BaseRepository
{
    public function model()
    {
        return ClaimNoteAttachment::class;
    }
}
