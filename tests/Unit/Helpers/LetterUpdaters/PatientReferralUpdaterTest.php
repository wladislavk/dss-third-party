<?php

namespace Tests\Unit\Helpers\LetterUpdaters;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Helpers\LetterUpdaters\PatientReferralUpdater;
use DentalSleepSolutions\Structs\LetterData;
use Tests\TestCases\UnitTestCase;

class PatientReferralUpdaterTest extends UnitTestCase
{
    /** @var PatientReferralUpdater */
    private $patientReferralUpdater;

    public function setUp()
    {
        $this->patientReferralUpdater = new PatientReferralUpdater();
    }

    public function testGetUpdatedFields()
    {
        $updatedFields = $this->patientReferralUpdater->getUpdatedFields();
        $this->assertEquals(['pat_referral_list', 'cc_pat_referral_list'], $updatedFields);
    }

    public function testUpdateDataBeforeDeleting()
    {
        $letter = new Letter();
        $letter->pat_referral_list = '1,2,3';
        $letter->cc_pat_referral_list = '2,4,5';
        $recipientId = 2;
        $newLetterData = new LetterData();
        $dataForUpdate = new LetterData();
        $this->patientReferralUpdater->updateDataBeforeDeleting(
            $letter, $recipientId, $newLetterData, $dataForUpdate
        );
        $this->assertEquals(2, $newLetterData->patientReferralList);
        $this->assertEquals('1,3', $dataForUpdate->patientReferralList);
        $this->assertEquals('4,5', $dataForUpdate->ccPatientReferralList);
    }
}
