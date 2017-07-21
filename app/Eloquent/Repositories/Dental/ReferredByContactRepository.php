<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ReferredByContact;
use Prettus\Repository\Eloquent\BaseRepository;

class ReferredByContactRepository extends BaseRepository
{
    public function model()
    {
        return ReferredByContact::class;
    }

    /**
     * @param int $contactId
     * @param array $data
     * @return bool|int
     */
    public function updateContact($contactId, array $data)
    {
        return $this->model->where('referredbyid', $contactId)->update($data);
    }
}
