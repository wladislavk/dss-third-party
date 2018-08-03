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
            'patient.last_name'       => 'sometimes|nullable|string',
            'patient.middle_name'     => 'sometimes|nullable|string',
            'patient.first_name'      => 'sometimes|nullable|string',
            'patient.preferred_name'  => 'sometimes|nullable|string',
            'patient.dob'             => 'sometimes|nullable|string',
            'patient.ssn'             => 'sometimes|nullable|numeric',
            'patient.gender'          => 'sometimes|nullable|string|in:m,f,M,F',
            'patient.marital_status'  => 'sometimes|nullable|between:1,4',

            'patient.height_feet'     => 'sometimes|nullable|integer',
            'patient.height_inches'   => 'sometimes|nullable|integer',
            'patient.weight'          => 'sometimes|nullable|integer',

            'patient.address1'        => 'sometimes|nullable|string',
            'patient.address2'        => 'sometimes|nullable|string',
            'patient.city'            => 'sometimes|nullable|string',
            'patient.state'           => 'sometimes|nullable|alpha|size:2',
            'patient.zip'             => ['sometimes', 'nullable', 'numeric', 'regex:/^(|\d{5}|\d{9})$/'],
            'patient.home_phone'      => ['sometimes', 'nullable', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],
            'patient.work_phone'      => ['sometimes', 'nullable', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],
            'patient.cell_phone'      => ['sometimes', 'nullable', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],
            'patient.email'           => 'sometimes|nullable|email',

            'patient.origin_record.origin_software'   => 'required|string',
            'patient.origin_record.origin_patient_Id' => 'required|string',

            'patient.insurance_primary.payer_info.name'     => 'present_with:patient.insurance_primary.payer_info|nullable|string',
            'patient.insurance_primary.payer_info.address1' => 'sometimes|nullable|string',
            'patient.insurance_primary.payer_info.address2' => 'sometimes|nullable|string',
            'patient.insurance_primary.payer_info.city'     => 'sometimes|nullable|string',
            'patient.insurance_primary.payer_info.state'    => 'sometimes|nullable|string',
            'patient.insurance_primary.payer_info.zip'      => ['sometimes', 'nullable', 'numeric', 'regex:/^(|\d{5}|\d{9})$/'],
            'patient.insurance_primary.payer_info.phone'    => ['sometimes', 'nullable', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],
            'patient.insurance_primary.payer_info.fax'      => ['sometimes', 'nullable', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],

            'patient.insurance_primary.insured_info.relationship_to_insured' => [
                'present_with:patient.insurance_primary.insured_info',
                'nullable',
                'string',
                'regex:/^(|self|spouse|child|other)$/i'
            ],

            'patient.insurance_primary.insured_info.subscriber.id'          => 'present_with:patient.insurance_primary.insured_info.subscriber|nullable|string',
            'patient.insurance_primary.insured_info.subscriber.first_name'  => 'present_with:patient.insurance_primary.insured_info.subscriber|nullable|string',
            'patient.insurance_primary.insured_info.subscriber.last_name'   => 'present_with:patient.insurance_primary.insured_info.subscriber|nullable|string',
            'patient.insurance_primary.insured_info.subscriber.middle_name' => 'sometimes|nullable|string',
            'patient.insurance_primary.insured_info.subscriber.address1'    => 'sometimes|nullable|string',
            'patient.insurance_primary.insured_info.subscriber.address2'    => 'sometimes|nullable|string',
            'patient.insurance_primary.insured_info.subscriber.city'        => 'sometimes|nullable|string',
            'patient.insurance_primary.insured_info.subscriber.state'       => 'sometimes|nullable|alpha|size:2',
            'patient.insurance_primary.insured_info.subscriber.zip'         => ['sometimes', 'nullable', 'numeric', 'regex:/^(|\d{5}|\d{9})$/'],
            'patient.insurance_primary.insured_info.subscriber.phone'       => ['sometimes', 'nullable', 'numeric', 'regex:/^(|\d{7}|\d{10})$/'],
            'patient.insurance_primary.insured_info.subscriber.dob'         => 'present_with:patient.insurance_primary.insured_info.subscriber|nullable|date_format:Y-m-d',
            'patient.insurance_primary.insured_info.subscriber.gender'      => 'sometimes|nullable|alpha|in:m,f,M,F',
            'patient.insurance_primary.insured_info.subscriber.group_id'    => 'sometimes|nullable|string',
            'patient.insurance_primary.insured_info.subscriber.group_name'  => 'sometimes|nullable|string',
        ];
    }
}
