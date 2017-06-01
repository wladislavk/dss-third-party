<?php

namespace DentalSleepSolutions\Structs;

class PressedButtons
{
    // TODO: what is hst?
    /** @var bool */
    public $sendHst;

    /** @var bool */
    public $sendPinCode;

    public function __construct(array $data)
    {
        if (isset($data['send_hst'])) {
            $this->sendHst = $data['send_hst'];
        }
        if (isset($data['send_pin_code'])) {
            $this->sendPinCode = $data['send_pin_code'];
        }
    }
}
