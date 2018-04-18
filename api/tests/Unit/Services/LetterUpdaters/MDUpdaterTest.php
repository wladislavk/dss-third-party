<?php

namespace Tests\Unit\Services\LetterUpdaters;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Services\LetterUpdaters\MDUpdater;
use DentalSleepSolutions\Structs\LetterData;
use Tests\TestCases\UnitTestCase;

class MDUpdaterTest extends UnitTestCase
{
    /** @var MDUpdater */
    private $mdUpdater;

    public function setUp()
    {
        $this->mdUpdater = new MDUpdater();
    }

    public function testGetUpdatedFields()
    {
        $updatedFields = $this->mdUpdater->getUpdatedFields();
        $this->assertEquals(['md_list', 'cc_md_list'], $updatedFields);
    }

    public function testUpdateDataBeforeDeleting()
    {
        $letter = new Letter();
        $letter->md_list = '1,2,3';
        $letter->cc_md_list = '2,4,5';
        $recipientId = 2;
        $newLetterData = new LetterData();
        $dataForUpdate = new LetterData();
        $this->mdUpdater->updateDataBeforeDeleting(
            $letter, $recipientId, $newLetterData, $dataForUpdate
        );
        $this->assertEquals(2, $newLetterData->mdList);
        $this->assertEquals('1,3', $dataForUpdate->mdList);
        $this->assertEquals('4,5', $dataForUpdate->ccMdList);
    }
}
