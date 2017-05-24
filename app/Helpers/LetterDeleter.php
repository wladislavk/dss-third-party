<?php

namespace DentalSleepSolutions\Helpers;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Dental\Fax;
use DentalSleepSolutions\Eloquent\Dental\Letter;
use DentalSleepSolutions\Factories\LetterUpdaterFactory;
use DentalSleepSolutions\Structs\ContactData;
use DentalSleepSolutions\Structs\LetterData;

class LetterDeleter
{
    /** @var GeneralHelper */
    private $generalHelper;

    /** @var LetterCreator */
    private $letterCreator;

    /** @var LetterUpdaterFactory */
    private $letterUpdaterFactory;

    /** @var Letter */
    private $letterModel;

    /** @var Fax */
    private $faxModel;

    public function __construct(
        GeneralHelper $generalHelper,
        LetterCreator $letterCreator,
        LetterUpdaterFactory $letterUpdaterFactory,
        Letter $letterModel,
        Fax $faxModel
    ) {
        $this->generalHelper = $generalHelper;
        $this->letterCreator = $letterCreator;
        $this->letterUpdaterFactory = $letterUpdaterFactory;
        $this->letterModel = $letterModel;
        $this->faxModel = $faxModel;
    }

    /**
     * TODO: check why we need the last argument
     *
     * @param int $letterId
     * @param $type
     * @param int $recipientId
     * @param int $docId
     * @param int $userId
     * @param null $template
     */
    public function deleteLetter($letterId, $type, $recipientId, $docId, $userId, $template = null)
    {
        if ($letterId <= 0) {
            return;
        }
        /** @var Letter|null $letter */
        $letter = $this->letterModel->find($letterId);
        if (!$letter) {
            return;
        }
        $patientId = 0;
        if ($letter->topatient) {
            $patientId = $letter->patientid;
        }
        $contactData = $this->generalHelper->getContactInfo(
            $patientId,
            $letter->md_list,
            $letter->md_referral_list,
            $letter->pat_referral_list
        );
        $totalContacts = $this->getTotalContacts($contactData);
        if ($totalContacts == 1) {
            $this->deleteLetterWithSingleContact($letterId, $userId);
            return;
        }
        $newLetterData = new LetterData();
        $newLetterData->deleted = true;

        $dataForUpdate = new LetterData();
        $letterUpdater = $this->letterUpdaterFactory->getLetterUpdater($type);
        $letterUpdater->updateDataBeforeDeleting($letter, $recipientId, $newLetterData, $dataForUpdate);
        $updatedFields = $letterUpdater->getUpdatedFields();

        $newLetterData->patientId = $letter->patientid;
        $newLetterData->infoId = $letter->info_id;
        $newLetterData->parentId = $letterId;
        $newLetterData->template = $template;
        $newLetterData->sendMethod = $letter->send_method;
        $newLetterData->status = false;
        $newLetterData->checkRecipient = false;

        $newLetterId = $this->letterCreator->createLetter(
            $letter->templateid, $newLetterData, $docId, $userId
        );

        if ($newLetterId > 0) {
            $where = ['letterid' => $letterId];
            $this->letterModel->updateLetterBy($where, $dataForUpdate, $updatedFields);
        }
    }

    /**
     * @param int $letterId
     * @param int $userId
     * @return bool|int
     */
    private function deleteLetterWithSingleContact($letterId, $userId)
    {
        $where = ['letterid' => $letterId];
        $updatedFields = ['parentid', 'deleted', 'deleted_by', 'deleted_on'];
        $data = new LetterData();
        $data->deleted = true;
        $data->deletedBy = $userId;
        $data->deletedOn = Carbon::now();

        $updatedLetter = $this->letterModel->updateLetterBy($where, $data, $updatedFields);

        $data = ['viewed' => 1];
        $this->faxModel->updateByLetterId($letterId, $data);

        $where = ['parentid' => $letterId];
        $updatedFields = ['parentid'];
        $data = new LetterData();
        $this->letterModel->updateLetterBy($where, $data, $updatedFields);

        return $updatedLetter;
    }

    /**
     * @param ContactData $contactData
     * @return int
     */
    private function getTotalContacts(ContactData $contactData)
    {
        $totalContacts =
            count($contactData->getPatients())
            +
            count($contactData->getMds())
            +
            count($contactData->getMdReferrals())
            +
            count($contactData->getPatientReferrals())
        ;
        return $totalContacts;
    }
}
