<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Helpers\ContactsAndCompaniesRetriever;
use DentalSleepSolutions\Helpers\NameSetter;
use DentalSleepSolutions\Helpers\QueryComposers\ContactsQueryComposer;
use DentalSleepSolutions\Structs\ContactWithCompany;
use Illuminate\Database\Eloquent\Collection;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class ContactsAndCompaniesRetrieverTest extends UnitTestCase
{
    /** @var string */
    private $resultingPartial;

    /** @var Collection */
    private $contactsAndCompanies;

    /** @var ContactsAndCompaniesRetriever */
    private $contactsAndCompaniesRetriever;

    public function setUp()
    {
        $this->contactsAndCompanies = new Collection();

        $contactsQueryComposer = $this->mockContactsQueryComposer();
        $nameSetter = $this->mockNameSetter();
        $this->contactsAndCompaniesRetriever = new ContactsAndCompaniesRetriever(
            $contactsQueryComposer, $nameSetter
        );
    }

    public function testWithMatches()
    {
        $firstContact = new Contact();
        $firstContact->contactid = 1;
        $firstContact->referral_type = 10;
        $firstContact->firstname = 'John';
        $firstContact->lastname = 'Doe';
        $secondContact = new Contact();
        $secondContact->contactid = 2;
        $secondContact->referral_type = 20;
        $secondContact->firstname = 'Jane';
        $secondContact->lastname = 'Jones';
        $this->contactsAndCompanies->add($firstContact);
        $this->contactsAndCompanies->add($secondContact);

        $docId = 1;
        $partial = 'Something-1 and 2\'';
        $withoutCompanies = false;
        $result = $this->contactsAndCompaniesRetriever->retrieveContactsAndCompanies(
            $docId, $partial, $withoutCompanies
        );
        $expected = [
            [
                'id'     => 1,
                'name'   => 'John Doe',
                'source' => 10,
            ],
            [
                'id'     => 2,
                'name'   => 'Jane Jones',
                'source' => 20,
            ],
        ];
        $this->assertEquals($expected, $result);
        $this->assertEquals('Something- and \'', $this->resultingPartial);
    }

    public function testWithoutMatches()
    {
        $docId = 1;
        $partial = 'Something-1 and 2\'';
        $withoutCompanies = false;
        $result = $this->contactsAndCompaniesRetriever->retrieveContactsAndCompanies(
            $docId, $partial, $withoutCompanies
        );
        $expected = [
            'error' => 'Error: No match found for this criteria.',
        ];
        $this->assertEquals($expected, $result);
    }

    private function mockContactsQueryComposer()
    {
        /** @var ContactsQueryComposer|MockInterface $contactsQueryComposer */
        $contactsQueryComposer = \Mockery::mock(ContactsQueryComposer::class);
        $contactsQueryComposer->shouldReceive('composeListContactsAndCompaniesQuery')
            ->andReturnUsing([$this, 'composeListContactsAndCompaniesQueryCallback']);
        return $contactsQueryComposer;
    }

    private function mockNameSetter()
    {
        /** @var NameSetter|MockInterface $nameSetter */
        $nameSetter = \Mockery::mock(NameSetter::class);
        $nameSetter->shouldReceive('formNameWithContact')
            ->andReturnUsing([$this, 'formNameWithContactCallback']);
        return $nameSetter;
    }

    public function composeListContactsAndCompaniesQueryCallback($docId, $partial)
    {
        $this->resultingPartial = $partial;
        return $this->contactsAndCompanies;
    }

    public function formNameWithContactCallback(ContactWithCompany $contactWithCompany)
    {
        return $contactWithCompany->firstName . ' ' . $contactWithCompany->lastName;
    }
}
