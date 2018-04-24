<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\DentalClinicalExam;
use Tests\TestCases\ApiTestCase;

class DentalClinicalExamsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return DentalClinicalExam::class;
    }

    protected function getRoute()
    {
        return '/dental-clinical-exams';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 8,
            "patientid" => 100,
            "exam_teeth" => "~7~6~",
            "other_exam_teeth" => "Praesentium aut ex id.",
            "caries" => "C, E, G, I, 10, 23, 24, 25",
            "where_facets" => "01, 04, 07",
            "cracked_fractured" => "01, 04, 07",
            "old_worn_inadequate_restorations" => "A, B, C, 01, 02, 03, 17, 18, 19",
            "dental_class_right" => "I (normal)",
            "dental_division_right" => "9",
            "dental_class_left" => "II (Retrognathic)(Retruded Lower Jaw)",
            "dental_division_left" => "3",
            "additional_paragraph" => "Iure excepturi placeat in delectus. Tempora deserunt sunt occaecati vel hic dolorem et. Sapiente maiores quo quo non repellat quo fugit. Voluptatum provident sit neque a explicabo qui recusandae.",
            "initial_tooth" => "09\/10",
            "open_proximal" => "09\/10",
            "deistema" => "09\/25",
            "userid" => 5,
            "docid" => 0,
            "status" => 3,
            "adddate" => "2009-09-21 08:13:24",
            "missing" => "04, 05, 20, 25",
            "crossbite" => "09\/10",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid' => 55,
            'docid'     => 100,
        ];
    }
}
