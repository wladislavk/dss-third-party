<?php namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Interfaces\EnrollmentInterface;
use DentalSleepSolutions\Interfaces\EnrollmentPayersInterface;

class EnrollmentRepository extends BaseRepository implements EnrollmentInterface
{
    /**
     *
     * @var string
     *
     * Main model name for the Enrollment  Payers Model
     */
    protected $modelName = '';

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
     * @param $payerId
     * @return mixed
     */
    public function getRequiredFieldsForEnrollment($payerId)
    {
        $mandatoryEnrollmentFields = [];
        $endPoints = $this->payers->getPayerSupportedEndpoints($payerId);
        foreach ($endPoints as $endPoint) {
            if($endPoint->endpoint=='coverage') {
                foreach ($endPoint->enrollment_mandatory_fields as $mandatoryEnrollmentField) {
                    $mandatoryEnrollmentFields[] = $mandatoryEnrollmentField;
                }

            }
        }

        dd($mandatoryEnrollmentFields);

    }


    /**
     *
     *
     * @param array $enrollmentParams
     * @return string
     */
    public function createEnrollment(array $enrollmentParams)
    {

        $postUrl = $this->providerUri.$this->enrollmentsRoute;
        $data['api_key'] = $this->elligibleConfigurtion['default_api_key'];

        if($this->elligibleConfigurtion['test']===TRUE)
        {
            $data['test'] = "true";
        }


        $data['enrollment_npi'] = $enrollmentParams;
        $data_string = json_encode($data);

        $headers = ['Content-Type' => 'application/json',
                    'Content-Length: ' . strlen($data_string)];

        $response = \Requests::post($postUrl,$headers,$data_string);
        return $response->body;

    }

    public function retrieveEnrollment()
    {

    }

    public function listEnrollments()
    {

    }
}