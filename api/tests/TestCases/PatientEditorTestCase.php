<?php

namespace Tests\TestCases;

use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Services\Letters\LetterTriggerLauncher;
use DentalSleepSolutions\Services\Patients\PatientSummaryManager;
use DentalSleepSolutions\Services\Emails\RegistrationEmailSender;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use Mockery\MockInterface;

class PatientEditorTestCase extends UnitTestCase
{
    /** @var array */
    protected $triggeredLetters = [];

    /** @var array */
    protected $updatedSummary = [];

    /** @var bool */
    protected $emailSent = false;

    /** @var int */
    protected $docId = 0;

    protected function mockRegistrationEmailSender()
    {
        /** @var RegistrationEmailSender|MockInterface $registrationEmailSender */
        $registrationEmailSender = \Mockery::mock(RegistrationEmailSender::class);
        $registrationEmailSender->shouldReceive('sendRegistrationEmail')
            ->andReturnUsing([$this, 'sendRegistrationEmailCallback']);
        return $registrationEmailSender;
    }

    protected function mockLetterTriggerLauncher()
    {
        /** @var LetterTriggerLauncher|MockInterface $letterTriggerLauncher */
        $letterTriggerLauncher = \Mockery::mock(LetterTriggerLauncher::class);
        $letterTriggerLauncher->shouldReceive('triggerLetters')
            ->andReturnUsing([$this, 'triggerLettersCallback']);
        return $letterTriggerLauncher;
    }

    protected function mockPatientSummaryManager()
    {
        /** @var PatientSummaryManager|MockInterface $patientSummaryManager */
        $patientSummaryManager = \Mockery::mock(PatientSummaryManager::class);
        $patientSummaryManager->shouldReceive('updatePatientSummary')
            ->andReturnUsing([$this, 'updatePatientSummaryCallback']);
        return $patientSummaryManager;
    }

    protected function mockUserRepository()
    {
        /** @var UserRepository|MockInterface $userRepository */
        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('find')->andReturnUsing(function ($userId) {
            $user = new User();
            $user->userid = $userId;
            $user->docid = $this->docId;
            return $user;
        });
        return $userRepository;
    }

    public function updatePatientSummaryCallback($patientId, $isInfoComplete)
    {
        $this->updatedSummary = [
            'patientId' => $patientId,
            'isInfoComplete' => $isInfoComplete,
        ];
    }

    public function triggerLettersCallback(
        $patientId,
        $docId,
        $userId,
        $userType,
        EditPatientRequestData $requestData
    ) {
        $this->triggeredLetters = [
            'patientId' => $patientId,
            'docId' => $docId,
            'userId' => $userId,
            'userType' => $userType,
        ];
    }

    public function sendRegistrationEmailCallback()
    {
        $this->emailSent = true;
    }
}
