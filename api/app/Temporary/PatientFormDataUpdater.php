<?php

namespace DentalSleepSolutions\Temporary;

// TODO: this class was created as temporary means to handle this ugly array
// TODO: this array has to be destroyed and laravel-ized into a proper model, then this class will be destroyed
use DentalSleepSolutions\Constants\PatientContactFields;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Services\Patients\PatientFormDataChecker;
use DentalSleepSolutions\Services\Patients\PatientPortalRetriever;
use DentalSleepSolutions\Services\Patients\UniqueLoginGenerator;
use DentalSleepSolutions\Structs\MDContacts;
use DentalSleepSolutions\Structs\PatientName;
use DentalSleepSolutions\Structs\PatientReferrer;

class PatientFormDataUpdater
{
    const INSURANCE_INFO_FIELDS = [
        'p_m_relation',
        'p_m_partyfname',
        'p_m_partylname',
        'ins_dob',
        'p_m_ins_type',
        'p_m_ins_ass',
        'p_m_ins_id',
        'p_m_ins_grp',
        'p_m_ins_plan',
    ];

    /** @var array */
    private $patientFormData = [];

    /** @var PatientPortalRetriever */
    private $patientPortalRetriever;

    /** @var UniqueLoginGenerator */
    private $uniqueLoginGenerator;

    /** @var PatientFormDataChecker */
    private $patientFormDataChecker;

    public function __construct(
        PatientPortalRetriever $patientPortalRetriever,
        UniqueLoginGenerator $uniqueLoginGenerator,
        PatientFormDataChecker $patientFormDataChecker
    ) {
        $this->patientPortalRetriever = $patientPortalRetriever;
        $this->uniqueLoginGenerator = $uniqueLoginGenerator;
        $this->patientFormDataChecker = $patientFormDataChecker;
    }

    /**
     * @param array $patientFormData
     */
    public function setPatientFormData(array $patientFormData): void
    {
        $this->patientFormData = $patientFormData;
    }

    /**
     * @return array
     */
    public function getPatientFormData(): array
    {
        return $this->patientFormData;
    }

    /**
     * @return int
     */
    public function getPatientLocation(): int
    {
        $patientLocation = 0;
        if (!empty($this->patientFormData['location'])) {
            $patientLocation = (int)$this->patientFormData['location'];
        }
        unset($this->patientFormData['location']);
        return $patientLocation;
    }

    /**
     * @param Patient|null $patient
     */
    public function setEmailBounce(?Patient $patient = null): void
    {
        if (isset($this->patientFormData['email']) && $this->patientFormData['email'] != $patient->email) {
            $this->patientFormData['email_bounce'] = 0;
        }
    }

    /**
     * @param string $existingLogin
     */
    public function modifyLogin(string $existingLogin): void
    {
        if ($existingLogin != '') {
            return;
        }
        $uniqueLogin = $this->uniqueLoginGenerator->generateUniquePatientLogin(
            $this->patientFormData['firstname'], $this->patientFormData['lastname']
        );
        $this->patientFormData['login'] = $uniqueLogin;
    }

    /**
     * @param int $docId
     * @return bool
     */
    public function getHasPatientPortal(int $docId): bool
    {
        if (!isset($this->patientFormData['use_patient_portal'])) {
            return false;
        }
        $hasPatientPortal = $this->patientPortalRetriever
            ->hasPatientPortal($docId, $this->patientFormData['use_patient_portal']);
        return $hasPatientPortal;
    }

    /**
     * @return PatientName
     */
    public function getPatientName(): PatientName
    {
        $patientName = new PatientName();
        $patientName->firstName = $this->patientFormData['firstname'];
        if (isset($this->patientFormData['lastname'])) {
            $patientName->lastName = $this->patientFormData['lastname'];
        }
        if (isset($this->patientFormData['middlename'])) {
            $patientName->middleName = $this->patientFormData['middlename'];
        }
        return $patientName;
    }

    /**
     * @return bool
     */
    public function shouldSendIntroLetter(): bool
    {
        if (isset($this->patientFormData['introletter']) && $this->patientFormData['introletter'] == 1) {
            return true;
        }
        return false;
    }

    /**
     * @return MDContacts
     */
    public function setMDContacts(): MDContacts
    {
        $contacts = new MDContacts();
        foreach (PatientContactFields::DOC_FIELDS as $docField) {
            if (isset($this->patientFormData[$docField]) && property_exists($contacts, $docField)) {
                $contacts->$docField = $this->patientFormData[$docField];
            }
        }
        return $contacts;
    }

    /**
     * @return bool
     */
    public function isInfoComplete(): bool
    {
        return $this->patientFormDataChecker->isInfoComplete($this->patientFormData);
    }

    /**
     * @return int
     */
    public function getSSN(): int
    {
        if (isset($this->patientFormData['ssn'])) {
            return (int)$this->patientFormData['ssn'];
        }
        return 0;
    }

    /**
     * @return string
     */
    public function getNewEmail(): string
    {
        if (isset($this->patientFormData['email'])) {
            return $this->patientFormData['email'];
        }
        return '';
    }

    /**
     * @return string
     */
    public function getCellphone(): string
    {
        if (isset($this->patientFormData['cell_phone'])) {
            return $this->patientFormData['cell_phone'];
        }
        return '';
    }

    /**
     * @return PatientReferrer
     */
    public function setReferrer(): PatientReferrer
    {
        $referrer = new PatientReferrer();
        if (isset($this->patientFormData['referred_by'])) {
            $referrer->referredBy = $this->patientFormData['referred_by'];
        }
        if (isset($this->patientFormData['referred_source'])) {
            $referrer->source = $this->patientFormData['referred_source'];
        }
        return $referrer;
    }

    /**
     * @return array
     */
    public function setInsuranceInfo(): array
    {
        $insuranceInfo = [];
        foreach (self::INSURANCE_INFO_FIELDS as $field) {
            if (isset($this->patientFormData[$field])) {
                $insuranceInfo[$field] = $this->patientFormData[$field];
            }
        }
        return $insuranceInfo;
    }
}
