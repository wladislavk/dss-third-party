<?php
namespace Ds3\Libraries\Legacy;

function coMorbidityLabels () {
    $coMorbidityLabels = [
        'rx_blood_pressure' => 'High blood pressure',
        'rx_apnea' => 'Sleep Apnea',
        'rx_lung_disease' => 'Lung Disease',
        'rx_insomnia' => 'Insomnia',
        'rx_depression' => 'Depression',
        'rx_medication' => 'Sleeping medication',
        'rx_restless_leg' => 'Restless leg syndrome',
        'rx_headaches' => 'Morning headaches',
        'rx_heart_disease' => 'Heart Failure',
        'rx_stroke' => 'Stroke',
        'rx_hypertension' => 'Hypertension',
        'rx_diabetes' => 'Diabetes',
        'rx_metabolic_syndrome' => 'Metabolic Syndrome',
        'rx_obesity' => 'Obesity',
        'rx_heartburn' => 'Heartburn (Gastroesophageal Reflux)',
        'rx_afib' => 'Atrial Fibrillation'
    ];

    return $coMorbidityLabels;
}

/**
 * This a collection of values gathered from the source code.
 *
 * Certain values from the list might be inactive fields, but they are included here
 * for historic purposes.
 */
function coMorbidityWeights () {
    $coMorbidityWeights = [
        'rx_cpap'               => 4,
        'rx_heart_disease'      => 2,
        'rx_stroke'             => 2,
        'rx_obesity'            => 2,
        'rx_afib'               => 2,
        'rx_apnea'              => 1,
        'rx_metabolic_syndrome' => 1,
        'rx_blood_pressure'     => 1,
        'rx_hypertension'       => 1,
        'rx_diabetes'           => 1,
        'rx_heartburn'          => 1,
        'rx_lung_disease'       => 1,
        'rx_insomnia'           => 1,
        'rx_depression'         => 1,
        'rx_narcolepsy'         => 1,
        'rx_medication'         => 1,
        'rx_restless_leg'       => 1,
        'rx_headaches'          => 1,
    ];

    return $coMorbidityWeights;
}

/**
 * Auxiliary function to calculate the associated risk for co-morbidity questions / answers
 *
 * @param array $sourceData
 * @return int
 */
function coMorbiditySum ($sourceData) {
    $weights = coMorbidityWeights();
    $total = 0;

    foreach ($weights as $key=>$value) {
        if (!empty($sourceData[$key])) {
            $total += $value;
        }
    }

    return $total;
}
