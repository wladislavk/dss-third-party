<?php

namespace DentalSleepSolutions\Libraries;

// Need to rewrite this class to laravel structure

require_once 'constants.inc';

class ClaimFormData
{
    /**
     * @var bool
     */
    static $throwExceptions = false;

    /**
     * List of fields that need to be taken into consideration when populating boxes 32. and 33.
     *
     * @var array
     */
    private static $taxDataFields = [
        'city',
        'state',
        'zip',
        'phone',
        'practice',
        'address',
        'medicare_npi',
        'npi',
        'tax_id_or_ssn',
        'ssn',
        'ein',
        'use_service_npi',
        'service_city',
        'service_state',
        'service_zip',
        'service_name',
        'service_address',
        'service_medicare_npi',
        'service_npi'
    ];

    /**
     * @var array
     */
    private static $claimStatuses = [
        'pending'             => [DSS_CLAIM_PENDING, DSS_CLAIM_SEC_PENDING],
        'sent'                => [DSS_CLAIM_SENT, DSS_CLAIM_SEC_SENT],
        'paid'                => [DSS_CLAIM_PAID_INSURANCE, DSS_CLAIM_PAID_SEC_INSURANCE,
                                    DSS_CLAIM_PAID_PATIENT, DSS_CLAIM_PAID_SEC_PATIENT],
        'paid-insurance'      => [DSS_CLAIM_PAID_INSURANCE, DSS_CLAIM_PAID_SEC_INSURANCE],
        'paid-patient'        => [DSS_CLAIM_PAID_PATIENT, DSS_CLAIM_PAID_SEC_PATIENT],
        'dispute'             => [DSS_CLAIM_DISPUTE, DSS_CLAIM_SEC_DISPUTE,
                                    DSS_CLAIM_PATIENT_DISPUTE, DSS_CLAIM_SEC_PATIENT_DISPUTE],
        'dispute-not-patient' => [DSS_CLAIM_DISPUTE, DSS_CLAIM_SEC_DISPUTE],
        'dispute-patient'     => [DSS_CLAIM_PATIENT_DISPUTE, DSS_CLAIM_SEC_PATIENT_DISPUTE],
        'rejected'            => [DSS_CLAIM_REJECTED, DSS_CLAIM_SEC_REJECTED],
        'efile-accepted'      => [DSS_CLAIM_EFILE_ACCEPTED, DSS_CLAIM_SEC_EFILE_ACCEPTED],
        'actionable'          => [DSS_CLAIM_PENDING, DSS_CLAIM_SEC_PENDING,
                                    DSS_CLAIM_REJECTED, DSS_CLAIM_SEC_REJECTED,
                                    DSS_CLAIM_DISPUTE, DSS_CLAIM_SEC_DISPUTE,
                                    DSS_CLAIM_PATIENT_DISPUTE, DSS_CLAIM_SEC_PATIENT_DISPUTE],
    ];

    /**
     * Auxiliary function to determine sequence of the claim status
     *
     * @param int $status
     * @return bool
     */
    public static function isPrimary ($status) {
        return !self::isSecondary($status);
    }

    /**
     * Auxiliary function to determine sequence of the claim status
     *
     * @param int $status
     * @return bool
     */
    public static function isSecondary ($status) {
        return in_array(
            $status,
            [
                DSS_CLAIM_SEC_PENDING,
                DSS_CLAIM_SEC_SENT,
                DSS_CLAIM_SEC_DISPUTE,
                DSS_CLAIM_PAID_SEC_INSURANCE,
                DSS_CLAIM_PAID_SEC_PATIENT,
                DSS_CLAIM_SEC_PATIENT_DISPUTE,
                DSS_CLAIM_SEC_REJECTED,
                DSS_CLAIM_SEC_EFILE_ACCEPTED,
            ]
        );
    }

    /**
     * Auxiliary function to get the list of statuses that belong to a status label
     *
     * Most statuses are pairs, being the first one the primary, and the second one the secondary.
     *
     * In case there are more than 2 states, odd elements represent primary statuses, even elements represent
     * secondary statuses.
     *
     * @param string $name
     * @return array
     */
    public static function statusListByName ($name) {
        $statusList = self::$claimStatuses;

        if (array_key_exists($name, $statusList)) {
                return $statusList[$name];
        }

        return [];
    }

    /**
     * Auxiliary method to identify associated statuses. Useful for filtering functionality where the legacy code
     * only implements a single status (almost always primary).
     *
     * The function can return an empty array, or an array with one or two items.
     * There are statuses that appear in more than one named status.
     *
     * @param int $status
     * @return array
     */
    public static function statusListByStatus ($status) {
        $statusList = self::$claimStatuses;

        // Only return sections of the statuses where the status appear
        $filteredList = array_filter($statusList, function ($statuses) use ($status) {
            return in_array($status, $statuses);
        });

        return $filteredList;
    }

    /**
     * Auxiliary method to determine the name of the status passed
     *
     * @param int $status
     * @return string
     */
    public static function statusName ($status) {
        /**
         * There are status names that represent collections of statuses, we are not interested on those.
         * The result must be an array if zero or one element
         */
        $possibleStatuses = self::statusListByStatus($status);
        $possibleStatuses = array_except($possibleStatuses, ['paid', 'dispute', 'actionable']);

        if ($possibleStatuses) {
            reset($possibleStatuses);
            return key($possibleStatuses);
        }

        return '';
    }

    /**
     * Auxiliary function to determine if some status matches any of the labels/names
     *
     * @param string|array $names
     * @param int          $status
     * @return bool
     */
    public static function isStatus ($names, $status) {
        if (is_string($names)) {
            $names = [$names];
        }

        foreach ($names as $name) {
            $statusList = self::statusListByName($name);

            if (in_array($status, $statusList)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Auxiliary function to error logs, or throw exceptions
     *
     * @param string $message
     * @throws \RuntimeException
     */
    private static function raiseError ($message) {
        if (self::$throwExceptions) {
            throw new \RuntimeException($message);
        }

        error_log($message);
    }

    /**
     * Auxiliary method to:
     *
     * - whitelist db column fields
     * - escape fields
     * - concatenate fields: column_name = "column value", ...
     *
     * Ready for DB insertion
     *
     * @param array $claimData
     * @return string
     */
    private static function prepareClaimDataFields ($claimData) {
        $db = new Db();

        $dbFields = [
            'pica1',
            'pica2',
            'pica3',
            'insurance_type',
            'other_insurance_type',
            'insured_id_number',
            'patient_lastname',
            'patient_firstname',
            'patient_middle',
            'patient_dob',
            'patient_sex',
            'insured_firstname',
            'insured_lastname',
            'insured_middle',
            'patient_address',
            'patient_relation_insured',
            'patient_relation_other_insured',
            'patient_city',
            'patient_state',
            'patient_status',
            'responsibility_sequence',
            'another_plan',
            'icd_ind',
            'insured_address',
            'insured_city',
            'insured_state',
            'insured_zip',
            'other_insured_address',
            'other_insured_city',
            'other_insured_state',
            'other_insured_zip',
            'patient_zip',
            'patient_phone_code',
            'patient_phone',
            'insured_phone_code',
            'insured_phone',
            'other_insured_firstname',
            'other_insured_lastname',
            'other_insured_middle',
            'employment',
            'auto_accident',
            'auto_accident_place',
            'other_accident',
            'insured_policy_group_feca',
            'other_insured_policy_group_feca',
            'insured_dob',
            'insured_sex',
            'other_insured_dob',
            'other_insured_sex',
            'insured_employer_school_name',
            'other_insured_employer_school_name',
            'insured_insurance_plan',
            'other_insured_insurance_plan',
            'reserved_local_use',
            'patient_signature',
            'patient_signed_date',
            'insured_signature',
            'date_current',
            'date_same_illness',
            'unable_date_from',
            'unable_date_to',
            'referring_provider',
            'field_17a_dd',
            'field_17a',
            'field_17b',
            'hospitalization_date_from',
            'hospitalization_date_to',
            'reserved_local_use1',
            'outside_lab',
            's_charges',
            'diagnosis_1',
            'diagnosis_2',
            'diagnosis_3',
            'diagnosis_4',
            'diagnosis_a',
            'diagnosis_b',
            'diagnosis_c',
            'diagnosis_d',
            'diagnosis_e',
            'diagnosis_f',
            'diagnosis_g',
            'diagnosis_h',
            'diagnosis_i',
            'diagnosis_j',
            'diagnosis_k',
            'diagnosis_l',
            'resubmission_code_fill',
            'medicaid_resubmission_code',
            'original_ref_no',
            'prior_authorization_number',
            'service_date1_from',
            'service_date1_to',
            'place_of_service1',
            'emg1',
            'cpt_hcpcs1',
            'modifier1_1',
            'modifier1_2',
            'modifier1_3',
            'modifier1_4',
            'diagnosis_pointer1',
            's_charges1_1',
            's_charges1_2',
            'days_or_units1',
            'epsdt_family_plan1',
            'id_qua1',
            'rendering_provider_id1',
            'service_date2_from',
            'service_date2_to',
            'place_of_service2',
            'emg2',
            'cpt_hcpcs2',
            'modifier2_1',
            'modifier2_2',
            'modifier2_3',
            'modifier2_4',
            'diagnosis_pointer2',
            's_charges2_1',
            's_charges2_2',
            'days_or_units2',
            'epsdt_family_plan2',
            'id_qua2',
            'rendering_provider_id2',
            'service_date3_from',
            'service_date3_to',
            'place_of_service3',
            'emg3',
            'cpt_hcpcs3',
            'modifier3_1',
            'modifier3_2',
            'modifier3_3',
            'modifier3_4',
            'diagnosis_pointer3',
            's_charges3_1',
            's_charges3_2',
            'days_or_units3',
            'epsdt_family_plan3',
            'id_qua3',
            'rendering_provider_id3',
            'service_date4_from',
            'service_date4_to',
            'place_of_service4',
            'emg4',
            'cpt_hcpcs4',
            'modifier4_1',
            'modifier4_2',
            'modifier4_3',
            'modifier4_4',
            'diagnosis_pointer4',
            's_charges4_1',
            's_charges4_2',
            'days_or_units4',
            'epsdt_family_plan4',
            'id_qua4',
            'rendering_provider_id4',
            'service_date5_from',
            'service_date5_to',
            'place_of_service5',
            'emg5',
            'cpt_hcpcs5',
            'modifier5_1',
            'modifier5_2',
            'modifier5_3',
            'modifier5_4',
            'diagnosis_pointer5',
            's_charges5_1',
            's_charges5_2',
            'days_or_units5',
            'epsdt_family_plan5',
            'id_qua5',
            'rendering_provider_id5',
            'service_date6_from',
            'service_date6_to',
            'place_of_service6',
            'emg6',
            'cpt_hcpcs6',
            'modifier6_1',
            'modifier6_2',
            'modifier6_3',
            'modifier6_4',
            'diagnosis_pointer6',
            's_charges6_1',
            's_charges6_2',
            'days_or_units6',
            'epsdt_family_plan6',
            'id_qua6',
            'rendering_provider_id6',
            'federal_tax_id_number',
            'ssn',
            'ein',
            'patient_account_no',
            'accept_assignment',
            'total_charge',
            'amount_paid',
            'balance_due',
            'signature_physician',
            'physician_signed_date',
            'service_facility_info_name',
            'service_facility_info_address',
            'service_facility_info_city',
            'service_info_a',
            'service_info_dd',
            'service_info_b_other',
            'billing_provider_phone_code',
            'billing_provider_phone',
            'billing_provider_name',
            'billing_provider_address',
            'billing_provider_city',
            'billing_provider_a',
            'billing_provider_dd',
            'billing_provider_b_other',
            'p_m_eligible_payer_id',
            'p_m_eligible_payer_name',
            'p_m_billing_id',
            'p_m_dss_file',
            'billing_provider_taxonomy_code',

            'patientid',
            'docid',
            'userid',
            'producer',
            'status',
            'primary_claim_id',
            'ip_address'
        ];

        $escapedFields = [];

        foreach ($dbFields as $field) {
            $value = isset($claimData[$field]) ? $db->escape($claimData[$field]) : '';
            $escapedFields []= "$field = '$value'";
        }

        return implode(', ', $escapedFields);
    }

    /**
     * Auxiliary function to retrieve amount paid, from the primary claim
     *
     * @param int $claimId
     * @return int|float
     */
    public static function amountPaidForClaim ($claimId) {
        $db = new Db();
        $amount = 0;

        $primaryClaim = $db->getRow("SELECT amount_paid
            FROM dental_insurance
            WHERE insuranceid = '$claimId'");

        if ($primaryClaim) {
            $amount = $primaryClaim['amount_paid'];
        }

        return $amount;
    }

    /**
     * Retrieve ledger items for either the given claim, or a new claim
     *
     * @param int $claimId
     * @return array
     */
    public static function dynamicLedgerItems ($claimId) {
        $db = new Db();
        $claimId = intval($claimId);

        $claimData = $db->getRow("SELECT docid, patientid, insurance_type
            FROM dental_insurance
            WHERE insuranceid = '$claimId'");

        if (!$claimData) {
            return [];
        }

        $docId = intval($claimData['docid']);
        $patientId = intval($claimData['patientid']);
        $insuranceType = intval($claimData['insurance_type']);

        $isNewClaim = !$claimId;

        $trxnStatusPending = DSS_TRXN_PENDING;
        $trxnTypeMed = DSS_TRXN_TYPE_MED;

        // Non-strict comparison
        $insuranceSource = $insuranceType == 1 ? 'medicare_npi' : 'npi';
        $pendingOrLinkedConditional = $isNewClaim ? "ledger.status = '$trxnStatusPending'" :
            "(ledger.primary_claim_id = '$claimId' OR ledger.secondary_claim_id = '$claimId')";

        /**
         * Control the source of the producer / doctor.
         *
         * The LEFT JOIN on producerid will set the proper values for the producer. If the producerid is not valid then
         * the joined values will be null, evaluating to FALSE by default.
         *
         * Thus, the producer is the source of data if:
         *
         * - ledger.producerid is valid (given by the LEFT JOIN)
         * - producer.producer_files is set to "1"
         * - the given field is not empty
         *
         * Otherwise, retrieve data from the doctor.
         */
        $transactionsQuery = "SELECT
            ledger.*,
            trxn_code.days_units AS daysorunits,
            name_source.place_service AS 'place',
            description_source.description AS place_description,
            CASE WHEN producer.producer_files AND LENGTH(TRIM(producer.$insuranceSource))
                THEN producer.$insuranceSource
                ELSE doctor.$insuranceSource
            END AS 'provider_id',
            CASE WHEN producer.producer_files AND LENGTH(TRIM(producer.first_name))
                THEN producer.first_name
                ELSE doctor.first_name
            END AS 'provider_first_name',
            CASE WHEN producer.producer_files AND LENGTH(TRIM(producer.last_name))
                THEN producer.last_name
                ELSE doctor.last_name
            END AS 'provider_last_name'
        FROM dental_ledger ledger
            LEFT JOIN dental_transaction_code trxn_code ON (
                trxn_code.transaction_code = ledger.transaction_code
                OR trxn_code.description = ledger.description
            )
            JOIN dental_users doctor ON doctor.userid = ledger.docid
            LEFT JOIN dental_users producer ON producer.userid = ledger.producerid
            LEFT JOIN dental_place_service name_source ON name_source.place_serviceid = trxn_code.place
            LEFT JOIN dental_place_service description_source
                ON description_source.place_service = ledger.placeofservice
        WHERE $pendingOrLinkedConditional
            AND ledger.patientid = '$patientId'
            AND ledger.docid = '$docId'
            AND trxn_code.docid = '$docId'
            AND trxn_code.type = '$trxnTypeMed'
        ORDER BY ledger.service_date ASC, ledger.amount DESC, ledger.ledgerid DESC";

        $transactions = $db->getResults($transactionsQuery);

        array_walk($transactions, function (&$each) {
            $each['verification'] = crc32(json_encode($each));
        });

        return $transactions;
    }

    /**
     * Retrieve ledger items stored in claim table
     *
     * @param int $claimId
     * @return array
     */
    public static function storedLedgerItems ($claimId) {
        $db = new Db();

        $claimId = intval($claimId);
        $claimData = $db->getRow("SELECT * FROM dental_insurance WHERE insuranceid = '$claimId'");

        /**
         * Relationship between dental_insurance and dental_ledger
         */
        $fieldMap = [
            'rendering_provider_id%n%' => 'ledgerid',
            'service_date%n%_from' => 'service_date',
            'service_date%n%_to' => 'service_date',
            'place_of_service%n%' => 'placeofservice',
            'emg%n%' => 'emg',
            'cpt_hcpcs%n%' => 'transaction_code',
            'modifier%n%_1' => 'modcode',
            'modifier%n%_2' => 'modcode2',
            'modifier%n%_3' => 'modcode3',
            'modifier%n%_4' => 'modcode4',
            'diagnosis_pointer%n%' => 'diagnosis_code_pointers',
            's_charges%n%_1' => 'amount',
            'days_or_units%n%' => 'daysorunits',
            'epsdt_family_plan%n%' => 'epsdt',
            'id_qua%n%' => 'idqual',
            'rendering_provider_entity_%n%' => 'entity',
            'rendering_provider_first_name_%n%' => 'provider_first_name',
            'rendering_provider_last_name_%n%' => 'provider_last_name',
            'rendering_provider_npi_%n%' => 'provider_id',
            'verification' => 'verification', // Empty field, to mimic the extra field in the dynamic ledger items
        ];

        $transactions = [];

        for ($line=1; $line<=6; $line++) {
            $keys = array_keys($fieldMap);

            array_walk($keys, function (&$key) use ($line) {
                $key = str_replace('%n%', $line, $key);
            });

            $currentLine = [];
            $currentMap = array_combine($keys, $fieldMap);

            foreach ($currentMap as $source=>$destination) {
                $currentLine[$destination] = $claimData[$source];
            }

            $isEmpty = !count(array_filter($currentLine, function ($each) {
                return strlen((string)$each);
            }));

            if ($isEmpty) {
                break;
            }

            $transactions []= $currentLine;
        }

        return $transactions;
    }

    /**
     * Retrieve associated ledger items, merging modified information with dynamic items
     *
     * @param int $claimId
     * @return array
     */
    public static function associatedLedgerItems ($claimId) {
        $db = new Db();
        $claimId = intval($claimId);

        $dynamicItems = self::dynamicLedgerItems($claimId);
        $storedItems = self::storedLedgerItems($claimId);

        /**
         * Claims before release date won't have the correct fields set. We cannot trust these, therefore
         * we only merge fields IF the claim was created or updated after this date.
         */
        $releaseDate = config('app.ledger.release_date');
        $storedOverridesDynamic = config('app.ledger.prefer_stored');

        $isNewerThanRelease = $db->getColumn("SELECT IF(updated_at > '$releaseDate', 1, 0) AS `newer`
            FROM dental_insurance_history
            WHERE insuranceid = '$claimId'
            ORDER BY updated_at DESC
            LIMIT 1", 'newer', 0);

        if (!$isNewerThanRelease || !$dynamicItems || !$storedItems) {
            return $dynamicItems;
        }

        /**
         * The processing will destroy the previous items arrays, thus we create a new array, and save a copy of the
         * length of the reference array.
         */
        $mergedItems = [];
        $itemLength = count($dynamicItems);

        /**
         * Determine if there are stored ledger items that need to be matched with dynamic ledger items.
         * Attempt to match by ledgerid if present, or a simple match, one to one, otherwise.
         */
        $dynamicIds = array_unique(array_pluck($dynamicItems, 'ledgerid'));
        $storedIds = array_unique(array_pluck($storedItems, 'ledgerid'));
        $intersectedIds = array_unique(array_intersect($dynamicIds, $storedIds));

        if ($intersectedIds) {
            /**
             * Some or all stored items have ledger ids set, give these preference in the order, and then match
             * one on one the rest of the stored items with no id.
             *
             * Remove the matched items, to avoid processing a line twice.
             */
            foreach ($intersectedIds as $targetId) {
                $dynamicIndex = array_search($targetId, $dynamicIds);
                $storedIndex = array_search($targetId, $storedIds);

                $mergedItem = $dynamicItems[$dynamicIndex];

                if ($storedOverridesDynamic) {
                    $mergedItem = $storedItems[$storedIndex];

                    array_walk($mergedItem, function (&$value, $key) use ($dynamicItems, $dynamicIndex) {
                        if (is_null($value)) {
                            $value = $dynamicItems[$dynamicIndex][$key];
                        }
                    });

                    $mergedItem['verification'] = $dynamicItems[$dynamicIndex]['verification'];
                }

                $mergedItems []= $mergedItem;

                unset($dynamicItems[$dynamicIndex]);
                unset($storedItems[$storedIndex]);
                unset($dynamicIds[$dynamicIndex]);
            }

            /**
             * Reset the array keys of the items arrays
             */
            $dynamicItems = array_values($dynamicItems);
            $storedItems = array_values($storedItems);
            $dynamicIds = array_values($dynamicIds);
        }

        foreach ($dynamicIds as $index=>$id) {
            if ($storedOverridesDynamic) {
                $mergedItem = isset($storedItems[$index]) ? $storedItems[$index] : $dynamicItems[$index];
            } else {
                $mergedItem = isset($dynamicItems[$index]) ? $dynamicItems[$index] :
                    (isset($storedItems[$index]) ? $storedItems[$index] : []);
            }

            $mergedItem['ledgerid'] = $dynamicItems[$index]['ledgerid'];
            $mergedItem['verification'] = $dynamicItems[$index]['verification'];

            $mergedItems []= $mergedItem;
        }

        $mergedItems = array_slice($mergedItems, 0, $itemLength);
        return $mergedItems;
    }

    /**
     * Base fields to include in a claim
     *
     * @param  int    $patientId
     * @param  int    $producerId
     * @param  string $sequence
     * @param  int    $primaryClaimId
     * @throws \RuntimeException
     * @return array
     */
    private static function emptyClaimData ($patientId, $producerId, $sequence, $primaryClaimId) {
        /**
         * Always assume primary unless explicit request of secondary
         * Also, enforce valid values for primary claim ids, or we will have "dangling" secondary claims
         */
        $isPrimary = $sequence !== 'secondary';

        /**
         * If the claim is secondary, then has_s_m_ins MUST be true and $primaryClaimId must be set
         */
        if (!$isPrimary && !$primaryClaimId) {
            self::raiseError(
                "Cannot create secondary claim for patientId $patientId, producerId $producerId. " .
                "\$primaryClaimId is empty"
            );
        }

        $docId = intval($_SESSION['docid']);
        $userId = intval($_SESSION['userid']);

        return [
            'patientid' => $patientId,
            'producer' => $producerId,
            'docid' => $docId,
            'userid' => $userId,
            'status' => $isPrimary ? DSS_CLAIM_PENDING : DSS_CLAIM_SEC_PENDING,
            'primary_claim_id' => $isPrimary ? 0 : $primaryClaimId
        ];
    }

    /**
     * Gather patient, doctor, and insurance data for the claim. Does not process ledger transactions.
     *
     * @param  int    $patientId
     * @param  int    $producerId
     * @param  string $sequence
     * @param  int    $primaryClaimId
     * @throws \RuntimeException
     * @return array
     */
    public static function dynamicClaimData ($patientId, $producerId, $sequence='primary', $primaryClaimId=null) {
        $db = new Db();

        $patientId = intval($patientId);
        $producerId = intval($producerId);

        /**
         * Only two possible options: primary or secondary
         */
        $isPrimary = strtolower($sequence) !== 'secondary';

        /**
         * If the CLAIM SEQUENCE is PRIMARY, then:
         * - insured data comes from fields marked as "p_m_..."
         * - other insured data comes from fields marked as "s_m_..."
         *
         * If the CLAIM SEQUENCE is SECONDARY, then:
         * - insured data comes from fields marked as "p_m_..."
         * - other insured data comes from fields marked as "s_m_..."
         *
         * Instead of switching each field individually, define prefixes to read from the correct fields
         * It is also possible to parse the fields, and generate some array:
         *
         * $patientData['p_m_dss_file']    --->    $patientData['p_m']['dss_file']
         * $patientData['s_m_dss_file']    --->    $patientData['s_m']['dss_file']
         *
         * Then read the equivalent values, from different arrays
         *
         * This trick does NOT work for Date of Birth fields, the names are ins_dob and ins2_dob
         */
        $primaryPrefix = $isPrimary ? 'p_m' : 's_m';
        $secondaryPrefix = $isPrimary ? 's_m' : 'p_m';

        $patientData = $db->getRow("SELECT p.*, u.billing_company_id
            FROM dental_patients p
                JOIN dental_users u ON u.userid=p.docid
            WHERE p.patientid = '$patientId'");

        $docId = intval($patientData['docid']);
        $hasSecondaryInsurance = isOptionSelected($patientData['has_s_m_ins']);

        /**
         * If the claim is secondary, then has_s_m_ins MUST be true
         */
        if (!$isPrimary && !$hasSecondaryInsurance) {
            self::raiseError(
                "Dynamic claim data for patientId $patientId, producerId $producerId inconsistency: " .
                "the sequence is secondary but the patient does not have secondary insurance enabled."
            );
        }

        $claimData = self::emptyClaimData($patientId, $producerId, $sequence, $primaryClaimId);

        $claimData['patient_firstname'] = $patientData['firstname'];
        $claimData['patient_lastname'] = $patientData['lastname'];
        $claimData['patient_middle'] = $patientData['middlename'];
        $claimData['patient_address'] = $patientData['add1'];
        $claimData['patient_city'] = $patientData['city'];
        $claimData['patient_state'] = $patientData['state'];
        $claimData['patient_zip'] = $patientData['zip'];
        $claimData['patient_dob'] = $patientData['dob'];
        $claimData['patient_sex'] = $patientData['gender'];

        // Not sure what these fields do
        $claimData['p_m_dss_file'] = $patientData["{$primaryPrefix}_dss_file"];
        $claimData['p_m_billing_id'] = $patientData['billing_company_id'];

        $insuranceType = $patientData["{$primaryPrefix}_ins_type"];
        $isMedicare = $insuranceType == 1;

        $claimData['insurance_type']                  = $insuranceType;
        $claimData['insured_firstname']               = $patientData["{$primaryPrefix}_partyfname"];
        $claimData['insured_lastname']                = $patientData["{$primaryPrefix}_partylname"];
        $claimData['insured_middle']                  = $patientData["{$primaryPrefix}_partymname"];
        $claimData['insured_id_number']               = $patientData["{$primaryPrefix}_ins_id"];
        $claimData['insured_insurance_plan']          = $patientData["{$primaryPrefix}_ins_plan"];
        $claimData['insured_policy_group_feca']       = $patientData["{$primaryPrefix}_ins_grp"];
        $claimData['insured_sex']                     = $patientData["{$primaryPrefix}_gender"];

        $claimData['other_insurance_type']            = $patientData["{$secondaryPrefix}_ins_type"];
        $claimData['other_insured_firstname']         = $patientData["{$secondaryPrefix}_partyfname"];
        $claimData['other_insured_lastname']          = $patientData["{$secondaryPrefix}_partylname"];
        $claimData['other_insured_middle']            = $patientData["{$secondaryPrefix}_partymname"];
        $claimData['other_insured_id_number']         = $patientData["{$secondaryPrefix}_ins_id"];
        $claimData['other_insured_insurance_plan']    = $patientData["{$secondaryPrefix}_ins_plan"];
        $claimData['other_insured_policy_group_feca'] = $patientData["{$secondaryPrefix}_ins_grp"];
        $claimData['other_insured_sex']               = $patientData["{$secondaryPrefix}_gender"];

        /**
         * DOB fields are exceptions to the naming rule
         *
         * Sequence value represents the alternate source of insurance data.
         * Therefore, its value is inverse to the sequence
         */
        if ($isPrimary) {
            $claimData['insured_dob'] = $patientData['ins_dob'];
            $claimData['other_insured_dob'] = $patientData['ins2_dob'];
            $claimData['responsibility_sequence'] = $hasSecondaryInsurance ? 'S' : '';
        } else {
            $claimData['insured_dob'] = $patientData['ins2_dob'];
            $claimData['other_insured_dob'] = $patientData['ins_dob'];
            $claimData['responsibility_sequence'] = 'P';
        }

        /**
         * @see CS-29
         *
         * Default value since 10-oct-2015
         * We depend on ledger entries dates. We don't have them available here, we just guess
         */
        $claimData['icd_ind'] = 10;

        $claimData['another_plan'] = $hasSecondaryInsurance || !$isPrimary;
        $claimData['insured_signature'] = isOptionSelected($patientData["{$primaryPrefix}_ins_ass"]);

        $claimData['patient_signature'] = 1;
        $claimData['signature_physician'] = 1;
        $claimData['patient_signed_date'] = dateFormat($patientData['adddate']);
        $claimData['physician_signed_date'] = dateFormat('Y-m-d');
        list($claimData['patient_phone_code'], $claimData['patient_phone']) =
            parsePhoneNumber($patientData['home_phone']);
        list($claimData['insured_phone_code'], $claimData['insured_phone']) =
            parsePhoneNumber($patientData['home_phone']);
        $claimData['patient_status'] = $patientData['marital_status'];
        $claimData['insured_id_number'] = $patientData["{$primaryPrefix}_ins_id"];

        if (isOptionSelected($patientData["{$primaryPrefix}_same_address"])) {
            $claimData['insured_address'] = $patientData['add1'];
            $claimData['insured_city'] = $patientData['city'];
            $claimData['insured_state'] = $patientData['state'];
            $claimData['insured_zip'] = $patientData['zip'];
        } else {
            $claimData['insured_address'] = $patientData["{$primaryPrefix}_address"];
            $claimData['insured_city'] = $patientData["{$primaryPrefix}_city"];
            $claimData['insured_state'] = $patientData["{$primaryPrefix}_state"];
            $claimData['insured_zip'] = $patientData["{$primaryPrefix}_zip"];
        }

        if (isOptionSelected($patientData["{$secondaryPrefix}_same_address"])) {
            $claimData['other_insured_address'] = $patientData['add1'];
            $claimData['other_insured_city'] = $patientData['city'];
            $claimData['other_insured_state'] = $patientData['state'];
            $claimData['other_insured_zip'] = $patientData['zip'];
        } else {
            $claimData['other_insured_address'] = $patientData["{$secondaryPrefix}_address"];
            $claimData['other_insured_city'] = $patientData["{$secondaryPrefix}_city"];
            $claimData['other_insured_state'] = $patientData["{$secondaryPrefix}_state"];
            $claimData['other_insured_zip'] = $patientData["{$secondaryPrefix}_zip"];
        }

        $claimData['patient_relation_insured'] = $patientData["{$primaryPrefix}_relation"];
        $claimData['patient_relation_other_insured'] = $patientData["{$secondaryPrefix}_relation"];
        $claimData['insured_employer_school_name'] = $patientData['employer'];
        $claimData['p_m_eligible_payer_id'] = $patientData["{$primaryPrefix}_eligible_payer_id"];
        $claimData['p_m_eligible_payer_name'] = $patientData["{$primaryPrefix}_eligible_payer_name"];
        $claimData['accept_assignment'] = $patientData["{$primaryPrefix}_ins_ass"];

        $producerData = $db->getRow("SELECT * FROM dental_users WHERE producer_files = 1 AND userid = '$producerId'");
        $doctorData = $db->getRow("SELECT * FROM dental_users WHERE userid = '$docId'");

        /**
         * 'producer_files' signals whether the action must be marked as the original producer OR the current docid
         *
         * IF $producerData['producer_files'] == 1
         * THEN use producer data, fallback to doctor data
         * ELSE use doctor data
         *
         * Set the doctor data first. Overwrite values where appropiate IF producer_files = 1
         */
        $taxSource = array_only($doctorData, self::$taxDataFields);

        if ($producerData['producer_files'] == 1) {
            array_walk($taxSource, function (&$taxField, $index) use ($producerData) {
                $producerField = trim($producerData[$index]);

                // IF producer_files = 1 THEN use the option from the producer
                if ($index === 'use_service_npi') {
                    $taxField = $producerField;
                }

                // If the corresponding producer value is set, use that value instead
                if (strlen($producerField)) {
                    $taxField = $producerField;
                }
            });
        }

        /**
         * Billing info always comes from the same place. Service info has the following restrictions:
         *
         * IF $isMedicare THEN empty
         * IF use_service_npi THEN service info
         * ELSE same as billing info
         */
        $billingAddress = [
            'city' => $taxSource['city'],
            'state' => $taxSource['state'],
            'zip' => $taxSource['zip']
        ];

        $claimData['billing_provider_phone'] = $taxSource['phone'];
        $claimData['billing_provider_name'] = $taxSource['practice'];
        $claimData['billing_provider_address'] = $taxSource['address'];
        $claimData['billing_provider_city'] = trim(preg_replace('/ +/', ' ', implode(' ', $billingAddress)));
        $claimData['billing_provider_a'] = $isMedicare ? $taxSource['medicare_npi'] : $taxSource['npi'];

        $claimData['federal_tax_id_number'] = $taxSource['tax_id_or_ssn'];
        $claimData['ssn'] = $taxSource['ssn'];
        $claimData['ein'] = !$taxSource['ssn'];

        /**
         * Only include service facility info IF NOT Medicare
         */
        if (!$isMedicare) {
            /**
             * IF user_service_npi
             * THEN populate from service facility info
             * ELSE copy from billing info
             */
            if ($taxSource['use_service_npi'] == 1) {
                $serviceAddress = [
                    'city' => $taxSource['service_city'],
                    'state' => $taxSource['service_state'],
                    'zip' => $taxSource['service_zip']
                ];

                $claimData['service_facility_info_name'] = $taxSource['service_name'];
                $claimData['service_facility_info_address'] = $taxSource['service_address'];
                $claimData['service_facility_info_city'] =
                    trim(preg_replace('/ +/', ' ', implode(' ', $serviceAddress)));
                $claimData['service_info_a'] = $isMedicare ?
                    $taxSource['service_medicare_npi'] : $taxSource['service_npi'];
            } else {
                $claimData['service_facility_info_name'] = $claimData['billing_provider_name'];
                $claimData['service_facility_info_address'] = $claimData['billing_provider_address'];
                $claimData['service_facility_info_city'] = $claimData['billing_provider_city'];
                $claimData['service_info_a'] = $claimData['billing_provider_a'];
            }
        }

        /**
         * Retrieve diagnosis
         * Also referrer details, fields 17a. 17b. (only for Medicare)
         */
        $sleepStudies = $db->getRow("SELECT ss.diagnosis, ss.diagnosising_doc, ss.diagnosising_npi
            FROM dental_summ_sleeplab ss
                JOIN dental_patients p ON ss.patiendid = p.patientid
            WHERE (
                    p.p_m_ins_type != '1'
                    OR (
                        COALESCE(ss.diagnosising_doc, '') != ''
                        AND COALESCE(ss.diagnosising_npi, '') != ''
                    )
                )
                AND COALESCE(ss.diagnosis, '') != ''
                AND ss.filename IS NOT NULL
                AND ss.patiendid = '$patientId'");

        if ($sleepStudies) {
            $claimData['diagnosis_1'] = $sleepStudies['diagnosis'];
            $diagnosisId = intval($claimData['diagnosis_1']);

            $ins_diag = $db->getRow("SELECT * FROM dental_ins_diagnosis WHERE ins_diagnosisid = '$diagnosisId'");
            $claimData['diagnosis_a'] = $ins_diag['ins_diagnosis'];

            // Fields 17a. 17b.
            if ($isMedicare) {
                $claimData['referring_provider'] = $sleepStudies['diagnosising_doc'];
                $claimData['field_17b'] = $sleepStudies['diagnosising_npi'];

                /**
                 * @see DSS-274
                 *
                 * New default value: DN - Referring Provider (Claim level)
                 */
                $claimData['name_referring_provider_qualifier'] = 'DN_CLAIM';
            }
        }

        // If claim doesn't yet have a preauth number, try to load it
        // from the patient's most recently completed preauth.
        if (empty($claimData['prior_authorization_number'])) {
            $preAuthStatus = DSS_PREAUTH_COMPLETE;
            $preAuth = $db->getRow("SELECT *
                FROM dental_insurance_preauth
                WHERE patient_id = '$patientId'
                    AND status = $preAuthStatus
                ORDER BY date_completed DESC LIMIT 1");

            if ($preAuth) {
                $claimData['prior_authorization_number'] = $preAuth['pre_auth_num'];
            }
        }

        if (!$isPrimary) {
            $claimData['amount_paid'] = self::amountPaidForClaim($primaryClaimId);
        }

        $claimData['resubmission_code_fill'] = 1;
        $claimData['billing_provider_taxonomy_code'] = '332B00000X';

        return $claimData;
    }

    /**
     * Return historic snapshot for the claim
     *
     * @param int $claimId
     * @param int $historyId
     * @return array|null
     */
    public static function historicClaimData ($claimId, $historyId) {
        $db = new Db();

        $claimId = intval($claimId);
        $historyId = intval($historyId);

        return $db->getRow("SELECT *
            FROM dental_insurance_history
            WHERE insuranceid = '$claimId'
                AND id = '$historyId'");
    }

    /**
     * Create new claim item, including patient, doctor, and insurance data. Does not process ledger transactions.
     *
     * @param int      $patientId
     * @param int      $producerId
     * @param string   $sequence
     * @param int      $primaryClaimId
     * @param bool     $empty
     * @param bool|int $forcedStatus
     * @return int
     */
    public static function createClaim (
        $patientId,
        $producerId,
        $sequence,
        $primaryClaimId,
        $empty=false,
        $forcedStatus=false
    ) {
        $db = new Db();

        $patientId = intval($patientId);
        $producerId = intval($producerId);
        $primaryClaimId = intval($primaryClaimId);

        $claimData = $empty ?
            self::emptyClaimData($patientId, $producerId, $sequence, $primaryClaimId) :
            self::dynamicClaimData($patientId, $producerId, $sequence, $primaryClaimId);
        $claimData['ip_address'] = $_SERVER['REMOTE_ADDR'];

        /**
         * Add amount_paid if the claim is secondary
         */
        if ($sequence === 'secondary') {
            $claimData['amount_paid'] = self::amountPaidForClaim($primaryClaimId);
        }

        if (
            $forcedStatus !== false && self::statusListByStatus($forcedStatus) &&
            (
                ($sequence === 'primary' && self::isPrimary($forcedStatus)) ||
                ($sequence === 'secondary' && self::isSecondary($forcedStatus))
            )
        ) {
            $claimData['status'] = $forcedStatus;
        }

        $preparedFields = self::prepareClaimDataFields($claimData);

        $newClaimQuery = "INSERT INTO dental_insurance SET
            adddate = NOW(),
            $preparedFields";

        $newClaimId = $db->getInsertId($newClaimQuery);

        /**
         * Now, associate current ledger items to the secondary claim
         */
        if ($sequence === 'secondary') {
            $db->query("UPDATE dental_ledger
                SET secondary_claim_id = '$newClaimId'
                WHERE primary_claim_id = '$primaryClaimId'");
        }

        return $newClaimId;
    }

    /**
     * Does not process ledger transactions.
     *
     * @param int $patientId
     * @param int $producerId
     * @return int
     */
    public static function createPrimaryClaim ($patientId, $producerId) {
        return self::createClaim($patientId, $producerId, 'primary', null, false);
    }

    /**
     * Only saves patientid, docid, userid, producer and adddate.
     *
     * @param int $patientId
     * @param int $producerId
     * @return int
     */
    public static function createEmptyPrimaryClaim ($patientId, $producerId) {
        return self::createClaim($patientId, $producerId, 'primary', null, true);
    }

    /**
     * Does not process ledger transactions. Allows to force an status, as some claims need it for Medicare reasons
     *
     * @param int      $patientId
     * @param int      $producerId
     * @param int      $primaryClaimId
     * @param bool|int $forcedStatus
     * @return int
     */
    public static function createSecondaryClaim ($patientId, $producerId, $primaryClaimId, $forcedStatus=false) {
        return self::createClaim($patientId, $producerId, 'secondary', $primaryClaimId, false, $forcedStatus);
    }

    /**
     * Only saves
     *
     * @param int $patientId
     * @param int $producerId
     * @param int $primaryClaimId
     * @return int
     */
    public static function createEmptySecondaryClaim ($patientId, $producerId, $primaryClaimId) {
        return self::createClaim($patientId, $producerId, 'secondary', $primaryClaimId, true);
    }

    /**
     * @param int $claimId
     * @return array
     */
    public static function dynamicDataForClaim ($claimId) {
        $db = new Db();
        $claimId = intval($claimId);

        $claimDetails = $db->getRow("SELECT patientid, producer, status, primary_claim_id
            FROM dental_insurance
            WHERE insuranceid = '$claimId'");
        $claimDetails = $claimDetails ?: [];

        if (!count($claimDetails)) {
            self::raiseError("The claim $claimId does not exist");
        }

        $patientId = array_get($claimDetails, 'patientid', 0);
        $producerId = array_get($claimDetails, 'producer', 0);
        $status = array_get($claimDetails, 'status', 0);
        $primaryClaimId = array_get($claimDetails, 'primary_claim_id', 0);

        $sequence = in_array($status, [DSS_CLAIM_SEC_PENDING, DSS_CLAIM_SEC_SENT, DSS_CLAIM_SEC_DISPUTE, DSS_CLAIM_SEC_REJECTED]) ?
            'secondary' : 'primary';

        $claimData = self::dynamicClaimData($patientId, $producerId, $sequence, $primaryClaimId);

        // Some scripts will rely on the insuranceid field being set
        $claimData['insuranceid'] = $claimId;

        return $claimData;
    }

    /**
     * Claim model
     *
     * @param int      $claimId
     * @param int|null $patientId
     * @return array
     */
    public static function storedDataForClaim ($claimId, $patientId=null) {
        $db = new Db();
        $claimId = intval($claimId);

        $sql = "SELECT * FROM dental_insurance WHERE insuranceid = '$claimId'";

        if (!is_null($patientId)) {
            $patientId = intval($patientId);
            $sql .= " AND patientid = '$patientId'";
        }

        $claimData = $db->getRow($sql);

        return $claimData ?: [];
    }
}