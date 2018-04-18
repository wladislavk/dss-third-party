<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Http\Transformers\ExternalPatient as Transformer;
use DentalSleepSolutions\Services\ExternalPatientDataRetriever;
use Tests\TestCases\UnitTestCase;

class ExternalPatientDataRetrieverTest extends UnitTestCase
{
    const REQUEST_DATA = [];
    const INVERSE_TRANSFORM = [
        'Foo' => 'Bar',
        'software' => 'software',
        'external_id' => 'external_id',
        'patient_id' => 'patient_id',
        'dirty' => 'dirty',
        'payer_name' => 'payer_name',
        'payer_address1' => 'payer_address1',
        'payer_address2' => 'payer_address2',
        'payer_city' => 'payer_city',
        'payer_state' => 'payer_state',
        'payer_zip' => 'payer_zip',
        'payer_phone' => 'payer_phone',
        'payer_fax' => 'payer_fax',
        'subscriber_phone' => 'subscriber_phone',
        'dependent_phone' => 'dependent_phone',
    ];
    const PATIENT_DATA = [
        'Foo' => 'Bar',
    ];
    
    /** @var ExternalPatientDataRetriever */
    private $dataRetriever;

    public function setUp()
    {
        $transformer = $this->mockTransformer();
        $this->dataRetriever = new ExternalPatientDataRetriever($transformer);
    }

    public function testToExternalPatientData()
    {
        $data = $this->dataRetriever->toExternalPatientData(self::REQUEST_DATA);
        $this->assertEquals(self::INVERSE_TRANSFORM, $data);
    }

    public function testToPatientData()
    {
        $data = $this->dataRetriever->toPatientData(self::REQUEST_DATA);
        $this->assertEquals(self::PATIENT_DATA, $data);
    }

    private function mockTransformer()
    {
        $mock = \Mockery::mock(Transformer::class);
        $mock->shouldReceive('inverseTransform')
            ->once()
            ->with(self::REQUEST_DATA)
            ->andReturn(self::INVERSE_TRANSFORM)
        ;
        return $mock;
    }
}
