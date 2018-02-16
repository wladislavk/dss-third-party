<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;

class UniqueTmjCreator
{
    /** @var TmjClinicalExamRepository */
    private $repository;

    public function __construct(TmjClinicalExamRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param User $user
     * @param int $patientId
     * @param string $device
     * @return TmjClinicalExam|null
     */
    public function createUniqueTmj(User $user, $patientId, $device)
    {
        /** @var TmjClinicalExam|null $existing */
        $existing = $this->repository->findByField('patientid', $patientId);
        if ($existing) {
            $resource = $existing;
            $resource->dentaldevice = $device;
            return $resource;
        }
        $resource = new TmjClinicalExam();
        $resource->patientid = $patientId;
        $resource->dentaldevice = $device;
        $resource->userid = $user->userid;
        $resource->docid = $user->docid;
        return $resource;
    }
}
