<?php
namespace Ds3\Libraries\Legacy;

class ClaimFormHelper
{
    /**
     * Default transform method, applied to list of source paths
     * with no methods specified
     *
     * @returns string|null
     */
    public static function concatenate () {
        $arguments = func_get_args();
        return count($arguments) ? join(' ', $arguments) : null;
    }

    /**
     * Map relationship for insured and patient, between paper form and e-file
     *
     * @param string $search Either the name (paper form) or the code (e-file) of the relationship to locate
     * @return array [name, code]
     */
    public static function mapRelationship ($search) {
        $map = [
            'self'   => '',
            'spouse' => '01',
            'child'  => '19',
            'other'  => 'g8'
        ];

        $search = strtolower($search);
        $name = self::arraySearch($map, $search, 'self');

        return [ucfirst($name), ucfirst($map[$name])];
    }

    /**
     * Map relationship for "accept assignment", between paper form and e-file
     *
     * @param string $search Option in paper form (key) or option in e-file (value)
     * @return array [(name in paper form), (name in e-file)]
     */
    public static function mapAcceptAssignment ($search) {
        $map = [
            'yes' => 'a',
            'no' => 'c'
        ];

        $search = strtolower($search);
        $name = self::arraySearch($map, $search, 'no');

        return [$name, strtoupper($map[$name])];
    }

    /**
     * Auxiliary function to retrieve phone code, from one or two fields
     *
     * @param string|number $codeOrPhone
     * @param string|number $phone
     * @return string
     */
    public static function getCodeFromPhone ($codeOrPhone, $phone='') {
        list($code, $number) = parsePhoneNumber($codeOrPhone, $phone);
        return $code;
    }

    /**
     * Auxiliary function to retrieve phone number without code, from one or two fields
     *
     * @param string|number $codeOrPhone
     * @param string|number $phone
     * @return string
     */
    public static function getNumberFromPhone ($codeOrPhone, $phone='') {
        list($code, $number) = parsePhoneNumber($codeOrPhone, $phone);
        return $number;
    }

    /**
     * Auxiliary function to map e-file relationship status into paper form relationship status
     *
     * @param string $code
     * @return string
     */
    public static function getRelationshipFromCode ($code) {
        list($relationship, $code) = self::mapRelationship($code);
        return $relationship;
    }

    /**
     * Auxiliary function to map e-file assignment status into paper form assignment status
     *
     * @param string $code
     * @return string
     */
    public static function getAssignmentFromCode ($code) {
        list($assignment, $code) = self::mapAcceptAssignment($code);
        return $assignment;
    }

    /**
     * @param string $location
     * @return string
     */
    public static function getCityFromLocation ($location) {
        list($city, $state, $stateCode, $zip) = parseCityStateZip($location);
        return $city;
    }

    /**
     * @param string $location
     * @return string
     */
    public static function getStateFromLocation ($location) {
        list($city, $state, $stateCode, $zip) = parseCityStateZip($location);
        return $stateCode;
    }

    /**
     * @param string $location
     * @return string
     */
    public static function getZipFromLocation ($location) {
        list($city, $state, $stateCode, $zip) = parseCityStateZip($location);
        return $zip;
    }

    /**
     * Determine if the field indicates the federal tax id number (field 25) is SSN
     *
     * @param string $value
     * @return bool
     */
    public static function isSsn ($value) {
        $value = strtolower($value);
        return $value === 'ssn' || $value === 'sy';
    }

    /**
     * Decouple ssn and ein
     *
     * @param int|bool $ssn
     * @param int|bool $ein
     * @return string
     */
    public static function ssnOrEin ($ssn, $ein) {
        return $ssn || !$ein ? 'ssn' : 'ein';
    }

    /**
     * Determine if the field indicates the federal tax id number (field 25) is EIN
     *
     * @param string $value
     * @return bool
     */
    public static function isEin ($value) {
        $value = strtolower($value);
        return $value === 'ein' || $value === 'ei';
    }

    /**
     * Determine if the value is a valid checkbox value
     *
     * @param string|number|bool $value
     * @return bool
     */
    public static function isChecked ($value) {
        if (is_string($value)) {
            $value = strtolower(trim($value));

            return $value === 'y' || $value === 'yes' || $value === 'true' || $value === '1';
        }

        return $value === 1 || $value === true;
    }

    /**
     * Try to determine if the value is "set". Null values are considered as "not set"
     *
     * @param mixed $value
     * @return bool
     */
    public static function isDefined ($value) {
        return !is_null($value);
    }

    /**
     * Search an array in keys and in items. Returns the key of the found element (string) or the default (mixed)
     *
     * @param array $haystack
     * @param mixed $search
     * @param mixed $default
     * @return string|mixed
     */
    public static function arraySearch (array $haystack, $search, $default) {
        if (array_key_exists($search, $haystack)) {
            $found = $search;
        } else if (array_search($search, $haystack)) {
            $found = array_search($search, $haystack);
        } else {
            $found = $default;
        }

        return $found;
    }
}

class ClaimFormDataMapperHelper
{
    /**
     * A map indicates the destination path (dot notation) as the key of the array, and
     * a string or an array of strings as the source (dot notation) of the data.
     *
     * The map() method will return an associative array. The keys of the array will be
     * the paths indicated by the map, the values will be the corresponding elements:
     *
     * - If the element is a string, then it represents a dot notation path, indicating
     *      the array element to search from the input data
     * - If the element is an array, then it represents multiple elements from the input
     *      data
     * - The last element in the array can indicate a name of a method of the ClaimFormHelper class
     *
     * $map['patient_address'] = 'patient.address.street_line_1';
     *      is equivalent to
     * $result['patient_address'] = $input['patient']['address']['street_line_1'];
     *
     * $map['patient.0.address'] = ['patient.address.city', 'patient.address.state', 'patient.address.zip'];
     *      is equivalent to
     * $result['patient'][0]['address'] = $input['patient']['address']['city'] . ' ' .
     *                                    $input['patient']['address']['state'] . ' ' .
     *                                    $input['patient']['address']['zip'];
     *
     * $map['service_line_{%sl}'] = 'claim.service_lines.{%sl}';
     *      is equivalent to
     * $result['service_line_0'] = $input['claim']['service_lines'][0];
     * $result['service_line_1'] = $input['claim']['service_lines'][1];
     *      ...
     * $result['service_line_5'] = $input['claim']['service_lines'][5];
     *
     * @param array $data
     * @param array $map
     * @return array
     */
    public static function map ($data, $map) {
        // Expand any "service line" or "diagnosis pointer" counters
        $map = self::expandMap($map);
        $mapped = [];

        foreach ($map as $destinationPath=>$sourcePaths) {
            if (!is_array($sourcePaths)) {
                $sourcePaths = [$sourcePaths];
            }

            // Possible helper method name, but it might not be it
            $helperMethod = last($sourcePaths);

            // "::" Identifies a helper method, always at the end of the array
            if (strpos($helperMethod, '::') === 0) {
                $helperMethod = substr($helperMethod, 2);

                // Discard the last array item
                array_pop($sourcePaths);
            } else {
                $helperMethod = "concatenate";
            }

            /**
             * Retrieve fields based on source paths
             */
            $fieldData = array_map(function ($path) use ($data) {
                return array_get($data, $path);
            }, $sourcePaths);

            /**
             * Call the helper method, using the "$source" array as the arguments
             * Use the result as the value in "$destinationPath"
             */
            $value = call_user_func_array([__NAMESPACE__ . '\ClaimFormHelper', $helperMethod], $fieldData);
            array_set($mapped, $destinationPath, $value);
        }

        return $mapped;
    }

    /**
     * "Expand" counters in values. Expand = parse a string and populate fields based on conventions over that string.
     *
     * There are only two types of counters:
     *
     * - Service lines:   "{%sl}" => 0..5
     * - Diagnosis codes: "{%dp}" => 0..11
     *
     * Service lines always comes first. "{%dp}" will never be parsed if "{%sl}" is NOT present
     *
     * @param array $map
     * @return array
     */
    public static function expandMap ($map) {
        $expandedMap = [];

        foreach ($map as $destinationPath=>$sourcePaths) {
            if (!is_array($sourcePaths)) {
                $sourcePaths = [$sourcePaths];
            }

            /**
             * Detect if the current $path includes "service lines" indicators:
             *
             * %sl: service line number      (0-5 lines)
             * %dp: diagnosis pointer number (0-11 pointers)
             */
            $extendedPaths = self::expandCounter($destinationPath, $sourcePaths, '%sl', 0, 5);

            // Temporary save the "$extendedPaths" variable, as we are going to rewrite it
            $expandedPaths = $extendedPaths;
            $extendedPaths = [];

            // Use Closure::bind to preserve the context, it allows to NOT write the class name
            array_map(
                \Closure::bind(
                    function ($destination, $sources) use (&$extendedPaths) {
                        // This method will return an array with (maybe) new keys and new elements
                        $newExtended = self::expandCounter($destination, $sources, '%dp', 0, 11);

                        // Merge the new keys/elements with the already processed elements
                        $extendedPaths = array_merge($extendedPaths, $newExtended);
                    },
                    null, __CLASS__
                ),
                array_keys($expandedPaths), $expandedPaths
            );

            /**
             * If the $extendedPaths array changed then we have expanded changes
             *
             * Merge the new array to include the new keys.
             * Otherwise, just re-set the original values.
             */
            if (
                count($extendedPaths) > 1 ||
                count(head($extendedPaths)) > count($sourcePaths)
            ) {
                $expandedMap = array_merge($expandedMap, $extendedPaths);
            } else {
                $expandedMap[$destinationPath] = $sourcePaths;
            }
        }

        // Flatten single item source arrays
        foreach ($expandedMap as &$each) {
            if (is_array($each) && count($each) === 1) {
                $each = head($each);
            }
        }

        return $expandedMap;
    }

    /**
     * Auxiliary function that expands a destination path (array key) and a collection of source paths (values from
     * the array item).
     *
     * ASSUME: lowercase marker means "0 based counter", uppercase marker means "1 based counter"
     *
     * Hydration will generate either new item elements (expands a string with a counter placeholder into the lines with
     * each corresponding number), or new elements AND new array keys (in case the destination path also needs to be
     * expanded).
     *
     * Because of this, this function always returns an array. This function works like we were passing an array with a
     * single element:
     *
     * [$destinationPath => [<$sourcePaths>]]
     *
     * @param string $destinationPath
     * @param array $sourcePaths
     * @param string $marker
     * @param int $start
     * @param int $end
     * @return array
     */
    private static function expandCounter ($destinationPath, $sourcePaths, $marker='%sl', $start=0, $end=5) {
        $expanded = [];
        $escapedMarker = preg_quote($marker);
        $pregMarker = "/
            \{
                $escapedMarker
                (?:
                    (?P<sign>[+-])
                    (?: (?P<counter>\d+) | \"(?P<letter>[a-z])\" )
                )?
            \}
        /x";

        if (!is_array($sourcePaths)) {
            $sourcePaths = [$sourcePaths];
        }

        /**
         * If the array key (destination path) does not have a placeholder, maybe some of the
         * array items (source paths) will have it.
         *
         * We must verify all of them. This revision will expand this:
         *
         * $map['all_service_lines'] = 'claim.service_lines.{%sl}';
         *      to:
         * $map['all_service_lines'] = ['claim.service_lines.0',
         *                              'claim.service_lines.1',
         *                              ...
         *                             ];
         */
        if (!preg_match($pregMarker, $destinationPath, $destinationMatch)) {
            $expanded[$destinationPath] = [];

            foreach ($sourcePaths as $source) {
                /**
                 * If the current source path does not have the counter placeholder, don't expand anything, skip
                 */
                if (!preg_match($pregMarker, $source, $sourceMatch)) {
                    $expanded[$destinationPath] []= $source;
                    continue;
                }

                /**
                 * Turn a single source path into several lines
                 */
                for ($n=$start;$n<=$end;$n++) {
                    $expanded[$destinationPath] []= self::replaceCounter($marker, [$n, $sourceMatch], $source);
                }
            }

            /**
             * Flatten the array if we only have a single element
             */
            if (count($expanded[$destinationPath]) === 1) {
                $expanded[$destinationPath] = $expanded[$destinationPath][0];
            }
        } else {
            /**
             * If the destination path contains a placeholder, the array will have new keys:
             *
             * $map['service_line_{%sl}'] = 'claim.service_lines.{%sl}';
             *      to:
             * $map['service_line_0'] = ['claim.service_lines.0'];
             * $map['service_line_1'] = ['claim.service_lines.1'];
             *      ...
             */
            for ($n=$start;$n<=$end;$n++) {
                $destination = self::replaceCounter($marker, [$n, $destinationMatch], $destinationPath);

                if (!isset($expanded[$destination])) {
                    $expanded[$destination] = [];
                }

                foreach ($sourcePaths as $source) {
                    preg_match($pregMarker, $source, $sourceMatch);
                    $expanded[$destination] []= self::replaceCounter($marker, [$n, $sourceMatch], $source);
                }
            }
        }

        return $expanded;
    }

    /**
     * Auxiliary function to replace markers, based on matches in regexp.
     *
     * Matches can be:
     * - solo marker      {%sl}
     * - marker with sum  {%sl+1}
     * - marker with text {%sl+a}
     *
     * The last type of marker, {%sl+"a"}, generates a sequence of letters, "a-f"
     *
     * @param string $marker
     * @param array $replaceConditions [$index, $regexpMatch]
     * @param string $target
     * @return string
     */
    private static function replaceCounter ($marker, $replaceConditions, $target) {
        list($index, $match) = $replaceConditions;

        $search = ['{' . $marker . '}'];
        $replacement = [$index];

        if (isset($match['sign'])) {
            $sign = $match['sign'];
            $step = $sign === '+' ? 1 : -1;

            if (isset($match['letter'])) {
                $index = chr(ord($match['letter']) + $step*$index);
                $symbol = '"' . $match['letter'] . '"';
            } else {
                $symbol = intval($match['counter']);
                $index += $step*$symbol;
            }

            $search []= '{' . $marker . $sign . $symbol . '}';
            $replacement []= $index;
        }

        $replacement = str_replace($search, $replacement, $target);

        return $replacement;
    }
}

$efileToPaper = [
    'insured_id_number'         => 'subscriber.id',
    'insured_lastname'          => 'subscriber.last_name',
    'insured_firstname'         => 'subscriber.first_name',
    'insured_middle'            => 'subscriber.middle_name',
    'insured_address'           => 'subscriber.address.street_line_1',
    'insured_city'              => 'subscriber.address.city',
    'insured_state'             => 'subscriber.address.state',
    'insured_zip'               => 'subscriber.address.zip',
    'insured_phone_code'        => ['subscriber.phone_number', '::getCodeFromPhone'],
    'insured_phone'             => ['subscriber.phone_number', '::getNumberFromPhone'],
    'insured_policy_group_feca' => 'subscriber.group_id',
    'insured_dob'               => 'subscriber.dob',
    'insured_sex'               => 'subscriber.gender',
    'insured_insurance_plan'    => 'subscriber.group_name',

    'patient_lastname'          => 'dependent.last_name',
    'patient_firstname'         => 'dependent.first_name',
    'patient_middle'            => 'dependent.middle_name',
    'patient_address'           => 'dependent.address.street_line_1',
    'patient_city'              => 'dependent.address.city',
    'patient_state'             => 'dependent.address.state',
    'patient_zip'               => 'dependent.address.zip',
    'patient_phone_code'        => ['dependent.phone_number', '::getCodeFromPhone'],
    'patient_phone'             => ['dependent.phone_number', '::getNumberFromPhone'],
    'patient_dob'               => 'dependent.dob',
    'patient_sex'               => 'dependent.gender',
    'patient_relation_insured'  => ['dependent.relationship', '::getRelationshipFromCode'],

    'another_plan'                      => ['other_payer', '::isChecked'],
    'other_insured_lastname'            => 'other_payers.0.subscriber.last_name',
    'other_insured_firstname'           => 'other_payers.0.subscriber.first_name',
    'other_insured_middle'              => 'other_payers.0.subscriber.middle_name',
    'other_insured_policy_group_feca'   => 'other_payers.0.subscriber.group_id',
    'other_insured_insurance_plan'      => 'other_payers.0.name',
    'responsibility_sequence'           => 'other_payers.0.responsibility_sequence',

    'referring_provider'     => 'referring_provider.first_name',
    'field_17a_dd'           => 'referring_provider.secondary_id_type',
    'field_17a'              => 'referring_provider.secondary_id',
    'field_17b'              => 'referring_provider.npi',

    'claim_codes'            => 'code',

    'employment'                => ['claim.related_to_employment', '::isChecked'],
    'auto_accident'             => ['claim.auto_accident', '::isChecked'],
    'auto_accident_place'       => 'claim.auto_accident_state',
    'other_accident'            => ['claim.other_accident', '::isChecked'],
    'patient_signature'         => 'claim.patient_signature_on_file',
    'insured_signature'         => 'claim.direct_payment_authorized',
    'date_current'              => 'claim.date',
    'current_qual'              => 'claim.date_type',
    'unable_date_from'          => 'claim.last_worked_date',
    'unable_date_to'            => 'claim.work_return_date',
    'hospitalization_date_from' => 'claim.admission_date',
    'hospitalization_date_to'   => 'claim.discharge_date',
    'reserved_local_use1'       => 'claim.note',
    'outside_lab'               => ['claim.outside_lab', '::isChecked'],
    's_charges'                 => 'claim.outside_lab_charges',
    'resubmission_code_fill'    => 'claim.frequency',

    'original_ref_no'           => 'claim.payer_control_number',
    'prior_authorization_number' => 'claim.prior_authorization_number',
    'icd_ind'                   => 'claim.icd_indicator',

    // diagnosis_a - diagnosis_l
    'diagnosis_{%dp+"a"}'      => 'claim.diagnosis_codes.{%dp+1}',

    // 0-5 ledger transactions
    // %sl - service lines
    // %dp - diagnosis pointer
    'placeofservice{%sl}'    => 'claim.service_lines.{%sl}.place_of_service',
    'emg{%sl}'               => ['claim.service_lines.{%sl}.emergency', '::isDefined'],
    'modifiercode{%sl}'      => 'claim.service_lines.{%sl}.procedure_modifiers.0',
    'modifiercode2_{%sl}'    => 'claim.service_lines.{%sl}.procedure_modifiers.1',
    'modifiercode3_{%sl}'    => 'claim.service_lines.{%sl}.procedure_modifiers.2',
    'modifiercode4_{%sl}'    => 'claim.service_lines.{%sl}.procedure_modifiers.3',

    'service_lines.{%sl}.diagnosis_code_pointers.{%dp}' => 'claim.service_lines.{%sl}.diagnosis_code_pointers.{%dp}',
    'daysorunits{%sl}'       => 'claim.service_lines.{%sl}.units',

    'signature_physician'    => ['claim.provider_signature_on_file', '::isChecked'],
    'physician_signed_date'  => 'claim.signature_date',

    'accept_assignment'      => ['claim.accept_assignment_code', '::getAssignmentFromCode'],
    'total_charge'           => 'claim.total_charge',
    'amount_paid'            => 'claim.patient_amount_paid',

    'federal_tax_id_number'         => 'billing_provider.tax_id',
    'ssnein'                        => 'billing_provider.tax_id_type',
    'billing_provider_phone_code'   => ['billing_provider.phone_number', '::getCodeFromPhone'],
    'billing_provider_phone'        => ['billing_provider.phone_number', '::getNumberFromPhone'],
    'billing_provider_name'         => 'billing_provider.organization_name',
    'billing_provider_address'      => 'billing_provider.address.street_line_1',
    'billing_provider_info.city'    => 'billing_provider.address.city',
    'billing_provider_info.state'   => 'billing_provider.address.state',
    'billing_provider_info.zip'     => 'billing_provider.address.zip',
    'billing_provider_a'            => 'billing_provider.npi',

    'service_facility_info_name'    => 'service_facility.name',
    'service_facility_info_address' => 'service_facility.address.street_line_1',
    'service_facility_info.city'    => 'service_facility.address.city',
    'service_facility_info.state'   => 'service_facility.address.state',
    'service_facility_info.zip'     => 'service_facility.address.zip',
    'service_info_a'                => 'service_facility.npi',
];

$efileToDb = [
    // Payer, new columns
    'payer_id'                  => 'payer.id',
    'payer_name'                => 'payer.name',
    'payer_address'             => 'payer.address.street_line_1',
    'payer_city'                => 'payer.address.city',
    'payer_state'               => 'payer.address.state',
    'payer_zip'                 => 'payer.address.zip',

    'insured_id_number'         => 'subscriber.id',
    'insured_lastname'          => 'subscriber.last_name',
    'insured_firstname'         => 'subscriber.first_name',
    'insured_middle'            => 'subscriber.middle_name',
    'insured_address'           => 'subscriber.address.street_line_1',
    'insured_city'              => 'subscriber.address.city',
    'insured_state'             => 'subscriber.address.state',
    'insured_zip'               => 'subscriber.address.zip',
    'insured_phone_code'        => ['subscriber.phone_number', '::getCodeFromPhone'],
    'insured_phone'             => ['subscriber.phone_number', '::getNumberFromPhone'],
    'insured_policy_group_feca' => 'subscriber.group_id',
    'insured_dob'               => 'subscriber.dob',
    'insured_sex'               => 'subscriber.gender',
    'insured_insurance_plan'    => 'subscriber.group_name',

    'patient_lastname'          => 'dependent.last_name',
    'patient_firstname'         => 'dependent.first_name',
    'patient_middle'            => 'dependent.middle_name',
    'patient_address'           => 'dependent.address.street_line_1',
    'patient_city'              => 'dependent.address.city',
    'patient_state'             => 'dependent.address.state',
    'patient_zip'               => 'dependent.address.zip',
    'patient_phone_code'        => ['dependent.phone_number', '::getCodeFromPhone'],
    'patient_phone'             => ['dependent.phone_number', '::getNumberFromPhone'],
    'patient_dob'               => 'dependent.dob',
    'patient_sex'               => 'dependent.gender',
    'patient_relation_insured'  => ['dependent.relationship', '::getRelationshipFromCode'],

    'another_plan'                      => ['other_payer', '::isChecked'],
    'other_insured_lastname'            => 'other_payers.0.subscriber.last_name',
    'other_insured_firstname'           => 'other_payers.0.subscriber.first_name',
    'other_insured_middle'              => 'other_payers.0.subscriber.middle_name',
    'other_insured_policy_group_feca'   => 'other_payers.0.subscriber.group_id',
    'other_insured_insurance_plan'      => 'other_payers.0.name',
    'responsibility_sequence'           => 'other_payers.0.responsibility_sequence',
    'other_insured_insurance_type'      => 'other_payers.0.subscriber.insurance_type_code',

    'referring_provider'     => 'referring_provider.first_name',
    'field_17a_dd'           => 'referring_provider.secondary_id_type',
    'field_17a'              => 'referring_provider.secondary_id',
    'field_17b'              => 'referring_provider.npi',

    'claim_codes'            => 'code',

    'employment'                => ['claim.related_to_employment', '::isChecked'],
    'auto_accident'             => ['claim.auto_accident', '::isChecked'],
    'auto_accident_place'       => 'claim.auto_accident_state',
    'other_accident'            => ['claim.other_accident', '::isChecked'],
    'patient_signature'         => 'claim.patient_signature_on_file',
    'insured_signature'         => 'claim.direct_payment_authorized',
    'date_current'              => 'claim.date',
    'current_qual'              => 'claim.date_type',
    'unable_date_from'          => 'claim.last_worked_date',
    'unable_date_to'            => 'claim.work_return_date',
    'hospitalization_date_from' => 'claim.admission_date',
    'hospitalization_date_to'   => 'claim.discharge_date',
    'reserved_local_use1'       => 'claim.note',
    'outside_lab'               => ['claim.outside_lab', '::isChecked'],
    's_charges'                 => 'claim.outside_lab_charges',
    'resubmission_code_fill'    => 'claim.frequency',

    'original_ref_no'           => 'claim.payer_control_number',
    'prior_authorization_number' => 'claim.prior_authorization_number',
    'icd_ind'                   => 'claim.icd_indicator',

    // diagnosis_a - diagnosis_l
    'diagnosis_{%dp+"a"}'      => 'claim.diagnosis_codes.{%dp+1}',

    // 0-5 ledger transactions
    // %sl - service lines
    // %dp - diagnosis pointer
    'service_date{%sl+1}_from'  => 'claim.service_lines.{%sl}.service_date_from',
    'service_date{%sl+1}_to'    => 'claim.service_lines.{%sl}.service_date_to',
    'place_of_service{%sl+1}'   => 'claim.service_lines.{%sl}.place_of_service',
    'emg{%sl+1}'                => ['claim.service_lines.{%sl}.emergency', '::isDefined'],
    'cpt_hcpcs{%sl+1}'          => 'claim.service_lines.{%sl}.procedure_code',
    'modifier{%sl+1}_1'         => 'claim.service_lines.{%sl}.procedure_modifiers.0',
    'modifier{%sl+1}_2'         => 'claim.service_lines.{%sl}.procedure_modifiers.1',
    'modifier{%sl+1}_3'         => 'claim.service_lines.{%sl}.procedure_modifiers.2',
    'modifier{%sl+1}_4'         => 'claim.service_lines.{%sl}.procedure_modifiers.3',

    'diagnosis_pointer{%sl+1}'  => 'claim.service_lines.{%sl}.diagnosis_code_pointers.0',
    's_charges{%sl+1}_1'        => 'claim.service_lines.{%sl}.charge_amount',
    'days_or_units{%sl+1}'      => 'claim.service_lines.{%sl}.units',

    'rendering_provider_entity_{%sl+1}'     => ['claim.service_lines.{%sl}.rendering_provider.entity', '::isChecked'],
    'rendering_provider_first_name_{%sl+1}' => 'claim.service_lines.{%sl}.rendering_provider.first_name',
    'rendering_provider_last_name_{%sl+1}'  => 'claim.service_lines.{%sl}.rendering_provider.last_name',
    'rendering_provider_org_{%sl+1}'        => 'claim.service_lines.{%sl}.rendering_provider.organization_name',
    'rendering_provider_npi_{%sl+1}'        => 'claim.service_lines.{%sl}.rendering_provider.npi',
    'rendering_provider_id{%sl+1}'          => 'claim.service_lines.{%sl}.rendering_provider.secondary_id',

    'signature_physician'    => ['claim.provider_signature_on_file', '::isChecked'],
    'physician_signed_date'  => 'claim.signature_date',

    'accept_assignment'      => ['claim.accept_assignment_code', '::getAssignmentFromCode'],
    'total_charge'           => 'claim.total_charge',
    'amount_paid'            => 'claim.patient_amount_paid',

    'federal_tax_id_number'         => 'billing_provider.tax_id',
    'ssn'                           => ['billing_provider.tax_id_type', '::isSsn'],
    'ein'                           => ['billing_provider.tax_id_type', '::isEin'],
    'billing_provider_phone_code'   => ['billing_provider.phone_number', '::getCodeFromPhone'],
    'billing_provider_phone'        => ['billing_provider.phone_number', '::getNumberFromPhone'],
    'billing_provider_name'         => 'billing_provider.organization_name',
    'billing_provider_address'      => 'billing_provider.address.street_line_1',
    'billing_provider_city'         => [
        'billing_provider.address.city',
        'billing_provider.address.state',
        'billing_provider.address.zip'
    ],
    'billing_provider_a'            => 'billing_provider.npi',

    'service_facility_info_name'    => 'service_facility.name',
    'service_facility_info_address' => 'service_facility.address.street_line_1',
    'service_facility_info_city'    => [
        'service_facility.address.city',
        'service_facility.address.state',
        'service_facility.address.zip'
    ],
    'service_info_a'                => 'service_facility.npi',
];

$paperToDb = [
    // PICA fields will disappear
    'pica1' => 'pica1',
    'pica2' => 'pica2',
    'pica3' => 'pica3',

    'insurance_type'            => 'insurance_type',
    'other_insurance_type'      => 'other_insurance_type',

    'insured_id_number'         => 'insured_id_number',
    'insured_lastname'          => 'insured_lastname',
    'insured_firstname'         => 'insured_firstname',
    'insured_middle'            => 'insured_middle',
    'insured_address'           => 'insured_address',
    'insured_city'              => 'insured_city',
    'insured_state'             => 'insured_state',
    'insured_zip'               => 'insured_zip',
    'insured_phone_code'        => ['insured_phone_code', 'insured_phone', '::getCodeFromPhone'],
    'insured_phone'             => ['insured_phone_code', 'insured_phone', '::getNumberFromPhone'],
    'insured_policy_group_feca' => 'insured_policy_group_feca',
    'insured_dob'               => 'insured_dob',
    'insured_sex'               => 'insured_sex',
    'insured_insurance_plan'    => 'insured_insurance_plan',
    'other_insured_id_number'   => 'other_insured_id_number',
    'other_claim_id'            => 'other_claim_id',

    'patient_lastname'          => 'patient_lastname',
    'patient_firstname'         => 'patient_firstname',
    'patient_middle'            => 'patient_middle',
    'patient_address'           => 'patient_address',
    'patient_city'              => 'patient_city',
    'patient_state'             => 'patient_state',
    'patient_zip'               => 'patient_zip',
    'patient_phone_code'        => ['patient_phone_code', 'patient_phone', '::getCodeFromPhone'],
    'patient_phone'             => ['patient_phone_code', 'patient_phone', '::getNumberFromPhone'],
    'patient_dob'               => 'patient_dob',
    'patient_sex'               => 'patient_sex',
    'patient_relation_insured'  => ['patient_relation_insured', '::getRelationshipFromCode'],
    'patient_signed_date'       => 'patient_signed_date',

    'another_plan'                      => ['another_plan', '::isChecked'],
    'other_insured_lastname'            => 'other_insured_lastname',
    'other_insured_firstname'           => 'other_insured_firstname',
    'other_insured_middle'              => 'other_insured_middle',
    'other_insured_policy_group_feca'   => 'other_insured_policy_group_feca',
    'other_insured_insurance_plan'      => 'other_insured_insurance_plan',
    'responsibility_sequence'           => 'responsibility_sequence',
    'nucc_8a'                           => 'nucc_8a',
    'nucc_8b'                           => 'nucc_8b',
    'nucc_9b'                           => 'nucc_9b',
    'nucc_9c'                           => 'nucc_9c',

    'name_referring_provider_qualifier' => 'name_referring_provider_qualifier',
    'referring_provider'                => 'referring_provider',
    'field_17a_dd'                      => 'field_17a_dd',
    'field_17a'                         => 'field_17a',
    'field_17b'                         => 'field_17b',

    'claim_codes'               => 'claim_codes',

    'employment'                => ['employment', '::isChecked'],
    'auto_accident'             => ['auto_accident', '::isChecked'],
    'auto_accident_place'       => 'auto_accident_place',
    'other_accident'            => ['other_accident', '::isChecked'],
    'patient_signature'         => 'patient_signature',
    'insured_signature'         => 'insured_signature',
    'date_current'              => 'date_current',
    'current_qual'              => 'current_qual',
    'same_illness_qual'         => 'same_illness_qual',
    'date_same_illness'         => 'date_same_illness',
    'unable_date_from'          => 'unable_date_from',
    'unable_date_to'            => 'unable_date_to',
    'hospitalization_date_from' => 'hospitalization_date_from',
    'hospitalization_date_to'   => 'hospitalization_date_to',
    'reserved_local_use1'       => 'reserved_local_use1',
    'outside_lab'               => ['outside_lab', '::isChecked'],
    's_charges'                 => 's_charges',
    'resubmission_code_fill'    => 'resubmission_code_fill',

    'original_ref_no'           => 'original_ref_no',
    'prior_authorization_number' => 'prior_authorization_number',
    'icd_ind'                   => 'icd_ind',

    // diagnosis_a - diagnosis_l
    'diagnosis_{%dp+"a"}'    => 'diagnosis_{%dp+"a"}',

    /**
     * %sl - service lines:     0-5
     * %dp - diagnosis pointer: 0-11
     */
    'place_of_service{%sl+1}'     => 'placeofservice{%sl}',
    'emg{%sl+1}'                  => ['emg{%sl}', '::isDefined'],
    'modifier{%sl+1}_1'           => 'modifiercode{%sl}',
    'modifier{%sl+1}_2'           => 'modifiercode2_{%sl}',
    'modifier{%sl+1}_3'           => 'modifiercode3_{%sl}',
    'modifier{%sl+1}_4'           => 'modifiercode4_{%sl}',

    'diagnosis_pointer{%sl+1}'    => 'service_lines.{%sl}.diagnosis_code_pointers.0',
    'days_or_units{%sl+1}'        => 'daysorunits{%sl}',
    'epsdt_family_plan{%sl+1}'    => 'epsdt{%sl}',
    'id_qua{%sl+1}'               => 'idqual{%sl}',

    'signature_physician'    => ['signature_physician', '::isChecked'],
    'physician_signed_date'  => 'physician_signed_date',

    'accept_assignment'      => ['accept_assignment', '::getAssignmentFromCode'],
    'total_charge'           => 'total_charge',
    'amount_paid'            => 'amount_paid',
    'nucc_30'                => 'nucc_30',

    'federal_tax_id_number'         => 'federal_tax_id_number',
    'patient_account_no'            => 'patient_account_no',
    'ssn'                           => ['ssnein', '::isSsn'],
    'ein'                           => ['ssnein', '::isEin'],
    'billing_provider_phone_code'   => [
        'billing_provider_phone_code',
        'billing_provider_phone',
        '::getCodeFromPhone'
    ],
    'billing_provider_phone'        => ['billing_provider_phone_code',
        'billing_provider_phone',
        '::getNumberFromPhone'],
    'billing_provider_name'         => 'billing_provider_name',
    'billing_provider_address'      => 'billing_provider_address',
    'billing_provider_city'         => [
        'billing_provider_info.city',
        'billing_provider_info.state',
        'billing_provider_info.zip'
    ],
    'billing_provider_a'            => 'billing_provider_a',
    'billing_provider_dd'           => 'billing_provider_dd',
    'billing_provider_b_other'      => 'billing_provider_b_other',

    'service_facility_info_name'    => 'service_facility_info_name',
    'service_facility_info_address' => 'service_facility_info_address',
    'service_facility_info_city'    => [
        'service_facility_info.city',
        'service_facility_info.state',
        'service_facility_info.zip'],
    'service_info_a'                => 'service_info_a',
    'service_info_dd'               => 'service_info_dd',
    'service_info_b_other'          => 'service_info_b_other',
];

$dbToPaper = [
    // PICA fields will disappear
    'pica1' => 'pica1',
    'pica2' => 'pica2',
    'pica3' => 'pica3',

    'insurance_type'            => 'insurance_type',
    'other_insurance_type'      => 'other_insurance_type',

    'insured_id_number'         => 'insured_id_number',
    'insured_lastname'          => 'insured_lastname',
    'insured_firstname'         => 'insured_firstname',
    'insured_middle'            => 'insured_middle',
    'insured_address'           => 'insured_address',
    'insured_city'              => 'insured_city',
    'insured_state'             => 'insured_state',
    'insured_zip'               => 'insured_zip',
    'insured_phone_code'        => ['insured_phone_code', 'insured_phone', '::getCodeFromPhone'],
    'insured_phone'             => ['insured_phone_code', 'insured_phone', '::getNumberFromPhone'],
    'insured_policy_group_feca' => 'insured_policy_group_feca',
    'insured_dob'               => 'insured_dob',
    'insured_sex'               => 'insured_sex',
    'insured_insurance_plan'    => 'insured_insurance_plan',
    'other_insured_id_number'   => 'other_insured_id_number',
    'other_claim_id'            => 'other_claim_id',

    'patient_lastname'          => 'patient_lastname',
    'patient_firstname'         => 'patient_firstname',
    'patient_middle'            => 'patient_middle',
    'patient_address'           => 'patient_address',
    'patient_city'              => 'patient_city',
    'patient_state'             => 'patient_state',
    'patient_zip'               => 'patient_zip',
    'patient_phone_code'        => ['patient_phone_code', 'patient_phone', '::getCodeFromPhone'],
    'patient_phone'             => ['patient_phone_code', 'patient_phone', '::getNumberFromPhone'],
    'patient_dob'               => 'patient_dob',
    'patient_sex'               => 'patient_sex',
    'patient_relation_insured'  => ['patient_relation_insured', '::getRelationshipFromCode'],
    'patient_signed_date'       => 'patient_signed_date',

    'another_plan'                      => ['another_plan', '::isChecked'],
    'other_insured_lastname'            => 'other_insured_lastname',
    'other_insured_firstname'           => 'other_insured_firstname',
    'other_insured_middle'              => 'other_insured_middle',
    'other_insured_policy_group_feca'   => 'other_insured_policy_group_feca',
    'other_insured_insurance_plan'      => 'other_insured_insurance_plan',
    'responsibility_sequence'           => 'responsibility_sequence',
    'nucc_8a'                           => 'nucc_8a',
    'nucc_8b'                           => 'nucc_8b',
    'nucc_9b'                           => 'nucc_9b',
    'nucc_9c'                           => 'nucc_9c',

    'name_referring_provider_qualifier' => 'name_referring_provider_qualifier',
    'referring_provider'                => 'referring_provider',
    'field_17a_dd'                      => 'field_17a_dd',
    'field_17a'                         => 'field_17a',
    'field_17b'                         => 'field_17b',

    'claim_codes'               => 'claim_codes',

    'employment'                => ['employment', '::isChecked'],
    'auto_accident'             => ['auto_accident', '::isChecked'],
    'auto_accident_place'       => 'auto_accident_place',
    'other_accident'            => ['other_accident', '::isChecked'],
    'patient_signature'         => 'patient_signature',
    'insured_signature'         => 'insured_signature',
    'date_current'              => 'date_current',
    'current_qual'              => 'current_qual',
    'same_illness_qual'         => 'same_illness_qual',
    'date_same_illness'         => 'date_same_illness',
    'unable_date_from'          => 'unable_date_from',
    'unable_date_to'            => 'unable_date_to',
    'hospitalization_date_from' => 'hospitalization_date_from',
    'hospitalization_date_to'   => 'hospitalization_date_to',
    'reserved_local_use1'       => 'reserved_local_use1',
    'outside_lab'               => ['outside_lab', '::isChecked'],
    's_charges'                 => 's_charges',
    'resubmission_code_fill'    => 'resubmission_code_fill',

    'original_ref_no'           => 'original_ref_no',
    'prior_authorization_number' => 'prior_authorization_number',
    'icd_ind'                   => 'icd_ind',

    // diagnosis_a - diagnosis_l
    'diagnosis_{%dp+"a"}'    => 'diagnosis_{%dp+"a"}',

    /**
     * %sl - service lines:     0-5
     * %dp - diagnosis pointer: 0-11
     */
    'placeofservice{%sl}'         => 'place_of_service{%sl+1}',
    'emg{%sl}'                    => ['emg{%sl+1}', '::isChecked'],
    'modifiercode{%sl}'           => 'modifier{%sl+1}_1',
    'modifiercode2_{%sl}'         => 'modifier{%sl+1}_2',
    'modifiercode3_{%sl}'         => 'modifier{%sl+1}_3',
    'modifiercode4_{%sl}'         => 'modifier{%sl+1}_4',

    'service_lines.{%sl}.diagnosis_code_pointers.0' => 'diagnosis_pointer{%sl+1}',
    'daysorunits{%sl}'            => 'days_or_units{%sl+1}',
    'epsdt{%sl}'                  => 'epsdt_family_plan{%sl+1}',
    'idqual{%sl}'                 => 'id_qua{%sl+1}',

    'signature_physician'    => ['signature_physician', '::isChecked'],
    'physician_signed_date'  => 'physician_signed_date',

    'accept_assignment'      => ['accept_assignment', '::getAssignmentFromCode'],
    'total_charge'           => 'total_charge',
    'amount_paid'            => 'amount_paid',
    'nucc_30'                => 'nucc_30',

    'federal_tax_id_number'         => 'federal_tax_id_number',
    'patient_account_no'            => 'patient_account_no',
    'ssnein'                        => ['ssn', 'ein', '::ssnOrEin'],
    'billing_provider_phone_code'   => [
        'billing_provider_phone_code',
        'billing_provider_phone',
        '::getCodeFromPhone'
    ],
    'billing_provider_phone'        => [
        'billing_provider_phone_code',
        'billing_provider_phone',
        '::getNumberFromPhone'
    ],
    'billing_provider_name'         => 'billing_provider_name',
    'billing_provider_address'      => 'billing_provider_address',
    'billing_provider_info.city'    => ['billing_provider_city', '::getCityFromLocation'],
    'billing_provider_info.state'   => ['billing_provider_city', '::getStateFromLocation'],
    'billing_provider_info.zip'     => ['billing_provider_city', '::getZipFromLocation'],
    'billing_provider_a'            => 'billing_provider_a',
    'billing_provider_dd'           => 'billing_provider_dd',
    'billing_provider_b_other'      => 'billing_provider_b_other',

    'service_facility_info_name'    => 'service_facility_info_name',
    'service_facility_info_address' => 'service_facility_info_address',
    'service_facility_info.city'    => ['service_facility_info_city', '::getCityFromLocation'],
    'service_facility_info.state'   => ['service_facility_info_city', '::getSateFromLocation'],
    'service_facility_info.zip'     => ['service_facility_info_city', '::getZipFromLocation'],
    'service_info_a'                => 'service_info_a',
    'service_info_dd'               => 'service_info_dd',
    'service_info_b_other'          => 'service_info_b_other',
];

$db = isset($db) ? $db : new Db();
ini_set('xdebug.var_display_max_children', 300);

// Claim id set, either save or retrieve claim
if (!empty($_GET['insid'])) {
    $insuranceId = intval($_GET['insid']);

    if (count($_POST)) {
        if (isset($_POST['insurancesub'])) {
            $correspondingMap = $paperToDb;
        } elseif (isset($_POST['cms_client'])) {
            $correspondingMap = $efileToDb;
        }

        if (isset($correspondingMap)) {
            $dbFields = ClaimFormDataMapperHelper::map($_POST, $correspondingMap);

            // total_charge and amount_paid must not be saved if they are empty
            if (!strlen($dbFields['total_charge'])) {
                unset($dbFields['total_charge']);
            }

            if (!strlen($dbFields['amount_paid'])) {
                unset($dbFields['amount_paid']);
            }

            /**
             * @ToDo Add user data here!
             */

            // Prepare statements
            array_walk($dbFields, function (&$value, $column) use ($db) {
                $value = $db->escape($value);
                $value = "$column = '$value'";
            });

            $dbFields = join(', ', $dbFields);

            $sql = "UPDATE dental_insurance SET $dbFields WHERE insuranceid=$insuranceId";
            $db->query($sql);
        }
    } else {
        $correspondingMap = $dbToPaper;

        $claimData = $db->getRow("SELECT * FROM dental_insurance WHERE insuranceid = '$insuranceId'");
        $paperFields = ClaimFormDataMapperHelper::map($claimData ? $claimData : [], $correspondingMap);

        header('Content-Type: text/json');
        echo json_encode($paperFields);
    }
} else if (isset($_GET['map'])) {
    $mapName = $_GET['map'];

    switch ($mapName) {
        case 'efile-to-paper':
            $correspondingMap = $efileToPaper;
            break;
        case 'efile-to-db':
            $correspondingMap = $efileToDb;
            break;
        case 'paper-to-db':
        default:
            $correspondingMap = $paperToDb;
    }

    if (isset($_GET['expanded'])) {
        $correspondingMap = ClaimFormDataMapperHelper::expandMap($correspondingMap);
    }

    header('Content-Type: text/json');
    echo json_encode($correspondingMap);
} elseif (config('app.debug')) {
    if (isset($_GET['insid']) && $_GET['status']) {
        $insuranceId = intval($_GET['insid']);
        $status = intval($_GET['status']);

        $db->query("UPDATE dental_insurance SET status='$status' WHERE insuranceid='$insuranceId'");
    } elseif (isset($_GET['compare-db-columns'])) {
        $dbRow = $db->getRow('SELECT * FROM dental_insurance LIMIT 1');
        $row = $dbRow;

        $efile = ClaimFormDataMapperHelper::expandMap($efileToDb);
        $paper = ClaimFormDataMapperHelper::expandMap($paperToDb);

        $efileKeys = array_keys($efile);
        $paperKeys = array_keys($paper);

        array_map(function ($mapKeys) use ($row) {
            $row = array_except($row, $mapKeys);

            var_dump($row);
            echo "<hr />\n";
        }, [$efileKeys, $paperKeys]);

        $row = array_except($row, $efileKeys);
        $row = array_except($row, $paperKeys);

        var_dump($row);
        echo "<hr />\n";

        $row = array_fill_keys(array_keys($dbRow), 'NOWHERE');

        array_map(function ($keys) use (&$row) {
            foreach ($keys as $key) {
                if (!is_numeric($row[$key])) {
                    $row[$key] = 0;
                }

                $row[$key]++;
            }
        }, [$efileKeys, $paperKeys]);

        var_dump($row);
    } elseif (isset($_GET['compare-forms'])) { ?>
<html>
<head>
    <title>
        Claim Forms Comparison Tool
    </title>
    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/manage/js/claim-form-mock.js"></script>
    <script>
        $(document).ready(function(){
            compareSideBySide();
        });
    </script>
</head>
</html>
    <?php }
}
