<?php

namespace DentalSleepSolutions\Repositories;

use Carbon\Carbon;
use DentalSleepSolutions\Interfaces\EnrollmentInterface;
use DentalSleepSolutions\Eloquent\Enrollments\Enrollment;
use DentalSleepSolutions\Interfaces\EnrollmentPayersInterface;

class EnrollmentRepository extends BaseRepository implements EnrollmentInterface
{

    /**
     *
     * @var string
     *
     * Main model name for the Enrollment  Payers Model
     */
    protected $modelName = Enrollment::class;

    /**
     * @var mixed|string
     */
    protected $elligibleConfigurtion = '';

    /**
     * @var string
     */
    protected $providerUri = '';

    /**
     * @var string
     */
    protected $enrollmentsRoute = '';

    /**
     * @var $restClient
     */
    protected $restClient;

    /**
     * @var EnrollmentPayersInterface $payers
     */
    protected $payers;

    /**
     * @var array
     */
    protected $elligibleParams = [];

    /**
     *
     *
     *
     * @param EnrollmentPayersInterface $enrollmentPayersInterface
     */
    public function __construct(EnrollmentPayersInterface $enrollmentPayersInterface)
    {
        $this->elligibleConfigurtion = config('elligibleapi');
        $this->providerUri = $this->elligibleConfigurtion['base_uri'];
        $this->enrollmentsRoute = $this->elligibleConfigurtion['request_uri']['enrollments'];
        $this->payers = $enrollmentPayersInterface;
    }

    /**
     *
     *
     * @param integer $payerId
     * @return mixed
     */
    public function getRequiredFieldsForEnrollment($payerId)
    {
        $mandatoryEnrollmentFields = [];
        $endPoints = $this->payers->getPayerSupportedEndpoints($payerId);

        foreach ($endPoints as $endPoint)
        {
            if ($endPoint->endpoint == 'coverage')
            {
                foreach ($endPoint->enrollment_mandatory_fields as $mandatoryEnrollmentField)
                {
                    $mandatoryEnrollmentFields[] = $mandatoryEnrollmentField;
                }
            }
        }

        return ($mandatoryEnrollmentFields);
    }

    /**
     * Submits an enrollment to Eliigible
     *
     * @param array  $enrollmentParams
     * @param string $apiKey
     * @return mixed
     */
    public function createEnrollment(array $enrollmentParams, $apiKey = '')
    {
        $enrollmentParams['endpoint'] = 'coverage';

        $this->elligibleParams['enrollment_npi'] = $enrollmentParams;
        $requestUri = $this->providerUri.$this->enrollmentsRoute;
        $this->checkAndSetProviderApiKey($apiKey);

        $data_string = $this->convertEnrollmentParamsToJson();

        $headers = $this->setupApiRequestHeaders($data_string);
        $response = \Requests::post($requestUri, $headers, $data_string);
        $enrollmentResponse = json_decode($response->body);

        if (isset($enrollmentResponse->error))
        {
            return $enrollmentResponse->error;
        }

        $this->setupEnrollmentResponseForCreateUpdate($enrollmentParams, $enrollmentResponse, $response);

        return $enrollmentResponse;
    }

    /**
     * Updates a enrollment on Elligible
     *
     * @param array   $enrollmentParams
     * @param integer $enrollmentId
     * @param string  $apiKey
     * @return mixed
     */
    public function updateEnrollment(array $enrollmentParams, $enrollmentId = 0, $apiKey = '')
    {
        $enrollmentParams['endpoint'] = 'coverage';

        $this->elligibleParams['enrollment_npi'] = $enrollmentParams;
        $requestUri = $this->providerUri.$this->enrollmentsRoute.'/'.$enrollmentId;

        $this->checkAndSetProviderApiKey($apiKey);
        $data_string = $this->convertEnrollmentParamsToJson();
        $headers = $this->setupApiRequestHeaders($data_string);
        $response = \Requests::put($requestUri, $headers, $data_string);
        $enrollmentResponse = json_decode($response->body);

        if (isset($enrollmentResponse->error))
        {
            return $enrollmentResponse->error;
        }

        $this->setupEnrollmentResponseForCreateUpdate($enrollmentParams, $enrollmentResponse, $response);

        return $enrollmentResponse;
    }

    /**
     * Fetches an enrollment from Elligible.
     *
     * @param integer $enrollmentId
     * @param array   $enrollmentParams
     * @param string  $apiKey
     * @return string
     */
    public function retrieveEnrollment($enrollmentId = 0, array $enrollmentParams = [], $apiKey = '')
    {
        if ($enrollmentId == 0)
        {
            return 'enrollment id parameter missing';
        }

        $this->elligibleParams = $enrollmentParams;
        $this->checkAndSetProviderApiKey($apiKey);
        $data_string = $this->convertEnrollmentParamsToJson();

        $requestUri = $this->setupRetrieveEnrollmentUrl($enrollmentId);
        $headers = $this->setupApiRequestHeaders($data_string);
        $response = \Requests::get($requestUri, $headers);

        return $response->body;
    }

    /**
     * List enrollments by page from Eligible
     *
     * @param integer $page
     * @param string  $apiKey
     * @return string
     */
    public function listEligibleEnrollments($page = 1, $apiKey = '')
    {
        $this->checkAndSetProviderApiKey($apiKey);
        $data_string = $this->convertEnrollmentParamsToJson();
        $requestUri = $this->setupListEnrollmentsUrl($page);
        $headers = $this->setupApiRequestHeaders($data_string);
        $response = \Requests::get($requestUri, $headers);

        return $response->body;
    }


    /**
     * Saves an enrollment to our DB
     *
     * @param array $data
     * @return void
     */
    public function saveEnrollmentDetailsToDatabase(array $data = [])
    {
        $this->store($data);
    }

    /**
     * If we are in test mode then include test as part of the generated url calls to Eligible
     *
     * @return void
     */
    protected function checkApiTestMode()
    {
        if ($this->elligibleConfigurtion['test'] == true)
        {
            $this->elligibleParams['test'] = "test";
        }
    }

    /**
     * Checks if an api key was supplied otherwise it uses the config based api key.
     *
     * @param string $apiKey
     * @return void
     */
    protected function checkAndSetProviderApiKey($apiKey)
    {
        $this->elligibleParams['api_key'] = $apiKey != ''
            ? $apiKey
            : $this->elligibleConfigurtion['default_api_key'];
    }

    /**
     * Converts the enrollment params submited to a json string so we can submit as part of the payload to Eligible.
     *
     * @return string
     */
    protected function convertEnrollmentParamsToJson()
    {
        $this->checkApiTestMode();
        $data_string = json_encode($this->elligibleParams);
        return $data_string;
    }

    /**
     * Adds our specific string to a header to setup the content type.
     *
     * @param string $data_string
     * @return array
     */
    public function setupApiRequestHeaders($data_string)
    {
        $headers = ['Content-Type' => 'application/json',
            'Content-Length: ' . strlen($data_string)];
        return $headers;
    }

    /**
     *
     *
     * @param string $enrollmentId
     * @return string
     */
    protected function setupRetrieveEnrollmentUrl($enrollmentId)
    {
        $urlParams = $enrollmentId . '?api_key=' . $this->elligibleParams['api_key'];
        $urlParams .= array_key_exists('test', $this->elligibleParams) ? '&test=true' : '';
        $requestUri = $this->providerUri . $this->enrollmentsRoute . '/' . $urlParams;
        return $requestUri;
    }

    /**
     *
     *
     * @param integer $page
     * @return string
     */
    protected function setupListEnrollmentsUrl($page = 1)
    {
        $urlParams = '?api_key=' . $this->elligibleParams['api_key'];
        $urlParams .= array_key_exists('test', $this->elligibleParams) ? '&test=true' : '';
        $urlParams .= '&page=' . $page;
        $requestUri = $this->providerUri . $this->enrollmentsRoute . $urlParams;
        return $requestUri;
    }


    /**
     * Grabs the response for the post/put API calls and adds it to the enrollmentResponse Object
     * we effectivelty return this object to the controller and we potential return it to the main calling client.
     *
     * @param array     $enrollmentParams
     * @param \stdClass $enrollmentResponse
     * @param string    $response
     * @return void
     */
    protected function setupEnrollmentResponseForCreateUpdate(
        array $enrollmentParams,
        \stdClass $enrollmentResponse,
        $response
    )
    {
        $enrollmentResponse->ip_address = $enrollmentParams['ip_address'];
        $enrollmentResponse->adddate = Carbon::now();
        $enrollmentResponse->response = $response->body;
    }

    /************************* Local DB Functions ***********************/

    /**
     *
     *
     * @param int $userId
     * @return mixed
     */
    public function listEnrollments($userId)
    {

        $query = \DB::table('dental_eligible_enrollment as enrollments');
        $query->join('dental_enrollment_transaction_type as types', function($joinClause){
            $joinClause->on('enrollments.transaction_type_id', '=', 'types.id');
        });
        $query->select(array("enrollments.*", \DB::raw("CONCAT(types.transaction_type,' - ',types.description) as transaction_type")));
        $query->where(\DB::raw('enrollments.user_id'),'=',$userId);

        return $query->get();
    }

    /**
     *
     *
     * @param int $userId
     * @return mixed
     */
    public function getUserCompanyEligibleApiKey($userId)
    {
        $query = \DB::table('dental_user_company')
            ->join('companies','dental_user_company.companyid','=','companies.id')
            ->select(array('eligible_api_key'))
            ->where('dental_user_company.userid','=',$userId)->first();

        return $query;

    }

    /**
     * [getEnrollmentTransactionType description]
     * @param  integer $id
     * @return mixed
     */
    public function getEnrollmentTransactionType($id)
    {
        $query = \DB::table('dental_enrollment_transaction_type')
            ->where('id','=',$id)->where('status','=',1)->first();

        return $query;
    }

}
