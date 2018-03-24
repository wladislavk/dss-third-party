<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\HealthHistory;
use DentalSleepSolutions\Eloquent\Models\Dental\HomeSleepTest;
use DentalSleepSolutions\Eloquent\Models\Dental\Insurance;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\HealthHistoryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\HomeSleepTestRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\InsuranceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientContactRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientInsuranceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Factories\RepositoryFactory;
use DentalSleepSolutions\Helpers\PatientDataRetriever;
use Illuminate\Database\Eloquent\Model;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PatientDataRetrieverTest extends UnitTestCase
{
    /** @var array */
    private $incompleteHSTs = [];

    /** @var array */
    private $healthHistories = [];

    /** @var Model */
    private $children;

    /** @var array */
    private $rejectedClaims = [];

    /** @var Patient */
    private $patient;

    /** @var PatientDataRetriever */
    private $patientDataRetriever;

    public function setUp()
    {
        $this->patient = new Patient();
        $this->patient->patientid = 1;
        $this->patient->history_status = 2;
        $this->patient->treatments_status = 3;
        $this->patient->symptoms_status = 4;
        $this->patient->email_bounce = 1;
        $this->patient->p_m_ins_type = '5';
        $this->patient->premed = 'foo';
        $this->patient->premedcheck = 1;
        $this->patient->alert_text = 'bar';
        $this->patient->display_alert = 1;
        $this->patient->firstname = 'John';
        $this->patient->lastname = 'Doe';

        $firstClaim = new Insurance();
        $firstClaim->primary_claim_id = 1;
        $secondClaim = new Insurance();
        $secondClaim->primary_claim_id = 2;
        $this->rejectedClaims = [$firstClaim, $secondClaim];

        $this->children = new Patient();

        $repositoryFactory = $this->mockRepositoryFactory();
        $this->patientDataRetriever = new PatientDataRetriever($repositoryFactory);
    }
    
    public function testGetPatientData()
    {
        $docId = 2;
        $patientData = $this->patientDataRetriever->getPatientData($docId, $this->patient);
        $expected = [
            'insurance_type' => '5',
            'premed' => 'foo',
            'premedcheck' => 1,
            'alert_text' => 'bar',
            'display_alert' => 1,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'patient_contacts_number' => 3,
            'patient_insurances_number' => 4,
            'sub_patients_number' => 0,
            'is_email_bounced' => 1,
            'rejected_claims' => [
                [
                    'primary_claim_id' => 1,
                ],
                [
                    'primary_claim_id' => 2,
                ],
            ],
            'questionnaire_data' => [
                'symptoms_status' => 4,
                'treatments_status' => 3,
                'history_status' => 2,
            ],
            'other_allergens' => '',
            'has_allergen' => 0,
            'hst_status' => 99,
            'incomplete_hsts' => [],
        ];
        $this->assertEquals($expected, $patientData->toArray());
    }

    public function testWithSubPatients()
    {
        $this->children->total = 2;

        $docId = 2;
        $patientData = $this->patientDataRetriever->getPatientData($docId, $this->patient)->toArray();
        $this->assertEquals(2, $patientData['sub_patients_number']);
    }

    public function testWithHealthHistories()
    {
        $firstHistory = new HealthHistory();
        $firstHistory->allergenscheck = 1;
        $firstHistory->other_allergens = 'foo';
        $secondHistory = new HealthHistory();
        $secondHistory->allergenscheck = 0;
        $secondHistory->other_allergens = 'bar';
        $this->healthHistories = [$firstHistory, $secondHistory];

        $docId = 2;
        $patientData = $this->patientDataRetriever->getPatientData($docId, $this->patient)->toArray();
        $this->assertEquals(1, $patientData['has_allergen']);
        $this->assertEquals('foo', $patientData['other_allergens']);
    }

    public function testWithIncompleteHSTs()
    {
        $firstHst = new HomeSleepTest();
        $firstHst->status = 1;
        $secondHst = new HomeSleepTest();
        $secondHst->status = 2;
        $this->incompleteHSTs = [$firstHst, $secondHst];

        $docId = 2;
        $patientData = $this->patientDataRetriever->getPatientData($docId, $this->patient)->toArray();
        $this->assertEquals(2, sizeof($patientData['incomplete_hsts']));
        $this->assertEquals(2, $patientData['hst_status']);
    }

    private function mockRepositoryFactory()
    {
        /** @var RepositoryFactory|MockInterface $repositoryFactory */
        $repositoryFactory = \Mockery::mock(RepositoryFactory::class);
        $repositoryFactory->shouldReceive('getRepository')->andReturnUsing(function ($className) {
            switch ($className) {
                case HealthHistoryRepository::class:
                    return $this->mockHealthHistoryRepository();
                case HomeSleepTestRepository::class:
                    return $this->mockHomeSleepTestRepository();
                case InsuranceRepository::class:
                    return $this->mockInsuranceRepository();
                case PatientRepository::class:
                    return $this->mockPatientRepository();
                case PatientContactRepository::class:
                    return $this->mockPatientContactRepository();
                case PatientInsuranceRepository::class:
                    return $this->mockPatientInsuranceRepository();
            }
            return null;
        });
        return $repositoryFactory;
    }

    private function mockPatientContactRepository()
    {
        /** @var PatientContactRepository|MockInterface $patientContactRepository */
        $patientContactRepository = \Mockery::mock(PatientContactRepository::class);
        $patientContactRepository->shouldReceive('getCurrent')->andReturnUsing(function () {
            return [1, 2, 3];
        });
        return $patientContactRepository;
    }

    private function mockPatientInsuranceRepository()
    {
        /** @var PatientInsuranceRepository|MockInterface $patientInsuranceRepository */
        $patientInsuranceRepository = \Mockery::mock(PatientInsuranceRepository::class);
        $patientInsuranceRepository->shouldReceive('getCurrent')->andReturnUsing(function () {
            return [1, 2, 3, 4];
        });
        return $patientInsuranceRepository;
    }

    private function mockInsuranceRepository()
    {
        /** @var InsuranceRepository|MockInterface $insuranceRepository */
        $insuranceRepository = \Mockery::mock(InsuranceRepository::class);
        $insuranceRepository->shouldReceive('getRejected')->andReturnUsing(function () {
            return $this->rejectedClaims;
        });
        return $insuranceRepository;
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('getNumberByPatient')->andReturnUsing(function () {
            return $this->children;
        });
        return $patientRepository;
    }

    private function mockHealthHistoryRepository()
    {
        /** @var HealthHistoryRepository|MockInterface $healthHistoryRepository */
        $healthHistoryRepository = \Mockery::mock(HealthHistoryRepository::class);
        $healthHistoryRepository->shouldReceive('findByField')->andReturnUsing(function () {
            return $this->healthHistories;
        });
        return $healthHistoryRepository;
    }

    private function mockHomeSleepTestRepository()
    {
        /** @var HomeSleepTestRepository|MockInterface $homeSleepTestRepository */
        $homeSleepTestRepository = \Mockery::mock(HomeSleepTestRepository::class);
        $homeSleepTestRepository->shouldReceive('getIncomplete')->andReturnUsing(function () {
            return $this->incompleteHSTs;
        });
        return $homeSleepTestRepository;
    }
}
