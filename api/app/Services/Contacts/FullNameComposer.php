<?php

namespace DentalSleepSolutions\Services\Contacts;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Factories\ReferredNameSetterFactory;
use DentalSleepSolutions\Temporary\PatientFormDataUpdater;

class FullNameComposer
{
    const VALUE_NOT_SET = 'Not Set';

    /** @var ReferredNameSetterFactory */
    private $referredNameSetterFactory;

    /** @var NameSetter */
    private $nameSetter;

    /** @var ContactRepository */
    private $contactRepository;

    public function __construct(
        ReferredNameSetterFactory $referredNameSetterFactory,
        NameSetter $nameSetter,
        ContactRepository $contactRepository
    ) {
        $this->referredNameSetterFactory = $referredNameSetterFactory;
        $this->nameSetter = $nameSetter;
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param Patient $foundPatient
     * @return array
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     */
    public function getFormedFullNames(Patient $foundPatient)
    {
        $formedFullNames = [];
        foreach (PatientFormDataUpdater::DOC_FIELDS as $field) {
            $nameField = $field . '_name';
            $name = $this->setNameForDocField($foundPatient, $field);
            $formedFullNames[$nameField] = $name;
        }

        $formedFullNames['ins_payer_name'] = '';
        if ($foundPatient->p_m_eligible_payer_id) {
            $payerName = $this->formPayerName(
                $foundPatient->p_m_eligible_payer_id,
                $foundPatient->p_m_eligible_payer_name
            );
            $formedFullNames['ins_payer_name'] = $payerName;
        }

        $formedFullNames['s_m_ins_payer_name'] = '';
        if ($foundPatient->s_m_eligible_payer_id) {
            $payerName = $this->formPayerName(
                $foundPatient->s_m_eligible_payer_id,
                $foundPatient->s_m_eligible_payer_name
            );
            $formedFullNames['s_m_ins_payer_name'] = $payerName;
        }

        $referredNameSetter = $this->referredNameSetterFactory
            ->getReferredNameSetter($foundPatient->referred_source);
        $referredName = $referredNameSetter->setReferredName($foundPatient);
        $formedFullNames['referred_name'] = '';
        if ($referredName) {
            $formedFullNames['referred_name'] = $referredName;
        }

        return $formedFullNames;
    }

    /**
     * @param Patient $foundPatient
     * @param string $field
     * @return string|null
     */
    private function setNameForDocField(Patient $foundPatient, $field)
    {
        if (!isset($foundPatient->$field)) {
            return '';
        }
        $shortInfo = $this->contactRepository->getDocShortInfo($foundPatient->$field);
        if (!$shortInfo) {
            return '';
        }
        return $this->getDocNameFromShortInfo($foundPatient->$field, $shortInfo);
    }

    /**
     * @param string $field
     * @param Contact $shortInfo
     * @return string
     */
    private function getDocNameFromShortInfo($field, Contact $shortInfo)
    {
        $name = '';
        if ($field != self::VALUE_NOT_SET && $shortInfo) {
            // TODO: does Contact model have contacttype property?
            $name = $this->nameSetter->formFullName(
                $shortInfo->firstname,
                $shortInfo->middlename,
                $shortInfo->lastname,
                $shortInfo->contacttype
            );
        }

        return $name;
    }

    /**
     * @param int $payerId
     * @param string $originalPayerName
     * @return string
     */
    private function formPayerName($payerId, $originalPayerName)
    {
        return "$payerId - $originalPayerName";
    }
}
