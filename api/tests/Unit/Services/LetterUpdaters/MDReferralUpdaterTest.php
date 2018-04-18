<?php

namespace Tests\Unit\Services\LetterUpdaters;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Services\LetterUpdaters\MDReferralUpdater;
use DentalSleepSolutions\Structs\LetterData;
use Tests\TestCases\UnitTestCase;

class MDReferralUpdaterTest extends UnitTestCase
{
    /** @var MDReferralUpdater */
    private $mdReferralUpdater;

    public function setUp()
    {
        $this->mdReferralUpdater = new MDReferralUpdater();
    }

    public function testGetUpdatedFields()
    {
        $updatedFields = $this->mdReferralUpdater->getUpdatedFields();
        $this->assertEquals(['md_referral_list', 'cc_md_referral_list'], $updatedFields);
    }

    public function testUpdateDataBeforeDeleting()
    {
        $letter = new Letter();
        $letter->md_referral_list = '1,2,3';
        $letter->cc_md_referral_list = '2,4,5';
        $recipientId = 2;
        $newLetterData = new LetterData();
        $dataForUpdate = new LetterData();
        $this->mdReferralUpdater->updateDataBeforeDeleting(
            $letter, $recipientId, $newLetterData, $dataForUpdate
        );
        $this->assertEquals(2, $newLetterData->mdReferralList);
        $this->assertEquals('1,3', $dataForUpdate->mdReferralList);
        $this->assertEquals('4,5', $dataForUpdate->ccMdReferralList);
    }
}
