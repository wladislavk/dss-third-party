<?php namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Interfaces\EnrollmentPayersInterface;

class EnrollmentPayersApiRepository extends BaseRepository implements EnrollmentPayersInterface
{

    /**
     *
     * @var string
     *
     * Main model name for the Enrollment  Payers Model
     */
    protected $modelName = 'DentalSleepSolutions\EnrollmentPayersList';

    /**
     * @var null
     */
    protected $elligibleConfigurtion = null;

    /**
     * @var $restClient
     */
    protected $restClient;

    public function __construct()
    {

        $this->elligibleConfigurtion = config('elligibleapi');

    }

    /**
     * Fetches a list of payers from our local DB that require enrollment.
     *
     * @return mixed
     */
    public function listPayers($orderBy = 'payer_id')
    {
        return $this->all($orderBy);
    }

    /**
     * Gets a payer from our local DB by payerId
     *
     * @param string $payerId
     * @return mixed
     */
    public function getPayerById($payerId)
    {
        return $this->getBy('payer_id',$payerId);
    }

    /**
     * Queries our local database for a payer name
     * e.g. name = 'ABC' will search the names field for a name that contains ABC
     *
     * @param string $name
     * @return mixed
     */
    public function findPayerByName($name)
    {

        $sql = <<< SQL
          SELECT * FROM enrollment_payers_list WHERE names RLIKE '"name":"[[:<:]]{$name}[[:>:]]"'
SQL;

        return \DB::select($sql);

    }

    /**
     *
     *
     * @param $name
     * @return mixed
     */
    public function findPayerWhereNameContains($name)
    {

        $sql = <<< SQL
          SELECT * FROM enrollment_payers_list WHERE names REGEXP '"name":"([^"]*){$name}([^"]*)"';
SQL;

        return \DB::select($sql);

    }


    /**
     *
     *
     * @param $payerId
     * @return mixed
     */
    public function getPayerSupportedEndpoints($payerId)
    {
        $endpoints = \DB::table('enrollment_payers_list')
                        ->select('supported_endpoints')
                        ->where('payer_id','=',$payerId)
                        ->first();

        return json_decode($endpoints->supported_endpoints);

    }

    /**
     *
     *
     * @param string $apiKey
     * @return void
     */
    public function syncEnrollmentPayersFromProvider($apiKey)
    {
        $model = $this->getModelName();
        $this->instance = $model::truncate();
        $apiKey = isset($apiKey) ? $apiKey : $this->elligibleConfigurtion['default_api_key'];
        $contents = $this->getFileContentsForEnrollmentPayersFromElligible($apiKey);

        if($contents!==FALSE)
        {

            $payers = json_decode($contents);

            $this->savePayerToDatabase($payers);

        }

    }

    /**
     *
     *
     * @return string
     */
    protected function getFileContentsForEnrollmentPayersFromElligible($apiKey)
    {
        $uri = $this->elligibleConfigurtion['base_uri'];
        $uri .= $this->elligibleConfigurtion['request_uri']['enrollment_payers_list'];
        $uri .= $apiKey;

        $contents = file_get_contents($uri);
        return $contents;
    }

    /**
     *
     *
     * @param $payers
     * @return void
     */
    protected function savePayerToDatabase(Object $payers)
    {
        foreach ($payers as $payer) {

            $names = [];
            $supported_endpoints = [];

            foreach ($payer->names as $name) {
                $names[] = ['name' => $name];
            }

            $row = ['payer_id' => $payer->payer_id, 'names' => json_encode($names),
                'supported_endpoints' => json_encode($payer->supported_endpoints)];

            $this->store($row);

        }
    }

}