<?php

namespace DentalSleepSolutions\Http\Requests;

class PreviousTreatment extends Request
{
    public function destroyRules()
    {
        return [
            // @todo Provide validation rules
        ];
    }

    public function storeRules()
    {
        return [
            'formid'                 => 'integer',
            'patientid'              => 'required|integer',
            'polysomnographic'       => 'integer',
            'sleep_center_name'      => 'string',
            'sleep_study_on'         => 'date',
            'confirmed_diagnosis'    => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'rdi'                    => 'regex:/^[0-9]+$/',
            'ahi'                    => 'regex:/^[0-9]+$/',
            'cpap'                   => ['required', 'regex:/^(:?Yes|No)$/'],
            'intolerance'            => 'regex:/^~([0-9]+~)+$/',
            'other_intolerance'      => 'string',
            'other_therapy'          => 'string',
            'userid'                 => 'required|integer',
            'docid'                  => 'required|integer',
            'status'                 => 'integer',
            'other'                  => 'string',
            'affidavit'              => 'string',
            'type_study'             => 'string',
            'nights_wear_cpap'       => 'regex:/^[0-9]+$/',
            'percent_night_cpap'     => 'regex:/^[0-9]+$/',
            'custom_diagnosis'       => 'string',
            'sleep_study_by'         => 'string',
            'triedquittried'         => 'string',
            'timesovertime'          => 'string',
            'cur_cpap'               => ['regex:/^(:?Yes|No)$/'],
            'sleep_center_name_text' => 'string',
            'dd_wearing'             => ['regex:/^(:?Yes|No)$/'],
            'dd_prev'                => ['regex:/^(:?Yes|No)$/'],
            'dd_otc'                 => ['regex:/^(:?Yes|No)$/'],
            'dd_fab'                 => ['regex:/^(:?Yes|No)$/'],
            'dd_who'                 => 'string',
            'dd_experience'          => 'string',
            'surgery'                => ['regex:/^(:?Yes|No)$/'],
            'parent_patientid'       => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'formid'                 => 'integer',
            'patientid'              => 'sometimes|required|integer',
            'polysomnographic'       => 'integer',
            'sleep_center_name'      => 'string',
            'sleep_study_on'         => 'date',
            'confirmed_diagnosis'    => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'rdi'                    => 'regex:/^[0-9]+$/',
            'ahi'                    => 'regex:/^[0-9]+$/',
            'cpap'                   => ['sometimes', 'required', 'regex:/^(:?Yes|No)$/'],
            'intolerance'            => 'regex:/^~([0-9]+~)+$/',
            'other_intolerance'      => 'string',
            'other_therapy'          => 'string',
            'userid'                 => 'sometimes|required|integer',
            'docid'                  => 'sometimes|required|integer',
            'status'                 => 'integer',
            'other'                  => 'string',
            'affidavit'              => 'string',
            'type_study'             => 'string',
            'nights_wear_cpap'       => 'regex:/^[0-9]+$/',
            'percent_night_cpap'     => 'regex:/^[0-9]+$/',
            'custom_diagnosis'       => 'string',
            'sleep_study_by'         => 'string',
            'triedquittried'         => 'string',
            'timesovertime'          => 'string',
            'cur_cpap'               => ['regex:/^(:?Yes|No)$/'],
            'sleep_center_name_text' => 'string',
            'dd_wearing'             => ['regex:/^(:?Yes|No)$/'],
            'dd_prev'                => ['regex:/^(:?Yes|No)$/'],
            'dd_otc'                 => ['regex:/^(:?Yes|No)$/'],
            'dd_fab'                 => ['regex:/^(:?Yes|No)$/'],
            'dd_who'                 => 'string',
            'dd_experience'          => 'string',
            'surgery'                => ['regex:/^(:?Yes|No)$/'],
            'parent_patientid'       => 'integer'
        ];
    }
}
