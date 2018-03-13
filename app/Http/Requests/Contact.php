<?php

namespace DentalSleepSolutions\Http\Requests;

use Illuminate\Support\Arr;

class Contact extends Request
{
    protected $rules = [
        'docid'                => 'integer',
        'salutation'           => 'string',
        'lastname'             => 'required|string',
        'firstname'            => 'required|string',
        'middlename'           => 'string',
        'company'              => 'required|string',
        'add1'                 => 'required|string',
        'add2'                 => 'string',
        'city'                 => 'required|string',
        'state'                => 'required|string',
        'zip'                  => 'required|string',
        'phone1'               => 'required|string',
        'phone2'               => 'string',
        'fax'                  => 'string',
        'email'                => 'required|email',
        'national_provider_id' => 'string',
        'qualifier'            => 'string',
        'qualifierid'          => 'string',
        'greeting'             => 'string',
        'sincerely'            => 'string',
        'contacttypeid'        => 'required|integer',
        'notes'                => 'string',
        'preferredcontact'     => 'string',
        'status'               => 'integer',
        'referredby_info'      => 'integer',
        'referredby_notes'     => 'string',
        'merge_id'             => 'integer',
        'merge_date'           => 'date',
        'corporate'            => 'integer',
        'dea_number'           => 'string',
    ];

    /**
     * @todo: this logic should be moved to services
     *
     * @param array|mixed $keys
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);

        $phoneFields = ['phone1', 'phone2', 'fax'];
        foreach ($phoneFields as $field) {
            if (Arr::has($data, $field)) {
                $data[$field] = preg_replace('/[^0-9]/', '', $data[$field]);
            }
        }

        return $data;
    }
}
