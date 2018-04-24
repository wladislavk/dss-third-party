<?php

namespace Tests\Unit\Services\Letters;

use DentalSleepSolutions\Constants\SummaryLetterTable;
use DentalSleepSolutions\Services\AppointmentSummaries\DoctorIDRetriever;
use DentalSleepSolutions\Services\Letters\SummaryLetterDataUpdater;
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class SummaryLetterDataUpdaterTest extends UnitTestCase
{
    private const LETTER_ID = 42;
    private const MD_CONTACT_IDS = [1, 2, 3];
    private const MD_REFERRAL_IDS = [1, 3];

    /** @var array */
    private $tableElement = [
        SummaryLetterTable::TO_PATIENT_COLUMN => true,
        SummaryLetterTable::LETTER_ID_COLUMN => self::LETTER_ID,
        SummaryLetterTable::MD_LIST_COLUMN => false,
        SummaryLetterTable::MD_REFERRAL_LIST_COLUMN => false,
    ];

    /** @var int[] */
    private $mdList = [];

    /** @var int[] */
    private $mdReferralList = [];

    /** @var SummaryLetterDataUpdater */
    private $summaryLetterDataUpdater;

    public function setUp()
    {
        $doctorIDRetriever = $this->mockDoctorIDRetriever();
        $this->summaryLetterDataUpdater = new SummaryLetterDataUpdater($doctorIDRetriever);
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithoutMdLists()
    {
        $data = new SummaryLetterTriggerData();
        $this->summaryLetterDataUpdater->completeSummaryLetterData($data, $this->tableElement);
        $this->assertEquals(self::LETTER_ID, $data->letterId);
        $this->assertTrue($data->toPatient);
        $this->assertEquals([], $data->mdList);
        $this->assertEquals([], $data->mdReferralList);
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithMdLists()
    {
        $this->tableElement[SummaryLetterTable::MD_LIST_COLUMN] = true;
        $this->tableElement[SummaryLetterTable::MD_REFERRAL_LIST_COLUMN] = true;
        $this->mdList = self::MD_CONTACT_IDS;
        $this->mdReferralList = self::MD_REFERRAL_IDS;

        $data = new SummaryLetterTriggerData();
        $this->summaryLetterDataUpdater->completeSummaryLetterData($data, $this->tableElement);
        $this->assertEquals([2], $data->mdList);
        $this->assertEquals([1, 3], $data->mdReferralList);
    }

    private function mockDoctorIDRetriever()
    {
        /** @var DoctorIDRetriever|MockInterface $doctorIDRetriever */
        $doctorIDRetriever = \Mockery::mock(DoctorIDRetriever::class);
        $doctorIDRetriever->shouldReceive('getMdContactIds')->andReturnUsing(function () {
            return $this->mdList;
        });
        $doctorIDRetriever->shouldReceive('getMdReferralIds')->andReturnUsing(function () {
            return $this->mdReferralList;
        });
        return $doctorIDRetriever;
    }
}
