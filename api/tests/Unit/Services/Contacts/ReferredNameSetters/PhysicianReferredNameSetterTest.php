<?php

namespace Tests\Unit\Services\Contacts\ReferredNameSetters;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Services\Contacts\NameSetter;
use DentalSleepSolutions\Services\Contacts\ReferredNameSetters\PhysicianReferredNameSetter;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PhysicianReferredNameSetterTest extends UnitTestCase
{
    /** @var Contact */
    private $contact;

    /** @var PhysicianReferredNameSetter */
    private $physicianReferredNameSetter;

    public function setUp()
    {
        $this->contact = new Contact();
        $this->contact->contactid = 1;
        $this->contact->firstname = 'John';
        $this->contact->middlename = 'Harry';
        $this->contact->lastname = 'Doe';

        $nameSetter = new NameSetter();
        $contactRepository = $this->mockContactRepository();
        $this->physicianReferredNameSetter = new PhysicianReferredNameSetter(
            $nameSetter, $contactRepository
        );
    }

    public function testWithContact()
    {
        $foundPatient = new Patient();
        $foundPatient->referred_by = 1;
        $name = $this->physicianReferredNameSetter->setReferredName($foundPatient);
        $this->assertEquals('Doe, John Harry', $name);
    }

    public function testWithoutContact()
    {
        $foundPatient = new Patient();
        $foundPatient->referred_by = 2;
        $name = $this->physicianReferredNameSetter->setReferredName($foundPatient);
        $this->assertNull($name);
    }

    private function mockContactRepository()
    {
        /** @var ContactRepository|MockInterface $contactRepository */
        $contactRepository = \Mockery::mock(ContactRepository::class);
        $contactRepository->shouldReceive('getDocShortInfo')
            ->andReturnUsing([$this, 'getDocShortInfoCallback']);
        return $contactRepository;
    }

    public function getDocShortInfoCallback($referredBy)
    {
        if ($referredBy == $this->contact->contactid) {
            return $this->contact;
        }
        return null;
    }
}
