<?php

namespace DentalSleepSolutions\Helpers\LetterTriggers;

use DentalSleepSolutions\Eloquent\Dental\Letter;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\LetterCreator;
use DentalSleepSolutions\Structs\LetterData;

abstract class AbstractLetterTrigger
{
    /** @var LetterCreator */
    protected $letterCreator;

    /** @var Letter */
    protected $letterModel;

    public function __construct(LetterCreator $letterCreator, Letter $letterModel)
    {
        $this->letterCreator = $letterCreator;
        $this->letterModel = $letterModel;
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @param int $userId
     * @param int $userType
     * @param array $params
     * @return void
     */
    public function trigger($patientId, $docId, $userId, $userType = 0, array $params = [])
    {
        $this->checkParams($params);
        $letterData = new LetterData();
        $letterData->patientId = $patientId;
        $shouldBeSent = $this->fillLetterData($letterData, $patientId, $docId, $params);
        if (!$shouldBeSent) {
            return;
        }
        $templateIds = $this->getTemplateIds($userType);
        foreach ($templateIds as $templateId) {
            $this->letterCreator->createLetter($templateId, $letterData, $docId, $userId);
        }
    }

    /**
     * @param array $params
     * @throws GeneralException
     */
    protected function checkParams(array $params)
    {
        // do nothing
    }

    /**
     * @param LetterData $letterData
     * @param int $patientId
     * @param int $docId
     * @param array $params
     * @return bool
     */
    abstract protected function fillLetterData(LetterData $letterData, $patientId, $docId, array $params);

    /**
     * @param int $userType
     * @return int[]
     */
    abstract protected function getTemplateIds($userType);
}
