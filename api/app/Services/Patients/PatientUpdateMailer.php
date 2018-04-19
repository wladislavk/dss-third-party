<?php

namespace DentalSleepSolutions\Services\Patients;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Factories\EmailHandlerFactory;
use DentalSleepSolutions\Services\Emails\EmailHandlers\UpdateEmailHandler;
use DentalSleepSolutions\Structs\EditPatientMail;
use DentalSleepSolutions\Structs\EditPatientRequestData;

class PatientUpdateMailer
{
    /** @var UpdateEmailHandler */
    private $emailHandlerFactory;

    public function __construct(EmailHandlerFactory $emailHandlerFactory)
    {
        $this->emailHandlerFactory = $emailHandlerFactory;
    }

    /**
     * @param Patient $unchangedPatient
     * @param EditPatientRequestData $requestData
     * @return EditPatientMail
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     */
    public function handleEmails(
        Patient $unchangedPatient,
        EditPatientRequestData $requestData
    ) {
        $editPatientMail = new EditPatientMail();
        $oldEmail = $unchangedPatient->email;
        $registrationStatus = $unchangedPatient->registration_status;
        $handler = $this->emailHandlerFactory->getCorrectHandler(
            $requestData->requestedEmails,
            $registrationStatus,
            $requestData->newEmail,
            $oldEmail
        );
        if (!$handler) {
            // TODO: check if exception should be thrown
            return $editPatientMail;
        }
        $handler->handleEmail(
            $unchangedPatient->patientid,
            $requestData->newEmail,
            $oldEmail,
            $requestData->hasPatientPortal
        );
        $message = $handler->getMessage();
        $mailType = array_search(get_class($handler), EmailHandlerFactory::EMAIL_TYPES);
        $editPatientMail->mailType = $mailType;
        $editPatientMail->message = $message;
        return $editPatientMail;
    }
}
