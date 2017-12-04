<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;

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
     * @param  User $user
     * @param  int $patientId
     * @param  int $deviceId
     * @return void
     */
    public function update($user, $patientId, $deviceId)
    {
        $dataForStoring = ['device_id' => $deviceId];
        $this->appointmentSummaryRepository->updateById($patientId, $dataForStoring);

        $lastAppointmentDevice = $this->appointmentSummaryRepository->getLastAppointmentDevice($patientId);

        if (empty($lastAppointmentDevice) || $lastAppointmentDevice->id !== $patientId) {
            return;
        }

        $fields = ['ex_page5id'];
        $where = ['patientid' => $patientId];
        $tmjClinicalExamItems = $this->tmjClinicalExamRepository->getWithFilter($fields, $where);

        if (count($tmjClinicalExamItems) === 0) {
            $dataForStoring = [
                'dentaldevice' => $deviceId,
                'patientid' => $patientId,
                'userid' => $user->userid,
                'docid' => $user->docid,
                'ip_address' => $user->ip_address
            ];

            $this->tmjClinicalExamRepository->create($dataForStoring);

            return;
        }

        $data = ['dentaldevice' => $deviceId];
        $where = ['patientid' => $patientId];
        $this->tmjClinicalExamRepository->updateWhere($data, $where);
    }
}
