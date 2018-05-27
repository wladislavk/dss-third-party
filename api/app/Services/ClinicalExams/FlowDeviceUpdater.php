<?php

namespace DentalSleepSolutions\Services\ClinicalExams;

use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use Prettus\Validator\Exceptions\ValidatorException;

class FlowDeviceUpdater
{
    const FIELDS = ['ex_page5id'];

    /**
     * @var AppointmentSummaryRepository
     */
    private $appointmentSummaryRepository;

    /**
     * @var TmjClinicalExamRepository
     */
    private $tmjClinicalExamRepository;

    public function __construct(
        AppointmentSummaryRepository $appointmentSummaryRepository,
        TmjClinicalExamRepository $tmjClinicalExamRepository
    ) {
        $this->appointmentSummaryRepository = $appointmentSummaryRepository;
        $this->tmjClinicalExamRepository = $tmjClinicalExamRepository;
    }

    /**
     * @param User $user
     * @param int $patientId
     * @param int $deviceId
     * @throws ValidatorException
     * @return void
     */
    public function update(User $user, $patientId, $deviceId)
    {
        $dataForStoring = ['device_id' => $deviceId];
        $updateCondition = ['patientid' => $patientId];
        $this->appointmentSummaryRepository->updateWhere($dataForStoring, $updateCondition);
        $lastAppointmentDevice = $this->appointmentSummaryRepository->getLastAppointmentDevice($patientId);
        if (!isset($lastAppointmentDevice['id'])) {
            return;
        }
        $getCondition = ['patientid' => $patientId];
        $tmjClinicalExamItems = $this->tmjClinicalExamRepository->getWithFilter(self::FIELDS, $getCondition);
        if (count($tmjClinicalExamItems) === 0) {
            $createParams = [
                'dentaldevice' => $deviceId,
                'patientid' => $patientId,
                'userid' => $user->userid,
                'docid' => $user->docid,
                'ip_address' => $user->ip_address,
            ];
            $this->tmjClinicalExamRepository->create($createParams);
            return;
        }
        $data = ['dentaldevice' => $deviceId];
        $this->tmjClinicalExamRepository->updateWhere($data, $updateCondition);
    }
}
