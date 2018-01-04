<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use Prettus\Validator\Exceptions\ValidatorException;

class FlowDeviceUpdater
{
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
        $fields = ['ex_page5id'];
        $getCondition = ['patientid' => $patientId];
        $tmjClinicalExamItems = $this->tmjClinicalExamRepository->getWithFilter($fields, $getCondition);
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
