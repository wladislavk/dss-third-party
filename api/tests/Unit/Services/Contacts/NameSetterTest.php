<?php

namespace Tests\Unit\Services\Contacts;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Services\Contacts\NameSetter;
use DentalSleepSolutions\Structs\ContactWithCompany;
use Tests\TestCases\UnitTestCase;

class NameSetterTest extends UnitTestCase
{
    /** @var Contact */
    private $contact;

    /** @var NameSetter */
    private $nameSetter;

    public function setUp()
    {
        $this->contact = new Contact();
        $this->contact->firstname = 'John';
        $this->contact->middlename = 'Harry';
        $this->contact->lastname = 'Doe';
        $this->contact->company = 'Microsoft';
        $this->contact->contacttype = '1';

        $this->nameSetter = new NameSetter();
    }

    public function testFormFullNameWithLabel()
    {
        $firstName = 'John';
        $middleName = 'Harry';
        $lastName = 'Doe';
        $label = 'Patient';
        $fullName = $this->nameSetter->formFullName($firstName, $middleName, $lastName, $label);
        $this->assertEquals('Doe, John Harry - Patient', $fullName);
    }

    public function testFormFullNameWithoutLabel()
    {
        $firstName = 'John';
        $middleName = 'Harry';
        $lastName = 'Doe';
        $fullName = $this->nameSetter->formFullName($firstName, $middleName, $lastName);
        $this->assertEquals('Doe, John Harry', $fullName);
    }

    public function testFormNameWithContact()
    {
        $contact = new ContactWithCompany($this->contact);
        $name = $this->nameSetter->formNameWithContact($contact, true);
        $expected = 'Doe, John Harry - 1';
        $this->assertEquals($expected, $name);
    }

    public function testFormNameWithContactAndCompany()
    {
        $contact = new ContactWithCompany($this->contact);
        $name = $this->nameSetter->formNameWithContact($contact, false);
        $expected = 'Microsoft - Doe, John Harry - 1';
        $this->assertEquals($expected, $name);
    }

    public function testFormNameWithSalutation()
    {
        $contact = new Contact();
        $contact->salutation = 'Mr.';
        $contact->firstname = 'John';
        $contact->middlename = 'Harry';
        $contact->lastname = 'Doe';
        $name = $this->nameSetter->formNameWithSalutation($contact);
        $expected = 'Mr. John Harry Doe';
        $this->assertEquals($expected, $name);
    }

    public function testFormNameWithSalutationForEmptyData()
    {
        $contact = new Contact();
        $name = $this->nameSetter->formNameWithSalutation($contact);
        $this->assertEquals('', $name);
    }
}
