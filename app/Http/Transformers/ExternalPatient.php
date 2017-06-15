<?php
namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Contracts\Resources\Resource;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;
use InvalidArgumentException;

class ExternalPatient extends TransformerAbstract
{
    use WithSimpleRelationship;
    use WithComplexRelationship;

    /**
     * @var array
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

    public function transform(Resource $resource) {
        $mapped = $this->simpleMapping($resource->toArray(), true);
        $mapped = $this->complexMapping($resource->toArray(), true, $mapped);

        return $mapped;
    }

    public function fromTransform(array $resource) {
        $mapped = $this->simpleMapping($resource, false);
        $mapped = $this->complexMapping($resource, false, $mapped);

        return $mapped;
    }

    public function exportGender($gender) {
        return $this->transformData($gender, self::GENDER_MAP, 0);
    }

    public function importGender($gender) {
        return $this->transformData($gender, self::GENDER_MAP, 1);
    }

    public function exportMaritalStatus($status) {
        return $this->transformData($status, self::STATUS_MAP, 0);
    }

    public function importMaritalStatus($status) {
        return $this->transformData($status, self::STATUS_MAP, 1);
    }

    public function exportDate($date) {
        return $this->transformDate($date, self::DATE_MAP['internal'], self::DATE_MAP['external']);
    }

    public function importDate($date) {
        return $this->transformDate($date, self::DATE_MAP['external'], self::DATE_MAP['internal']);
    }

    private function transformData($search, array $searchMap, $returnIndex) {
        $search = strtolower($search);

        $match = array_reduce($searchMap, function ($previousValue, array $currentMap) use($search, $returnIndex) {
            return $this->arrayReduceCallback($previousValue, $currentMap, $search, $returnIndex);
        } ,'');

        return ucwords($match);
    }

    private function arrayReduceCallback($previousValue, array $currentMap, $search, $returnIndex) {
        if (strlen($previousValue)) {
            return $previousValue;
        }

        if (in_array($search, $currentMap)) {
            return $currentMap[$returnIndex];
        }

        return $previousValue;
    }

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
