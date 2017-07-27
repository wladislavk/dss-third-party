<?php
namespace DentalSleepSolutions\Http\Requests\Patient;

use DentalSleepSolutions\Http\Requests\AbstractNonRestRequest;

class ExternalPatientStore extends AbstractNonRestRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'api_key_company' => 'required|string',
            'api_key_user'    => 'sometimes|string',

            'patient.last_name'       => 'sometimes|string',
            'patient.middle_name'     => 'sometimes|string',
            'patient.first_name'      => 'sometimes|string',
            'patient.preferred_name'  => 'sometimes|string',
            'patient.dob'             => 'sometimes|string',
            'patient.ssn'             => 'sometimes|numeric',
            'patient.gender'          => 'sometimes|string|in:m,f,M,F',
            'patient.marital_status'  => 'sometimes|between:1,4',

            'patient.height_feet'     => 'sometimes|integer',
            'patient.height_inches'   => 'sometimes|integer',
            'patient.weight'          => 'sometimes|integer',

            'patient.address1'        => 'sometimes|string',
            'patient.address2'        => 'sometimes|string',
            'patient.city'            => 'sometimes|string',
            'patient.state'           => 'sometimes|alpha|size:2',
            'patient.zip'             => ['sometimes', 'numeric', 'regex:/^(|\d{5}|\d{9})$/'],
            'patient.home_phone'      => ['sometimes', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],
            'patient.work_phone'      => ['sometimes', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],
            'patient.cell_phone'      => ['sometimes', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],
            'patient.email'           => 'sometimes|email',

            'patient.origin_record.origin_software'   => 'required|string',
            'patient.origin_record.origin_patient_Id' => 'required|string',

            'patient.insurance_primary.payer_info.name'     => 'present_with:patient.insurance_primary.payer_info|string',
            'patient.insurance_primary.payer_info.address1' => 'sometimes|string',
            'patient.insurance_primary.payer_info.address2' => 'sometimes|string',
            'patient.insurance_primary.payer_info.city'     => 'sometimes|string',
            'patient.insurance_primary.payer_info.state'    => 'sometimes|string',
            'patient.insurance_primary.payer_info.zip'      => ['sometimes', 'numeric', 'regex:/^(|\d{5}|\d{9})$/'],
            'patient.insurance_primary.payer_info.phone'    => ['sometimes', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],
            'patient.insurance_primary.payer_info.fax'      => ['sometimes', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],

            'patient.insurance_primary.insured_info.relationship_to_insured' => [
                'present_with:patient.insurance_primary.insured_info',
                'string',
                'regex:/^(|self|spouse|child|other)$/i'
            ],

            'patient.insurance_primary.insured_info.subscriber.id'          => 'present_with:patient.insurance_primary.insured_info.subscriber|string',
            'patient.insurance_primary.insured_info.subscriber.first_name'  => 'present_with:patient.insurance_primary.insured_info.subscriber|string',
            'patient.insurance_primary.insured_info.subscriber.last_name'   => 'present_with:patient.insurance_primary.insured_info.subscriber|string',
            'patient.insurance_primary.insured_info.subscriber.middle_name' => 'sometimes|string',
            'patient.insurance_primary.insured_info.subscriber.address1'    => 'sometimes|string',
            'patient.insurance_primary.insured_info.subscriber.address2'    => 'sometimes|string',
            'patient.insurance_primary.insured_info.subscriber.city'        => 'sometimes|string',
            'patient.insurance_primary.insured_info.subscriber.state'       => 'sometimes|alpha|size:2',
            'patient.insurance_primary.insured_info.subscriber.zip'         => ['sometimes', 'numeric', 'regex:/^(|\d{5}|\d{9})$/'],
            'patient.insurance_primary.insured_info.subscriber.phone'       => ['sometimes', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],
            'patient.insurance_primary.insured_info.subscriber.dob'         => 'present_with:patient.insurance_primary.insured_info.subscriber|date_format:Y-m-d',
            'patient.insurance_primary.insured_info.subscriber.gender'      => 'sometimes|alpha|in:m,f,M,F',
            'patient.insurance_primary.insured_info.subscriber.group_id'    => 'sometimes|string',
            'patient.insurance_primary.insured_info.subscriber.group_name'  => 'sometimes|string',

            'patient.insurance_primary.insured_info.dependent.id'          => 'sometimes|string',
            'patient.insurance_primary.insured_info.dependent.first_name'  => 'present_with:patient.insurance_primary.insured_info.dependent|string',
            'patient.insurance_primary.insured_info.dependent.last_name'   => 'present_with:patient.insurance_primary.insured_info.dependent|string',
            'patient.insurance_primary.insured_info.dependent.middle_name' => 'sometimes|string',
            'patient.insurance_primary.insured_info.dependent.address1'    => 'sometimes|string',
            'patient.insurance_primary.insured_info.dependent.address2'    => 'sometimes|string',
            'patient.insurance_primary.insured_info.dependent.city'        => 'sometimes|string',
            'patient.insurance_primary.insured_info.dependent.state'       => 'sometimes|alpha|size:2',
            'patient.insurance_primary.insured_info.dependent.zip'         => ['sometimes', 'numeric', 'regex:/^(|\d{5}|\d{9})$/'],
            'patient.insurance_primary.insured_info.dependent.phone'       => ['sometimes', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],
            'patient.insurance_primary.insured_info.dependent.dob'         => 'present_with:patient.insurance_primary.insured_info.dependent|date_format:Y-m-d',
            'patient.insurance_primary.insured_info.dependent.gender'      => 'sometimes|alpha|in:m,f,M,F',
        ];
    }
}
