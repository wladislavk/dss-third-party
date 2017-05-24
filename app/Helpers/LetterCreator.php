<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Letter;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Structs\LetterData;

class LetterCreator
{
    /** @var LetterCreationEvaluator */
    private $letterCreationEvaluator;

    /** @var User */
    private $userModel;

    /** @var Letter */
    private $letterModel;

    public function __construct(
        LetterCreationEvaluator $letterCreationEvaluator,
        User $userModel,
        Letter $letterModel
    ) {
        $this->letterCreationEvaluator = $letterCreationEvaluator;
        $this->userModel = $userModel;
        $this->letterModel = $letterModel;
    }

    /**
     * @param int $templateId
     * @param LetterData $letterData
     * @param int $docId
     * @param int $userId
     * @return int
     */
    public function createLetter($templateId, LetterData $letterData, $docId, $userId) {
        if ($docId > 0) {
            $foundUsers = $this->userModel->getWithFilter(
                ['use_letters'],
                ['userid' => $docId]
            );

            $doctor = null;
            if (isset($foundUsers[0])) {
                $doctor = $foundUsers[0];
            }

            if (!empty($doctor) && $doctor->use_letters != 1) {
                return 0;
            }
        }

        if (!$this->letterCreationEvaluator->shouldLetterBeCreated($letterData, $templateId)) {
            return 0;
        }

        //To remove referral source from md list if exists
        $mdArray = explode(',', $letterData->mdList);

        if (($key = array_search($letterData->mdReferralList, $mdArray)) !== false) {
            unset($mdArray[$key]);
        }

        $letterData->mdList = implode(',', $mdArray);
        $letterData->userId = $userId;
        $letterData->docId = $docId;

        $createdLetter = $this->letterModel->createLetter($letterData);

        if ($createdLetter) {
            return $createdLetter->letterid;
        }
        return 0;
    }
}
