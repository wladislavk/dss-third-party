<?php

namespace DentalSleepSolutions\Helpers\LetterTriggers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\LetterCreator;
use DentalSleepSolutions\Structs\LetterData;

abstract class AbstractLetterTrigger
{
    /** @var LetterCreator */
    protected $letterCreator;

    /** @var LetterRepository */
    protected $letterRepository;

    public function __construct(LetterCreator $letterCreator, LetterRepository $letterRepository)
    {
        $this->letterCreator = $letterCreator;
        $this->letterRepository = $letterRepository;
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @param int $userId
     * @param int $userType
     * @param array $params
     * @return void
     * @throws \Prettus\Validator\Exceptions\ValidatorException
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
