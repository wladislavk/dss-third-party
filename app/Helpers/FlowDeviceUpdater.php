<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Structs\TmjClinicalExamStoringData;
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
     * @param  User $user
     * @param  int $patientId
     * @param  int $deviceId
     * @throws ValidatorException
     * @return void
     */
    public function update($user, $patientId, $deviceId)
    {
        $dataForStoring = ['device_id' => $deviceId];
        $this->appointmentSummaryRepository->update($dataForStoring, $patientId);

        $lastAppointmentDevice = $this->appointmentSummaryRepository->getLastAppointmentDevice($patientId);

        if (empty($lastAppointmentDevice) || $lastAppointmentDevice->id !== $patientId) {
            return;
        }

        $fields = ['ex_page5id'];
        $where = ['patientid' => $patientId];
        $tmjClinicalExamItems = $this->tmjClinicalExamRepository->getWithFilter($fields, $where);

        if (count($tmjClinicalExamItems) === 0) {
            $tmjClinicalExamStoringData = new TmjClinicalExamStoringData();
            $tmjClinicalExamStoringData->dentalDevice = $deviceId;
            $tmjClinicalExamStoringData->patientId = $patientId;
            $tmjClinicalExamStoringData->userId = $user->userid;
            $tmjClinicalExamStoringData->docId = $user->docid;
            $tmjClinicalExamStoringData->ipAddress = $user->ip_address;

            $this->tmjClinicalExamRepository->create(
                $tmjClinicalExamStoringData->toArray()
            );

            return;
        }

        $data = ['dentaldevice' => $deviceId];
        $where = ['patientid' => $patientId];
        $this->tmjClinicalExamRepository->updateWhere($data, $where);
    }
}
