<?php

namespace DentalSleepSolutions\Http\Requests;

class ClaimNote extends Request
{
    protected $rules = [
        'claim_id'    => 'required|integer',
        'create_type' => 'required|integer',
        'creator_id'  => 'required|integer',
        'note'        => 'required|string',
    ];
}
