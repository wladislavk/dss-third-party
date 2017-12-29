<?php

namespace DentalSleepSolutions\Structs;

use Illuminate\Contracts\Support\Arrayable;

class TmjClinicalExamStoringData implements Arrayable
{
    /**
     * @var int
     */
    public $dentalDevice;

    /**
     * @var int
     */
    public $patientId;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var int
     */
    public $docId;

    /**
     * @var string
     */
    public $ipAddress;

    public function toArray()
    {
        return [
            'dentaldevice' => $this->dentalDevice,
            'patientid' => $this->patientId,
            'userid' => $this->userId,
            'docid' => $this->docId,
            'ip_address' => $this->ipAddress
        ];
    }
}
