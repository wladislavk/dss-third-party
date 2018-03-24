<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\NameSetter;
use DentalSleepSolutions\Helpers\ReferredContactParser;
use Illuminate\Database\Eloquent\Collection;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class ReferredContactParserTest extends UnitTestCase
{
    /** @var Collection|Contact[] */
    private $contacts;

    /** @var ReferredContactParser */
    private $referredContactParser;

    public function setUp()
    {
        $this->contacts = new Collection();
        $firstContact = new Contact();
        $firstContact->contactid = 1;
        $firstContact->referral_type = 1;
        $firstContact->firstname = 'John';
        $firstContact->lastname = 'Doe';
        $secondContact = new Contact();
        $secondContact->contactid = 2;
        $secondContact->referral_type = 2;
        $secondContact->firstname = 'Jane';
        $secondContact->lastname = 'Jones';
        $this->contacts->add($firstContact);
        $this->contacts->add($secondContact);

        $nameSetter = $this->mockNameSetter();
        $patientRepository = $this->mockPatientRepository();
        $this->referredContactParser = new ReferredContactParser($nameSetter, $patientRepository);
    }

    public function testWithoutSorting()
    {
        $sortColumn = 'foo';
        $contacts = $this->referredContactParser->parseReferredContacts(
            $this->contacts, $sortColumn, 'DESC', false
        );
        $expected = [
            [
                'contactid' => 1,
                'referral_type' => 1,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'name' => 'John Doe',
                'num_ref60' => 1,
            ],
            [
                'contactid' => 2,
                'referral_type' => 2,
                'firstname' => 'Jane',
                'lastname' => 'Jones',
                'name' => 'Jane Jones',
                'num_ref60' => 2,
            ],
        ];
        $this->assertEquals($expected, $contacts);
    }

    public function testWithSorting()
    {
        $sortColumn = 'sixty';
        $contacts = $this->referredContactParser->parseReferredContacts(
            $this->contacts, $sortColumn, 'ASC', false
        );
        $expected = [
            [
                'contactid' => 1,
                'referral_type' => 1,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'name' => 'John Doe',
                'num_ref60' => 1,
            ],
            [
                'contactid' => 2,
                'referral_type' => 2,
                'firstname' => 'Jane',
                'lastname' => 'Jones',
                'name' => 'Jane Jones',
                'num_ref60' => 2,
            ],
        ];
        $this->assertEquals($expected, $contacts);
    }

    public function testWithSortingDesc()
    {
        $sortColumn = 'sixty';
        $contacts = $this->referredContactParser->parseReferredContacts(
            $this->contacts, $sortColumn, 'DESC', false
        );
        $expected = [
            [
                'contactid' => 2,
                'referral_type' => 2,
                'firstname' => 'Jane',
                'lastname' => 'Jones',
                'name' => 'Jane Jones',
                'num_ref60' => 2,
            ],
            [
                'contactid' => 1,
                'referral_type' => 1,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'name' => 'John Doe',
                'num_ref60' => 1,
            ],
        ];
        $this->assertEquals($expected, $contacts);
    }

    public function testWithBadSortColumn()
    {
        $sortColumn = 'ninty';
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Element num_ref90 does not exist in array');
        $this->referredContactParser->parseReferredContacts(
            $this->contacts, $sortColumn, 'DESC', false
        );
    }

    private function mockNameSetter()
    {
        /** @var NameSetter|MockInterface $nameSetter */
        $nameSetter = \Mockery::mock(NameSetter::class);
        $nameSetter->shouldReceive('formNameWithSalutation')
            ->andReturnUsing([$this, 'formNameWithSalutationCallback']);
        return $nameSetter;
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('getReferralCountersForContactWithoutDate')
            ->andReturnUsing([$this, 'getReferralCountersForContactWithoutDateCallback']);
        return $patientRepository;
    }

    public function formNameWithSalutationCallback(Contact $contact)
    {
        return $contact->firstname . ' ' . $contact->lastname;
    }

    public function getReferralCountersForContactWithoutDateCallback($id)
    {
        return ['num_ref60' => $id];
    }
}
