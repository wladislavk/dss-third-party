<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\AirwayEvaluation;
use Tests\TestCases\ApiTestCase;

class AirwayEvaluationsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return AirwayEvaluation::class;
    }

    protected function getRoute()
    {
        return '/airway-evaluations';
    }

    protected function getStoreData()
    {
        return [
            'formid'               => 7,
            'patientid'            => 7,
            'maxilla'              => '~7~8~',
            'other_maxilla'        => 'test other maxilla',
            'mandible'             => '~7~8~',
            'other_mandible'       => 'test other mandible',
            'soft_palate'          => '~7~8~',
            'other_soft_palate'    => 'test other soft palate',
            'uvula'                => '~7~8~',
            'other_uvula'          => 'test other uvula',
            'gag_reflex'           => '~7~8~',
            'other_gag_reflex'     => 'test other gag reflex',
            'nasal_passages'       => '~7~8~',
            'other_nasal_passages' => 'test other nasal passages',
            'userid'               => 7,
            'docid'                => 7,
            'status'               => 7,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'other_mandible' => 'update test other mandible',
            'status'         => 8,
        ];
    }
}
