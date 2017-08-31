<?php

namespace DentalSleepSolutions\Http\Requests;

class Filemanager extends Request
{
    protected $rules = [
        'docid'   => 'required|integer',
        'name'    => ['regex:/^[A-Za-z0-9_]+\.(gif|jpg|jpeg|bmp|png)$/'],
        'type'    => 'string',
        'size'    => 'integer',
        'ext'     => ['regex:/^(gif|jpg|jpeg|bmp|png)$/'],
    ];
}
