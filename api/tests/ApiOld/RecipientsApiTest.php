<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Recipient;
use Tests\TestCases\ApiTestCase;

class RecipientsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Recipient::class;
    }

    protected function getRoute()
    {
        return '/recipients';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 9,
            "patientid" => 100,
            "referring_physician" => "Odio libero error nisi nemo.",
            "dentist" => "Quia magni esse ratione nisi illo illo atque.",
            "physicians_other" => "In voluptas deleniti vel eos iusto voluptatem recusandae.",
            "patient_info" => "Impedit sed itaque quia et ratione atque.",
            "q_file1" => "3ljeakee4cpo.gif",
            "q_file2" => "c7hv24pkp961.png",
            "q_file3" => "qtjxf7dr719i.png",
            "q_file4" => "zxe7va72pq3e.gif",
            "q_file5" => "ntn63z765v2a.jpg",
            "userid" => 9,
            "docid" => 0,
            "status" => 0,
            "q_file6" => "7a8ptmvhbb1s.png",
            "q_file7" => "5zy6gzhpwdm1.jpg",
            "q_file8" => "8mbm7brjgdp9.jpg",
            "q_file9" => "e352y91b4no8.jpg",
            "q_file10" => "utcrs7jxy6f8.gif",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'formid' => 100,
            'patient_info' => 'updated patient info',
        ];
    }
}
