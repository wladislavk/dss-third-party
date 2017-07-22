<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Enrollments;

use DentalSleepSolutions\Eloquent\Models\Enrollments\PayersList;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PayersListRepository extends AbstractRepository
{
    public function model()
    {
        return PayersList::class;
    }

    /**
     * @param string $orderBy
     * @return mixed
     */
    public function listPayers($orderBy = 'payer_id')
    {
        return $this->allWithOrder($orderBy);
    }

    /**
     * @param string $payerId
     * @return mixed
     */
    public function getPayerById($payerId)
    {
        return $this->getBy('payer_id', $payerId);
    }

    /**
     * Queries our local database for a payer name
     * e.g. name = 'ABC' will search the names field for a name that contains ABC
     *
     * @param string $name
     * @return PayersList[]
     */
    public function findPayerByName($name)
    {

        $sql = <<< SQL
          SELECT * FROM enrollment_payers_list WHERE names RLIKE '"name":"[[:<:]]{$name}[[:>:]]"'
SQL;

        return \DB::select($sql);
    }

    /**
     * @param string $name
     * @return PayersList[]
     */
    public function findPayerWhereNameContains($name)
    {

        $sql = <<< SQL
          SELECT * FROM enrollment_payers_list WHERE names REGEXP '"name":"([^"]*){$name}([^"]*)"';
SQL;

        return \DB::select($sql);
    }

    /**
     * @param int $payerId
     * @return bool
     */
    public function payerRequiresSignature($payerId)
    {
        $endpoint = $this->getPayerSupportedEndpoints($payerId);
        return $endpoint[0]->signature_required;
    }

    /**
     * @param int $payerId
     * @return bool
     */
    public function payerRequiresBlueInkSignature($payerId)
    {
        $endpoint = $this->getPayerSupportedEndpoints($payerId);
        return $endpoint[0]->blue_ink_required;
    }

    /**
     * @param int $payerId
     * @return \stdClass
     */
    public function getPayerSupportedEndpoints($payerId)
    {
        $endpoints = $this->model
            ->select('supported_endpoints')
            ->where('payer_id','=',$payerId)
            ->first();

        return json_decode($endpoints->supported_endpoints);
    }

    /**
     * @param string $apiKey
     * @return \stdClass
     */
    public function syncEnrollmentPayersFromProvider($apiKey)
    {
        $this->model->truncate();
        $config = config('elligibleapi');
        $apiKey = isset($apiKey) ? $apiKey : $config['default_api_key'];
        $contents = $this->getFileContentsForEnrollmentPayersFromEligible($apiKey, $config);

        $payers = new \stdClass();
        if ($contents !== false) {
            $payers = json_decode($contents);
            $this->savePayerToDatabase($payers);
        }
        return $payers;
    }

    /**
     * @param string $apiKey
     * @param array $config
     * @return string
     */
    private function getFileContentsForEnrollmentPayersFromEligible($apiKey, array $config)
    {
        $uri = $config['base_uri'];
        $uri .= $config['request_uri']['enrollment_payers_list'];
        $uri .= $apiKey;

        $contents = file_get_contents($uri);
        return $contents;
    }

    /**
     * @param PayersList[] $payers
     */
    private function savePayerToDatabase(array $payers)
    {
        foreach ($payers as $payer) {
            $names = [];
            foreach ($payer->names as $name) {
                $names[] = ['name' => $name];
            }
            $row = [
                'payer_id' => $payer->payer_id,
                'names' => json_encode($names),
                'supported_endpoints' => json_encode($payer->supported_endpoints),
            ];
            $payer = new PayersList();
            $payer->fill($row);
            $payer->save();
        }
    }
}
