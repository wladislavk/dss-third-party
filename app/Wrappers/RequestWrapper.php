<?php

namespace DentalSleepSolutions\Wrappers;

class RequestWrapper
{
    /**
     * @return array|\Illuminate\Http\Request|string
     */
    public function getRequest()
    {
        return request();
    }
}
