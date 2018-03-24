<?php

namespace Tests\Unit\Helpers\QueryComposers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Helpers\QueryComposers\ContactsQueryComposer;
use Mockery\MockInterface;
use Tests\TestCases\QueryComposerTestCase;

class ContactsQueryComposerTest extends QueryComposerTestCase
{
    /** @var ContactsQueryComposer */
    private $contactsQueryComposer;

    public function setUp()
    {
        $methods = [
            'getFindContactBaseQuery',
            'getContactQueryWhereContactTypeId',
            'getContactQueryWhereLastNameOrCompanyLikeLetter',
            'getContactQueryOrderByColumnOrNull',
            'getContactQueryOrderByColumnAndDirection',
            'getListContactsAndCompaniesBaseQuery',
            'getContactQueryWithConditionsForNamesOnly',
            'getContactQueryWithConditionsForNamesAndCompanies',
        ];
        /** @var ContactRepository $contactRepository */
        $contactRepository = $this->mockRepository(ContactRepository::class, $methods);
        $this->contactsQueryComposer = new ContactsQueryComposer($contactRepository);
    }

    public function testComposeFindContactQueryWithoutContactTypeAndLetter()
    {
        $contactType = 0;
        $status = 1;
        $docId = 2;
        $letter = 0;
        $sortDir = 'desc';
        $orderByColumns = [];
        $result = $this->contactsQueryComposer->composeFindContactQuery(
            $contactType, $status, $docId, $letter, $sortDir, $orderByColumns
        );
        $this->assertEquals([], $result);
        $sequence = [
            ContactRepository::class => [
                'getFindContactBaseQuery' => [
                    [2, 1],
                ],
                'getContactQueryOrderByColumnOrNull' => [
                    ['dc.lastname', 'desc']
                ],
                'getContactQueryOrderByColumnAndDirection' => [
                    ['dc.lastname', 'asc'],
                    ['firstname', 'asc'],
                    ['company', 'asc'],
                    ['dct.contacttype', 'asc'],
                ],
            ],
        ];
        $this->assertEquals($sequence, $this->repositories);
    }

    public function testComposeFindContactQueryWithoutContactTypeAndLetterWithOrderMatch()
    {
        $contactType = 0;
        $status = 1;
        $docId = 2;
        $letter = 0;
        $sortDir = 'desc';
        $orderByColumns = ['company', 'firstname'];
        $result = $this->contactsQueryComposer->composeFindContactQuery(
            $contactType, $status, $docId, $letter, $sortDir, $orderByColumns
        );
        $this->assertEquals([], $result);
        $sequence = [
            ContactRepository::class => [
                'getFindContactBaseQuery' => [
                    [2, 1],
                ],
                'getContactQueryOrderByColumnOrNull' => [
                    ['company', 'desc']
                ],
                'getContactQueryOrderByColumnAndDirection' => [
                    ['company', 'desc'],
                    ['firstname', 'desc'],
                    ['dc.lastname', 'asc'],
                    ['dct.contacttype', 'asc'],
                ],
            ],
        ];
        $this->assertEquals($sequence, $this->repositories);
    }

    public function testComposeFindContactQueryWithContactTypeAndLetter()
    {
        $contactType = 10;
        $status = 1;
        $docId = 2;
        $letter = 11;
        $sortDir = 'desc';
        $orderByColumns = [];
        $result = $this->contactsQueryComposer->composeFindContactQuery(
            $contactType, $status, $docId, $letter, $sortDir, $orderByColumns
        );
        $this->assertEquals([], $result);
        $sequence = [
            ContactRepository::class => [
                'getFindContactBaseQuery' => [
                    [2, 1],
                ],
                'getContactQueryWhereContactTypeId' => [
                    [10],
                ],
                'getContactQueryWhereLastNameOrCompanyLikeLetter' => [
                    [11],
                ],
                'getContactQueryOrderByColumnOrNull' => [
                    ['dc.lastname', 'desc']
                ],
                'getContactQueryOrderByColumnAndDirection' => [
                    ['dc.lastname', 'asc'],
                    ['firstname', 'asc'],
                    ['company', 'asc'],
                    ['dct.contacttype', 'asc'],
                ],
            ],
        ];
        $this->assertEquals($sequence, $this->repositories);
    }

    public function testComposeListContactsAndCompaniesQueryWithCompanies()
    {
        $docId = 1;
        $partial = 'foo';
        $withoutCompanies = false;
        $result = $this->contactsQueryComposer->composeListContactsAndCompaniesQuery(
            $docId, $partial, $withoutCompanies
        );
        $this->assertEquals([], $result);
        $sequence = [
            ContactRepository::class => [
                'getListContactsAndCompaniesBaseQuery' => [
                    [1],
                ],
                'getContactQueryWithConditionsForNamesAndCompanies' => [
                    ['foo'],
                ],
            ],
        ];
        $this->assertEquals($sequence, $this->repositories);
    }

    public function testComposeListContactsAndCompaniesQueryWithoutCompanies()
    {
        $docId = 1;
        $partial = 'foo';
        $withoutCompanies = true;
        $result = $this->contactsQueryComposer->composeListContactsAndCompaniesQuery(
            $docId, $partial, $withoutCompanies
        );
        $this->assertEquals([], $result);
        $sequence = [
            ContactRepository::class => [
                'getListContactsAndCompaniesBaseQuery' => [
                    [1],
                ],
                'getContactQueryWithConditionsForNamesOnly' => [
                    ['foo'],
                ],
            ],
        ];
        $this->assertEquals($sequence, $this->repositories);
    }
}
