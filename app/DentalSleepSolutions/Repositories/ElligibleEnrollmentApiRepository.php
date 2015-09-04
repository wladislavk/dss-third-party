<?php namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Interfaces\EnrollmentInterface;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

class ElligibleEnrollmentApiRepository extends BaseRepository implements EnrollmentInterface
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
     * @var Client
     */
    protected $restClient;

    public function __construct()
    {

        $this->elligibleConfigurtion = config('elligibleapi');
        $handler = new CurlHandler();
        $stack = HandlerStack::create($handler); // Wrap w/ middleware
        $this->restClient = new Client(['handler' => $stack, 'base_uri' => $this->elligibleConfigurtion['base_uri']]);
        dd($this->listPayers());

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
     * @return mixed
     */
    public function syncPayersFromProvider()
    {
        $model = $this->getModelName();
        $this->instance = $model::truncate();

        $uri = $this->elligibleConfigurtion['base_uri'];
        $uri .= $this->elligibleConfigurtion['request_uri']['enrollment_payers_list'];
        $uri .= $this->elligibleConfigurtion['api_key'];

        $contents = file_get_contents($uri);

        if($contents!==FALSE)
        {

            $payers = json_decode($contents);

            foreach ($payers as $payer)
            {

                $names = [];
                $supported_endpoints = [];

                foreach ($payer->names as $name)
                {
                    $names[] = ['name' => $name];
                }

                $row = ['payer_id' => $payer->payer_id, 'names' => json_encode($names),
                        'supported_endpoints' => json_encode($payer->supported_endpoints)];

                $this->store($row);

            }

        }

    }

    public function createEnrollment() {

    }

    public function updateEnrollment() {

    }

    public function retrieveEnrollment() {

    }

    public function listEnrollments() {

    }

    /**
     * Create new memo
     *
     * @param array $data
     * @return object
     */
    public function store(array $data = null)
    {
        $data = $data ?: \Input::all();

        $this->instance = parent::store($data);

        return $this->instance;
    }

    /**
     * Update memo
     *
     * @param integer $id
     * @param array   $data
     * @return object
     */
    public function update($id, array $data = null)
    {
        $data = $data ?: \Input::all();

        $this->instance = parent::update($id, $data);

        return $this->instance;
    }

}