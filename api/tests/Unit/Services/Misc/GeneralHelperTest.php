<?php

namespace Tests\Unit\Services\Misc;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Services\Misc\GeneralHelper;
use DentalSleepSolutions\Wrappers\FileWrapper;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class GeneralHelperTest extends UnitTestCase
{
    /** @var GeneralHelper */
    private $generalHelper;

    public function setUp()
    {
        $fileWrapper = $this->mockFileWrapper();
        $patientRepository = $this->mockPatientRepository();
        $contactRepository = $this->mockContactRepository();
        $this->generalHelper = new GeneralHelper($fileWrapper, $patientRepository, $contactRepository);
    }

    public function testIsSharedFile()
    {
        $filename = 'foo';
        $isShared = $this->generalHelper->isSharedFile($filename);
        $this->assertTrue($isShared);
    }

    public function testIsSharedFileWithoutName()
    {
        $filename = '';
        $isShared = $this->generalHelper->isSharedFile($filename);
        $this->assertFalse($isShared);
    }

    public function testIsSharedFileWithoutFile()
    {
        $filename = 'false';
        $isShared = $this->generalHelper->isSharedFile($filename);
        $this->assertFalse($isShared);
    }

    public function testFormatPhone()
    {
        $phone = 'f123o456o7890b0987';
        $formatted = $this->generalHelper->formatPhone($phone);
        $this->assertEquals('(123) 456-7890 x0987', $formatted);
    }

    public function testFormatPhoneWithoutMatch()
    {
        $phone = 'f123o456o789b098';
        $formatted = $this->generalHelper->formatPhone($phone);
        $this->assertNull($formatted);
    }

    public function testFormatPhoneWithoutEnding()
    {
        $phone = 'f123o456o7890';
        $formatted = $this->generalHelper->formatPhone($phone);
        $this->assertEquals('(123) 456-7890', $formatted);
    }

    public function testGetContactInfo()
    {
        $patient = 5;
        $mdList = 'foo';
        $mdReferralList = 'bar';
        $patientReferralsList = 'baz';
        $letterId = 2;
        $contactInfo = $this->generalHelper->getContactInfo(
            $patient, $mdList, $mdReferralList, $patientReferralsList, $letterId
        );
        $this->assertEquals(2, sizeof($contactInfo->getPatients()));
        $this->assertEquals(1, $contactInfo->getPatients()[0]['patientid']);
        $this->assertEquals(1, sizeof($contactInfo->getPatientReferrals()));
        $this->assertEquals(3, $contactInfo->getPatientReferrals()[0]['patientid']);
        $this->assertEquals(2, sizeof($contactInfo->getMds()));
        $this->assertEquals(2, $contactInfo->getMdReferrals()[0]['contactid']);
        $this->assertEquals(2, sizeof($contactInfo->getMdReferrals()));
        $this->assertEquals(4, $contactInfo->getMdReferrals()[1]['contactid']);
    }

    public function testGetContactInfoWithoutData()
    {
        $patient = 0;
        $mdList = '';
        $mdReferralList = ',,,';
        $contactInfo = $this->generalHelper->getContactInfo($patient, $mdList, $mdReferralList);
        $this->assertEquals([], $contactInfo->getPatients());
        $this->assertEquals([], $contactInfo->getMds());
        $this->assertEquals([], $contactInfo->getMdReferrals());
        $this->assertEquals([], $contactInfo->getPatientReferrals());
    }

    private function mockFileWrapper()
    {
        /** @var FileWrapper|MockInterface $fileWrapper */
        $fileWrapper = \Mockery::mock(FileWrapper::class);
        $fileWrapper->shouldReceive('isFile')->andReturnUsing([$this, 'isFileCallback']);
        return $fileWrapper;
    }

    public function isFileCallback($filename)
    {
        if ($filename == 'false') {
            return false;
        }
        return true;
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('getContactInfo')
            ->andReturnUsing([$this, 'getPatientContactInfoCallback']);
        $patientRepository->shouldReceive('getReferralList')
            ->andReturnUsing([$this, 'getReferralListCallback']);
        return $patientRepository;
    }

    public function getPatientContactInfoCallback()
    {
        $firstPatient = new Patient();
        $firstPatient->patientid = 1;
        $secondPatient = new Patient();
        $secondPatient->patientid = 2;
        return [$firstPatient, $secondPatient];
    }

    public function getReferralListCallback()
    {
        $firstReferral = new Patient();
        $firstReferral->patientid = 3;
        return [$firstReferral];
    }

    private function mockContactRepository()
    {
        /** @var ContactRepository|MockInterface $contactRepository */
        $contactRepository = \Mockery::mock(ContactRepository::class);
        $contactRepository->shouldReceive('getContactInfo')
            ->andReturnUsing([$this, 'getContactContactInfoCallback']);
        return $contactRepository;
    }

    public function getContactContactInfoCallback($letterId)
    {
        $firstContact = new Contact();
        $firstContact->contactid = $letterId;
        $secondContact = new Contact();
        $secondContact->contactid = $letterId * 2;
        return [$firstContact, $secondContact];
    }
}
