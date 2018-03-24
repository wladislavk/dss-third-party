<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Helpers\LetterDeleter;
use DentalSleepSolutions\Helpers\LetterManager;
use DentalSleepSolutions\Structs\PatientReferrer;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class LetterManagerTest extends UnitTestCase
{
    private $letterIds = [1, 2];

    /** @var array */
    private $updatedLetters = [];

    /** @var array */
    private $deletedLetters = [];

    /** @var Patient */
    private $unchangedPatient;

    /** @var PatientReferrer */
    private $referrer;

    /** @var LetterManager */
    private $letterManager;

    public function setUp()
    {
        $this->unchangedPatient = new Patient();
        $this->unchangedPatient->patientid = 5;
        $this->referrer = new PatientReferrer();

        $letterDeleter = $this->mockLetterDeleter();
        $letterRepository = $this->mockLetterRepository();
        $this->letterManager = new LetterManager($letterDeleter, $letterRepository);
    }

    public function testWithReferrerChange()
    {
        $this->unchangedPatient->referred_source = LetterManager::PHYSICIAN_REFERRED_SOURCE;
        $this->unchangedPatient->referred_by = 11;
        $this->referrer->source = LetterManager::PATIENT_REFERRED_SOURCE;
        $this->referrer->referredBy = 12;
        $docId = 1;
        $userId = 2;
        $this->letterManager->manageLetters($docId, $userId, $this->unchangedPatient, $this->referrer);
        $expected = [];
        foreach ($this->letterIds as $letterId) {
            $expected[] = [
                'letterId' => $letterId,
                'type' => LetterManager::DELETE_TYPES[LetterManager::PHYSICIAN_REFERRED_SOURCE],
                'recipientId' => 11,
                'docId' => $docId,
                'userId' => $userId,
            ];
        }
        $this->assertEquals([], $this->updatedLetters);
        $this->assertEquals($expected, $this->deletedLetters);
    }

    public function testWithoutReferrerChange()
    {
        $this->unchangedPatient->referred_source = LetterManager::PHYSICIAN_REFERRED_SOURCE;
        $this->unchangedPatient->referred_by = 11;
        $this->referrer->source = LetterManager::PHYSICIAN_REFERRED_SOURCE;
        $this->referrer->referredBy = 12;
        $docId = 1;
        $userId = 2;
        $this->letterManager->manageLetters($docId, $userId, $this->unchangedPatient, $this->referrer);
        $expected = [
            'oldReferredBy' => 11,
            'newReferredBy' => 12,
            'patientId' => 5,
            'type' => LetterManager::UPDATE_TYPES[LetterManager::PHYSICIAN_REFERRED_SOURCE],
        ];
        $this->assertEquals($expected, $this->updatedLetters);
        $this->assertEquals([], $this->deletedLetters);
    }

    public function testWithBadReferredSource()
    {
        $this->unchangedPatient->referred_source = 100;
        $docId = 1;
        $userId = 2;
        $this->letterManager->manageLetters($docId, $userId, $this->unchangedPatient, $this->referrer);
        $this->assertEquals([], $this->updatedLetters);
        $this->assertEquals([], $this->deletedLetters);
    }

    private function mockLetterDeleter()
    {
        /** @var LetterDeleter|MockInterface $letterDeleter */
        $letterDeleter = \Mockery::mock(LetterDeleter::class);
        $letterDeleter->shouldReceive('deleteLetter')
            ->andReturnUsing([$this, 'deleteLetterCallback']);
        return $letterDeleter;
    }

    private function mockLetterRepository()
    {
        /** @var LetterRepository|MockInterface $letterRepository */
        $letterRepository = \Mockery::mock(LetterRepository::class);
        $letterRepository->shouldReceive('updatePendingLettersToNewReferrer')
            ->andReturnUsing([$this, 'updatePendingLettersToNewReferrerCallback']);
        $letterRepository->shouldReceive('getPhysicianOrPatientPendingLetters')
            ->andReturnUsing([$this, 'getPhysicianOrPatientPendingLettersCallback']);
        return $letterRepository;
    }

    public function updatePendingLettersToNewReferrerCallback($oldReferredBy, $newReferredBy, $patientId, $type)
    {
        $this->updatedLetters = [
            'oldReferredBy' => $oldReferredBy,
            'newReferredBy' => $newReferredBy,
            'patientId' => $patientId,
            'type' => $type,
        ];
    }

    public function getPhysicianOrPatientPendingLettersCallback($referralList, $patientId, $type)
    {
        $letters = [];
        foreach ($this->letterIds as $letterId) {
            $letter = new Letter();
            $letter->letterid = $letterId;
            $letters[] = $letter;
        }
        return $letters;
    }

    public function deleteLetterCallback(Letter $letter, $type, $recipientId, $docId, $userId)
    {
        $this->deletedLetters[] = [
            'letterId' => $letter->letterid,
            'type' => $type,
            'recipientId' => $recipientId,
            'docId' => $docId,
            'userId' => $userId,
        ];
    }
}
