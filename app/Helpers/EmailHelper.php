<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Helpers\GeneralHelper;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\Summary;
use DentalSleepSolutions\Eloquent\Dental\User;

use Carbon\Carbon;
use Mail;

class EmailHelper
{
    const DSS_USER_TYPE_SOFTWARE = 2;

    private $patient;
    private $summary;
    private $user;
    private $docId;
    private $generalHelper;

    public function __construct(
        GeneralHelper $generalHelper,
        Patient $patient,
        Summary $summary,
        User $user
    ) {
        $this->generalHelper = $generalHelper;

        $this->patient = $patient;
        $this->summary = $summary;
        $this->user = $user;
        $this->docId = 0;
    }

    public function setDocId($docId)
    {
        $this->docId = $docId;
    }

    /**
     * @param int    $patientId
     * @param string $newEmail
     * @param string $oldEmail
     * @param string $sentBy
     *
     * @return bool
     */
    public function sendUpdatedEmail($patientId, $newEmail, $oldEmail, $sentBy)
    {
        if (strtolower(trim($oldEmail)) === strtolower(trim($newEmail))) {
            return false;
        }

        $contactData = $this->retrieveMailerData($patientId, $this->docId);
        $patientData = $contactData['patientData'];
        $mailingData = $contactData['mailingData'];

        $mailingData['old_email'] = $oldEmail;
        $mailingData['new_email'] = $newEmail;
        $mailingData['legend'] = $sentBy === 'doc'
            ? 'An update has been made to your account.'
            : 'You have updated your account.';

        $headerInfo = [
            'from_email'   => 'patient@dentalsleepsolutions.com',
            'from_name'    => 'Dental Sleep Solutions',
            'to_old_email' => $oldEmail,
            'to_new_email' => $newEmail,
            'to_name'      => $patientData['firstname'] . ' ' . $patientData['lastname'],
            'subject'      => 'Online Patient Portal Email Update'
        ];

        $usingOldEmail = Mail::send('emails.update', $mailingData, function ($message) use ($headerInfo) {
            $message->from($headerInfo['from_email'], $headerInfo['from_name'])
                ->to($headerInfo['to_old_email'], $headerInfo['to_name'])
                ->subject($headerInfo['subject']);
        });

        $usingNewEmail = Mail::send('emails.update', $mailingData, function ($message) use ($headerInfo) {
            $message->from($headerInfo['from_email'], $headerInfo['from_name'])
                ->to($headerInfo['to_new_email'], $headerInfo['to_name'])
                ->subject($headerInfo['subject']);
        });

        return $usingOldEmail && $usingNewEmail;
    }

    /**
     * Send "remember" email
     *
     * @param int    $patientId
     * @param string $patientEmail
     *
     * @return bool
     */
    public function sendRemEmail($patientId, $patientEmail)
    {
        return $this->sendRegistrationRelatedEmail($patientId, $patientEmail, false);
    }

    /**
     * Send registration email
     *
     * @param int    $patientId
     * @param string $patientEmail
     * @param mixed  $unusedLogin
     * @param string $oldEmail
     * @param int    $accessType
     * @return bool
     */
    public function sendRegEmail($patientId, $patientEmail, $unusedLogin, $oldEmail, $accessType = 1)
    {
        return $this->sendRegistrationRelatedEmail($patientId, $patientEmail, true, $oldEmail, $accessType);
    }

    /**
     * @param int    $patientId
     * @param string $patientEmail
     * @param bool   $isPasswordReset
     * @param string $oldEmail
     * @param int    $accessType
     *
     * @return bool
     */
    private function sendRegistrationRelatedEmail($patientId, $patientEmail, $isPasswordReset = false, $oldEmail = '', $accessType = 1)
    {
        $patientId = intval($patientId);
        $accessType = intval($accessType);

        $contactData = $this->retrieveMailerData($patientId, $this->docId);
        $patientData = $contactData['patientData'];
        $mailingData = $contactData['mailingData'];

        if ($isPasswordReset) {
            if ($patientData['recover_hash'] == '' || $patientEmail != $oldEmail) {
                $accessCode = rand(100000, 999999);
                $recoverHash = hash('sha256', $patientId . $patientData['email'] . rand());

                $this->patient->updatePatient($patientId, [
                    'text_num'            => 0,
                    'access_type'         => $accessType,
                    'registration_status' => 1,
                    'access_code'         => "$accessCode",
                    'recover_hash'        => "$recoverHash",
                    'text_date'           => Carbon::now(),
                    'recover_time'        => Carbon::now(),
                    'registration_senton' => Carbon::now()
                ]);
            } else {
                $this->patient->updatePatient($patientId, [
                    'access_type'         => $accessType,
                    'registration_status' => 1,
                    'registration_senton' => Carbon::now()
                ]);

                $recoverHash = $patientData['recover_hash'];
            }

            $mailingData['legend'] = '<p>We hope to hear from you soon!</p>';
            $mailingData['link'] = 'reg/activate.php?id=' . $patientId . '&amp;hash=' . $recoverHash;
        } else {
            $mailingData['link'] = 'reg/login.php?email=' . $patientEmail;
        }

        $mailingData['email'] = $patientEmail;

        $headerInfo = [
            'from_email' => 'patient@dentalsleepsolutions.com',
            'from_name'  => 'Dental Sleep Solutions',
            'to_email'   => $patientEmail,
            'to_name'    => $patientData['firstname'] . ' ' . $patientData['lastname'],
            'subject'    => 'Online Patient Registration'
        ];

        return Mail::send('emails.registration', $mailingData, function ($message) use ($headerInfo) {
            $message->from($headerInfo['from_email'], $headerInfo['from_name'])
                ->to($headerInfo['to_email'], $headerInfo['to_name'])
                ->subject($headerInfo['subject']);
        });
    }

    /**
     * Retrieve patient and mailing doctor details, for patient emails
     *
     * @param int $patientId
     *
     * @return array
     */
    private function retrieveMailerData($patientId, $docId = 0)
    {
        $patient = $this->patient->find($patientId);
        $summaryInfo = $this->summary->getWithFilter('location', ['patientid' => $patientId]);
        $location = count($summaryInfo) ? $summaryInfo[0]->location : 0;

        $mailingData = $this->user->getMailingData($docId, $patientId, $location);

        if ($mailingData->user_type == self::DSS_USER_TYPE_SOFTWARE &&
            $this->generalHelper->isSharedFile($mailingData->logo)
        ) {
            $mailingData->logo = 'manage/display_file.php?f=' . $mailingData->logo;
        } else {
            $mailingData->logo = 'foreign_images/email/reg_logo.gif';
        }

        $mailingData->mailing_phone = $this->generalHelper->formatPhone($mailingData->mailing_phone);

        return [
            'patientData' => $patient->toArray(),
            'mailingData' => $mailingData->toArray()
        ];
    }
}
