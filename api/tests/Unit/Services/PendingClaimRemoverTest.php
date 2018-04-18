<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Eloquent\Repositories\Dental\InsuranceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Services\PendingClaimRemover;
use DentalSleepSolutions\Http\Controllers\InsurancesController;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PendingClaimRemoverTest extends UnitTestCase
{
    /** @var bool */
    private $isSuccess = true;

    /** @var array */
    private $updated = [];

    /** @var PendingClaimRemover */
    private $pendingClaimRemover;

    public function setUp()
    {
        $insuranceRepository = $this->mockInsuranceRepository();
        $ledgerRepository = $this->mockLedgerRepository();
        $this->pendingClaimRemover = new PendingClaimRemover($insuranceRepository, $ledgerRepository);
    }

    public function testRemovePendingClaim()
    {
        $claimId = 1;
        $this->pendingClaimRemover->removePendingClaim($claimId);
        $expected = [
            'primary_claim_id' => null,
            'status' => InsurancesController::DSS_TRXN_NA,
        ];
        $this->assertEquals($expected, $this->updated);
    }

    public function testUnsuccessfulAttempt()
    {
        $this->isSuccess = false;
        $claimId = 1;
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Could not remove pending claim');
        $this->pendingClaimRemover->removePendingClaim($claimId);
    }

    private function mockInsuranceRepository()
    {
        /** @var InsuranceRepository|MockInterface $insuranceRepository */
        $insuranceRepository = \Mockery::mock(InsuranceRepository::class);
        $insuranceRepository->shouldReceive('removePendingClaim')
            ->andReturnUsing(function () {
                return $this->isSuccess;
            });
        return $insuranceRepository;
    }

    private function mockLedgerRepository()
    {
        /** @var LedgerRepository|MockInterface $ledgerRepository */
        $ledgerRepository = \Mockery::mock(LedgerRepository::class);
        $ledgerRepository->shouldReceive('updateWherePrimaryClaimId')
            ->andReturnUsing(function ($claimId, array $data) {
                $this->updated = $data;
            });
        return $ledgerRepository;
    }
}
