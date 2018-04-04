<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use Prettus\Repository\Exceptions\RepositoryException;

class DoctorIDRetriever
{
    private const NOT_SET_VALUE = 'Not Set';

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
     */
    public function getMdContactIds(int $patientId): array
    {
        /** @var Patient|null $contact */
        $contact = $this->patientRepository->findOrNull($patientId);
        if (!$contact) {
            return null;
        }
        $contactIds = [];
        foreach ($contact->toArray() as $field) {
            if ($field == self::NOT_SET_VALUE) {
                continue;
            }
            $contacts = explode(',', $field);
            foreach ($contacts as $contactId) {
                $contactId = (int)$contactId;
                if ($contactId && !in_array($contactId, $contactIds)) {
                    /** @var Contact|null $contact */
                    $contact = $this->contactRepository->findOrNull($contactId);
                    if ($contact->status == 1) {
                        $contactIds[] = $contact;
                    }
                }
            }
        }
        return $contactIds;
    }

    /**
     * @param int $patientId
     * @return int[]
     */
    public function getMdReferralIds(int $patientId): array
    {
        $contactResult = $this->contactRepository->getReferralIds($patientId);
        $contactIds = [];

        foreach ($contactResult as $contact) {
            if (
                !in_array($contact->contactid, $contactIds)
                &&
                $contact->status == 1
            ) {
                $contactIds[] = $contact->contactid;
            }
        }
        return $contactIds;
    }
}
