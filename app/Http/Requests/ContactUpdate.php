<?php

namespace DentalSleepSolutions\Http\Requests;

use Illuminate\Support\Arr;

class ContactUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'docid'                => 'sometimes|required|integer',
            'salutation'           => 'string',
            'lastname'             => 'sometimes|required|string',
            'firstname'            => 'sometimes|required|string',
            'middlename'           => 'string',
            'company'              => 'sometimes|required|string',
            'add1'                 => 'sometimes|required|string',
            'add2'                 => 'string',
            'city'                 => 'sometimes|required|string',
            'state'                => 'sometimes|required|string',
            'zip'                  => 'sometimes|required|string',
            'phone1'               => 'sometimes|required|string',
            'phone2'               => 'string',
            'fax'                  => 'string',
            'email'                => 'sometimes|required|email',
            'national_provider_id' => 'string',
            'qualifier'            => 'string',
            'qualifierid'          => 'string',
            'greeting'             => 'string',
            'sincerely'            => 'string',
            'contacttypeid'        => 'sometimes|required|integer',
            'notes'                => 'string',
            'preferredcontact'     => 'string',
            'status'               => 'integer',
            'referredby_info'      => 'integer',
            'referredby_notes'     => 'string',
            'merge_id'             => 'integer',
            'merge_date'           => 'date',
            'corporate'            => 'integer',
            'dea_number'           => 'string'
        ];
    }

    public function all()
    {
        $data = parent::all();

        $phoneFields = ['phone1', 'phone2', 'fax'];
        foreach ($phoneFields as $field) {
            if (Arr::has($data, $field)) {
                $data[$field] = preg_replace('/[^0-9]/', '', $data[$field]);
            }
        }

        return $data;
    }
}
