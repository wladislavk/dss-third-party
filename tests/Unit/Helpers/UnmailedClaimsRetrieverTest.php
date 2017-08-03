<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Insurance;
use DentalSleepSolutions\Eloquent\Repositories\Dental\InsuranceRepository;
use DentalSleepSolutions\Helpers\UnmailedClaimsRetriever;
use DentalSleepSolutions\Http\Controllers\InsurancesController;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class UnmailedClaimsRetrieverTest extends UnitTestCase
{
    /** @var Insurance */
    private $claims;

    /** @var Insurance */
    private $softwareClaims;

    /** @var UnmailedClaimsRetriever */
    private $unmailedClaimsRetriever;

    public function setUp()
    {
        $this->claims = new Insurance();
        $this->claims->insuranceid = 1;
        $this->softwareClaims = new Insurance();
        $this->softwareClaims->insuranceid = 2;

        $insuranceRepository = $this->mockInsuranceRepository();
        $this->unmailedClaimsRetriever = new UnmailedClaimsRetriever($insuranceRepository);
    }

    public function testGetUnmailedClaims()
    {
        $docId = 1;
        $userType = InsurancesController::DSS_USER_TYPE_FRANCHISEE;
        /** @var Insurance $claims */
        $claims = $this->unmailedClaimsRetriever->getUnmailedClaims($docId, $userType);
        $this->assertEquals(1, $claims->insuranceid);
    }

    public function testWithSoftware()
    {
        $docId = 1;
        $userType = InsurancesController::DSS_USER_TYPE_SOFTWARE;
        /** @var Insurance $claims */
        $claims = $this->unmailedClaimsRetriever->getUnmailedClaims($docId, $userType);
        $this->assertEquals(2, $claims->insuranceid);
    }

    private function mockInsuranceRepository()
    {
        /** @var InsuranceRepository|MockInterface $insuranceRepository */
        $insuranceRepository = \Mockery::mock(InsuranceRepository::class);
        $insuranceRepository->shouldReceive('getUnmailedClaims')
            ->andReturnUsing(function () {
                return $this->claims;
            });
        $insuranceRepository->shouldReceive('getUnmailedClaimsForSoftware')
            ->andReturnUsing(function () {
                return $this->softwareClaims;
            });
        return $insuranceRepository;
    }
}
