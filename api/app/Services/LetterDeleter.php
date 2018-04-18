<?php

namespace DentalSleepSolutions\Services;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Eloquent\Repositories\Dental\FaxRepository;
use DentalSleepSolutions\Factories\LetterUpdaterFactory;
use DentalSleepSolutions\Services\QueryComposers\LettersQueryComposer;
use DentalSleepSolutions\Structs\ContactData;
use DentalSleepSolutions\Structs\LetterData;

class LetterDeleter
{
    /** @var GeneralHelper */
    private $generalHelper;

    /** @var LetterCreator */
    private $letterCreator;

    /** @var LettersQueryComposer */
    private $lettersQueryComposer;

    /** @var LetterUpdaterFactory */
    private $letterUpdaterFactory;

    /** @var FaxRepository */
    private $faxRepository;

    public function __construct(
        GeneralHelper $generalHelper,
        LetterCreator $letterCreator,
        LettersQueryComposer $lettersQueryComposer,
        LetterUpdaterFactory $letterUpdaterFactory,
        FaxRepository $faxRepository
    ) {
        $this->generalHelper = $generalHelper;
        $this->letterCreator = $letterCreator;
        $this->lettersQueryComposer = $lettersQueryComposer;
        $this->letterUpdaterFactory = $letterUpdaterFactory;
        $this->faxRepository = $faxRepository;
    }

    /**
     * TODO: check why we need the last argument
     *
     * @param Letter $letter
     * @param $type
     * @param int $recipientId
     * @param int $docId
     * @param int $userId
     * @param string|null $template
     */
    public function deleteLetter(Letter $letter, $type, $recipientId, $docId, $userId, $template = null)
    {
        $patientId = $this->setPatientId($letter);
        $contactData = $this->generalHelper->getContactInfo(
            $patientId,
            $letter->md_list,
            $letter->md_referral_list,
            $letter->pat_referral_list
        );
        $totalContacts = $this->getTotalContacts($contactData);
        // TODO: check what should happen if totalContacts == 0
        if ($totalContacts == 1) {
            $this->deleteLetterWithSingleContact($letter->letterid, $userId);
            return;
        }
        $this->deleteLetterWithMultipleContacts(
            $letter, $type, $recipientId, $docId, $userId, $template
        );
    }

    /**
     * @param Letter $letter
     * @return int
     */
    private function setPatientId(Letter $letter)
    {
        $patientId = 0;
        if ($letter->topatient) {
            $patientId = $letter->patientid;
        }
        return $patientId;
    }

    // TODO: the following two methods highly differ in implementation. could they be simplified?

    /**
     * @param int $letterId
     * @param int $userId
     */
    private function deleteLetterWithSingleContact($letterId, $userId)
    {
        $where = ['letterid' => $letterId];
        $updatedFields = ['parentid', 'deleted', 'deleted_by', 'deleted_on'];
        $data = new LetterData();
        $data->deleted = true;
        $data->deletedBy = $userId;
        $data->deletedOn = Carbon::now();

        $firstUpdateArray = $this->composeUpdateData($data, $updatedFields);
        $this->lettersQueryComposer->updateLetterBy($where, $firstUpdateArray);

        $data = ['viewed' => 1];
        $this->faxRepository->updateByLetterId($letterId, $data);

        $where = ['parentid' => $letterId];
        $updatedFields = ['parentid'];
        $data = new LetterData();
        $secondUpdateArray = $this->composeUpdateData($data, $updatedFields);
        $this->lettersQueryComposer->updateLetterBy($where, $secondUpdateArray);
    }

    /**
     * @param Letter $letter
     * @param string $type
     * @param int $recipientId
     * @param int $docId
     * @param int $userId
     * @param string|null $template
     */
    private function deleteLetterWithMultipleContacts(Letter $letter, $type, $recipientId, $docId, $userId, $template)
    {
        $newLetterData = new LetterData();
        $dataForUpdate = new LetterData();

        $letterUpdater = $this->letterUpdaterFactory->getLetterUpdater($type);
        $letterUpdater->updateDataBeforeDeleting($letter, $recipientId, $newLetterData, $dataForUpdate);

        $this->setNewLetterData($newLetterData, $letter, $template);

        $newLetterId = $this->letterCreator->createLetter(
            $letter->templateid, $newLetterData, $docId, $userId
        );

        if ($newLetterId > 0) {
            $where = ['letterid' => $letter->letterid];
            $updatedFields = $letterUpdater->getUpdatedFields();
            $updateArray = $this->composeUpdateData($dataForUpdate, $updatedFields);
            $this->lettersQueryComposer->updateLetterBy($where, $updateArray);
        }
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

    /**
     * @param LetterData $newLetterData
     * @param Letter $letter
     * @param string $template
     */
    private function setNewLetterData(LetterData $newLetterData, Letter $letter, $template)
    {
        $newLetterData->patientId = $letter->patientid;
        $newLetterData->infoId = $letter->info_id;
        $newLetterData->parentId = $letter->letterid;
        $newLetterData->template = $template;
        $newLetterData->sendMethod = $letter->send_method;
        $newLetterData->status = false;
        $newLetterData->deleted = true;
        $newLetterData->checkRecipient = false;
    }

    /**
     * @param LetterData $data
     * @param array $fields
     * @return array
     */
    private function composeUpdateData(LetterData $data, array $fields)
    {
        $dataArray = $data->toArray();
        $updated = [];
        foreach ($fields as $field) {
            if (isset($dataArray[$field])) {
                $updated[$field] = $dataArray[$field];
            }
        }
        return $updated;
    }
}
