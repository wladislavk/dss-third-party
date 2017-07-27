<?php

namespace Tests\TestCases;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Helpers\LetterCreator;
use DentalSleepSolutions\Structs\LetterData;
use Mockery\MockInterface;

class LetterTriggerTestCase extends UnitTestCase
{
    /** @var array  */
    protected $createdLetters = [];

    /** @var bool */
    protected $shouldHaveLetters = false;

    protected function mockLetterCreator()
    {
        /** @var LetterCreator|MockInterface $letterCreator */
        $letterCreator = \Mockery::mock(LetterCreator::class);
        $letterCreator->shouldReceive('createLetter')
            ->andReturnUsing([$this, 'createLetterCallback']);
        return $letterCreator;
    }

    protected function mockLetterRepository()
    {
        /** @var LetterRepository|MockInterface $letterRepository */
        $letterRepository = \Mockery::mock(LetterRepository::class);
        $letterRepository->shouldReceive('getMdList')
            ->andReturnUsing([$this, 'getMdListCallback']);
        $letterRepository->shouldReceive('getPatientTreatmentComplete')
            ->andReturnUsing([$this, 'getPatientTreatmentCompleteCallback']);
        return $letterRepository;
    }

    public function createLetterCallback($templateId, LetterData $letterData, $docId, $userId)
    {
        $this->createdLetters[] = [
            'templateId' => $templateId,
            'letterData' => $letterData,
            'docId' => $docId,
            'userId' => $userId,
        ];
    }

    public function getMdListCallback($contactId)
    {
        if (!in_array($contactId, [0, 1, 2])) {
            return [];
        }
        return ['foo'];
    }

    public function getPatientTreatmentCompleteCallback()
    {
        if (!$this->shouldHaveLetters) {
            return [];
        }
        return ['foo'];
    }
}
