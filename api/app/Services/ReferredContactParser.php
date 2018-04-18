<?php

namespace DentalSleepSolutions\Services;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ReferredContactParser
{
    const SORT_COLUMNS = [
        'thirty' => 'num_ref30',
        'sixty' => 'num_ref60',
        'ninty' => 'num_ref90',
        'nintyplus' => 'num_ref90plus',
    ];

    /** @var NameSetter */
    private $nameSetter;

    /** @var PatientRepository */
    private $patientRepository;

    public function __construct(NameSetter $nameSetter, PatientRepository $patientRepository)
    {
        $this->nameSetter = $nameSetter;
        $this->patientRepository = $patientRepository;
    }

    /**
     * @param Collection|Contact[] $referredByContacts
     * @param string $sort
     * @param string $sortDir
     * @param bool $isDetailed
     * @return array[]
     */
    public function parseReferredContacts(Collection $referredByContacts, $sort, $sortDir, $isDetailed)
    {
        $newContacts = [];
        foreach ($referredByContacts as $contact) {
            // @todo: this code will give N+1 queries problem
            $counters = $this->patientRepository->getReferralCountersForContactWithoutDate(
                $contact->contactid,
                $contact->referral_type,
                $isDetailed
            );

            $newContact = $contact->toArray();
            $newContact = $this->overrideContactWithCounters($newContact, $counters);

            $newContact['name'] = $this->nameSetter->formNameWithSalutation($contact);
            $newContacts[] = $newContact;
        }

        if (array_key_exists($sort, self::SORT_COLUMNS)) {
            $sortColumn = self::SORT_COLUMNS[$sort];
            $newContacts = $this->sortByColumn($newContacts, $sortColumn, $sortDir);
        }
        return $newContacts;
    }

    /**
     * @param array $newContact
     * @param array $counters
     * @return array
     */
    private function overrideContactWithCounters(array $newContact, array $counters)
    {
        foreach ($counters as $field => $value) {
            $newContact[$field] = $value;
        }
        return $newContact;
    }

    /**
     * @param array[] $newContacts
     * @param string $sortColumn
     * @param string $sortDir
     * @return array
     * @throws GeneralException
     */
    private function sortByColumn(array $newContacts, $sortColumn, $sortDir)
    {
        usort($newContacts, function (array $first, array $second) use ($sortColumn, $sortDir) {
            if (!isset($first[$sortColumn])) {
                throw new GeneralException("Element $sortColumn does not exist in array");
            }
            if ($first[$sortColumn] == $second[$sortColumn]) {
                return 0;
            }

            if (strtolower($sortDir) === 'desc') {
                return ($first[$sortColumn] > $second[$sortColumn]) ? -1 : 1;
            }

            return ($first[$sortColumn] < $second[$sortColumn]) ? -1 : 1;
        });
        return $newContacts;
    }
}
