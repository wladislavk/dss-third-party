<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Summary as Resource;
use DentalSleepSolutions\Contracts\Repositories\Summaries as Repository;

/**
 * DentalSleepSolutions\Eloquent\Dental\Summary
 *
 * @property int $summaryid
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $patient_name
 * @property string|null $patient_dob
 * @property string $docpcp
 * @property string $docsmd
 * @property string $docomd1
 * @property string $docomd2
 * @property string $docdds
 * @property string $osite
 * @property string|null $referral_source
 * @property string|null $reason_seeking_tx
 * @property string|null $symptoms_osa
 * @property string|null $bed_time_partner
 * @property string|null $snoring
 * @property string|null $apnea
 * @property string|null $history_surgery
 * @property string|null $tried_cpap
 * @property int $cpap_totalnights
 * @property string $fna
 * @property string|null $cpap_date
 * @property string|null $problem_cpap
 * @property string|null $wearing_cpap
 * @property string|null $max_translation_from
 * @property string|null $max_translation_to
 * @property string|null $max_translation_equal
 * @property string|null $initial_device_titration_1
 * @property string|null $initial_device_titration_equal_h
 * @property string $initial_device_titration_equal_v
 * @property string|null $optimum_echovision_ver
 * @property string|null $optimum_echovision_hor
 * @property string|null $type_device
 * @property string|null $personal
 * @property string|null $lab_name
 * @property string|null $sti_test_1
 * @property string|null $sti_test_2
 * @property string|null $sti_test_3
 * @property string|null $sti_test_4
 * @property string|null $sti_date_1
 * @property string|null $sti_date_2
 * @property string|null $sti_date_3
 * @property string|null $sti_date_4
 * @property string|null $sti_ahi_1
 * @property string|null $sti_ahi_2
 * @property string|null $sti_ahi_3
 * @property string|null $sti_ahi_4
 * @property string|null $sti_rdi_1
 * @property string|null $sti_rdi_2
 * @property string|null $sti_rdi_3
 * @property string|null $sti_rdi_4
 * @property string|null $sti_supine_ahi_1
 * @property string|null $sti_supine_ahi_2
 * @property string|null $sti_supine_ahi_3
 * @property string|null $sti_supine_ahi_4
 * @property string|null $sti_supine_rdi_1
 * @property string|null $sti_supine_rdi_2
 * @property string|null $sti_supine_rdi_3
 * @property string|null $sti_supine_rdi_4
 * @property string|null $sti_lsat_1
 * @property string|null $sti_lsat_2
 * @property string|null $sti_lsat_3
 * @property string|null $sti_lsat_4
 * @property string|null $sti_titration_1
 * @property string|null $sti_titration_2
 * @property string|null $sti_titration_3
 * @property string|null $sti_titration_4
 * @property string|null $sti_cpap_p_1
 * @property string|null $sti_cpap_p_2
 * @property string|null $sti_cpap_p_3
 * @property string|null $sti_cpap_p_4
 * @property string|null $sti_apnea_1
 * @property string|null $sti_apnea_2
 * @property string|null $sti_apnea_3
 * @property string|null $sti_apnea_4
 * @property string|null $ep_date_1
 * @property string|null $ep_date_2
 * @property string|null $ep_date_3
 * @property string|null $ep_date_4
 * @property string|null $ep_date_5
 * @property string $dset1
 * @property string $dset2
 * @property string $dset3
 * @property string $dset4
 * @property string $dset5
 * @property string|null $ep_e_1
 * @property string|null $ep_e_2
 * @property string|null $ep_e_3
 * @property string|null $ep_e_4
 * @property string|null $ep_e_5
 * @property string|null $ep_s_1
 * @property string|null $ep_s_2
 * @property string|null $ep_s_3
 * @property string|null $ep_s_4
 * @property string|null $ep_s_5
 * @property string|null $ep_w_1
 * @property string|null $ep_w_2
 * @property string|null $ep_w_3
 * @property string|null $ep_w_4
 * @property string|null $ep_w_5
 * @property string|null $ep_a_1
 * @property string|null $ep_a_2
 * @property string|null $ep_a_3
 * @property string|null $ep_a_4
 * @property string|null $ep_a_5
 * @property string|null $ep_el_1
 * @property string|null $ep_el_2
 * @property string|null $ep_el_3
 * @property string|null $ep_el_4
 * @property string|null $ep_el_5
 * @property string|null $ep_h_1
 * @property string|null $ep_h_2
 * @property string|null $ep_h_3
 * @property string|null $ep_h_4
 * @property string|null $ep_h_5
 * @property string|null $ep_r_1
 * @property string|null $ep_r_2
 * @property string|null $ep_r_3
 * @property string|null $ep_r_4
 * @property string|null $ep_r_5
 * @property string|null $mini_consult
 * @property string|null $exam_impressions
 * @property string|null $oa_soap
 * @property string|null $fm_blue
 * @property string|null $oa_check_1
 * @property string|null $oa_check_2
 * @property string|null $oa_check_3
 * @property string|null $oa_check_4
 * @property string|null $oa_check_5
 * @property string|null $oa_check_6
 * @property string|null $month_check_1
 * @property string|null $month_check_2
 * @property string|null $month_check_3
 * @property string|null $month_check_4
 * @property string|null $oa_psg
 * @property string|null $year_check_1
 * @property string|null $year_check_2
 * @property string|null $year_check_3
 * @property string|null $year_check_4
 * @property string|null $additional_notes
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $office
 * @property string|null $sleep_same_room
 * @property string|null $currently_wearing
 * @property string|null $what_percentage
 * @property string|null $how_long
 * @property string|null $sleep_md
 * @property string|null $test_type_name
 * @property string|null $sti_sleep_efficiency_1
 * @property string|null $sti_sleep_efficiency_2
 * @property string|null $sti_sleep_efficiency_3
 * @property string|null $sti_sleep_efficiency_4
 * @property string|null $sti_rem_ahi_1
 * @property string|null $sti_rem_ahi_2
 * @property string|null $sti_rem_ahi_3
 * @property string|null $sti_rem_ahi_4
 * @property string|null $sti_o2_1
 * @property string|null $sti_o2_2
 * @property string|null $sti_o2_3
 * @property string|null $sti_o2_4
 * @property string|null $sti_other_1
 * @property string|null $sti_other_2
 * @property string|null $sti_other_3
 * @property string|null $sti_other_4
 * @property string|null $ep_ts_1
 * @property string|null $ep_ts_2
 * @property string|null $ep_ts_3
 * @property string|null $ep_ts_4
 * @property string|null $ep_ts_5
 * @property string|null $ep_tr_1
 * @property string|null $ep_tr_2
 * @property string|null $ep_tr_3
 * @property string|null $ep_tr_4
 * @property string|null $ep_tr_5
 * @property string $appt_notes_1
 * @property string $appt_notes_2
 * @property string $appt_notes_3
 * @property string $appt_notes_4
 * @property string $appt_notes_1p3
 * @property string $appt_notes_2p3
 * @property string $appt_notes_3p3
 * @property string $appt_notes_4p3
 * @property string $appt_notes_5p3
 * @property string $wapn1
 * @property string $wapn2
 * @property string $wapn3
 * @property string $wapn4
 * @property string $wapn5
 * @property string $patientphoto
 * @property string $sleep_qual1
 * @property string $sleep_qual2
 * @property string $sleep_qual3
 * @property string $sleep_qual4
 * @property string $sleep_qual5
 * @property int|null $location
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereAdditionalNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApnea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes1p3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes2p3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes3p3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes4p3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes5p3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereBedTimePartner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereCpapDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereCpapTotalnights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereCurrentlyWearing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDocdds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDocomd1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDocomd2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDocpcp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDocsmd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDset1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDset2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDset3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDset4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDset5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpA1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpA2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpA3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpA4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpA5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpDate1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpDate2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpDate3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpDate4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpDate5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpE1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpE2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpE3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpE4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpE5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpEl1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpEl2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpEl3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpEl4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpEl5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpH2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpH3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpH4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpH5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpR1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpR2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpR3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpR4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpR5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpS2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpS3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpS4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpS5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTr1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTr2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTr3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTr4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTr5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTs1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTs2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTs3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTs4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTs5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpW1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpW2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpW3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpW4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpW5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereExamImpressions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereFmBlue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereFna($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereHistorySurgery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereHowLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereInitialDeviceTitration1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereInitialDeviceTitrationEqualH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereInitialDeviceTitrationEqualV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereLabName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMaxTranslationEqual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMaxTranslationFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMaxTranslationTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMiniConsult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMonthCheck1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMonthCheck2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMonthCheck3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMonthCheck4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaCheck1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaCheck2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaCheck3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaCheck4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaCheck5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaCheck6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaPsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaSoap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOptimumEchovisionHor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOptimumEchovisionVer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary wherePatientDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary wherePatientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary wherePatientphoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary wherePersonal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereProblemCpap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereReasonSeekingTx($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereReferralSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepMd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepQual1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepQual2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepQual3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepQual4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepQual5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepSameRoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSnoring($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiAhi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiAhi2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiAhi3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiAhi4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiApnea1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiApnea2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiApnea3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiApnea4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiCpapP1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiCpapP2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiCpapP3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiCpapP4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiDate1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiDate2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiDate3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiDate4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiLsat1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiLsat2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiLsat3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiLsat4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiO21($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiO22($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiO23($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiO24($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiOther1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiOther2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiOther3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiOther4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRdi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRdi2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRdi3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRdi4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRemAhi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRemAhi2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRemAhi3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRemAhi4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSleepEfficiency1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSleepEfficiency2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSleepEfficiency3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSleepEfficiency4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineAhi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineAhi2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineAhi3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineAhi4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineRdi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineRdi2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineRdi3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineRdi4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTest1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTest2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTest3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTest4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTitration1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTitration2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTitration3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTitration4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSummaryid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSymptomsOsa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereTestTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereTriedCpap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereTypeDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWapn1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWapn2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWapn3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWapn4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWapn5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWearingCpap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWhatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereYearCheck1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereYearCheck2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereYearCheck3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereYearCheck4($value)
 * @mixin \Eloquent
 */
class Summary extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['summaryid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_summary';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'summaryid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    /**
     * @param array $fields
     * @param array $where
     * @return Summary[]
     */
    public function getWithFilter($fields = [], $where = [])
    {
        $object = $this;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }

    public function updateForPatient($patientId = 0, $data = [])
    {
        $this->where('patientid', $patientId)
            ->update($data);
    }
}
