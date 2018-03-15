<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Factories\LetterTriggerFactory;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\FirstRefusedTreatmentTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\SecondRefusedTreatmentTrigger;
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;

class AppointmentSummaryCreator
{
    private const SEGMENTS = [
        1 => 'Initial Contact',
        2 => 'Consult',
        3 => 'Sleep Study',
        4 => 'Impressions',
        5 => 'Delaying Tx / Waiting',
        6 => 'Refused Treatment',
        7 => 'Device Delivery',
        8 => 'Check / Follow Up',
        9 => 'Pt. Non-Compliant',
        10 => 'Home Sleep Test',
        11 => 'Treatment Complete',
        12 => 'Annual Recall',
        13 => 'Termination',
        14 => 'Not a Candidate',
        15 => 'Baseline Sleep Test',
    ];

    private const STEPS_WITH_LETTERS = [4, 5, 6, 8, 9, 11, 12, 13, 14];

    /** @var LetterTriggerFactory */
    private $letterTriggerFactory;

    /** @var IdListCleaner */
    private $idListCleaner;

    /** @var AppointmentSummaryRepository */
    private $appointmentSummaryRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var TmjClinicalExamRepository */
    private $clinicalExamRepository;

    /** @var ContactRepository */
    private $contactRepository;

    /** @var LetterRepository */
    private $letterRepository;

    public function __construct(
        LetterTriggerFactory $letterTriggerFactory,
        IdListCleaner $idListCleaner,
        AppointmentSummaryRepository $appointmentSummaryRepository,
        UserRepository $userRepository,
        TmjClinicalExamRepository $clinicalExamRepository,
        ContactRepository $contactRepository,
        LetterRepository $letterRepository
    ) {
        $this->letterTriggerFactory = $letterTriggerFactory;
        $this->idListCleaner = $idListCleaner;
        $this->appointmentSummaryRepository = $appointmentSummaryRepository;
        $this->userRepository = $userRepository;
        $this->clinicalExamRepository = $clinicalExamRepository;
        $this->contactRepository = $contactRepository;
        $this->letterRepository = $letterRepository;
    }

    /**
     * @param int $stepId
     * @param int $patientId
     * @param int $docId
     * @param int $userId
     * @return array
     * @throws GeneralException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Exception
     */
    public function createAppointmentSummary(int $stepId, int $patientId, int $docId, int $userId): array
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
            /** @var TmjClinicalExam[] $clinicalExams */
            $clinicalExams = $this->clinicalExamRepository->findByField('patientid', $patientId);
            if (isset($clinicalExams[0])) {
                $clinicalExam = $clinicalExams[0];
            } else {
                $clinicalExam = new TmjClinicalExam();
                $clinicalExam->patientid = $patientId;
                $clinicalExam->userid = $userId;
                $clinicalExam->docid = $docId;
            }
            $clinicalExam->dentaldevice_date = new \DateTime();
            $clinicalExam->save();
        }
        if (empty($create)) {
            // @todo: set error message
            throw new GeneralException('');
        }
        $newAppointmentSummary = new AppointmentSummary();
        $newAppointmentSummary->patientid = $patientId;
        $newAppointmentSummary->segmentid = $stepId;
        $newAppointmentSummary->appointment_type = 1;
        $newAppointmentSummary->date_completed = new \DateTime();
        $newAppointmentSummary->save();
        $insertId = $newAppointmentSummary->id;
        if ($insertId) {
            $futureAppointment = $this->appointmentSummaryRepository->getFutureAppointment($patientId);
            if ($futureAppointment) {
                $futureAppointment->delete();
            }
        }
        $stepId = 2;
        $completed = $this->appointmentSummaryRepository->getCompletedByPatient($stepId, $patientId);
        $trigger = $this->letterTriggerFactory->getLetterTrigger($stepId);
        $triggerData = new SummaryLetterTriggerData();
        $triggerData->patientId = $patientId;
        $triggerData->infoId = $insertId;
        $triggerData->userId = $userId;
        $triggerData->docId = $docId;
        if ($createLetters && in_array($stepId, self::STEPS_WITH_LETTERS)) {
            switch ($stepId) {
                case 6:
                    if ($completed) {
                        $firstTrigger = new FirstRefusedTreatmentTrigger();
                        $letterIds[] = $firstTrigger->triggerLetter($triggerData);
                        $secondTrigger = new SecondRefusedTreatmentTrigger();
                        $letterIds[] = $secondTrigger->triggerLetter($triggerData);
                    }
                    break;
                case 4:
                    // fall through
                case 5:
                    // fall through
                case 8:
                    // fall through
                case 9:
                    // fall through
                case 11:
                    // fall through
                case 12:
                    // fall through
                case 13:
                    // fall through
                case 14:
                    $newLetterId = $trigger->triggerLetter($triggerData);
                    if ($newLetterId) {
                        $letterIds[] = $newLetterId;
                    }
                    break;
            }
        }
        $letterIds = array_unique($letterIds);
        $letterIds = array_filter($letterIds, function ($each) {
            return $each > 0;
        });
        $letter_count = 0;
        if (count($letterIds) > 0 && $createLetters) {
            $letterIdList = implode(',', $letterIds);
            $dentalLettersResult = $this->letterRepository->getByPatientAndIdList($patientId, $letterIdList);
            $dentalLetters = [];
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

        $title = self::SEGMENTS[$stepId];

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

    private function getContactInfo (
        ?string $patient,
        ?string $md_list,
        ?string $md_referral_list,
        ?string $pat_referral_list = null,
        int $letterid = 0
    ) {
        $contact_info = [];

        $patient = $this->idListCleaner->clearIdList($patient);
        $md_list = $this->idListCleaner->clearIdList($md_list);
        $md_referral_list = $this->idListCleaner->clearIdList($md_referral_list);
        $pat_referral_list = $this->idListCleaner->clearIdList($pat_referral_list);

        if (isset($patient)) {
            $sql = "
            SELECT patientid AS id, salutation, firstname, lastname, add1, add2, city, state, zip, email, preferredcontact, ".$letterid." AS letterid 
            FROM dental_patients 
            WHERE patientid IN('".$patient."');";
            $result = $db->getResults($sql);
            if ($result) {
                foreach ($result as $row) {
                    $contact_info['patient'][] = $row;
                }
            }
        }
        if (isset($md_list) && $md_list != "") {
            $result = $this->contactRepository->getWithContactTypeByList($md_list);
            foreach ($result as $row) {
                $row['letterid'] = $letterid;
                $contact_info['mds'][] = $row;
            }
        }
        if (isset($md_referral_list) && $md_referral_list != "") {
            $result = $this->contactRepository->getWithContactTypeByList($md_referral_list);
            foreach ($result as $row) {
                $row['letterid'] = $letterid;
                $contact_info['md_referrals'][] = $row;
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
