<?php

namespace DentalSleepSolutions\Structs;

class RequestedEmails
{
    /** @var bool */
    public $registration;

    /** @var bool */
    public $reminder;

    public function __construct(array $data)
    {
        if (isset($data['registration'])) {
            $this->registration = $data['registration'];
        }
        if (isset($data['reminder'])) {
            $this->reminder = $data['reminder'];
        }
    }
}
