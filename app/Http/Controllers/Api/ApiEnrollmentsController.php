<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use DentalSleepSolutions\Eligible\Client;
use DentalSleepSolutions\Helpers\InvoiceHelper;
use DentalSleepSolutions\StaticClasses\ApiResponse;
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
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Eloquent\Dental\User;

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
     * @param JWTAuth $auth
     * @param User $userModel
     * @param EnrollmentInterface $enrollments
     * @param EnrollmentPayersInterface $payers
     * @param UserSignaturesInterface $signatures
     */
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
     * @SWG\Get(
     *     path="/enrollments/list/{userId}",
     *     @SWG\Parameter(name="userId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @SWG\Get(
     *     path="/enrollments/list",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * Enrollments list
     *
     * @param Request $request
     * @param int|bool $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function listEnrollments(Request $request, $userId = false)
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
     * @SWG\Post(
     *     path="/enrollments/create",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * create enrollment
     *
     * @param  \DentalSleepSolutions\Http\Requests\Enrollments\Create $request
     * @param InvoiceHelper $invoiceHelper
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Create $request, InvoiceHelper $invoiceHelper)
    {
        $user_id = $request->input('user_id');
        $provider_id = $request->input('provider_id');

        $payer_id = explode('-', $request->input('payer_id'));

        $signature = $request->input('signature', '');
        if ($signature == '') {
            $user_signature = UserSignature::formUser($provider_id);
            $signature = $user_signature->signature_json;
        }

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
            $enrollment = $invoiceHelper->addEnrollment(1, $user_id, $enrollment_id);
            $enrollment->save();

            if ($request->input('signature', '') != '') {
                $signature_id = UserSignature::addUpdate($provider_id, $signature, $ip);

                $img = \sigJsonToImage($request->input('signature', ''));

                $file = "signature_" . $provider_id . "_" . $signature_id . ".png";
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
     * @SWG\Get(
     *     path="/enrollments/payers/{transaction_type}",
     *     @SWG\Parameter(name="transaction_type", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $transaction_type
     * @return object|string
     */
    public function getPayersList($transaction_type)
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
     * @SWG\Post(
     *     path="/enrollments/payers/original-signature/send",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
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
     * @SWG\Get(
     *     path="/enrollments/syncpayers",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncEnrollmentPayers()
    {
        $response = [];
        try {
            $results = $this->payers->syncEnrollmentPayersFromProvider(null);
            $response = ['data' => $results, 'status' => true, 'message' => ''];
        } catch (Exception $ex) {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
        return response()->json($response, 200);
    }

    /**
     * @SWG\Post(
     *     path="/enrollments/update/{enrollmentId}",
     *     @SWG\Parameter(name="enrollmentId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param ApiEligibleEnrollmentRequest $request
     * @param int $enrollmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEnrollment(ApiEligibleEnrollmentRequest $request, $enrollmentId = 0)
    {
        $enrollment = null;
        try {
            $enrollmentParams = $this->setupEnrollmentArrayFromFormInput($request);
            $enrollment = $this->enrollments->updateEnrollment($enrollmentParams, $enrollmentId);
        } catch (Exception $ex) {
            $this->createErrorResponse('An error occured updating the Enrollment.', 404);
        }
        return response()->json($enrollment, 200);
    }

    /**
     * @SWG\Get(
     *     path="/enrollments/retrieve/{enrollmentId}",
     *     @SWG\Parameter(name="enrollmentId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $enrollmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveEnrollment($enrollmentId)
    {
        $response = [];
        try {
            $response = $this->enrollments->retrieveEnrollment($enrollmentId);
        } catch (Exception $ex) {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
        return response()->json($response, 200);
    }

    /**
     * @SWG\Get(
     *     path="/enrollments/apikey/{userId}",
     *     @SWG\Parameter(name="userId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDentalUserCompanyApiKey($userId)
    {
        $response = [];
        try {
            $response = $this->enrollments->getUserCompanyEligibleApiKey($userId);
        } catch (Exception $ex) {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
        return response()->json($response, 200);
    }

    /**
     * @SWG\Get(
     *     path="/enrollments/type/{id}",
     *     @SWG\Parameter(name="id", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEnrollmentTransactionType($id)
    {
        $response = [];
        try {
            $response = $this->enrollments->getEnrollmentTransactionType($id);
        } catch (Exception $ex) {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
        return response()->json($response, 200);
    }

    /**
     * @param ApiEligibleEnrollmentRequest $request
     * @return mixed
     */
    private function setupEnrollmentArrayFromFormInput(ApiEligibleEnrollmentRequest $request)
    {
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
     * @param ApiEligibleEnrollmentRequest $request
     * @return void
     */
    private function setTransationTypeValue(ApiEligibleEnrollmentRequest $request)
    {
        $transactionTypes = $this->enrollments->getEnrollmentTransactionType($request->get('transaction_type_id'));
        $this->transcationType = $transactionTypes->transaction_type;
    }
}
