<?php namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Interfaces\EnrollmentInterface;
use DentalSleepSolutions\Http\Requests\ApiEligibleEnrollmentRequest;
use DentalSleepSolutions\Interfaces\EnrollmentPayersInterface;
use DentalSleepSolutions\Interfaces\UserSignaturesInterface;
use Mockery\CountValidator\Exception;

/**
 * @SWG\Info(title="Dental Sleep Solutions Enrollment Api", version="0.1")
 */

class ApiEnrollmentsController extends ApiBaseController
{

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
     * @var array $enrollmentValues
     */
    protected $enrollmentValues = [];

    /**
     * @var boolean
     */
    protected $signatureRequired = false;

    /**
     * @var boolean
     */
    protected $blueInkSignatureRequired = false;

    protected $transcationType = 0;


    /**
     * @param EnrollmentInterface       $enrollments
     * @param EnrollmentPayersInterface $payers
     * @param UserSignaturesInterface   $signatures
     */
    public function __construct(
        EnrollmentInterface $enrollments,
        EnrollmentPayersInterface $payers,
        UserSignaturesInterface $signatures
    )
    {
        $this->enrollments = $enrollments;
        $this->payers      = $payers;
        $this->signatures  = $signatures;
    }

    /**
     *
     *
     * @param integer $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function listEligibleEnrollments($page = 1)
    {
        try
        {
            $results = $this->enrollments->listEnrollments($page);
            $response = ['data' => $results, 'status' => true, 'message' => ''];
            return response()->json($response, 200);
        }
        catch (Exception $ex)
        {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
    }

    /**
     *
     *
     * @param integer $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function listEnrollments($userId = 0)
    {
        try
        {
            $results = $this->enrollments->listEnrollments($userId);
            $response = ['data' => $results, 'status' => true, 'message' => 'List of Enrollments'];
            return response()->json($response, 200);
        }
        catch (Exception $ex)
        {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
    }

    /**
     *
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
     *
     * @param ApiEligibleEnrollmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createEnrollment(ApiEligibleEnrollmentRequest $request)
    {
        $enrollmentParams = [];

        try
        {
            if (null !== $request->get('payer_id') || !empty($request->get('payer_id')))
            {
                //What fields are required for this enrollment

                $enrollmentRequiredFields       = $this->checkEnrollmentFields($request->get('payer_id'));

                $this->signatureRequired        = $this->payers->payerRequiresSignature($request->get('payer_id'));

                $this->blueInkSignatureRequired = $this->payers
                                                       ->payerRequiresBlueInkSignature($request->get('payer_id'));

                foreach ($enrollmentRequiredFields as $field)
                {
                    if (!$request->has($field))
                    {
                        $message = 'You have not supplied the required enrolment fields. - '
                                .implode(",", $enrollmentRequiredFields);

                        $this->createErrorResponse($message, 300);
                    }
                }

                //setup the eligible enrollment array
                $enrollmentParams = $this->setupEnrollmentArrayFromFormInput($request);

            }

            //create a new eligible enrollment
            $enrollment = $this->enrollments->createEnrollment($enrollmentParams);
            //dd($enrollment);
            //grab the request values submited from the form so we can persist it to the DB
            //setup the returned values from Eligible to be saved to db.
            $this->setEnrollmentValuesForSavingToDb($request, $enrollment);
            $this->enrollments->saveEnrollmentDetailsToDatabase($this->enrollmentValues);

            return response()->json($enrollment, 200);
        }
        catch (Exception $ex)
        {
            $this->createErrorResponse('An error occured creating the Enrollment.', 404);
        }
    }

    //Todo - add the json signature to the swagegr items
    /**
     *
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
     *

     * @param ApiEligibleEnrollmentRequest $request
     * @param integer                      $enrollmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEnrollment(ApiEligibleEnrollmentRequest $request, $enrollmentId = 0)
    {
        $response = [];
        try
        {
            $enrollmentParams = $this->setupEnrollmentArrayFromFormInput($request);
            $enrollment = $this->enrollments->updateEnrollment($enrollmentParams, $enrollmentId);
            return response()->json($enrollment, 200);
        }
        catch (Exception $ex)
        {
            $this->createErrorResponse('An error occured updating the Enrollment.', 404);
        }
    }


    //Todo - Add relevant params to the Swagger Items.

    /**
     *
     *
     * @SWG\Get(
     *     path="/api/v1/enrollments.json",
     * )
     *
     * @param integer $enrollmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveEnrollment($enrollmentId = 0)
    {
        try
        {
            $response = $this->enrollments->retrieveEnrollment($enrollmentId);
            return response()->json($response, 200);
        }
        catch (Exception $ex)
        {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
    }

    /**
     *
     *
     * @param ApiEligibleEnrollmentRequest $request
     * @return mixed
     */
    private function setupEnrollmentArrayFromFormInput(ApiEligibleEnrollmentRequest $request)
    {
        $signatureCordinates = [];

        $transactionTypes = $this->enrollments->getEnrollmentTransactionType($request->get('transaction_type_id'));
        $this->transcationType = $transactionTypes->transaction_type;

        $elligibleEnrollment['payer_id']            = $request->get('payer_id');
        $elligibleEnrollment['transaction_type_id'] = $request->get('transaction_type_id');
        $elligibleEnrollment['transaction_type']    = $this->transcationType;
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

        $elligibleEnrollment['authorized_signer'] = ['title' => $request->get('title'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'contact_number' => $request->get('contact_number'),
            'email' => $request->get('email'),
            ];

        if ($this->signatureRequired)
        {
            $signature = $this->getDentalUserSignature($request->get('user_id'));
            $elligibleEnrollment['authorized_signer']['signature'] = ['coordinates' => $signature->signature_json];
        }

        return $elligibleEnrollment;
    }


    /**
     *
     *
     * @param ApiEligibleEnrollmentRequest $request
     * @param \stdClass                    $enrollment
     * @return void
     */
    private function setEnrollmentValuesForSavingToDb(
        ApiEligibleEnrollmentRequest $request,
        \stdClass $enrollment
    )
    {
        $this->enrollmentValues['user_id']                = $request->get('user_id');
        $this->enrollmentValues['payer_id']               = $request->get('payer_id');
        $this->enrollmentValues['transaction_type_id']    = $request->get('transaction_type_id');
        $this->enrollmentValues['transaction_type']       = $this->transcationType;
        $this->enrollmentValues['facility_name']          = $request->get('facility_name');
        $this->enrollmentValues['provider_name']          = $request->get('provider_name');
        $this->enrollmentValues['tax_id']                 = $request->get('tax_id');
        $this->enrollmentValues['address']                = $request->get('address');
        $this->enrollmentValues['city']                   = $request->get('city');
        $this->enrollmentValues['state']                  = $request->get('state');
        $this->enrollmentValues['zip']                    = $request->get('zip');
        $this->enrollmentValues['first_name']             = $request->get('first_name');
        $this->enrollmentValues['last_name']              = $request->get('last_name');
        $this->enrollmentValues['contact_number']         = $request->get('contact_number');
        $this->enrollmentValues['email']                  = $request->get('email');

        $this->enrollmentValues['payer_name'] = rtrim(
            implode(
                ',',
                $enrollment->enrollment_npi->payer->names
            ),
            ','
        );

        $this->enrollmentValues['npi'] = $enrollment->enrollment_npi->npi;
        $this->enrollmentValues['reference_id'] = $enrollment->enrollment_npi->id;
        $this->enrollmentValues['response'] = $enrollment->response;
        $this->enrollmentValues['adddate'] = $enrollment->adddate;
        $this->enrollmentValues['ip_address'] = $enrollment->ip_address;
        $this->enrollmentValues['status'] = 0;
    }

    /**
     *
     *
     * @param integer $payerId
     * @return mixed
     */
    protected function checkEnrollmentFields($payerId)
    {
        return $this->enrollments->getRequiredFieldsForEnrollment($payerId);
    }

    /**
     *
     *
     * @param integer $user_id
     * @return mixed
     */
    protected function getDentalUserSignature($user_id)
    {
        return $this->signatures->findBy('user_id', $user_id);
    }

    /**
     *
     *
     * @param integer $user_id
     * @return mixed
     */
    public function getDentalUserCompanyApiKey($userId)
    {
        try
        {
            $response = $this->enrollments->getUserCompanyEligibleApiKey($userId);
            return response()->json($response, 200);
        }
        catch (Exception $ex)
        {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
    }

    public function getEnrollmentTransactionType($id=0)
    {

     try
        {
            $response = $this->enrollments->getEnrollmentTransactionType($id);
            return response()->json($response, 200);
        }
        catch (Exception $ex)
        {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }   
    }
}
