<?php

namespace DentalSleepSolutions\Helpers;

// need to fix it
define('SHARED_FOLDER', __DIR__ . '/../../../../shared/');
define('Q_FILE_FOLDER', SHARED_FOLDER . '/q_file/');

use DentalSleepSolutions\Helpers\GeneralHelper;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\Summary;
use DentalSleepSolutions\Eloquent\Dental\User;

class EmailHelper
{
    const DSS_USER_TYPE_SOFTWARE = 2;

    private $patient;
    private $summary;
    private $user;
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
    }

    /**
     * @param int    $patientId
     * @param string $newEmail
     * @param string $oldEmail
     * @param string $sentBy
     *
     * @return bool
     */
    public function sendUpdatedEmail($docId, $patientId, $newEmail, $oldEmail, $sentBy)
    {
        if (strtolower(trim($oldEmail)) === strtolower(trim($newEmail))) {
            return false;
        }

        $contactData = $this->retrieveMailerData($patientId, $docId);
        $patientData = $contactData['patientData'];
        $mailingData = $contactData['mailingData'];

        $mailingData['old_email'] = $oldEmail;
        $mailingData['new_email'] = $newEmail;
        $mailingData['legend'] = $sentBy === 'doc'
            ? 'An update has been made to your account.'
            : 'You have updated your account.';

        $from = 'Dental Sleep Solutions <patient@dentalsleepsolutions.com>';
        $to = "{$patientData['firstname']} {$patientData['lastname']}";
        $subject = 'Online Patient Portal Email Update';
        $message = $this->generalHelper->getTemplate('patient/update');

        $return = $this->sendEmail($from, "$to <$oldEmail>", $subject, $message, $mailingData);
        $return = $this->sendEmail($from, "$to <$newEmail>", $subject, $message, $mailingData) && $return;

        return $return;
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

    // need to rewrite this function to the sctucture of Laravel
    private function sendRegistrationRelatedEmail($patientId, $patientEmail, $isPasswordReset = false, $oldEmail = '', $accessType = 1)
    {
        $db = new Db();
        $patientId = intval($patientId);
        $accessType = intval($accessType);

        $contactData = retrieveMailerData($patientId);
        $patientData = $contactData['patientData'];
        $mailingData = $contactData['mailingData'];

        if ($isPasswordReset) {
            if ($patientData['recover_hash'] == '' || $patientEmail != $oldEmail) {
                $accessCode = rand(100000, 999999);
                $recoverHash = hash('sha256', $patientData['patientid'] . $patientData['email'] . rand());

                $db->query("UPDATE dental_patients SET
                        text_num = 0,
                        access_type = $accessType,
                        registration_status = 1,
                        access_code = '$accessCode',
                        recover_hash = '$recoverHash',
                        text_date = NOW(),
                        recover_time = NOW(),
                        registration_senton = NOW()
                    WHERE patientid = '$patientId'");
            } else {
                $db->query("UPDATE dental_patients SET
                        access_type = $accessType,
                        registration_status = 1,
                        registration_senton = NOW()
                    WHERE patientid = '$patientId'");
                $recoverHash = $patientData['recover_hash'];
            }

            $mailingData['patient_id'] = $patientId;
            $mailingData['recover_hash'] = $recoverHash;
            $mailingData['legend'] = '<p>We hope to hear from you soon!</p>';
            $mailingData['link'] = '{{baseUrl}}/reg/activate.php?id={%patient_id%}&amp;hash={%recover_hash%}';
        } else {
            $mailingData['link'] = '{{baseUrl}}/reg/login.php?email={%email%}';
        }

        $mailingData['email'] = $patientEmail;

        $from = 'Dental Sleep Solutions <patient@dentalsleepsolutions.com>';
        $to = "{$patientData['firstname']} {$patientData['lastname']} <{$patientEmail}>";
        $subject = 'Online Patient Registration';
        $message = getTemplate('patient/registration');

        return sendEmail($from, $to, $subject, $message, $mailingData);
    }

    /**
     * Retrieve patient and mailing doctor details, for patient emails
     *
     * @param int $patientId
     *
     * @return array
     */
    private function retrieveMailerData($patientId, $docId)
    {
        $patient = $this->patient->find($patientId);
        $summaryInfo = $this->summary->getWithFilter('location', ['patientid' => $patientId]);
        $location = !empty($summaryInfo) ? $summaryInfo[0]->location : 0;

        $mailingData = $this->user->getMailingData($docId, $patientId, $location);

        if ($mailingData->user_type == self::DSS_USER_TYPE_SOFTWARE &&
            $this->generalHelper->isSharedFile($mailingData->logo)
        ) {
            $mailingData->logo = 'manage/display_file.php?f=' . $mailingData->logo;
        } else {
            $mailingData->logo = 'reg/images/email/reg_logo.gif';
        }

        $mailingData->mailing_phone = $this->generalHelper->formatPhone($mailingData->mailing_phone);

        return [
            'patientData' => $patient->toArray(),
            'mailingData' => $mailingData->toArray()
        ];
    }

    /**
     * Centralized place to send emails.
     *
     * The function will create a multipart email from either an HTML template, or an array of html/text templates.
     *
     * @param string       $from
     * @param string       $to
     * @param string       $subject
     * @param string|array $template
     * @param array        $variables
     * @param array        $extraHeaders
     *
     * @return bool
     */

    // need to rewrite this function to the sctucture of Laravel
    private function sendEmail($from, $to, $subject, $template, $variables = [], $extraHeaders = [])
    {
        $newLine = "\n";
        $boundary = uniqid('ds3');
        $returnPath = preg_replace('/^.*?<(.+?)>$/', '$1', $from);
        $htmlContentType = 'Content-Type: text/html; charset=UTF-8';

        $headers = [
                "From: $from",
                "Reply-To: $from",
                "Return-Path: $returnPath",
                'X-Mailer: Dental Sleep Solutions Mailer',
                'MIME-Version: 1.0',
                "Content-Type: multipart/alternative; boundary=$boundary",
                'Date: '.date('n/d/Y g:i A'),
            ] + $extraHeaders;
        $headers = join($newLine, $headers) . $newLine;

        if (is_array($template)) {
            if (!isset($template['text']) && !isset($template['html'])) {
                throw new \RuntimeException('sendEmail requires the html or the text version of the message.');
            }

            $textBody = (string)array_get($template, 'text');
            $htmlBody = (string)array_get($template, 'html');
        } else {
            $htmlBody = (string)$template;
        }

        $htmlBody = tidyHtml($htmlBody);

        if (!isset($textBody) || !strlen($textBody)) {
            $textBody = \Html2Text\Html2Text::convert($htmlBody);
        }

        if ($variables) {
            $htmlBody = parseTemplate($htmlBody, $variables, true);
            $textBody = parseTemplate($textBody, $variables, true);
        }

        $body = $textBody .
            $newLine .
            $newLine .
            "--$boundary" .
            $newLine .
            $htmlContentType .
            $newLine .
            $newLine .
            $htmlBody;

        logEmailActivity($from, $to, $subject, $body, $headers);

        return mail($to, $subject, $body, $headers, "-f$returnPath");
    }
}
