<?php

namespace DentalSleepSolutions\Helpers;

// TODO: this class was created as temporary means to handle this ugly array
// TODO: this array has to be destroyed and laravel-ized into a proper model, then this class will be destroyed
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Structs\MDContacts;
use DentalSleepSolutions\Structs\PatientName;

class PatientFormDataUpdater
{
    const DOC_FIELDS = [
        'docsleep',
        'docpcp',
        'docdentist',
        'docent',
        'docmdother',
        'docmdother2',
        'docmdother3',
    ];

    /** @var array */
    private $patientFormData = [];

    /** @var PatientPortalRetriever */
    private $patientPortalRetriever;

    /** @var UniqueLoginGenerator */
    private $uniqueLoginGenerator;

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
    public function setPatientFormData(array $patientFormData)
    {
        $this->patientFormData = $patientFormData;
    }

    /**
     * @return array
     */
    public function getPatientFormData()
    {
        return $this->patientFormData;
    }

    public function getPatientLocation()
    {
        $patientLocation = 0;
        if (!empty($this->patientFormData['location'])) {
            $patientLocation = $this->patientFormData['location'];
        }
        unset($this->patientFormData['location']);
        return $patientLocation;
    }

    /**
     * @param Patient|null $patient
     */
    public function setEmailBounce(Patient $patient = null)
    {
        if ($this->patientFormData['email'] != $patient->email) {
            $this->patientFormData['email_bounce'] = 0;
        }
    }

    /**
     * @param int $docId
     * @return bool
     */
    public function getHasPatientPortal($docId)
    {
        if (!isset($this->patientFormData['use_patient_portal'])) {
            return false;
        }
        $hasPatientPortal = $this->patientPortalRetriever
            ->hasPatientPortal($docId, $this->patientFormData['use_patient_portal']);
        return $hasPatientPortal;
    }

    /**
     * @param string $existingLogin
     */
    public function modifyLogin($existingLogin)
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
     * @return PatientName
     */
    public function getPatientName()
    {
        $patientName = new PatientName();
        $patientName->firstName = $this->patientFormData['firstname'];
        $patientName->lastName = $this->patientFormData['lastname'];
        if (isset($this->patientFormData['middlename'])) {
            $patientName->middleName = $this->patientFormData['middlename'];
        }
        return $patientName;
    }

    /**
     * @return bool
     */
    public function shouldSendIntroLetter()
    {
        if (isset($this->patientFormData['introletter']) && $this->patientFormData['introletter'] == 1) {
            return true;
        }
        return false;
    }

    public function setMDContacts()
    {
        $contacts = new MDContacts();
        foreach (self::DOC_FIELDS as $docField) {
            if (isset($this->patientFormData[$docField]) && property_exists($contacts, $docField)) {
                $contacts->$docField = $this->patientFormData[$docField];
            }
        }
        return $contacts;
    }

    /**
     * @return bool
     */
    public function isInfoComplete()
    {
        return $this->patientFormDataChecker->isInfoComplete($this->patientFormData);
    }

    /**
     * @return int
     */
    public function getSSN()
    {
        if (isset($this->patientFormData['ssn'])) {
            return $this->patientFormData['ssn'];
        }
        return 0;
    }

    /**
     * @return string
     */
    public function getNewEmail()
    {
        return $this->patientFormData['email'];
    }
}
