<?php

namespace DentalSleepSolutions\Services\AppointmentSummaries;

use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Models\User;
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
     * @param int $deviceId
     * @return TmjClinicalExam
     */
    public function createUniqueTmj(User $user, int $patientId, int $deviceId): TmjClinicalExam
    {
        /** @var TmjClinicalExam|null $existing */
        $existing = $this->repository->getOneBy('patientid', $patientId);
        if ($existing) {
            $existing->dentaldevice = $deviceId;
            return $existing;
        }
        $resource = new TmjClinicalExam();
        $resource->patientid = $patientId;
        $resource->dentaldevice = $deviceId;
        $resource->userid = $user->userid;
        $resource->docid = $user->docid;
        return $resource;
    }
}
