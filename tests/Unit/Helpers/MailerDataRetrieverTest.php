<?php

namespace Unit\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\Summary;
use DentalSleepSolutions\Eloquent\Dental\User;
use Mockery\MockInterface;
use TestCases\UnitTestCase;

class MailerDataRetrieverTest extends UnitTestCase
{
    private function mockGeneralHelper()
    {
        /** @var GeneralHelper|MockInterface $generalHelper */
        $generalHelper = \Mockery::mock(GeneralHelper::class);
        return $generalHelper;
    }

    private function mockUserModel()
    {
        /** @var User|MockInterface $userModel */
        $userModel = \Mockery::mock(User::class);
        return $userModel;
    }

    private function mockPatientModel()
    {
        /** @var Patient|MockInterface $patientModel */
        $patientModel = \Mockery::mock(Patient::class);
        return $patientModel;
    }

    private function mockSummaryModel()
    {
        /** @var Summary|MockInterface $summaryModel */
        $summaryModel = \Mockery::mock(Summary::class);
        return $summaryModel;
    }
}
