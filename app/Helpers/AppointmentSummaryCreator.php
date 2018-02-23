<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\AnnualRecallTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\DelayingTreatmentTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\FirstRefusedTreatmentTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\FollowUpTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\ImpressionTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\NonCompliantTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\NotCandidateTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\SecondRefusedTreatmentTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\TerminationTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\TreatmentCompleteTrigger;

class AppointmentSummaryCreator
{
    /** @var LetterTrigger */
    private $letterTrigger;

    /** @var IdListCleaner */
    private $idListCleaner;

    /** @var AppointmentSummaryRepository */
    private $appointmentSummaryRepository;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(
        LetterTrigger $letterTrigger,
        IdListCleaner $idListCleaner,
        AppointmentSummaryRepository $appointmentSummaryRepository,
        UserRepository $userRepository
    ) {
        $this->letterTrigger = $letterTrigger;
        $this->idListCleaner = $idListCleaner;
        $this->appointmentSummaryRepository = $appointmentSummaryRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $stepId
     * @param int $patientId
     * @param int $docId
     * @return array
     * @throws GeneralException
     */
    public function createAppointmentSummary($stepId, $patientId, $docId)
    {
        $numSteps = null;
        $impressionDevice = true;
        $letterIds = [];
        $create = true;

        $letterRow = $this->userRepository->getLetterInfo($docId);
        $createLetters = false;
        if ($letterRow && $letterRow->use_letters && $letterRow->tracker_letters) {
            $createLetters = true;
        }
        if ($stepId == 7 || $stepId == 4) {  //device deliver - check if impressions are done
            $firstImpression = $this->appointmentSummaryRepository->getDeviceDelivery($patientId);
            $impressionDevice = false;
            if ($firstImpression) {
                $impressionDevice = $firstImpression->device_id;
            }
        }
        if ($stepId == 7) {
            $sql = "SELECT * FROM dental_ex_page5 where patientid=$patientId";
            if ($db->getNumberRows($sql) == 0) {
                $sqlex = "INSERT INTO dental_ex_page5 set
                  dentaldevice_date = CURDATE(),
                  patientid = $patientId,
                  userid = {$_SESSION['userid']},
                  docid = {$_SESSION['docid']},
                  adddate = now(),
                  ip_address = '{$_SERVER['REMOTE_ADDR']}'";
            } else {
                $sqlex = "update dental_ex_page5 set dentaldevice_date=CURDATE() where patientid=$patientId";
            }
            $db->query($sqlex);
        }
        if (empty($create)) {
            // @todo: set error message
            throw new GeneralException('');
        }
        $query = "INSERT INTO dental_flow_pg2_info SET
          patientid=$patientId,
          segmentid=$stepId,
          appointment_type=1,";
        if ($impressionDevice) {
            $query .= " device_id='$impressionDevice',";
        }
        $query .= ' date_completed = CURDATE()';
        $insertId = $db->getInsertId($query);
        if ($insertId) {
            $db->query("DELETE FROM dental_flow_pg2_info WHERE appointment_type=0 AND patientid=$patientId");
        }
        if (!empty($createLetters)) {
            switch ($stepId) {
                case 8: // Follow-Up/Check
                    $triggerQuery = "SELECT dental_flow_pg2_info.patientid, dental_flow_pg2_info.date_completed FROM dental_flow_pg2_info WHERE dental_flow_pg2_info.segmentid = '7' AND dental_flow_pg2_info.date_completed != '0000-00-00' AND dental_flow_pg2_info.patientid = $patientId";
                    $numRows = $db->getNumberRows($triggerQuery);
                    if ($numRows > 0) {
                        $trigger = new FollowUpTrigger();
                        $letterIds[] = $trigger->triggerLetter($patientId, $insertId);
                    }
                    break;
                case 13: // Termination
                    $trigger = new TerminationTrigger();
                    $letterIds[] = $trigger->triggerLetter($patientId, $insertId);
                    break;
                case 4: // Impressions
                    $trigger = new ImpressionTrigger();
                    $letterIds[] = $trigger->triggerLetter($patientId, $insertId);
                    break;
            }
        }
        $consultQuery = "SELECT date_completed FROM dental_flow_pg2_info WHERE segmentid = '2' and patientid = $patientId LIMIT 1";
        $consultResult = $db->getResults($consultQuery);
        $consulted = false;
        if (count($consultResult) > 0) {
            $consult_date = $consultResult[0]['date_completed'];
            if ($consult_date != "0000-00-00") {
                $consulted = true;
            }
        }
        if (!empty($createLetters)) {
            switch ($stepId) {
                // Delaying Treatment / Waiting
                case 5:
                    if ($consulted) {
                        $trigger = new DelayingTreatmentTrigger();
                        $letterIds[] = $trigger->triggerLetter($patientId, $insertId);
                    }
                    break;
                case 6:
                    if ($consulted) {
                        $firstTrigger = new FirstRefusedTreatmentTrigger();
                        $letterIds[] = $firstTrigger->triggerLetter($patientId, $insertId);
                        $secondTrigger = new SecondRefusedTreatmentTrigger();
                        $letterIds[] = $secondTrigger->triggerLetter($patientId, $insertId);
                    }
                    break;
                case 9:
                    $trigger = new NonCompliantTrigger();
                    $letterIds[] = $trigger->triggerLetter($patientId, $insertId);
                    break;
                case 11:
                    $trigger = new TreatmentCompleteTrigger();
                    $letterIds[] = $trigger->triggerLetter($patientId, $insertId);
                    break;
                case 12:
                    $trigger = new AnnualRecallTrigger();
                    $letterIds[] = $trigger->triggerLetter($patientId, $insertId);
                    break;
                case 14:
                    $trigger = new NotCandidateTrigger();
                    $letterIds[] = $trigger->triggerLetter($patientId, $insertId);
                    break;
            }
        }
        if (!empty($letterIds)) {
            // Cast values to integers
            array_walk($letterIds, function (&$each) {
                $each = (int)$each;
            });
            // Remove duplicates
            $letterIds = array_unique($letterIds);
            // Keep values greater than zero
            $letterIds = array_filter($letterIds, function ($each) {
                return $each > 0;
            });
        }
        $letter_count = 0;
        if (count($letterIds) > 0 && $createLetters) {
            $letterIdList = implode(',', $letterIds);
            $dentalLettersQuery = "SELECT patientid, letterid, UNIX_TIMESTAMP(generated_date) as generated_date, topatient, md_list, md_referral_list, pdf_path, status, delivered, dental_letter_templates.name, dental_letter_templates.template, deleted FROM dental_letters LEFT JOIN dental_letter_templates ON dental_letters.templateid=dental_letter_templates.id WHERE patientid = $patientId AND (letterid IN($letterIdList) OR parentid IN($letterIdList));";
            $dentalLettersResult = $db->getResults($dentalLettersQuery);
            $dentalLetters = [];
            if (!empty($dentalLettersResult)) {
                foreach ($dentalLettersResult as $row) {
                    $dentalLetters[] = $row;
                    $rowPatient = '';
                    if ($row['topatient'] == "1") {
                        $rowPatient = $row['patientid'];
                    };
                    $contacts = $this->getContactInfo($rowPatient, $row['md_list'], $row['md_referral_list']);
                    $letter_count += count($contacts['patient']) + count($contacts['md_referrals']) + count($contacts['mds']);
                }
            }
        }
        $segments = [];
        $segments[1] = "Initial Contact";
        $segments[15] = "Baseline Sleep Test";
        $segments[2] = "Consult";
        $segments[4] = "Impressions";
        $segments[7] = "Device Delivery";
        $segments[8] = "Check / Follow Up";
        $segments[10] = "Home Sleep Test";
        $segments[3] = "Sleep Study";
        $segments[11] = "Treatment Complete";
        $segments[12] = "Annual Recall";
        $segments[14] = "Not a Candidate";
        $segments[5] = "Delaying Tx / Waiting";
        $segments[9] = "Pt. Non-Compliant";
        $segments[6] = "Refused Treatment";
        $segments[13] = "Termination";

        $title = $segments[$stepId];

        $nextSql = "SELECT steps.* FROM dental_flowsheet_steps steps
            JOIN dental_flowsheet_steps_next next ON steps.id = next.child_id
            WHERE next.parent_id=$stepId
            ORDER BY next.sort_by ASC";
        $nextQuery = $db->getResults($nextSql);

        $impressionJson = 'false';
        if ($impressionDevice) {
            $impressionJson = $impressionDevice;
        }
        $result = [
            'success' => true,
            'datecomp' => date('m/d/Y'),
            'id' => $insertId,
            'next_steps' => $next,
            'title' => $title,
            'letters' => $letter_count,
            'impression' => $impressionJson,
        ];
        return $result;
    }

    private function getContactInfo ($patient, $md_list, $md_referral_list, $pat_referral_list = null, $letterid = 0) {

        $db = new Db();
        $contact_info = array();

        $patient = $this->idListCleaner->clearIdList($patient);
        $md_list = $this->idListCleaner->clearIdList($md_list);
        $md_referral_list = $this->idListCleaner->clearIdList($md_referral_list);
        $pat_referral_list = $this->idListCleaner->clearIdList($pat_referral_list);

        if (isset($patient)) {
            $sql = "SELECT patientid AS id, salutation, firstname, lastname, add1, add2, city, state, zip, email, preferredcontact, ".$letterid." AS letterid FROM dental_patients WHERE patientid IN('".$patient."');";
            $result = $db->getResults($sql);
            if ($result) {
                foreach ($result as $row) {
                    $contact_info['patient'][] = $row;
                }
            }
        }
        if (isset($md_list) && $md_list != "") {
            $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, ".$letterid." AS letterid, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid IN(".$md_list.");";
            $result = $db->getResults($sql);
            if ($result) {
                foreach ($result as $row) {
                    $contact_info['mds'][] = $row;
                }
            }
        }
        if (isset($md_referral_list) && $md_referral_list != "") {
            $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.lastname, dental_contact.middlename, dental_contact.firstname, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contact.contacttypeid, ".$letterid." AS letterid, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid IN(".$md_referral_list.");";
            $result = $db->getResults($sql);
            if ($result) {
                foreach ($result as $row) {
                    $contact_info['md_referrals'][] = $row;
                }
            }
        }

        if (isset($pat_referral_list) && $pat_referral_list != "") {
            $sql = "SELECT p.patientid AS id,
              p.salutation,
              p.lastname,
              p.middlename,
              p.firstname,
              '' as company,
              p.add1,
              p.add2,
              p.city,
              p.state,
              p.zip,
              p.email,
              '' as fax,
              p.preferredcontact,
              '' as contacttypeid,
              ".$letterid." AS letterid,
              p.status
            FROM dental_patients p WHERE p.patientid IN(".$pat_referral_list.");";
            $result = $db->getResults($sql);
            if ($result) {
                foreach ($result as $row) {
                    $contact_info['pat_referrals'][] = $row;
                }
            }
        }

        return $contact_info;
    }
}
