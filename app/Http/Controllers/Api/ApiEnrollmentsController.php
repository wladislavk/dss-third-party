<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use DentalSleepSolutions\Eligible\Client;
use DentalSleepSolutions\Helpers\Invoice;
use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Helpers\SignatureToImage;
use DentalSleepSolutions\Eloquent\UserSignature;
use DentalSleepSolutions\Http\Requests\Enrollments\Create;
use DentalSleepSolutions\Http\Requests\ApiEligibleEnrollmentRequest;
use DentalSleepSolutions\Http\Requests\Enrollments\OriginalSignature;

use DentalSleepSolutions\Eloquent\Enrollments\Enrollment;
use DentalSleepSolutions\Eloquent\Enrollments\TransactionType;
use DentalSleepSolutions\Eligible\Webhooks\EnrollmentsHandler;

use DentalSleepSolutions\Interfaces\EnrollmentInterface;
use DentalSleepSolutions\Interfaces\UserSignaturesInterface;
use DentalSleepSolutions\Interfaces\EnrollmentPayersInterface;

class ApiEnrollmentsController extends ApiBaseController
{
    /**
     * create enrollment
     *
     * @param  \DentalSleepSolutions\Http\Requests\Enrollments\Create $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Create $request)
    {
        $user_id = $request->input('user_id');

        $payer_id = explode('-', $request->input('payer_id'));

        $user_signature = UserSignature::formUser($user_id);
        $signature = $user_signature ? $user_signature->signature_json : $request->input('signature', '');

        $transaction_type = TransactionType::where('id', $request->input('transaction_type_id'))
            ->where('status', 1)->first();

        if (count($payer_id) < 2 || !$transaction_type) {
            return ApiResponse::responseError("Error creating enrollment.", 422);
        }

        $payer_name = $payer_id[1];
        $payer_id = $payer_id[0];

        $data['enrollment_npi'] = [
            "payer_id" => $payer_id,
            "endpoint" => $transaction_type->endpoint_type,
            "facility_name" => $request->input('facility_name'),
            "provider_name" => $request->input('provider_name'),
            "npi" => $request->input('npi'),
            "tax_id" => $request->input('tax_id'),
            "address" => $request->input('address'),
            "city" => $request->input('city'),
            "state" => $request->input('state'),
            "zip" => $request->input('zip'),
            "ptan" => $request->input('ptan'),
            "authorized_signer" => [
                "first_name" => $request->input('first_name'),
                "last_name" => $request->input('last_name'),
                "contact_number" => $request->input('contact_number'),
                "email" => $request->input('email'),
                "signature" => ["coordinates" => json_decode($signature)]
            ]
        ];

        $client = new Client;
        $client->setApiKeyFromUser($user_id);
        $response = $client->createEnrollment($data);

        if ($response->isSuccess()) {
            $inputs = $request->all();
            $inputs['contact_number'] = array_get($inputs, 'contact_number', '');
            $ip = $request->server('REMOTE_ADDR');
            $result = $response->getContent();
            $ref_id = $response->getObject()->enrollment_npi->id;

            $enrollment_id = Enrollment::add($inputs, $user_id, $payer_id, $payer_name, $ref_id, $result, $ip);
            Invoice::addEnrollment('1', $user_id, $enrollment_id);

            if ($request->input('signature', '') != '') {
                $signature_id = UserSignature::add($user_id, $signature, $ip);

                $signature = new SignatureToImage();
                $img = $signature->sigJsonToImage($request->input('signature', ''));

                $file = "signature_" . $user_id . "_" . $signature_id . ".png";
                imagepng($img, env('LEGACY_PATH').'/../shared/q_file/'.$file);
                imagedestroy($img);
            }
        }

        return ApiResponse::response($response->getResponse(), "Enrollments is created.", "Error creating enrollment.");
    }

    /**
     * @param int $transaction_type
     * @return object|string
     */
    public function getPayersList($transaction_type = 1)
    {
        $transaction_type = TransactionType::where('id', $transaction_type)->where('status', 1)->first();

        $client = new Client;
        $response = $client->getPayers($transaction_type->endpoint_type);

        if ($response->isSuccess()) {
            return \Response::json($response->getObject());
        }

        return \Response::json([]);
    }

    /**
     * @param  \DentalSleepSolutions\Http\Requests\Enrollments\OriginalSignature $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadOriginalSignaturePdf(OriginalSignature $request)
    {
        $user_id = $request->input('user_id');
        $npi = $request->input('npi');
        $reference_id = $request->input('reference_id');

        $data = [
            'file' => $request->file('original_signature')->openFile(),
        ];

        $enrollment = Enrollment::getWhereReference($reference_id);

        $client = new Client;
        $client->setApiKeyFromUser($user_id);

        if ($enrollment->signed_download_url) {
            $response = $client->updateOriginalSignaturePdf($data, $npi);
        } else {
            $response = $client->createOriginalSignaturePdf($data, $npi);
        }

        if ($response->isSuccess()) {
            $download_url = $response->getObject()->original_signature_pdf->download_url;
            Enrollment::setStatus($reference_id, Enrollment::DSS_ENROLLMENT_PDF_SENT);
            Enrollment::setSignedDownloadUrl($reference_id, $download_url);

            (new EnrollmentsHandler)->updateChanges($reference_id);
        }

        return ApiResponse::response(
            $response->getResponse(),
            "Your enrollment has been submitted.",
            "Error submitted enrollment."
        );
    }

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
     * @param EnrollmentInterface $enrollments
     * @param EnrollmentPayersInterface $payers
     * @param UserSignaturesInterface $signatures
     */
    public function __construct(
        EnrollmentInterface $enrollments,
        EnrollmentPayersInterface $payers,
        UserSignaturesInterface $signatures
    ) {
        $this->enrollments = $enrollments;
        $this->payers = $payers;
        $this->signatures = $signatures;
    }

    public function syncEnrollmentPayers()
    {
        try {
            $results = $this->payers->syncEnrollmentPayersFromProvider(null);
            $response = ['data' => $results, 'status' => true, 'message' => ''];
            return response()->json($response, 200);
        } catch (Exception $ex) {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
    }

    /**
     * @param integer $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function listEligibleEnrollments($page = 1)
    {
        try {
            $results = $this->enrollments->listEnrollments($page);
            $response = ['data' => $results, 'status' => true, 'message' => ''];
            return response()->json($response, 200);
        } catch (Exception $ex) {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
    }

    /**
     * @param integer $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function listEnrollments($userId = 0)
    {
        try {
            $results = $this->enrollments->listEnrollments($userId);
            $response = ['data' => $results, 'status' => true, 'message' => 'List of Enrollments'];
            return response()->json($response, 200);
        } catch (Exception $ex) {
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
    /*public function createEnrollment(ApiEligibleEnrollmentRequest $request)
    {
        $enrollmentParams = [];
        try {
            if (null !== $request->get('payer_id') || !empty($request->get('payer_id'))) {
                //What fields are required for this enrollment
                $enrollmentRequiredFields = $this->checkEnrollmentFields($request->get('payer_id'));
                $this->signatureRequired = $this->payers->payerRequiresSignature($request->get('payer_id'));
                $this->blueInkSignatureRequired = $this->payers
                    ->payerRequiresBlueInkSignature($request->get('payer_id'));
                foreach ($enrollmentRequiredFields as $field) {
                    if (!$request->has($field)) {
                        $message = 'You have not supplied the required enrolment fields. - '
                            . implode(",", $enrollmentRequiredFields);
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
        } catch (Exception $ex) {
            $this->createErrorResponse('An error occured creating the Enrollment.', 404);
        }
    }*/
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
     * @param integer $enrollmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEnrollment(ApiEligibleEnrollmentRequest $request, $enrollmentId = 0)
    {
        $response = [];
        try {
            $enrollmentParams = $this->setupEnrollmentArrayFromFormInput($request);
            $enrollment = $this->enrollments->updateEnrollment($enrollmentParams, $enrollmentId);
            return response()->json($enrollment, 200);
        } catch (Exception $ex) {
            $this->createErrorResponse('An error occured updating the Enrollment.', 404);
        }
    }
    //Todo - Add relevant params to the Swagger Items.
    /**
     * @SWG\Get(
     *     path="/api/v1/enrollments.json",
     * )
     *
     * @param integer $enrollmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveEnrollment($enrollmentId = 0)
    {
        try {
            $response = $this->enrollments->retrieveEnrollment($enrollmentId);
            return response()->json($response, 200);
        } catch (Exception $ex) {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
    }

    /**
     * @param ApiEligibleEnrollmentRequest $request
     * @return mixed
     */
    private function setupEnrollmentArrayFromFormInput(ApiEligibleEnrollmentRequest $request)
    {
        $signatureCordinates = [];
        $this->setTransationTypeValue($request);
        $elligibleEnrollment['payer_id'] = $request->get('payer_id');
        $elligibleEnrollment['transaction_type_id'] = $request->get('transaction_type_id');
        $elligibleEnrollment['transaction_type'] = $this->transcationType;
        $elligibleEnrollment['facility_name'] = $request->get('facility_name');
        $elligibleEnrollment['provider_name'] = $request->get('provider_name');
        $elligibleEnrollment['tax_id'] = $request->get('tax_id');
        $elligibleEnrollment['address'] = $request->get('address');
        $elligibleEnrollment['city'] = $request->get('city');
        $elligibleEnrollment['state'] = $request->get('state');
        $elligibleEnrollment['zip'] = $request->get('zip');
        $elligibleEnrollment['npi'] = $request->get('npi');
        $elligibleEnrollment['ptan'] = $request->get('ptan');
        $elligibleEnrollment['ip_address'] = $request->ip();
        $elligibleEnrollment['authorized_signer'] = ['title' => $request->get('title'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'contact_number' => $request->get('contact_number'),
            'email' => $request->get('email'),
        ];
        if ($this->signatureRequired) {
            $signature = $this->getDentalUserSignature($request->get('user_id'));
            $elligibleEnrollment['authorized_signer']['signature'] = ['coordinates' => $signature->signature_json];
        }
        return $elligibleEnrollment;
    }

    /**
     * @param ApiEligibleEnrollmentRequest $request
     * @param \stdClass $enrollment
     * @return void
     */
    private function setEnrollmentValuesForSavingToDb(
        ApiEligibleEnrollmentRequest $request,
        \stdClass $enrollment
    ) {
        $this->enrollmentValues['user_id'] = $request->get('user_id');
        $this->enrollmentValues['payer_id'] = $request->get('payer_id');
        $this->enrollmentValues['transaction_type_id'] = $request->get('transaction_type_id');
        $this->enrollmentValues['transaction_type'] = $this->transcationType;
        $this->enrollmentValues['facility_name'] = $request->get('facility_name');
        $this->enrollmentValues['provider_name'] = $request->get('provider_name');
        $this->enrollmentValues['tax_id'] = $request->get('tax_id');
        $this->enrollmentValues['address'] = $request->get('address');
        $this->enrollmentValues['city'] = $request->get('city');
        $this->enrollmentValues['state'] = $request->get('state');
        $this->enrollmentValues['zip'] = $request->get('zip');
        $this->enrollmentValues['first_name'] = $request->get('first_name');
        $this->enrollmentValues['last_name'] = $request->get('last_name');
        $this->enrollmentValues['contact_number'] = $request->get('contact_number');
        $this->enrollmentValues['email'] = $request->get('email');
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
     * @param integer $payerId
     * @return mixed
     */
    protected function checkEnrollmentFields($payerId)
    {
        return $this->enrollments->getRequiredFieldsForEnrollment($payerId);
    }

    /**
     * @param integer $user_id
     * @return mixed
     */
    protected function getDentalUserSignature($user_id)
    {
        return $this->signatures->findBy('user_id', $user_id);
    }

    /**
     * @param integer $user_id
     * @return mixed
     */
    public function getDentalUserCompanyApiKey($userId)
    {
        try {
            $response = $this->enrollments->getUserCompanyEligibleApiKey($userId);
            return response()->json($response, 200);
        } catch (Exception $ex) {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
    }

    public function getEnrollmentTransactionType($id = 0)
    {
        try {
            $response = $this->enrollments->getEnrollmentTransactionType($id);
            return response()->json($response, 200);
        } catch (Exception $ex) {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
    }

    /**
     * @param ApiEligibleEnrollmentRequest $request
     * @return void
     */
    private function setTransationTypeValue(ApiEligibleEnrollmentRequest $request)
    {
        $transactionTypes = $this->enrollments->getEnrollmentTransactionType($request->get('transaction_type_id'));
        $this->transcationType = $transactionTypes->transaction_type;
    }
}
