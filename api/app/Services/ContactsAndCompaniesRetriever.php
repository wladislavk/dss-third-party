<?php

namespace DentalSleepSolutions\Services;

use DentalSleepSolutions\Services\QueryComposers\ContactsQueryComposer;
use DentalSleepSolutions\Structs\ContactWithCompany;

class ContactsAndCompaniesRetriever
{
    /** @var ContactsQueryComposer */
    private $contactsQueryComposer;

    /** @var NameSetter */
    private $nameSetter;

    public function __construct(ContactsQueryComposer $contactsQueryComposer, NameSetter $nameSetter)
    {
        $this->contactsQueryComposer = $contactsQueryComposer;
        $this->nameSetter = $nameSetter;
    }

    /**
     * @param int $docId
     * @param string $partial
     * @param bool $withoutCompanies
     * @return array
     */
    public function retrieveContactsAndCompanies($docId, $partial, $withoutCompanies)
    {
        $partial = preg_replace("/[^ A-Za-z\'\-]/", "", $partial);

        $contactsAndCompanies = $this->contactsQueryComposer->composeListContactsAndCompaniesQuery(
            $docId, $partial, $withoutCompanies
        );

        $response = [];
        if (!count($contactsAndCompanies)) {
            $response = [
                'error' => 'Error: No match found for this criteria.',
            ];
        }
        foreach ($contactsAndCompanies as $item) {
            $contactWithCompany = new ContactWithCompany($item);
            $name = $this->nameSetter->formNameWithContact($contactWithCompany, $withoutCompanies);
            $response[] = [
                'id'     => $contactWithCompany->id,
                'name'   => $name,
                'source' => $contactWithCompany->referralType,
            ];
        }
        return $response;
    }
}
