<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\TongueClinicalExam;
use Tests\TestCases\ApiTestCase;

class TongueClinicalExamsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return TongueClinicalExam::class;
    }

    protected function getRoute()
    {
        return '/tongue-clinical-exams';
    }

    protected function getStoreData()
    {
        return [
            'formid'               => 5,
            'patientid'            => 5,
            'blood_pressure'       => '130/85',
            'pulse'                => '5',
            'neck_measurement'     => 50.5,
            'bmi'                  => 12.5,
            'additional_paragraph' => 'paragraph',
            'tongue'               => '~1~2~3~',
            'userid'               => 5,
            'docid'                => 5,
            'status'               => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'additional_paragraph' => 'Update Test additional paragraph',
            'status'               => 8,
        ];
    }
}
