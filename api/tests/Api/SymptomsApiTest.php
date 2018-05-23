<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Symptom;
use Tests\TestCases\ApiTestCase;

class SymptomsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Symptom::class;
    }

    protected function getRoute()
    {
        return '/symptoms';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 5,
            "member_no" => "similique",
            "group_no" => "fuga",
            "plan_no" => "sint",
            "primary_care_physician" => "ea",
            "feet" => "20",
            "inches" => "98",
            "weight" => "04",
            "bmi" => "511.74",
            "sleep_qual" => "61",
            "complaintid" => "1|5~10|6~11|2~12|19~13|4~14|18~15|17~16|1~0|1~",
            "other_complaint" => "Saepe facilis voluptate nemo laudantium.",
            "additional_paragraph" => "Rerum esse architecto quo deleniti ut.",
            "energy_level" => "41",
            "snoring_sound" => "45",
            "wake_night" => "47",
            "breathing_night" => "Rem omnis explicabo natus quod.",
            "morning_headaches" => "Nemo doloremque tenetur mollitia molestias.",
            "hours_sleep" => "46",
            "status" => 0,
            "quit_breathing" => "Quo quasi est ut consequatur quo officia.",
            "bed_time_partner" => "Yes",
            "sleep_same_room" => "Sometimes",
            "told_you_snore" => "Yes",
            "main_reason" => "Alias quasi et et sit aperiam.",
            "main_reason_other" => "Repellendus neque vel omnis similique temporibus.",
            "chief_complaint_text" => "Veritatis qui perspiciatis amet consectetur ad quae.",
            "tss" => "22",
            "ess" => "16",
            "parent_patientid" => 8,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'formid'  => 458,
            'plan_no' => 'updated plan number',
        ];
    }
}
