<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Structs\LetterData;

class LetterCreator
{
    /** @var LetterCreationEvaluator */
    private $letterCreationEvaluator;

    /** @var UserRepository */
    private $userRepository;

    /** @var LetterRepository */
    private $letterRepository;

    public function __construct(
        LetterCreationEvaluator $letterCreationEvaluator,
        UserRepository $userRepository,
        LetterRepository $letterRepository
    ) {
        $this->letterCreationEvaluator = $letterCreationEvaluator;
        $this->userRepository = $userRepository;
        $this->letterRepository = $letterRepository;
    }

    /**
     * @param int $templateId
     * @param LetterData $letterData
     * @param int $docId
     * @param int $userId
     * @return int
     */
    public function createLetter($templateId, LetterData $letterData, $docId, $userId) {
        if (!$this->letterCreationEvaluator->shouldLetterBeCreated($letterData, $templateId)) {
            return 0;
        }
        if ($docId > 0 && !$this->checkUseLetters($docId)) {
            return 0;
        }

        $this->removeReferralSourceFromMDList($letterData);
        $letterData->userId = $userId;
        $letterData->docId = $docId;

        $createdLetter = $this->letterRepository->createLetter($letterData);

        if ($createdLetter) {
            return $createdLetter->letterid;
        }
        return 0;
    }

    /**
     * @param int $docId
     * @return bool
     */
    private function checkUseLetters($docId)
    {
        $foundUsers = $this->userRepository->getWithFilter(
            ['use_letters'],
            ['userid' => $docId]
        );
        // TODO: this is strange, why do we need only the first one?
        // TODO: perhaps refactor to utilize first() on the model
        if (isset($foundUsers[0]) && !$foundUsers[0]->use_letters) {
            return false;
        }
        return true;
    }

    /**
     * @param LetterData $letterData
     */
    private function removeReferralSourceFromMDList(LetterData $letterData)
    {
        $mdArray = explode(',', $letterData->mdList);
        // TODO: this logic rests on assumption that there can be no more than one referral in the list
        // TODO: we need to check this assumption
        if (($key = array_search($letterData->mdReferralList, $mdArray)) !== false) {
            unset($mdArray[$key]);
        }
        $letterData->mdList = implode(',', $mdArray);
    }
}
