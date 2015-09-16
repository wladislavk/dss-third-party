<?php namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Interfaces\EnrollmentInterface;
use DentalSleepSolutions\Http\Requests\ApiElligibleEnrollmentRequest;
use DentalSleepSolutions\Interfaces\EnrollmentPayersInterface;
use DentalSleepSolutions\Interfaces\UserSignaturesInterface;
use Mockery\CountValidator\Exception;

class ApiEnrollmentsController extends ApiBaseController
{
    /**
     * @SWG\Info(title="Dental Sleep Solutions Enrollment Api", version="0.1")
     */

    /**
     * @var EnrollmentInterface $enrollments
     */
    protected $enrollments;

    /**
     * @var EnrollmentPayersInterface $payers
     */
    protected $payers;

    /**
     * @var UserSignaturesInterface $signatures
     */
    protected $signatures;

    /**
     * @param EnrollmentInterface $enrollments
     * @param EnrollmentPayersInterface $payers
     * @param UserSignaturesInterface $signatures
     */
    public function __construct(EnrollmentInterface $enrollments,
                                EnrollmentPayersInterface $payers,
                                UserSignaturesInterface $signatures)
    {
        $this->enrollments = $enrollments;
        $this->payers      = $payers;
        $this->signatures  = $signatures;
    }

    public function listEnrollments($page=1)
    {
        try {
            $results = $this->enrollments->listEnrollments($page);
            $response = ['data' => $results, 'status' => true, 'message' => ''];
            return response()->json($response,200);
        } catch(Exception $ex) {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }

    }

    /**
     * @SWG\Post(
     *     path="/api/v1/enrollments.json",
     *     @SWG\Parameter(name="endpoint",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="payer_id",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="transaction_type",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="facility_name",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="provider_name",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="tax_id",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="address",
     *                    description="",
     *                    required=true,type="string"),
     *    @SWG\Parameter(name="city",
     *                    description="",
     *                    required=true,type="string"),
     *    @SWG\Parameter(name="state",
     *                    description="",
     *                    required=true,type="string"),
     *    @SWG\Parameter(name="zip",
     *                    description="",
     *                    required=true,type="string"),
     *
     *    @SWG\Response(response="200", description="Action completed successfully.")
     * )
     */

    /**
     *
     *
     * @param ApiElligibleEnrollmentRequest $apiElligibleEnrollmentRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function createEnrollment(ApiElligibleEnrollmentRequest $request)
    {
        $response = [];
        $enrollmentValues = [];

        try
        {

            $enrollmentRequiredFields = $this->checkEnrollmentFields();

            dd($enrollmentRequiredFields);

            $enrollmentParams = $this->setupEnrollmentArrayFromFormInput($request);
            $enrollment = $this->enrollments->createEnrollment($enrollmentParams);

            $enrollmentValues = $this->setCreatedEnrollmentsValuesForSavingToDb($enrollment, $enrollmentValues);
            $enrollmentValues = $this->setEnrollmentFormPostValuesForSavingToDb($request, $enrollmentValues);

            $this->enrollments->saveEnrollmentDetailsToDatabase($enrollmentValues);

            return response()->json($enrollment, 200);

        }
        catch(Exception $ex)
        {
            $this->createErrorResponse('An error occured creating the Enrollment.', 404);
        }
    }


    /**
     * @SWG\Put(
     *     path="/api/v1/enrollments.json",
     *     @SWG\Parameter(name="endpoint",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="payer_id",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="transaction_type",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="facility_name",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="provider_name",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="tax_id",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="address",
     *                    description="",
     *                    required=true,type="string"),
     *    @SWG\Parameter(name="city",
     *                    description="",
     *                    required=true,type="string"),
     *    @SWG\Parameter(name="state",
     *                    description="",
     *                    required=true,type="string"),
     *    @SWG\Parameter(name="zip",
     *                    description="",
     *                    required=true,type="string"),
     *
     *    @SWG\Response(response="200", description="Action completed successfully.")
     * )
     */

    /**
     *
     *
     * @param int $enrollmentId
     * @param ApiElligibleEnrollmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEnrollment($enrollmentId=0, ApiElligibleEnrollmentRequest $request)
    {
        $response = [];
        try{
            $enrollmentParams = $this->enrollmentFormInput($request);
            $enrollmentParams['ip_address'] = $request->ip();
            $this->enrollment = $this->enrollments->updateEnrollment($enrollmentId,$enrollmentParams);
            return response()->json($this->enrollment, 200);
        } catch(Exception $ex) {
            $this->createErrorResponse('An error occured updating the Enrollment.', 404);
        }
    }



    /**
     * @SWG\Get(
     *     path="/api/v1/enrollments.json",
     * )
     */

    /**
     *
     *
     * @param int $enrollmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveEnrollment($enrollmentId=0)
    {
        try {
            $response = $this->enrollments->retrieveEnrollment($enrollmentId);
            return response()->json($response, 200);
        } catch(Exception $ex) {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
    }

    public function destroyEnrollment()
    {

    }


    /**
     *
     *
     * @return mixed
     */
    private function setupEnrollmentArrayFromFormInput($request)
    {
        $elligibleEnrollment['payer_id']            = $request->get('payer_id');
        $elligibleEnrollment['transaction_type']    = $request->get('transaction_type');
        $elligibleEnrollment['facility_name']       = $request->get('facility_name');
        $elligibleEnrollment['provider_name']       = $request->get('provider_name');
        $elligibleEnrollment['tax_id']              = $request->get('tax_id');
        $elligibleEnrollment['address']             = $request->get('address');
        $elligibleEnrollment['city']                = $request->get('city');
        $elligibleEnrollment['state']               = $request->get('state');
        $elligibleEnrollment['zip']                 = $request->get('zip');
        $elligibleEnrollment['npi']                 = $request->get('npi');
        $elligibleEnrollment['ptan']                = $request->get('ptan');
        $elligibleEnrollment['ip_address']          = $request->ip();

        $signature = $this->getDentalUserSignature($request->get('user_id'));

        $elligibleEnrollment['authorized_signer'] = ['title' => $request->get('title'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'contact_number' => $request->get('contact_number'),
            'email' => $request->get('email'),
            'signature' => ['coordinates' => $signature->signature_json]];

        return $elligibleEnrollment;
    }

    /**
     *
     *
     * @param ApiElligibleEnrollmentRequest $request
     * @param $enrollmentValues
     * @return mixed
     */
    private function setEnrollmentFormPostValuesForSavingToDb(ApiElligibleEnrollmentRequest $request, $enrollmentValues)
    {
        $enrollmentValues['user_id']                = $request->get('user_id');
        $enrollmentValues['payer_id']               = $request->get('payer_id');
        $enrollmentValues['transaction_type_id']    = $request->get('transaction_type');
        $enrollmentValues['facility_name']          = $request->get('facility_name');
        $enrollmentValues['provider_name']          = $request->get('provider_name');
        $enrollmentValues['tax_id']                 = $request->get('tax_id');
        $enrollmentValues['address']                = $request->get('address');
        $enrollmentValues['city']                   = $request->get('city');
        $enrollmentValues['state']                  = $request->get('state');
        $enrollmentValues['zip']                    = $request->get('zip');
        $enrollmentValues['first_name']             = $request->get('first_name');
        $enrollmentValues['last_name']              = $request->get('last_name');
        $enrollmentValues['contact_number']         = $request->get('contact_number');
        $enrollmentValues['email']                  = $request->get('email');

        return $enrollmentValues;
    }

    /**
     *
     *
     * @return mixed
     */
    protected function checkEnrollmentFields() {
        return $this->enrollments->getRequiredFieldsForEnrollment('00901');
    }

    protected function getDentalUserSignature($user_id) {
        return $this->signatures->findBy('user_id', $user_id);
    }

    /**
     *
     *
     * @param $enrollment
     * @param $enrollmentValues
     * @return mixed
     */
    private function setCreatedEnrollmentsValuesForSavingToDb($enrollment, $enrollmentValues)
    {
        $enrollmentValues['payer_name'] = rtrim(implode(',',
            $enrollment->enrollment_npi->payer->names), ',');
        $enrollmentValues['npi'] = $enrollment->enrollment_npi->npi;
        $enrollmentValues['reference_id'] = $enrollment->enrollment_npi->id;
        $enrollmentValues['response'] = $enrollment->response;
        $enrollmentValues['adddate'] = $enrollment->adddate;
        $enrollmentValues['ip_address'] = $enrollment->ip_address;

        $enrollmentValues['status'] = 0;
        return $enrollmentValues; //Find out why were not using the elligible status here...
    }

}
