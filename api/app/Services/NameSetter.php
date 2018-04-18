<?php

namespace DentalSleepSolutions\Services;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Structs\ContactWithCompany;

class NameSetter
{
    /**
     * TODO: an interface is needed for models that share these fields
     *
     * @param string $firstName
     * @param string $middleName
     * @param string $lastName
     * @param string $label
     * @return string
     */
    public function formFullName($firstName, $middleName, $lastName, $label = '')
    {
        $name = "$lastName, $firstName $middleName";
        if ($label) {
            $name .= " - $label";
        }
        return $name;
    }

    /**
     * @param Contact $contact
     * @return string
     */
    public function formNameWithSalutation(Contact $contact)
    {
        $name = '';
        if ($contact->salutation) {
            $name .= $contact->salutation . ' ';
        }
        if ($contact->firstname) {
            $name .= $contact->firstname . ' ';
        }
        if ($contact->middlename) {
            $name .= $contact->middlename . ' ';
        }
        if ($contact->lastname) {
            $name .= $contact->lastname;
        }
        return trim($name);
    }

    /**
     * @param ContactWithCompany $contact
     * @param bool $withoutCompanies
     * @return string
     */
    public function formNameWithContact(ContactWithCompany $contact, $withoutCompanies)
    {
        $name = '';
        if (!$withoutCompanies) {
            $name .= $contact->company . ' - ';
        }
        $name .= $contact->lastName;
        $name .= ', ';
        $name .= $contact->firstName;
        $name .= ' ';
        $name .= $contact->middleName;
        $name .= ' - ';
        $name .= $contact->contactType;
        return $name;
    }
}
