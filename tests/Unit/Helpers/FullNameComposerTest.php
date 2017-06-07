<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Constants\ReferredTypes;
use DentalSleepSolutions\Eloquent\Dental\Contact;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Factories\ReferredNameSetterFactory;
use DentalSleepSolutions\Helpers\FullNameComposer;
use DentalSleepSolutions\Helpers\NameSetter;
use DentalSleepSolutions\Helpers\ReferredNameSetters\AbstractReferredNameSetter;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class FullNameComposerTest extends UnitTestCase
{
    /** @var Contact[] */
    private $contacts = [];

    /** @var FullNameComposer */
    private $fullNameComposer;

    public function setUp()
    {
        $contact1 = new Contact();
        $contact1->contactid = 1;
        $contact2 = new Contact();
        $contact2->contactid = 2;
        $contact2->firstname = 'John';
        $contact2->middlename = 'Harry';
        $contact2->lastname = 'Doe';
        $contact3 = new Contact();
        $contact3->contactid = 3;
        $contact3->firstname = 'Jane';
        $contact3->middlename = 'Margaret';
        $contact3->lastname = 'Smith';
        $this->contacts = [$contact1, $contact2, $contact3];

        $referredNameSetterFactory = $this->mockReferredNameSetterFactory();
        $nameSetter = new NameSetter();
        $contactModel = $this->mockContactModel();
        $this->fullNameComposer = new FullNameComposer(
            $referredNameSetterFactory, $nameSetter, $contactModel
        );
    }

    public function testWithBareMinimum()
    {
        $foundPatient = new Patient();
        $foundPatient->patientid = 5;
        $foundPatient->docent = 2;
        $foundPatient->docpcp = 3;
        $foundPatient->docmdother = 4;
        $fullNames = $this->fullNameComposer->getFormedFullNames($foundPatient);
        $expected = [
            'docent_name' => 'Doe, John Harry',
            'docpcp_name' => 'Smith, Jane Margaret',
            'ins_payer_name' => '',
            's_m_ins_payer_name' => '',
            'docsleep_name' => '',
            'docdentist_name' => '',
            'docmdother_name' => '',
            'docmdother2_name' => '',
            'docmdother3_name' => '',
            'referred_name' => '',
        ];
        $this->assertEquals($expected, $fullNames);
    }

    public function testWithInsPayerName()
    {
        $foundPatient = new Patient();
        $foundPatient->patientid = 5;
        $foundPatient->docent = 2;
        $foundPatient->docpcp = 3;
        $foundPatient->docmdother = 4;
        $foundPatient->p_m_eligible_payer_id = 6;
        $foundPatient->p_m_eligible_payer_name = 'Jack';
        $fullNames = $this->fullNameComposer->getFormedFullNames($foundPatient);
        $expected = [
            'docent_name' => 'Doe, John Harry',
            'docpcp_name' => 'Smith, Jane Margaret',
            'ins_payer_name' => '6 - Jack',
            's_m_ins_payer_name' => '',
            'docsleep_name' => '',
            'docdentist_name' => '',
            'docmdother_name' => '',
            'docmdother2_name' => '',
            'docmdother3_name' => '',
            'referred_name' => '',
        ];
        $this->assertEquals($expected, $fullNames);
    }

    public function testWithSMInsPayerName()
    {
        $foundPatient = new Patient();
        $foundPatient->patientid = 5;
        $foundPatient->docent = 2;
        $foundPatient->docpcp = 3;
        $foundPatient->docmdother = 4;
        $foundPatient->s_m_eligible_payer_id = 7;
        $foundPatient->s_m_eligible_payer_name = 'Jill';
        $fullNames = $this->fullNameComposer->getFormedFullNames($foundPatient);
        $expected = [
            'docent_name' => 'Doe, John Harry',
            'docpcp_name' => 'Smith, Jane Margaret',
            'ins_payer_name' => '',
            's_m_ins_payer_name' => '7 - Jill',
            'docsleep_name' => '',
            'docdentist_name' => '',
            'docmdother_name' => '',
            'docmdother2_name' => '',
            'docmdother3_name' => '',
            'referred_name' => '',
        ];
        $this->assertEquals($expected, $fullNames);
    }

    public function testWithReferredName()
    {
        $foundPatient = new Patient();
        $foundPatient->patientid = 5;
        $foundPatient->firstname = 'Walter';
        $foundPatient->middlename = 'Marmaduke';
        $foundPatient->lastname = 'Monmorancy';
        $foundPatient->docent = 2;
        $foundPatient->docpcp = 3;
        $foundPatient->docmdother = 4;
        $fullNames = $this->fullNameComposer->getFormedFullNames($foundPatient);
        $expected = [
            'docent_name' => 'Doe, John Harry',
            'docpcp_name' => 'Smith, Jane Margaret',
            'ins_payer_name' => '',
            's_m_ins_payer_name' => '',
            'docsleep_name' => '',
            'docdentist_name' => '',
            'docmdother_name' => '',
            'docmdother2_name' => '',
            'docmdother3_name' => '',
            'referred_name' => 'Monmorancy, Walter Marmaduke - Patient',
        ];
        $this->assertEquals($expected, $fullNames);
    }

    private function mockReferredNameSetterFactory()
    {
        /** @var ReferredNameSetterFactory|MockInterface $referredNameSetterFactory */
        $referredNameSetterFactory = \Mockery::mock(ReferredNameSetterFactory::class);
        $referredNameSetterFactory->shouldReceive('getReferredNameSetter')
            ->andReturn($this->mockReferredNameSetter());
        return $referredNameSetterFactory;
    }

    private function mockReferredNameSetter()
    {
        /** @var AbstractReferredNameSetter|MockInterface $referredNameSetter */
        $referredNameSetter = \Mockery::mock(AbstractReferredNameSetter::class);
        $referredNameSetter->shouldReceive('setReferredName')
            ->andReturnUsing([$this, 'setReferredNameCallback']);
        return $referredNameSetter;
    }

    private function mockContactModel()
    {
        /** @var Contact|MockInterface $contactModel */
        $contactModel = \Mockery::mock(Contact::class);
        $contactModel->shouldReceive('getDocShortInfo')
            ->andReturnUsing([$this, 'getDocShortInfoCallback']);
        return $contactModel;
    }

    public function setReferredNameCallback(Patient $foundPatient)
    {
        if ($foundPatient->getFirstName()) {
            $nameSetter = new NameSetter();
            return $nameSetter->formFullName(
                $foundPatient->getFirstName(),
                $foundPatient->getMiddleName(),
                $foundPatient->getLastName(),
                $foundPatient->getLabel()
            );
        }
        return null;
    }

    public function getDocShortInfoCallback($patientId)
    {
        foreach ($this->contacts as $contact) {
            if ($contact->contactid == $patientId) {
                return $contact;
            }
        }
        return null;
    }
}
