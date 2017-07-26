<?php

namespace DentalSleepSolutions\Structs;

use Illuminate\Contracts\Support\Arrayable;

class EditPatientResponseData implements Arrayable
{
    const PATIENT_ADDED_STATUS = 'Patient "%s" was added successfully.';
    const PATIENT_EDITED_STATUS = 'Edited Successfully';

    /** @var EditPatientMail */
    public $mails;

    /** @var string */
    public $status;

    /** @var string */
    public $redirectTo;

    /** @var bool */
    public $sendPinCode;

    /** @var int */
    public $currentPatientId = 0;

    public function toArray()
    {
        return [
            'created_patient_id' => $this->currentPatientId,
            'redirect_to' => $this->redirectTo,
            'status' => $this->status,
            'send_pin_code' => $this->sendPinCode,
            'mails' => [$this->mails->mailType => $this->mails->message],
        ];
    }
}
