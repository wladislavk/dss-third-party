<?php

namespace DentalSleepSolutions\Helpers;

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
     * @param  int $patientId
     * @param  int $deviceId
     * @param  int $userId
     * @param  int $docId
     * @param  string $ipAddress
     * @return void
     */
    public function update($patientId, $deviceId, $userId, $docId, $ipAddress)
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
                'userid' => $userId,
                'docid' => $docId,
                'ip_address' => $ipAddress
            ];

            $this->tmjClinicalExamRepository->create($dataForStoring);
        }

        $data = ['dentaldevice' => $deviceId];
        $where = ['patientid' => $patientId];
        $this->tmjClinicalExamRepository->updateWhere($data, $where);
    }
}
