<?php

namespace Tests\Integration\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalPatient;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalPatientRepository;
use DentalSleepSolutions\Helpers\ExternalPatientDataRetriever;
use DentalSleepSolutions\Helpers\ExternalPatientSyncManager;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCases\BaseIntegrationTestCase;

class ExternalPatientSyncManagerTest extends BaseIntegrationTestCase
{
    const EXISTING_COMPANY_ID = 'Foo';
    const NON_EXISTING_COMPANY_ID = 'Bar';
    const VALID_USER_ID = 'foo-id';
    const CREATE_ATTRIBUTES = [];
    const REQUEST_DATA = [
        ExternalPatientSyncManager::EXTERNAL_COMPANY_KEY => self::EXISTING_COMPANY_ID,
        ExternalPatientSyncManager::EXTERNAL_PATIENT_KEY => self::VALID_USER_ID,
    ];
    const EXTERNAL_PATIENT_DATA = [
        ExternalPatientSyncManager::EXTERNAL_PATIENT_KEY => self::VALID_USER_ID,
    ];
    const PATIENT_DATA = [];

    use DatabaseTransactions;

    /** @var ExternalPatientSyncManager */
    private $syncManager;

    public function setUp()
    {
        parent::setUp();
        $repository = $this->mockRepository();
        $dataRetriever = $this->mockDataRetriever();
        $this->syncManager = new ExternalPatientSyncManager($repository, $dataRetriever);
    }

    public function testUpdateExistingModels()
    {
        $requestData = self::REQUEST_DATA;
        $attributes = self::CREATE_ATTRIBUTES;
        $externalPatient = $this->syncManager->updateOnMissingCreate($requestData, $attributes);

        $this->assertInstanceOf(ExternalPatient::class, $externalPatient);
        $this->assertEquals(
            self::EXISTING_COMPANY_ID,
            $externalPatient->{ExternalPatientSyncManager::EXTERNAL_COMPANY_KEY}
        );
        $this->assertEquals(1, $externalPatient->{ExternalPatientSyncManager::MODEL_DIRTY_KEY});
    }

    public function testCreateModels()
    {
        $requestData = self::REQUEST_DATA;
        $requestData[ExternalPatientSyncManager::EXTERNAL_COMPANY_KEY] = self::NON_EXISTING_COMPANY_ID;
        $attributes = self::CREATE_ATTRIBUTES;
        $externalPatient = $this->syncManager->updateOnMissingCreate($requestData, $attributes);

        $this->assertInstanceOf(ExternalPatient::class, $externalPatient);
        $this->assertEquals(
            self::NON_EXISTING_COMPANY_ID,
            $externalPatient->{ExternalPatientSyncManager::EXTERNAL_COMPANY_KEY}
        );
        $this->assertEquals(0, $externalPatient->{ExternalPatientSyncManager::MODEL_DIRTY_KEY});
    }

    private function newLinkedExternalPatient()
    {
        $patient = factory(Patient::class)->create();
        $externalPatient = $this->newExternalPatient();
        $externalPatient->patient_id = $patient->getKey();
        $externalPatient->save();

        return $externalPatient;
    }

    private function newExternalPatient()
    {
        $model = factory(ExternalPatient::class)->create();
        return $model;
    }

    private function mockRepository()
    {
        $mock = \Mockery::mock(ExternalPatientRepository::class);
        $mock->shouldReceive('findByExternalCompanyAndPatient')
            ->atMost(1)
            ->with(self::EXISTING_COMPANY_ID, self::VALID_USER_ID)
            ->andReturnUsing(function () {
                return $this->newLinkedExternalPatient();
            })
        ;
        $mock->shouldReceive('findByExternalCompanyAndPatient')
            ->atMost(1)
            ->with(self::NON_EXISTING_COMPANY_ID, self::VALID_USER_ID)
            ->andReturnNull()
        ;
        $mock->shouldReceive('create')
            ->atMost(1)
            ->andReturnUsing(function () {
                return $this->newExternalPatient();
            })
        ;
        return $mock;
    }

    private function mockDataRetriever()
    {
        $mock = \Mockery::mock(ExternalPatientDataRetriever::class);
        $mock->shouldReceive('toExternalPatientData')
            ->once()
            ->andReturnUsing(function (array $requestData) {
                $data = self::EXTERNAL_PATIENT_DATA;
                $data[ExternalPatientSyncManager::EXTERNAL_COMPANY_KEY] =
                    $requestData[ExternalPatientSyncManager::EXTERNAL_COMPANY_KEY];
                return $data;
            })
        ;
        $mock->shouldReceive('toPatientData')
            ->once()
            ->andReturn(self::PATIENT_DATA)
        ;
        return $mock;
    }
}
