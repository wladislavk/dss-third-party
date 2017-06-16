<?php

namespace DentalSleepSolutions\Http\Requests;

class Symptom extends Request
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
            'member_no'              => 'string',
            'group_no'               => 'string',
            'plan_no'                => 'string',
            'primary_care_physician' => 'string',
            'feet'                   => 'regex:/^[0-9]+$/',
            'inches'                 => 'regex:/^[0-9]+$/',
            'weight'                 => 'regex:/^[0-9]+$/',
            'bmi'                    => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'sleep_qual'             => 'regex:/^[0-9]+$/',
            'complaintid'            => ['regex:/^(:?[0-9]+\|[0-9]+~)+$/'],
            'other_complaint'        => 'string',
            'additional_paragraph'   => 'string',
            'energy_level'           => 'regex:/^[0-9]+$/',
            'snoring_sound'          => 'regex:/^[0-9]+$/',
            'wake_night'             => 'regex:/^[0-9]+$/',
            'breathing_night'        => 'string',
            'morning_headaches'      => 'string',
            'hours_sleep'            => 'regex:/^[0-9]+$/',
            'userid'                 => 'required|integer',
            'docid'                  => 'required|integer',
            'status'                 => 'integer',
            'quit_breathing'         => 'string',
            'bed_time_partner'       => ['regex:/^(:?Yes|Sometimes|No)$/'],
            'sleep_same_room'        => ['regex:/^(:?Yes|Sometimes|No)$/'],
            'told_you_snore'         => ['regex:/^(:?Yes|Sometimes|No)$/'],
            'main_reason'            => 'string',
            'main_reason_other'      => 'string',
            'exam_date'              => 'date',
            'chief_complaint_text'   => 'string',
            'tss'                    => 'regex:/^[0-9]+$/',
            'ess'                    => 'regex:/^[0-9]+$/',
            'parent_patientid'       => 'integer'
        ];
    }

    public function updateRules()
    {
        return [
            'formid'                 => 'integer',
            'patientid'              => 'sometimes|required|integer',
            'member_no'              => 'string',
            'group_no'               => 'string',
            'plan_no'                => 'string',
            'primary_care_physician' => 'string',
            'feet'                   => 'regex:/^[0-9]+$/',
            'inches'                 => 'regex:/^[0-9]+$/',
            'weight'                 => 'regex:/^[0-9]+$/',
            'bmi'                    => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'sleep_qual'             => 'regex:/^[0-9]+$/',
            'complaintid'            => ['regex:/^(:?[0-9]+\|[0-9]+~)+$/'],
            'other_complaint'        => 'string',
            'additional_paragraph'   => 'string',
            'energy_level'           => 'regex:/^[0-9]+$/',
            'snoring_sound'          => 'regex:/^[0-9]+$/',
            'wake_night'             => 'regex:/^[0-9]+$/',
            'breathing_night'        => 'string',
            'morning_headaches'      => 'string',
            'hours_sleep'            => 'regex:/^[0-9]+$/',
            'userid'                 => 'sometimes|required|integer',
            'docid'                  => 'sometimes|required|integer',
            'status'                 => 'integer',
            'quit_breathing'         => 'string',
            'bed_time_partner'       => ['regex:/^(:?Yes|Sometimes|No)$/'],
            'sleep_same_room'        => ['regex:/^(:?Yes|Sometimes|No)$/'],
            'told_you_snore'         => ['regex:/^(:?Yes|Sometimes|No)$/'],
            'main_reason'            => 'string',
            'main_reason_other'      => 'string',
            'exam_date'              => 'date',
            'chief_complaint_text'   => 'string',
            'tss'                    => 'regex:/^[0-9]+$/',
            'ess'                    => 'regex:/^[0-9]+$/',
            'parent_patientid'       => 'integer'
        ];
    }
}
