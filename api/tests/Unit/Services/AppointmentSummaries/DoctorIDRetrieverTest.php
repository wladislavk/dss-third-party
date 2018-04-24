<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Exceptions\UntestableException;
use DentalSleepSolutions\Services\AppointmentSummaries\DoctorIDRetriever;
use Mockery\MockInterface;
use Prettus\Repository\Exceptions\RepositoryException;
use Tests\TestCases\UnitTestCase;

class DoctorIDRetrieverTest extends UnitTestCase
{
    private const PATIENT_ID = 42;

    /** @var Patient|null */
    private $patient;

    /** @var Contact[] */
    private $mdContacts = [];

    /** @var Contact[] */
    private $referralContacts = [];

    /** @var DoctorIDRetriever */
    private $doctorIDRetriever;

    public function setUp()
    {
        $firstContact = new Contact();
        $firstContact->contactid = 1;
        $firstContact->status = 1;
        $secondContact = new Contact();
        $secondContact->contactid = 2;
        $secondContact->status = 0;
        $thirdContact = new Contact();
        $thirdContact->contactid = 3;
        $thirdContact->status = 1;
        $this->mdContacts = [
            $firstContact,
            $secondContact,
            $thirdContact,
        ];

        $patientRepository = $this->mockPatientRepository();
        $contactRepository = $this->mockContactRepository();
        $this->doctorIDRetriever = new DoctorIDRetriever($patientRepository, $contactRepository);
    }

    /**
     * @throws UntestableException
     * @throws RepositoryException
     */
    public function testGetMdContactIds()
    {
        $this->patient = new Patient();
        $this->patient->docpcp = '1,2';
        $this->patient->docent = '2,3';
        $this->patient->docsleep = '3,4';
        $this->patient->docdentist = 'foo,bar';
        $this->patient->docmdother = '';
        $this->patient->docmdother2 = '';
        $this->patient->docmdother3 = '';

        $contactIds = $this->doctorIDRetriever->getMdContactIds(self::PATIENT_ID);
        $this->assertEquals([1, 3], $contactIds);
    }

    /**
     * @throws RepositoryException
     * @throws UntestableException
     */
    public function testWithoutPatient()
    {
        $contactIds = $this->doctorIDRetriever->getMdContactIds(self::PATIENT_ID);
        $this->assertEquals([], $contactIds);
    }

    public function testGetMdReferralIds()
    {
        $firstReferral = new Contact();
        $firstReferral->contactid = 1;
        $firstReferral->status = 1;
        $secondReferral = new Contact();
        $secondReferral->contactid = 2;
        $secondReferral->status = 1;
        $thirdReferral = new Contact();
        $thirdReferral->contactid = 2;
        $thirdReferral->status = 1;
        $fourthReferral = new Contact();
        $fourthReferral->contactid = 3;
        $fourthReferral->status = 0;
        $this->referralContacts = [
            $firstReferral,
            $secondReferral,
            $thirdReferral,
            $fourthReferral,
        ];

        $referralIds = $this->doctorIDRetriever->getMdReferralIds(self::PATIENT_ID);
        $this->assertEquals([1, 2], $referralIds);
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('findOrNull')->andReturnUsing(function () {
            return $this->patient;
        });
        return $patientRepository;
    }

    private function mockContactRepository()
    {
        /** @var ContactRepository|MockInterface $contactRepository */
        $contactRepository = \Mockery::mock(ContactRepository::class);
        $contactRepository->shouldReceive('getReferralIds')->andReturnUsing(function () {
            return $this->referralContacts;
        });
        $contactRepository->shouldReceive('findWhereIn')->andReturnUsing(function (string $field, array $values) {
            $contacts = [];
            foreach ($this->mdContacts as $contact) {
                if (in_array($contact->contactid, $values)) {
                    $contacts[] = $contact;
                }
            }
            return $contacts;
        });
        return $contactRepository;
    }
}
