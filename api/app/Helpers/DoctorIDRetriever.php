<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Constants\PatientContactFields;
use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Exceptions\UntestableException;
use Prettus\Repository\Exceptions\RepositoryException;

class DoctorIDRetriever
{
    /** @var PatientRepository */
    private $patientRepository;

    /** @var ContactRepository */
    private $contactRepository;

    public function __construct(
        PatientRepository $patientRepository,
        ContactRepository $contactRepository
    ) {
        $this->patientRepository = $patientRepository;
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param int $patientId
     * @return int[]
     * @throws RepositoryException
     * @throws UntestableException
     */
    public function getMdContactIds(int $patientId): array
    {
        /** @var Patient|null $patient */
        $patient = $this->patientRepository->findOrNull($patientId);
        if (!$patient) {
            return [];
        }
        $contactIds = [];
        foreach (PatientContactFields::DOC_FIELDS as $fieldName) {
            $contactIds = array_merge($contactIds, $this->addContactIdsFromField($patient, $fieldName));
        }
        return array_unique($contactIds);
    }

    /**
     * @param Patient $patient
     * @param string $fieldName
     * @return int[]
     * @throws UntestableException
     */
    private function addContactIdsFromField(Patient $patient, string $fieldName): array
    {
        $properties = $patient->getAttributes();
        if (!isset($properties[$fieldName])) {
            throw new UntestableException("$fieldName property does not exist on class " . Patient::class);
        }
        $fieldValue = $patient->$fieldName;
        $fieldValueArray = explode(',', $fieldValue);
        $fieldValueArray = array_map(function (string $element): int {
            return (int)$element;
        }, $fieldValueArray);
        $fieldValueArray = array_filter($fieldValueArray, function (int $element): bool {
            return $element > 0;
        });
        $contacts = $this->contactRepository->findWhereIn('contactid', $fieldValueArray);
        $contactIds = $this->getActiveContactIds($contacts);
        return $contactIds;
    }

    /**
     * @param int $patientId
     * @return int[]
     */
    public function getMdReferralIds(int $patientId): array
    {
        $contacts = $this->contactRepository->getReferralIds($patientId);
        $contactIds = $this->getActiveContactIds($contacts);
        return array_unique($contactIds);
    }

    /**
     * @param Contact[] $contacts
     * @return int[]
     */
    private function getActiveContactIds(array $contacts): array
    {
        $contactIds = [];
        foreach ($contacts as $contact) {
            if ($contact->status == 1) {
                $contactIds[] = $contact->contactid;
            }
        }
        return $contactIds;
    }
}
