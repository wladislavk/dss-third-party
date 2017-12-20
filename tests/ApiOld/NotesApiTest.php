<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Note;
use Tests\TestCases\ApiTestCase;

class NotesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Note::class;
    }

    protected function getRoute()
    {
        return '/notes';
    }

    protected function getStoreData()
    {
        return [
            "patientid" => 100,
            "notes" => "Ut cupiditate et vel.",
            "edited" => 1,
            "editor_initials" => "distinctio",
            "userid" => 9,
            "docid" => 2,
            "status" => 0,
            "procedure_date" => "2017-07-27",
            "signed_id" => 6,
            "signed_on" => "1984-12-02 08:14:20",
            "parentid" => 3,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'notes'  => 'updated notes',
            'userid' => 12,
        ];
    }
}
