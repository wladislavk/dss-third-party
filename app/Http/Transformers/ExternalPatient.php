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
    public $simpleMap = [
        'api_key_company' => 'origin_record.company',
        'api_key_user'    => 'origin_record.user',

        'patient.last_name'       => 'patient.lastname',
        'patient.middle_name'     => 'patient.middlename',
        'patient.first_name'      => 'patient.firstname',
        'patient.preferred_name'  => 'patient.salutation',
        'patient.dob'             => 'patient.dob',
        'patient.ssn'             => 'patient.ssn',
        'patient.gender'          => 'patient.gender',
        'patient.marital_status'  => 'patient.marital_status',

        'patient.height_feet'     => 'patient.feet',
        'patient.height_inches'   => 'patient.inches',
        'patient.weight'          => 'patient.weight',

        'patient.address1'        => 'patient.add1',
        'patient.address2'        => 'patient.add2',
        'patient.city'            => 'patient.city',
        'patient.state'           => 'patient.state',
        'patient.zip'             => 'patient.zip',
        'patient.home_phone'      => 'patient.home_phone',
        'patient.work_phone'      => 'patient.work_phone',
        'patient.cell_phone'      => 'patient.cell_phone',
        'patient.email'           => 'patient.email',

        'patient.origin_record.origin_software'   => 'external_patient.software',
        'patient.origin_record.origin_patient_Id' => 'external_patient.external_id',

        'patient.insurance_primary.payer_info.name'     => 'external_patient.payer_name',
        'patient.insurance_primary.payer_info.address1' => 'external_patient.payer_address1',
        'patient.insurance_primary.payer_info.address2' => 'external_patient.payer_address2',
        'patient.insurance_primary.payer_info.city'     => 'external_patient.payer_city',
        'patient.insurance_primary.payer_info.state'    => 'external_patient.payer_state',
        'patient.insurance_primary.payer_info.zip'      => 'external_patient.payer_zip',
        'patient.insurance_primary.payer_info.phone'    => 'external_patient.payer_phone',
        'patient.insurance_primary.payer_info.fax'      => 'external_patient.payer_fax',

        'patient.insurance_primary.insured_info.relationship_to_insured' => 'patient.p_m_relation',

        'patient.insurance_primary.insured_info.subscriber.id'          => 'patient.p_m_ins_id',
        'patient.insurance_primary.insured_info.subscriber.first_name'  => 'patient.p_m_partyfname',
        'patient.insurance_primary.insured_info.subscriber.last_name'   => 'patient.p_m_partylname',
        'patient.insurance_primary.insured_info.subscriber.middle_name' => 'patient.p_m_partymname',
        'patient.insurance_primary.insured_info.subscriber.address1'    => 'patient.p_m_address',
        'patient.insurance_primary.insured_info.subscriber.address2'    => 'patient.p_m_address2',
        'patient.insurance_primary.insured_info.subscriber.city'        => 'patient.p_m_city',
        'patient.insurance_primary.insured_info.subscriber.state'       => 'patient.p_m_state',
        'patient.insurance_primary.insured_info.subscriber.zip'         => 'patient.p_m_zip',
        'patient.insurance_primary.insured_info.subscriber.phone'       => 'external_patient.subscriber_phone',
        'patient.insurance_primary.insured_info.subscriber.dob'         => 'patient.ins_dob',
        'patient.insurance_primary.insured_info.subscriber.gender'      => 'patient.p_m_gender',
        'patient.insurance_primary.insured_info.subscriber.group_id'    => 'patient.p_m_ins_id',
        'patient.insurance_primary.insured_info.subscriber.group_name'  => 'patient.p_m_ins_grp',
    ];

    public $complexMap = [
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

    public $inverseComplexMap = [
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

    private $genderMap = [
        ['m', 'male'],
        ['f', 'female'],
    ];

    private $statusMap = [
        ['1', 'married'],
        ['2', 'single'],
        ['3', 'life partner'],
        ['4', 'minor'],
    ];

    private $dateMap = [
        'external' => 'Y-m-d',
        'internal' => 'm/d/Y',
    ];

    public function transform (Resource $resource) {
        $mapped = $this->simpleMapping($resource->toArray(), true);
        $mapped = $this->complexMapping($resource->toArray(), true, $mapped);

        return $mapped;
    }

    public function fromTransform (Array $resource) {
        $mapped = $this->simpleMapping($resource, false);
        $mapped = $this->complexMapping($resource, false, $mapped);

        return $mapped;
    }

    public function exportGender ($gender) {
        return $this->transformData($gender, $this->genderMap, 0);
    }

    public function importGender ($gender) {
        return $this->transformData($gender, $this->genderMap, 1);
    }

    public function exportMaritalStatus ($status) {
        return $this->transformData($status, $this->statusMap, 0);
    }

    public function importMaritalStatus ($status) {
        return $this->transformData($status, $this->statusMap, 1);
    }

    public function exportDate ($date) {
        return $this->transformDate($date, $this->dateMap['internal'], $this->dateMap['external']);
    }

    public function importDate ($date) {
        return $this->transformDate($date, $this->dateMap['external'], $this->dateMap['internal']);
    }

    private function transformData ($search, Array $searchMap, $returnIndex) {
        $search = strtolower($search);

        $match = array_reduce($searchMap, function ($previousValue, Array $currentMap) use ($search, $returnIndex) {
            return $this->arrayReduceCallback($previousValue, $currentMap, $search, $returnIndex);
        } ,'');

        return ucwords($match);
    }

    private function arrayReduceCallback ($previousValue, Array $currentMap, $search, $returnIndex) {
        if (strlen($previousValue)) {
            return $previousValue;
        }

        if (in_array($search, $currentMap)) {
            return $currentMap[$returnIndex];
        }

        return $previousValue;
    }

    private function transformDate ($date, $sourceFormat, $targetFormat) {
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
