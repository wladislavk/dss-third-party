<?php

namespace DentalSleepSolutions\Http\Requests;

class TmjClinicalExamStore extends AbstractStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formid'                   => 'integer',
            'patientid'                => 'required|integer',
            'palpationid'              => 'string',
            'palpationRid'             => 'string',
            'additional_paragraph_pal' => 'string',
            'joint_exam'               => 'string',
            'jointid'                  => 'string',
            'i_opening_from'           => 'string',
            'i_opening_to'             => 'string',
            'i_opening_equal'          => 'string',
            'protrusion_from'          => 'string',
            'protrusion_to'            => 'string',
            'protrusion_equal'         => 'string',
            'l_lateral_from'           => 'string',
            'l_lateral_to'             => 'string',
            'l_lateral_equal'          => 'string',
            'r_lateral_from'           => 'string',
            'r_lateral_to'             => 'string',
            'r_lateral_equal'          => 'string',
            'deviation_from'           => 'string',
            'deviation_to'             => 'string',
            'deviation_equal'          => 'string',
            'deflection_from'          => 'string',
            'deflection_to'            => 'string',
            'deflection_equal'         => 'string',
            'range_normal'             => 'string',
            'normal'                   => 'string',
            'other_range_motion'       => 'string',
            'additional_paragraph_rm'  => 'string',
            'screening_aware'          => 'string',
            'screening_normal'         => 'string',
            'userid'                   => 'required|integer',
            'docid'                    => 'required|integer',
            'status'                   => 'integer',
            'deviation_r_l'            => 'string',
            'deflection_r_l'           => 'string',
            'dentaldevice'             => 'integer',
            'dentaldevice_date'        => 'date'
        ];
    }
}
