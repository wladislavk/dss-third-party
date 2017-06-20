<?php

namespace DentalSleepSolutions\Http\Requests;

class DentalClinicalExam extends Request
{
    protected $rules = [
        'formid'                           => 'integer',
        'patientid'                        => 'required|integer',
        'exam_teeth'                       => 'string',
        'other_exam_teeth'                 => 'string',
        'caries'                           => 'string',
        'where_facets'                     => 'string',
        'cracked_fractured'                => 'string',
        'old_worn_inadequate_restorations' => 'string',
        'dental_class_right'               => 'string',
        'dental_division_right'            => 'string',
        'dental_class_left'                => 'string',
        'dental_division_left'             => 'string',
        'additional_paragraph'             => 'string',
        'initial_tooth'                    => 'string',
        'open_proximal'                    => 'string',
        'deistema'                         => 'string',
        'userid'                           => 'required|integer',
        'docid'                            => 'required|integer',
        'status'                           => 'integer',
        'missing'                          => 'string',
        'crossbite'                        => 'string'
    ];
}
