<?php

namespace DentalSleepSolutions\Helpers\LetterTriggers;

use DentalSleepSolutions\Eloquent\Dental\Contact;
use DentalSleepSolutions\Eloquent\Dental\Letter;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\LetterCreator;
use DentalSleepSolutions\Helpers\MailerDataRetriever;
use DentalSleepSolutions\Structs\LetterData;
use DentalSleepSolutions\Structs\MDContacts;

class LettersToMDTrigger extends AbstractLetterTrigger
{
    const MD_CONTACTS_PARAM = 'mdContacts';

    // TODO: these IDs should not be hardcoded
    const LETTER_TO_MD_FROM_DSS = 1;
    const LETTER_TO_MD_FROM_FRANCHISEE = 2;

    /** @var User */
    private $userModel;

    /** @var Contact */
    private $contactModel;

    public function __construct(
        LetterCreator $letterCreator,
        Letter $letterModel,
        User $userModel,
        Contact $contactModel
    ) {
        parent::__construct($letterCreator, $letterModel);
        $this->userModel = $userModel;
        $this->contactModel = $contactModel;
    }

    /**
     * @param int $userType
     * @return array
     */
    protected function getTemplateIds($userType)
    {
        $templateIds = [self::LETTER_TO_MD_FROM_FRANCHISEE];
        if ($userType == MailerDataRetriever::DSS_USER_TYPE_SOFTWARE) {
            $templateIds[] = self::LETTER_TO_MD_FROM_DSS;
        }
        return $templateIds;
    }

    /**
     * @param LetterData $letterData
     * @param int $patientId
     * @param int $docId
     * @param array $params
     * @return bool
     */
    protected function fillLetterData(LetterData $letterData, $patientId, $docId, array $params)
    {
        $userLetterInfo = $this->getUserLetterInfo($docId);
        if (
            !$userLetterInfo
            ||
            !$userLetterInfo->use_letters
            ||
            !$userLetterInfo->intro_letters
        ) {
            return false;
        }
        $recipients = $this->getRecipientsList($params[self::MD_CONTACTS_PARAM]);
        if (!count($recipients)) {
            return false;
        }
        $recipientsList = implode(',', $recipients);
        $letterData->mdList = $recipientsList;
        return true;
    }

    /**
     * @param MDContacts $mdContacts
     * @return array
     */
    private function getRecipientsList(MDContacts $mdContacts)
    {
        $recipients = [];
        foreach ($mdContacts as $contactId) {
            $foundContact = $this->findContact($contactId);
            if ($foundContact) {
                $recipients[] = $contactId;
            }
        }
        return array_unique($recipients);
    }

    /**
     * @param array $params
     * @throws GeneralException
     */
    protected function checkParams(array $params)
    {
        if (!isset($params[self::MD_CONTACTS_PARAM]) || !$params[self::MD_CONTACTS_PARAM] instanceof MDContacts) {
            throw new GeneralException(
                self::MD_CONTACTS_PARAM . ' key must be present in $params and contain an instance of ' . MDContacts::class
            );
        }
    }

    /**
     * @param int $docId
     * @return User|null
     */
    private function getUserLetterInfo($docId)
    {
        $baseUserLetterInfo = $this->userModel->getWithFilter(
            ['use_letters', 'intro_letters'],
            ['userid' => $docId]
        );
        // TODO: why is only the first entry used? perhaps better to use first() on the model
        if (isset($baseUserLetterInfo[0])) {
            return $baseUserLetterInfo[0];
        }
        return null;
    }

    /**
     * @param int $contactId
     * @return Contact|null
     */
    private function findContact($contactId)
    {
        if ($contactId <= 0) {
            return null;
        }
        $mdLists = $this->letterModel->getMdList(
            $contactId,
            self::LETTER_TO_MD_FROM_DSS,
            self::LETTER_TO_MD_FROM_FRANCHISEE
        );

        if (!count($mdLists)) {
            return null;
        }
        $foundContact = $this->contactModel->getActiveContact($contactId);
        return $foundContact;
    }
}
