<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Plan;
use Tests\TestCases\ApiTestCase;

class PlansApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Plan::class;
    }

    protected function getRoute()
    {
        return '/plans';
    }

    protected function getStoreData()
    {
        return [
            "name" => "added plan",
            "monthly_fee" => 423.78,
            "trial_period" => 4,
            "fax_fee" => 186.97,
            "free_fax" => 2,
            "status" => 8,
            "eligibility_fee" => 473.18,
            "free_eligibility" => 8,
            "enrollment_fee" => 83.92,
            "free_enrollment" => 4,
            "claim_fee" => 168.2,
            "free_claim" => 0,
            "vob_fee" => 98.17,
            "free_vob" => 8,
            "office_type" => 7,
            "efile_fee" => 296.13,
            "free_efile" => 8,
            "duration" => 0,
            "producer_fee" => 330.36,
            "user_fee" => 98.57,
            "patient_fee" => 147.6,
            "e0486_bill" => 4,
            "e0486_fee" => 237.4,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'name'         => 'updated plan',
            'trial_period' => 54,
            'status'       => 5,
        ];
    }
}
