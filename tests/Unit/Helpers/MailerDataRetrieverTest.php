<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\Summary;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\SummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Exceptions\EmailHandlerException;
use DentalSleepSolutions\Helpers\GeneralHelper;
use DentalSleepSolutions\Helpers\MailerDataRetriever;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class MailerDataRetrieverTest extends UnitTestCase
{
    /** @var Patient */
    private $patient;

    /** @var User */
    private $user;

    /** @var Summary[] */
    private $summary = [];

    /** @var MailerDataRetriever */
    private $mailerDataRetriever;

    public function setUp()
    {
        $this->patient = new Patient();
        $this->patient->patientid = 1;

        $this->user = new User();
        $this->user->mailing_phone = '1234567';
        $this->user->user_type = MailerDataRetriever::DSS_USER_TYPE_SOFTWARE;
        $this->user->logo = '1234';

        $generalHelper = $this->mockGeneralHelper();
        $userRepository = $this->mockUserRepository();
        $patientRepository = $this->mockPatientRepository();
        $summaryRepository = $this->mockSummaryRepository();
        $this->mailerDataRetriever = new MailerDataRetriever(
            $generalHelper, $userRepository, $patientRepository, $summaryRepository
        );
    }

    public function testRetrieveMailerData()
    {
        $patientId = 1;
        $mailerData = $this->mailerDataRetriever->retrieveMailerData($patientId);
        $patient = $mailerData->patientData;
        $this->assertEquals(1, $patient->patientid);
        $user = $mailerData->mailingData;
        $this->assertEquals('123-45-67', $user->mailing_phone);
        $this->assertEquals(MailerDataRetriever::DSS_USER_TYPE_SOFTWARE, $user->user_type);
        $this->assertEquals(0, $user->zip);
        $this->assertEquals(0, $user->docid);
        $this->assertEquals(MailerDataRetriever::LOGO, $user->logo);
    }

    public function testWithSummaryInfo()
    {
        $patientId = 1;
        $docId = 2;
        $summary1 = new Summary();
        $summary1->location = '1232';
        $this->summary = [$summary1];
        $mailerData = $this->mailerDataRetriever->retrieveMailerData($patientId, $docId);
        $this->assertEquals(1232, $mailerData->mailingData->zip);
        $this->assertEquals($docId, $mailerData->mailingData->docid);
    }

    public function testWithCustomLogo()
    {
        $this->user->logo = '5678';
        $patientId = 1;
        $mailerData = $this->mailerDataRetriever->retrieveMailerData($patientId);
        $expectedLogo = MailerDataRetriever::DISPLAY_FILE_PAGE . '?f=5678';
        $this->assertEquals($expectedLogo, $mailerData->mailingData->logo);
    }

    public function testWithoutPatient()
    {
        $patientId = 2;
        $this->expectException(EmailHandlerException::class);
        $this->expectExceptionMessage("Patient with ID $patientId not found");
        $this->mailerDataRetriever->retrieveMailerData($patientId);
    }

    public function testWithoutMailingData()
    {
        $patientId = 1;
        $this->user = null;
        $this->expectException(EmailHandlerException::class);
        $this->expectExceptionMessage("Mailing data for patient with ID $patientId not found");
        $this->mailerDataRetriever->retrieveMailerData($patientId);
    }

    private function mockGeneralHelper()
    {
        /** @var GeneralHelper|MockInterface $generalHelper */
        $generalHelper = \Mockery::mock(GeneralHelper::class);
        $generalHelper->shouldReceive('formatPhone')
            ->andReturnUsing([$this, 'formatPhoneCallback']);
        $generalHelper->shouldReceive('isSharedFile')
            ->andReturnUsing([$this, 'isSharedFileCallback']);
        return $generalHelper;
    }

    private function mockUserRepository()
    {
        /** @var UserRepository|MockInterface $userRepository */
        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getMailingData')
            ->andReturnUsing([$this, 'getMailingDataCallback']);
        return $userRepository;
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('find')
            ->andReturnUsing([$this, 'findPatientCallback']);
        return $patientRepository;
    }

    private function mockSummaryRepository()
    {
        /** @var SummaryRepository|MockInterface $summaryRepository */
        $summaryRepository = \Mockery::mock(SummaryRepository::class);
        $summaryRepository->shouldReceive('getWithFilter')
            ->andReturnUsing([$this, 'getWithFilterCallback']);
        return $summaryRepository;
    }

    public function findPatientCallback($id)
    {
        if ($this->patient->patientid == $id) {
            return $this->patient;
        }
        return null;
    }

    public function getWithFilterCallback(array $fields = [], array $where = [])
    {
        return $this->summary;
    }

    public function getMailingDataCallback($docId, $patientId, $location)
    {
        if (!$this->user) {
            return null;
        }
        $this->user->zip = $location;
        $this->user->docid = $docId;
        return $this->user;
    }

    public function formatPhoneCallback($phone)
    {
        return substr($phone, 0, 3) . '-' . substr($phone, 3, 2) . '-' . substr($phone, 5);
    }

    public function isSharedFileCallback($logo)
    {
        if ($logo == '5678') {
            return true;
        }
        return false;
    }
}
