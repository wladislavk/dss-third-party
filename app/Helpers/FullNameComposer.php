<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Contact;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Factories\ReferredNameSetterFactory;

class FullNameComposer
{
    // TODO: deja vu... several similar-looking field array constants need a service for retrieving them
    // TODO: ideally, these constants need to be replaced by a model interface
    const DOC_FIELDS = [
        'docsleep',
        'docpcp',
        'docdentist',
        'docent',
        'docmdother',
        'docmdother2',
        'docmdother3',
    ];

    const VALUE_NOT_SET = 'Not Set';

    /** @var ReferredNameSetterFactory */
    private $referredNameSetterFactory;

    /** @var NameSetter */
    private $nameSetter;

    /** @var Contact */
    private $contactModel;

    public function __construct(
        ReferredNameSetterFactory $referredNameSetterFactory,
        NameSetter $nameSetter,
        Contact $contactModel
    ) {
        $this->referredNameSetterFactory = $referredNameSetterFactory;
        $this->nameSetter = $nameSetter;
        $this->contactModel = $contactModel;
    }

    /**
     * @param Patient $foundPatient
     * @return array
     */
    public function getFormedFullNames(Patient $foundPatient)
    {
        $formedFullNames = [];
        foreach (self::DOC_FIELDS as $field) {
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
     * @return string|null
     */
    private function setNameForDocField(Patient $foundPatient, $field)
    {
        if (!isset($foundPatient->$field)) {
            return '';
        }
        $shortInfo = $this->contactModel->getDocShortInfo($foundPatient->$field);
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
