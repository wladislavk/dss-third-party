<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use DentalSleepSolutions\Eligible\Client;
use DentalSleepSolutions\Helpers\InvoiceHelper;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Eloquent\Models\UserSignature;
use DentalSleepSolutions\Http\Requests\Enrollments\Create;
use DentalSleepSolutions\Http\Requests\ApiEligibleEnrollmentRequest;
use DentalSleepSolutions\Http\Requests\Enrollments\OriginalSignature;
use DentalSleepSolutions\Eloquent\Models\Enrollments\Enrollment;
use DentalSleepSolutions\Eloquent\Models\Enrollments\TransactionType;
use DentalSleepSolutions\Eligible\Webhooks\EnrollmentsHandler;
use DentalSleepSolutions\Interfaces\EnrollmentInterface;
use DentalSleepSolutions\Interfaces\UserSignaturesInterface;
use DentalSleepSolutions\Interfaces\EnrollmentPayersInterface;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Eloquent\Models\Dental\User;

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

    /** @var int */
    protected $transactionType = 0;

    public function __construct(
        JWTAuth $auth,
        User $userModel,
        EnrollmentInterface $enrollments,
        EnrollmentPayersInterface $payers,
        UserSignaturesInterface $signatures
    ) {
        parent::__construct($auth, $userModel);
        $this->enrollments = $enrollments;
        $this->payers = $payers;
        $this->signatures = $signatures;
    }

    /**
     * Enrollments list
     *
     * @param Request $request
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function listEnrollments(Request $request, $userId = 0)
    {
        $result = Enrollment::getList(
            $userId,
            $request->get('num_rows', false),
            $request->get('search', false),
            $request->get('sort', 'transaction_type'),
            $request->get('sort_type', 'asc')
        );

        if ($request->get('num_rows', false)) {
            $result = ApiResponse::getPaginateStructure($result);
        }

        return ApiResponse::responseOk('List of Enrollments', $result);
    }

    /**
     * create enrollment
     *
     * @param  \DentalSleepSolutions\Http\Requests\Enrollments\Create $request
     * @param InvoiceHelper $invoiceHelper
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Create $request, InvoiceHelper $invoiceHelper)
    {
        $userId = $request->input('user_id');
        $providerId = $request->input('provider_id');

        $payerId = explode('-', $request->input('payer_id'));

        $signature = $request->input('signature', '');
        if ($signature == '') {
            $userSignature = UserSignature::formUser($providerId);
            $signature = $userSignature->signature_json;
        }

        $transactionType = TransactionType::where('id', $request->input('transaction_type_id'))
            ->where('status', 1)->first();

        if (count($payerId) < 2 || !$transactionType) {
            return ApiResponse::responseError("Error creating enrollment.", 422);
        }

        $payerName = $payerId[1];
        $payerId = $payerId[0];

        $data['enrollment_npi'] = [
            "payer_id" => $payerId,
            "endpoint" => $transactionType->endpoint_type,
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
        $client->setApiKeyFromUser($userId);
        $response = $client->createEnrollment($data);

        if ($response->isSuccess()) {
            $inputs = $request->all();
            $inputs['contact_number'] = array_get($inputs, 'contact_number', '');
            $ip = $request->server('REMOTE_ADDR');
            $result = $response->getContent();
            $ref_id = $response->getObject()->enrollment_npi->id;

            $enrollmentId = Enrollment::add($inputs, $userId, $payerId, $payerName, $ref_id, $result, $ip);
            $enrollment = $invoiceHelper->addEnrollment(1, $userId, $enrollmentId);
            $enrollment->save();

            if ($request->input('signature', '') != '') {
                $signatureId = UserSignature::addUpdate($providerId, $signature, $ip);

                $img = \sigJsonToImage($request->input('signature', ''));

                $file = "signature_" . $providerId . "_" . $signatureId . ".png";
                $path = env('SHARED_PATH', '').'/q_file/'.$file;

                if (file_exists($path)) {
                    unlink($path);
                }

                imagepng($img, $path);
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
        $userId = $request->input('user_id');
        $npi = $request->input('npi');
        $referenceId = $request->input('reference_id');

        $data = [
            'file' => $request->file('original_signature')->openFile(),
        ];

        $enrollment = Enrollment::getWhereReference($referenceId);

        $client = new Client();
        $client->setApiKeyFromUser($userId);

        if ($enrollment->signed_download_url) {
            $response = $client->updateOriginalSignaturePdf($data, $npi);
        } else {
            $response = $client->createOriginalSignaturePdf($data, $npi);
        }

        if ($response->isSuccess()) {
            $download_url = $response->getObject()->original_signature_pdf->download_url;
            Enrollment::setStatus($referenceId, Enrollment::DSS_ENROLLMENT_PDF_SENT);
            Enrollment::setSignedDownloadUrl($referenceId, $download_url);

            (new EnrollmentsHandler())->updateChanges($referenceId);
        }

        return ApiResponse::response(
            $response->getResponse(),
            "Your enrollment has been submitted.",
            "Error submitted enrollment."
        );
    }

    /**
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function syncEnrollmentPayers()
    {
        try {
            $results = $this->payers->syncEnrollmentPayersFromProvider(null);
            $response = ['data' => $results, 'status' => true, 'message' => ''];
        } catch (Exception $ex) {
            return $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
        return response()->json($response, 200);
    }

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
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function updateEnrollment(ApiEligibleEnrollmentRequest $request, $enrollmentId = 0)
    {
        try {
            $enrollmentParams = $this->setupEnrollmentArrayFromFormInput($request);
            $enrollment = $this->enrollments->updateEnrollment($enrollmentParams, $enrollmentId);
        } catch (Exception $ex) {
            return $this->createErrorResponse('An error occured updating the Enrollment.', 404);
        }
        return response()->json($enrollment, 200);
    }

    //Todo - Add relevant params to the Swagger Items.
    /**
     * @SWG\Get(
     *     path="/api/v1/enrollments.json",
     * )
     *
     * @param integer $enrollmentId
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function retrieveEnrollment($enrollmentId = 0)
    {
        try {
            $response = $this->enrollments->retrieveEnrollment($enrollmentId);
        } catch (Exception $ex) {
            return $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
        return response()->json($response, 200);
    }

    /**
     * @param ApiEligibleEnrollmentRequest $request
     * @return mixed
     */
    private function setupEnrollmentArrayFromFormInput(ApiEligibleEnrollmentRequest $request)
    {
        $this->setTransactionTypeValue($request);
        $elligibleEnrollment['payer_id'] = $request->get('payer_id');
        $elligibleEnrollment['transaction_type_id'] = $request->get('transaction_type_id');
        $elligibleEnrollment['transaction_type'] = $this->transactionType;
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
        $this->enrollmentValues['transaction_type'] = $this->transactionType;
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
            implode(',', $enrollment->enrollment_npi->payer->names),
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
     * @param int $userId
     * @return mixed
     */
    public function getDentalUserCompanyApiKey($userId)
    {
        try {
            $response = $this->enrollments->getUserCompanyEligibleApiKey($userId);
        } catch (Exception $ex) {
            return $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
        return response()->json($response, 200);
    }

    /**
     * @param int $id
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getEnrollmentTransactionType($id = 0)
    {
        try {
            $response = $this->enrollments->getEnrollmentTransactionType($id);
        } catch (Exception $ex) {
            return $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
        return response()->json($response, 200);
    }

    /**
     * @param ApiEligibleEnrollmentRequest $request
     * @return void
     */
    private function setTransactionTypeValue(ApiEligibleEnrollmentRequest $request)
    {
        $transactionTypes = $this->enrollments->getEnrollmentTransactionType($request->get('transaction_type_id'));
        if (isset($transactionTypes->transaction_type)) {
            $this->transactionType = $transactionTypes->transaction_type;
        }
    }
}
