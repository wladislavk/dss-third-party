<?php

namespace DentalSleepSolutions\Structs;

use DentalSleepSolutions\Eloquent\Models\Dental\HomeSleepTest;
use DentalSleepSolutions\Eloquent\Models\Dental\Insurance;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Support\Arrayable;

class PatientData implements Arrayable
{
    /** @var int */
    public $patientContactsNumber = 0;

    /** @var int */
    public $patientInsurancesNumber = 0;

    /** @var int */
    public $subPatientsNumber = 0;

    /** @var bool */
    public $isEmailBounced = false;

    /** @var Insurance[]|Collection */
    public $rejectedClaims = [];

    /** @var QuestionnaireData */
    public $questionnaireData;

    public $insuranceType = 0;

    /** @var string */
    public $preMed = '';

    /** @var int */
    public $preMedCheck = 0;

    /** @var string */
    public $alertText = '';

    /** @var bool */
    public $displayAlert = false;

    /** @var string */
    public $firstName = '';

    /** @var string */
    public $lastName = '';

    /** @var string */
    public $otherAllergens = '';

    /** @var bool */
    public $hasAllergen = false;

    /** @var int */
    public $homeSleepTestStatus = 99;

    /** @var HomeSleepTest[]|Collection */
    public $incompleteHomeSleepTests = [];

    public function populatePlainFields(Patient $patient)
    {
        $this->insuranceType = $patient->p_m_ins_type;
        $this->preMed = $patient->premed;
        $this->preMedCheck = $patient->premedcheck;
        $this->alertText = '' . $patient->alert_text;
        $this->displayAlert = boolval($patient->display_alert);
        $this->firstName = $patient->firstname;
        $this->lastName = $patient->lastname;
    }

    public function toArray()
    {
        $rejectedClaims = $this->rejectedClaims;
        if ($this->rejectedClaims instanceof Collection) {
            $rejectedClaims = $this->rejectedClaims->toArray();
        }
        $incompleteHsts = $this->incompleteHomeSleepTests;
        if ($this->incompleteHomeSleepTests instanceof Collection) {
            $incompleteHsts = $this->incompleteHomeSleepTests->toArray();
        }
        return [
            'insurance_type' => $this->insuranceType,
            'premed' => $this->preMed,
            'premedcheck' => $this->preMedCheck,
            'alert_text' => $this->alertText,
            'display_alert' => intval($this->displayAlert),
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'patient_contacts_number' => $this->patientContactsNumber,
            'patient_insurances_number' => $this->patientInsurancesNumber,
            'sub_patients_number' => $this->subPatientsNumber,
            'is_email_bounced' => intval($this->isEmailBounced),
            'rejected_claims' => $rejectedClaims,
            'questionnaire_data' => [
                'symptoms_status' => $this->questionnaireData->symptomsStatus,
                'treatments_status' => $this->questionnaireData->treatmentsStatus,
                'history_status' => $this->questionnaireData->historyStatus,
            ],
            'other_allergens' => $this->otherAllergens,
            'has_allergen' => intval($this->hasAllergen),
            'hst_status' => $this->homeSleepTestStatus,
            'incomplete_hsts' => $incompleteHsts,
        ];
    }
}
