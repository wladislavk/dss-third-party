<?php
namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Contracts\ComplexRelationshipInterface;
use DentalSleepSolutions\Contracts\SimpleRelationshipInterface;
use DentalSleepSolutions\Contracts\TransformerInterface;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;
use InvalidArgumentException;

/**
 * Map Dentrix API data into Patient/ExternalPatient data
 *
 * Class ExternalPatient
 */
class ExternalPatient
    extends TransformerAbstract
    implements TransformerInterface, SimpleRelationshipInterface, ComplexRelationshipInterface
{
    use WithSimpleRelationship;
    use WithComplexRelationship;

    /**
     * @see DSS-519 Secondary insurance details removed
     */
    const SIMPLE_MAP = [
        'api_key_company' => 'origin_record.company',
        'api_key_user' => 'origin_record.user',

        'patient.last_name' => 'patient.lastname',
        'patient.middle_name' => 'patient.middlename',
        'patient.first_name' => 'patient.firstname',
        'patient.preferred_name' => 'patient.salutation',
        'patient.dob' => 'patient.dob',
        'patient.ssn' => 'patient.ssn',
        'patient.gender' => 'patient.gender',
        'patient.marital_status' => 'patient.marital_status',

        'patient.height_feet' => 'patient.feet',
        'patient.height_inches' => 'patient.inches',
        'patient.weight' => 'patient.weight',

        'patient.address1' => 'patient.add1',
        'patient.address2' => 'patient.add2',
        'patient.city' => 'patient.city',
        'patient.state' => 'patient.state',
        'patient.zip' => 'patient.zip',
        'patient.home_phone' => 'patient.home_phone',
        'patient.work_phone' => 'patient.work_phone',
        'patient.cell_phone' => 'patient.cell_phone',
        'patient.email' => 'patient.email',

        'patient.origin_record.origin_software' => 'external_patient.software',
        'patient.origin_record.origin_patient_Id' => 'external_patient.external_id',

        'patient.insurance_primary.payer_info.name' => 'external_patient.payer_name',
        'patient.insurance_primary.payer_info.address1' => 'external_patient.payer_address1',
        'patient.insurance_primary.payer_info.address2' => 'external_patient.payer_address2',
        'patient.insurance_primary.payer_info.city' => 'external_patient.payer_city',
        'patient.insurance_primary.payer_info.state' => 'external_patient.payer_state',
        'patient.insurance_primary.payer_info.zip' => 'external_patient.payer_zip',
        'patient.insurance_primary.payer_info.phone' => 'external_patient.payer_phone',
        'patient.insurance_primary.payer_info.fax' => 'external_patient.payer_fax',

        'patient.insurance_primary.insured_info.relationship_to_insured' => 'patient.p_m_relation',

        'patient.insurance_primary.insured_info.subscriber.id' => 'patient.p_m_ins_id',
        'patient.insurance_primary.insured_info.subscriber.first_name' => 'patient.p_m_partyfname',
        'patient.insurance_primary.insured_info.subscriber.last_name' => 'patient.p_m_partylname',
        'patient.insurance_primary.insured_info.subscriber.middle_name' => 'patient.p_m_partymname',
        'patient.insurance_primary.insured_info.subscriber.address1' => 'patient.p_m_address',
        'patient.insurance_primary.insured_info.subscriber.address2' => 'patient.p_m_address2',
        'patient.insurance_primary.insured_info.subscriber.city' => 'patient.p_m_city',
        'patient.insurance_primary.insured_info.subscriber.state' => 'patient.p_m_state',
        'patient.insurance_primary.insured_info.subscriber.zip' => 'patient.p_m_zip',
        'patient.insurance_primary.insured_info.subscriber.phone' => 'external_patient.subscriber_phone',
        'patient.insurance_primary.insured_info.subscriber.dob' => 'patient.ins_dob',
        'patient.insurance_primary.insured_info.subscriber.gender' => 'patient.p_m_gender',
        'patient.insurance_primary.insured_info.subscriber.group_id' => 'patient.p_m_ins_grp',
        'patient.insurance_primary.insured_info.subscriber.group_name' => 'patient.p_m_ins_plan',
    ];

    const COMPLEX_MAP = [
        'patient.gender' => [
            'patient.gender' => 'exportGender',
        ],
        'patient.insurance_primary.insured_info.subscriber.gender' => [
            'patient.p_m_gender' => 'exportGender'
        ],
        'patient.marital_status' => [
            'patient.marital_status' => 'exportMaritalStatus',
        ],
        'patient.dob' => [
            'patient.dob' => 'exportDate',
        ],
        'patient.insurance_primary.insured_info.subscriber.dob' => [
            'patient.ins_dob' => 'exportDate',
        ],
    ];

    const INVERSE_COMPLEX_MAP = [
        'patient.gender' => [
            'patient.gender' => 'importGender',
        ],
        'patient.p_m_gender' => [
            'patient.insurance_primary.insured_info.subscriber.gender' => 'importGender'
        ],
        'patient.marital_status' => [
            'patient.marital_status' => 'importMaritalStatus',
        ],
        'patient.dob' => [
            'patient.dob' => 'importDate',
        ],
        'patient.ins_dob' => [
            'patient.insurance_primary.insured_info.subscriber.dob' => 'importDate',
        ],
    ];

    const GENDER_MAP = [
        ['m', 'male'],
        ['f', 'female'],
    ];

    const STATUS_MAP = [
        ['1', 'married'],
        ['2', 'single'],
        ['3', 'life partner'],
        ['4', 'minor'],
    ];

    const DATE_MAP = [
        'external' => 'Y-m-d',
        'internal' => 'm/d/Y',
    ];

    /**
     * Transform model data into an array, for output
     *
     * @param Model $resource
     * @return array
     */
    public function transform(Model $resource) {
        $mapped = $this->simpleMapping($resource->toArray(), true);
        $mapped = $this->complexMapping($resource->toArray(), true, $mapped);

        return $mapped;
    }

    /**
     * Inverse transformation, from array to model data array
     *
     * @param array $resource
     * @return array
     */
    public function inverseTransform(array $resource) {
        $mapped = $this->simpleMapping($resource, false);
        $mapped = $this->complexMapping($resource, false, $mapped);

        return $mapped;
    }

    /**
     * Translate gender internal representation into the API equivalent value
     *
     * @param string $gender
     * @return string
     */
    public function exportGender($gender) {
        return $this->transformData($gender, self::GENDER_MAP, 0);
    }

    /**
     * Translate gender API representation into the internal equivalent value
     *
     * @param string $gender
     * @return string
     */
    public function importGender($gender) {
        return $this->transformData($gender, self::GENDER_MAP, 1);
    }

    /**
     * Translate marital status internal representation into the API equivalent value
     *
     * @param string $status
     * @return string
     */
    public function exportMaritalStatus($status) {
        return $this->transformData($status, self::STATUS_MAP, 0);
    }

    /**
     * Translate marital status API representation into the internal equivalent value
     *
     * @param string $status
     * @return string
     */
    public function importMaritalStatus($status) {
        return $this->transformData($status, self::STATUS_MAP, 1);
    }

    /**
     * Translate date internal representation into the API equivalent value
     *
     * @param string $date
     * @return string
     */
    public function exportDate($date) {
        return $this->transformDate($date, self::DATE_MAP['internal'], self::DATE_MAP['external']);
    }

    /**
     * Translate date API representation into the internal equivalent value
     *
     * @param string $date
     * @return string
     */
    public function importDate($date) {
        return $this->transformDate($date, self::DATE_MAP['external'], self::DATE_MAP['internal']);
    }

    /**
     * Search $search into the nested arrays in $searchMap, and return the nth $returnIndex element of the matching
     * nested array.
     *
     * The returning value is Title Case.
     *
     * @param string $search
     * @param array  $searchMap
     * @param int    $returnIndex
     * @return string
     */
    private function transformData($search, array $searchMap, $returnIndex) {
        $search = strtolower($search);

        $match = array_reduce($searchMap, function ($previousValue, array $currentMap) use($search, $returnIndex) {
            return $this->arrayReduceCallback($previousValue, $currentMap, $search, $returnIndex);
        } ,'');

        return ucwords($match);
    }

    /**
     * Callback to find a value in nested arrays. Returns the nth element of the first matching nested array.
     *
     * @param string $previousValue
     * @param array  $currentMap
     * @param string $search
     * @param int    $returnIndex
     * @return string
     */
    private function arrayReduceCallback($previousValue, array $currentMap, $search, $returnIndex) {
        if (strlen($previousValue)) {
            return $previousValue;
        }

        if (in_array($search, $currentMap) && isset($currentMap[$returnIndex])) {
            return $currentMap[$returnIndex];
        }

        return $previousValue;
    }

    /**
     * Translate a date to a different format. Return the original date in case the translation cannot be done.
     *
     * @param string $date
     * @param string $sourceFormat
     * @param string $targetFormat
     * @return string
     */
    private function transformDate($date, $sourceFormat, $targetFormat) {
        try {
            $dateTime = Carbon::createFromFormat($sourceFormat, $date);
        } catch (InvalidArgumentException $e) {
            return $date;
        }

        if ($dateTime) {
            return $dateTime->format($targetFormat);
        }

        return $date;
    }
}
