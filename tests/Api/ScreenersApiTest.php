<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Screener;
use Tests\TestCases\ApiTestCase;

class ScreenersApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Screener::class;
    }

    protected function getRoute()
    {
        return '/screeners';
    }

    protected function getStoreData()
    {
        return [
            "docid" => 100,
            "userid" => 7,
            "first_name" => "Murray",
            "last_name" => "Dicki",
            "email" => "caesar.bednar@gmail.com",
            "epworth_reading" => 9,
            "epworth_public" => 1,
            "epworth_passenger" => 2,
            "epworth_lying" => 5,
            "epworth_talking" => 4,
            "epworth_lunch" => 4,
            "epworth_traffic" => 3,
            "snore_1" => 6,
            "snore_2" => 8,
            "snore_3" => 9,
            "snore_4" => 5,
            "snore_5" => 7,
            "breathing" => 4,
            "driving" => 1,
            "gasping" => 0,
            "sleepy" => 7,
            "snore" => 9,
            "weight_gain" => 5,
            "blood_pressure" => 8,
            "jerk" => 1,
            "burning" => 2,
            "headaches" => 0,
            "falling_asleep" => 5,
            "staying_asleep" => 8,
            "rx_blood_pressure" => 1,
            "rx_hypertension" => 6,
            "rx_heart_disease" => 8,
            "rx_stroke" => 1,
            "rx_apnea" => 9,
            "rx_diabetes" => 2,
            "rx_lung_disease" => 6,
            "rx_insomnia" => 0,
            "rx_depression" => 5,
            "rx_narcolepsy" => 1,
            "rx_medication" => 1,
            "rx_restless_leg" => 0,
            "rx_headaches" => 9,
            "rx_heartburn" => 3,
            "rx_cpap" => 4,
            "phone" => "(858) 413-0773",
            "contacted" => 1,
            "patient_id" => 6,
            "rx_metabolic_syndrome" => 4,
            "rx_obesity" => 7,
            "rx_afib" => 3,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'userid'     => 100,
            'first_name' => 'John',
            'last_name'  => 'Doe',
        ];
    }
}
