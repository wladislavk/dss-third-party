<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\PreviousTreatment;
use Tests\TestCases\ApiTestCase;

class PreviousTreatmentsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return PreviousTreatment::class;
    }

    protected function getRoute()
    {
        return '/previous-treatments';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 1,
            "patientid" => 100,
            "polysomnographic" => 2,
            "sleep_center_name" => "38",
            "sleep_study_on" => "05/01/2001",
            "confirmed_diagnosis" => "399.93",
            "rdi" => "96",
            "ahi" => "60",
            "cpap" => "Yes",
            "intolerance" => "~719~299~",
            "other_intolerance" => "Praesentium accusamus voluptatem veritatis et.",
            "other_therapy" => "Voluptas sed fuga odit sint.",
            "other" => "Officia eligendi sit ipsam et.",
            "affidavit" => "optio",
            "type_study" => "odit",
            "nights_wear_cpap" => "62",
            "percent_night_cpap" => "02",
            "custom_diagnosis" => "voluptatem",
            "sleep_study_by" => "voluptatem",
            "triedquittried" => "culpa",
            "timesovertime" => "facere",
            "cur_cpap" => "Yes",
            "sleep_center_name_text" => "Totam perspiciatis nisi odit.",
            "dd_wearing" => "Yes",
            "dd_prev" => "Yes",
            "dd_otc" => "No",
            "dd_fab" => "No",
            "dd_who" => "possimus",
            "dd_experience" => "Aut nostrum.",
            "surgery" => "No",
            "parent_patientid" => 0,
            "userid" => 9,
            "docid" => 8,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'formid'            => 153,
            'other_intolerance' => 'updated intolerance',
        ];
    }
}
