<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\SocialHistory;
use Tests\TestCases\ApiTestCase;

class SocialHistoriesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return SocialHistory::class;
    }

    protected function getRoute()
    {
        return '/social-histories';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 5,
            "patientid" => 100,
            "family_had" => "Quis laboriosam ut id necessitatibus.",
            "family_diagnosed" => "Yes",
            "additional_paragraph" => "Ipsam ullam eligendi sint sequi dolore architecto maxime quaerat.",
            "alcohol" => "optio",
            "sedative" => "et",
            "caffeine" => "harum",
            "smoke" => "No",
            "smoke_packs" => "9",
            "tobacco" => "Yes",
            "userid" => 1,
            "docid" => 5,
            "status" => 2,
            "parent_patientid" => 3,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'formid'               => 100,
            'additional_paragraph' => 'updated social history',
        ];
    }
}
