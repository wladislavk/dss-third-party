<?php

namespace Tests\Unit\Helpers\ReferredNameSetters;

use DentalSleepSolutions\Eloquent\Dental\Contact;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Helpers\NameSetter;
use DentalSleepSolutions\Helpers\ReferredNameSetters\PhysicianReferredNameSetter;
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
        $contactModel = $this->mockContactModel();
        $this->physicianReferredNameSetter = new PhysicianReferredNameSetter($nameSetter, $contactModel);
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

    private function mockContactModel()
    {
        /** @var Contact|MockInterface $contactModel */
        $contactModel = \Mockery::mock(Contact::class);
        $contactModel->shouldReceive('getDocShortInfo')
            ->andReturnUsing([$this, 'getDocShortInfoCallback']);
        return $contactModel;
    }

    public function getDocShortInfoCallback($referredBy)
    {
        if ($referredBy == $this->contact->contactid) {
            return $this->contact;
        }
        return null;
    }
}
