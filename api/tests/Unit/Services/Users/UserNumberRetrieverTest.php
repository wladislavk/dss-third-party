<?php

namespace Tests\Unit\Services\Users;

use DentalSleepSolutions\Eloquent\Models\Dental\Insurance;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\SupportTicket;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\InsuranceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PaymentReportRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\SupportTicketRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Factories\RepositoryFactory;
use DentalSleepSolutions\Services\Users\UserNumberRetriever;
use DentalSleepSolutions\Http\Controllers\InsurancesController;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class UserNumberRetrieverTest extends UnitTestCase
{
    /** @var User */
    private $user;

    /** @var string[] */
    private $methods = [
        'payment_reports' => PaymentReportRepository::class . '@getNumber',
        'support_tickets' => SupportTicketRepository::class . '@getNumber',
        'patient_changes' => PatientRepository::class . '@getNumber',
        'unmailed_claims' => InsuranceRepository::class . '@getUnmailedClaims',
        'unmailed_claims_software' => InsuranceRepository::class . '@getUnmailedClaimsForSoftware',
    ];

    /** @var UserNumberRetriever */
    private $userNumberRetriever;

    public function setUp()
    {
        $this->user = new User();
        $this->user->id = 1;
        $this->user->user_type = InsurancesController::DSS_USER_TYPE_FRANCHISEE;

        $repositoryFactory = $this->mockRepositoryFactory();
        $this->userNumberRetriever = new UserNumberRetriever($repositoryFactory);
    }

    /**
     * @throws GeneralException
     */
    public function testAddNumbers()
    {
        $userData = $this->userNumberRetriever->addUserNumbers($this->user, $this->methods);
        $expected = [
            'id' => 1,
            'user_type' => InsurancesController::DSS_USER_TYPE_FRANCHISEE,
            'numbers' => [
                'payment_reports' => 0,
                'support_tickets' => 0,
                'patient_changes' => 2,
                'unmailed_claims' => 5,
                'unmailed_claims_software' => 7,
            ],
            'docid' => 0,
        ];
        $this->assertEquals($expected, $userData);
    }

    /**
     * @throws GeneralException
     */
    public function testWithoutAtChar()
    {
        $this->methods['payment_reports'] = 'foo';
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Value of field payment_reports does not contain \'@\' character');
        $this->userNumberRetriever->addUserNumbers($this->user, $this->methods);
    }

    /**
     * @throws GeneralException
     */
    public function testWithNonexistentMethod()
    {
        $this->methods['support_tickets'] = SupportTicketRepository::class . '@getFoo';
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Method getFoo must exist on repo ' . SupportTicketRepository::class);
        $this->userNumberRetriever->addUserNumbers($this->user, $this->methods);
    }

    /**
     * @throws GeneralException
     */
    public function testWithSoftwareUserType()
    {
        $this->user->user_type = InsurancesController::DSS_USER_TYPE_SOFTWARE;
        $userData = $this->userNumberRetriever->addUserNumbers($this->user, $this->methods);
        $expected = [
            'id' => 1,
            'user_type' => InsurancesController::DSS_USER_TYPE_SOFTWARE,
            'numbers' => [
                'payment_reports' => 0,
                'support_tickets' => 0,
                'patient_changes' => 2,
                'unmailed_claims' => 7,
                'unmailed_claims_software' => 7,
            ],
            'docid' => 0,
        ];
        $this->assertEquals($expected, $userData);
    }

    private function mockRepositoryFactory()
    {
        /** @var RepositoryFactory|MockInterface $repositoryFactory */
        $repositoryFactory = \Mockery::mock(RepositoryFactory::class);
        $repositoryFactory->shouldReceive('getRepository')->andReturnUsing(function ($repoName) {
            switch ($repoName) {
                case PaymentReportRepository::class:
                    return $this->mockPaymentReportRepository();
                case SupportTicketRepository::class:
                    return $this->mockSupportTicketRepository();
                case PatientRepository::class:
                    return $this->mockPatientRepository();
                case InsuranceRepository::class:
                    return $this->mockInsuranceRepository();
            }
            return null;
        });
        return $repositoryFactory;
    }

    private function mockPaymentReportRepository()
    {
        $paymentReportRepository = \Mockery::mock(PaymentReportRepository::class);
        $paymentReportRepository->shouldReceive('getNumber')->andReturnNull();
        return $paymentReportRepository;
    }

    private function mockSupportTicketRepository()
    {
        $supportTicketRepository = \Mockery::mock(SupportTicketRepository::class);
        $supportTicketRepository->shouldReceive('getNumber')->andReturnUsing(function () {
            $model = new SupportTicket();
            $model->id = 1;
            return $model;
        });
        return $supportTicketRepository;
    }

    private function mockPatientRepository()
    {
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('getNumber')->andReturnUsing(function () {
            $model = new Patient();
            $model->total = 2;
            return $model;
        });
        return $patientRepository;
    }

    private function mockInsuranceRepository()
    {
        $insuranceRepository = \Mockery::mock(InsuranceRepository::class);
        $insuranceRepository->shouldReceive('getUnmailedClaims')->andReturnUsing(function () {
            $model = new Insurance();
            $model->total = 5;
            return $model;
        });
        $insuranceRepository->shouldReceive('getUnmailedClaimsForSoftware')->andReturnUsing(function () {
            $model = new Insurance();
            $model->total = 7;
            return $model;
        });
        return $insuranceRepository;
    }
}
