<?php

namespace DentalSleepSolutions\Http\Requests;

class ScreenerStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'docid'                 => 'required|integer',
            'userid'                => 'required|integer',
            'first_name'            => 'required|string',
            'last_name'             => 'required|string',
            'email'                 => 'email',
            'epworth_reading'       => 'integer',
            'epworth_public'        => 'integer',
            'epworth_passenger'     => 'integer',
            'epworth_lying'         => 'integer',
            'epworth_talking'       => 'integer',
            'epworth_lunch'         => 'integer',
            'epworth_traffic'       => 'integer',
            'snore_1'               => 'integer',
            'snore_2'               => 'integer',
            'snore_3'               => 'integer',
            'snore_4'               => 'integer',
            'snore_5'               => 'integer',
            'breathing'             => 'integer',
            'driving'               => 'integer',
            'gasping'               => 'integer',
            'sleepy'                => 'integer',
            'snore'                 => 'integer',
            'weight_gain'           => 'integer',
            'blood_pressure'        => 'integer',
            'jerk'                  => 'integer',
            'burning'               => 'integer',
            'headaches'             => 'integer',
            'falling_asleep'        => 'integer',
            'staying_asleep'        => 'integer',
            'rx_blood_pressure'     => 'integer',
            'rx_hypertension'       => 'integer',
            'rx_heart_disease'      => 'integer',
            'rx_stroke'             => 'integer',
            'rx_apnea'              => 'integer',
            'rx_diabetes'           => 'integer',
            'rx_lung_disease'       => 'integer',
            'rx_insomnia'           => 'integer',
            'rx_depression'         => 'integer',
            'rx_narcolepsy'         => 'integer',
            'rx_medication'         => 'integer',
            'rx_restless_leg'       => 'integer',
            'rx_headaches'          => 'integer',
            'rx_heartburn'          => 'integer',
            'rx_cpap'               => 'integer',
            'phone'                 => 'required|regex:/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$/',
            'contacted'             => 'integer',
            'patient_id'            => 'integer',
            'rx_metabolic_syndrome' => 'integer',
            'rx_obesity'            => 'integer',
            'rx_afib'               => 'integer'
        ];
    }
}
