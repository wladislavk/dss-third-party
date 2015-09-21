<?php namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Interfaces\EnrollmentInterface;
use DentalSleepSolutions\Interfaces\EnrollmentPayersInterface;
use Carbon\Carbon;

class EnrollmentRepository extends BaseRepository implements EnrollmentInterface
{

    /**
     *
     * @var string
     *
     * Main model name for the Enrollment  Payers Model
     */
    protected $modelName = 'DentalSleepSolutions\Enrollment';

    /**
     * @var null
     */
    protected $elligibleConfigurtion = null;

    /**
     * @var null
     */
    protected $providerUri = null;

    /**
     * @var null
     */
    protected $enrollmentsRoute = null;

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
     *
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
     *
     *
     * @param int $enrollmentId
     * @param array $enrollmentParams
     * @param string $apiKey
     * @return mixed
     */
    public function updateEnrollment($enrollmentId = 0,array $enrollmentParams, $apiKey = '')
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
     *
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
     *
     *
     * @param integer $page
     * @param string  $apiKey
     * @return string
     */
    public function listEnrollments($page = 1, $apiKey = '')
    {
        $this->checkAndSetProviderApiKey($apiKey);
        $data_string = $this->convertEnrollmentParamsToJson();
        $requestUri = $this->setupListEnrollmentsUrl($page);
        $headers = $this->setupApiRequestHeaders($data_string);
        $response = \Requests::get($requestUri, $headers);

        return $response->body;
    }


    /**
     *
     *
     * @param array $data
     * @return void
     */
    public function saveEnrollmentDetailsToDatabase($data = [])
    {
        $this->store($data);
    }

    /**
     *
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
     *
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
     *
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
     *
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
     *
     *
     * @param array $enrollmentParams
     * @param $enrollmentResponse
     * @param $response
     * @return void
     */
    protected function setupEnrollmentResponseForCreateUpdate(array $enrollmentParams, $enrollmentResponse, $response)
    {
        $enrollmentResponse->ip_address = $enrollmentParams['ip_address'];
        $enrollmentResponse->adddate = Carbon::now();
        $enrollmentResponse->response = $response->body;
    }

}
