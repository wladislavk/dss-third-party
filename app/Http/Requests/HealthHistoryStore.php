<?php

namespace DentalSleepSolutions\Http\Requests;

class HealthHistoryStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formid'                 => 'integer',
            'patientid'              => 'required|integer',
            'allergens'              => 'string',
            'other_allergens'        => 'string',
            'medications'            => 'string',
            'other_medications'      => 'string',
            'history'                => 'string',
            'other_history'          => 'string',
            'userid'                 => 'required|integer',
            'docid'                  => 'required|integer',
            'status'                 => 'integer',
            'dental_health'          => ['regex:/^(?:Good|Excellent|Fair|Poor)$/'],
            'removable'              => ['regex:/^(?:Yes|No)$/'],
            'year_completed'         => 'string',
            'tmj'                    => 'string',
            'gum_problems'           => 'string',
            'dental_pain'            => 'string',
            'dental_pain_describe'   => 'string',
            'completed_future'       => ['regex:/^(?:Yes|No)$/'],
            'clinch_grind'           => ['regex:/^(?:Yes|No)$/'],
            'wisdom_extraction'      => ['regex:/^(?:Yes|No)$/'],
            'injurytohead'           => ['regex:/^(?:Yes|No)$/'],
            'injurytoneck'           => ['regex:/^(?:Yes|No)$/'],
            'injurytoface'           => ['regex:/^(?:Yes|No)$/'],
            'injurytoteeth'          => ['regex:/^(?:Yes|No)$/'],
            'injurytomouth'          => ['regex:/^(?:Yes|No)$/'],
            'drymouth'               => ['regex:/^(?:Yes|No)$/'],
            'jawjointsurgery'        => ['regex:/^(?:Yes|No)$/'],
            'no_allergens'           => 'regex:/^[0-9]$/',
            'no_medications'         => 'regex:/^[0-9]$/',
            'no_history'             => 'regex:/^[0-9]$/',
            'orthodontics'           => ['regex:/^(?:Yes|No)$/'],
            'wisdom_extraction_text' => 'string',
            'removable_text'         => 'string',
            'dentures'               => ['regex:/^(?:Yes|No)$/'],
            'dentures_text'          => 'string',
            'tmj_cp'                 => ['regex:/^(?:Yes|No)$/'],
            'tmj_cp_text'            => 'string',
            'tmj_pain'               => ['regex:/^(?:Yes|No)$/'],
            'tmj_pain_text'          => 'string',
            'tmj_surgery'            => ['regex:/^(?:Yes|No)$/'],
            'tmj_surgery_text'       => 'string',
            'injury'                 => ['regex:/^(?:Yes|No)$/'],
            'injury_text'            => 'string',
            'gum_prob'               => ['regex:/^(?:Yes|No)$/'],
            'gum_prob_text'          => 'string',
            'gum_surgery'            => ['regex:/^(?:Yes|No)$/'],
            'gum_surgery_text'       => 'string',
            'clinch_grind_text'      => 'string',
            'future_dental_det'      => 'string',
            'drymouth_text'          => 'string',
            'family_hd'              => ['regex:/^(?:Yes|No)$/'],
            'family_bp'              => ['regex:/^(?:Yes|No)$/'],
            'family_dia'             => ['regex:/^(?:Yes|No)$/'],
            'family_sd'              => ['regex:/^(?:Yes|No)$/'],
            'alcohol'                => 'string',
            'sedative'               => 'string',
            'caffeine'               => 'string',
            'smoke'                  => ['regex:/^(?:Yes|No)$/'],
            'smoke_packs'            => 'string',
            'tobacco'                => ['regex:/^(?:Yes|No)$/'],
            'additional_paragraph'   => 'string',
            'allergenscheck'         => 'boolean',
            'medicationscheck'       => 'boolean',
            'historycheck'           => 'boolean',
            'parent_patientid'       => 'integer'
        ];
    }
}
