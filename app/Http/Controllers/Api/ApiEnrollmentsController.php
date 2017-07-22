<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Eloquent\Repositories\Dental\UserCompanyRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Eloquent\Repositories\EligibleResponseRepository;
use DentalSleepSolutions\Eloquent\Repositories\Enrollments\EnrollmentRepository;
use DentalSleepSolutions\Eloquent\Repositories\Enrollments\PayersListRepository;
use DentalSleepSolutions\Eloquent\Repositories\Enrollments\TransactionTypeRepository;
use DentalSleepSolutions\Eloquent\Repositories\UserSignatureRepository;
use Exception;
use Illuminate\Http\Request;
use DentalSleepSolutions\Eligible\Client;
use DentalSleepSolutions\Helpers\InvoiceHelper;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\Enrollments\Create;
use DentalSleepSolutions\Http\Requests\ApiEligibleEnrollmentRequest;
use DentalSleepSolutions\Http\Requests\Enrollments\OriginalSignature;
use DentalSleepSolutions\Eloquent\Models\Enrollments\Enrollment;
use DentalSleepSolutions\Eligible\Webhooks\EnrollmentsHandler;
use Tymon\JWTAuth\JWTAuth;

class ApiEnrollmentsController extends ApiBaseController
{
    /** @var EnrollmentRepository */
    private $repository;

    /** @var array */
    private $enrollmentValues = [];

    /** @var bool */
    private $signatureRequired = false;

    /** @var int */
    private $transactionType = 0;

    public function __construct(
        JWTAuth $auth,
        UserRepository $userRepository,
        EnrollmentRepository $enrollmentRepository
    ) {
        parent::__construct($auth, $userRepository);
        $this->repository = $enrollmentRepository;
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
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function listEnrollments(Request $request, $userId = 0)
    {
        $result = $this->repository->getList(
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
     * @param UserCompanyRepository $userCompanyRepository
     * @param UserSignatureRepository $userSignatureRepository
     * @param TransactionTypeRepository $transactionTypeRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        Create $request,
        InvoiceHelper $invoiceHelper,
        UserCompanyRepository $userCompanyRepository,
        UserSignatureRepository $userSignatureRepository,
        TransactionTypeRepository $transactionTypeRepository
    ) {
        $userId = $request->input('user_id');
        $providerId = $request->input('provider_id');

        $payerId = explode('-', $request->input('payer_id'));

        $signature = $request->input('signature', '');
        if ($signature == '') {
            $userSignature = $userSignatureRepository->formUser($providerId);
            $signature = $userSignature->signature_json;
        }

        $transactionType = $transactionTypeRepository->findWithStatusOne($request->input('transaction_type_id'));

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

        $client = new Client($userCompanyRepository);
        $client->setApiKeyFromUser($userId);
        $response = $client->createEnrollment($data);

        if ($response->isSuccess()) {
            $inputs = $request->all();
            $inputs['contact_number'] = array_get($inputs, 'contact_number', '');
            $ip = $request->server('REMOTE_ADDR');
            $result = $response->getContent();
            $ref_id = $response->getObject()->enrollment_npi->id;

            $enrollmentId = $this->repository->add($inputs, $userId, $payerId, $payerName, $ref_id, $result, $ip);
            $enrollment = $invoiceHelper->addEnrollment(1, $userId, $enrollmentId);
            $enrollment->save();

            if ($request->input('signature', '') != '') {
                $signatureId = $userSignatureRepository->addUpdate($providerId, $signature, $ip);

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
     * @SWG\Get(
     *     path="/enrollments/payers/{transaction_type}",
     *     @SWG\Parameter(name="transaction_type", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $transactionType
     * @param UserCompanyRepository $userCompanyRepository
     * @param TransactionTypeRepository $transactionTypeRepository
     * @return object|string
     */
    public function getPayersList(
        $transactionType,
        UserCompanyRepository $userCompanyRepository,
        TransactionTypeRepository $transactionTypeRepository
    ) {
        $transactionTypeModel = $transactionTypeRepository->findWithStatusOne($transactionType);

        $client = new Client($userCompanyRepository);
        $response = $client->getPayers($transactionTypeModel->endpoint_type);

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
     * @param OriginalSignature $request
     * @param UserCompanyRepository $userCompanyRepository
     * @param EligibleResponseRepository $eligibleResponseRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadOriginalSignaturePdf(
        OriginalSignature $request,
        UserCompanyRepository $userCompanyRepository,
        EligibleResponseRepository $eligibleResponseRepository
    ) {
        $userId = $request->input('user_id');
        $npi = $request->input('npi');
        $referenceId = $request->input('reference_id');

        $data = [
            'file' => $request->file('original_signature')->openFile(),
        ];

        $enrollment = $this->repository->getWhereReference($referenceId);

        $client = new Client($userCompanyRepository);
        $client->setApiKeyFromUser($userId);

        if ($enrollment->signed_download_url) {
            $response = $client->updateOriginalSignaturePdf($data, $npi);
        } else {
            $response = $client->createOriginalSignaturePdf($data, $npi);
        }

        if ($response->isSuccess()) {
            $downloadUrl = $response->getObject()->original_signature_pdf->download_url;
            $this->repository->setStatus($referenceId, Enrollment::DSS_ENROLLMENT_PDF_SENT);
            $this->repository->setSignedDownloadUrl($referenceId, $downloadUrl);

            $handler = new EnrollmentsHandler($eligibleResponseRepository, $this->repository);
            $handler->updateChanges($referenceId);
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
     * @param PayersListRepository $payersListRepository
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function syncEnrollmentPayers(PayersListRepository $payersListRepository)
    {
        try {
            $results = $payersListRepository->syncEnrollmentPayersFromProvider(null);
            $response = ['data' => $results, 'status' => true, 'message' => ''];
        } catch (Exception $ex) {
            return $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
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
     * @param TransactionTypeRepository $transactionTypeRepository
     * @param UserSignatureRepository $userSignatureRepository
     * @param int $enrollmentId
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function updateEnrollment(
        ApiEligibleEnrollmentRequest $request,
        TransactionTypeRepository $transactionTypeRepository,
        UserSignatureRepository $userSignatureRepository,
        $enrollmentId
    ) {
        $enrollment = null;
        try {
            $enrollmentParams = $this->setupEnrollmentArrayFromFormInput(
                $request, $transactionTypeRepository, $userSignatureRepository
            );
            $enrollment = $this->repository->updateEnrollment($enrollmentParams, $enrollmentId);
        } catch (Exception $ex) {
            return $this->createErrorResponse('An error occured updating the Enrollment.', 404);
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
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function retrieveEnrollment($enrollmentId)
    {
        try {
            $response = $this->repository->retrieveEnrollment($enrollmentId);
        } catch (Exception $ex) {
            return $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
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
            $response = $this->repository->getUserCompanyEligibleApiKey($userId);
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
     * @param TransactionTypeRepository $transactionTypeRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEnrollmentTransactionType($id, TransactionTypeRepository $transactionTypeRepository)
    {
        $response = [];
        try {
            $response = $transactionTypeRepository->findWithStatusOne($id);
        } catch (Exception $ex) {
            $this->createErrorResponse('Could not retrieve list of Enrollments from Provider', 404);
        }
        return response()->json($response, 200);
    }

    /**
     * @param ApiEligibleEnrollmentRequest $request
     * @param TransactionTypeRepository $transactionTypeRepository
     * @param UserSignatureRepository $userSignatureRepository
     * @return mixed
     */
    private function setupEnrollmentArrayFromFormInput(
        ApiEligibleEnrollmentRequest $request,
        TransactionTypeRepository $transactionTypeRepository,
        UserSignatureRepository $userSignatureRepository
    ) {
        $this->setTransactionTypeValue($request, $transactionTypeRepository);
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
            $signature = $this->getDentalUserSignature($request->get('user_id'), $userSignatureRepository);
            $elligibleEnrollment['authorized_signer']['signature'] = ['coordinates' => $signature->signature_json];
        }
        return $elligibleEnrollment;
    }

    /**
     * @todo: this method is never called
     *
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
     * @todo: this method is never called
     *
     * @param int $payerId
     * @param PayersListRepository $payersListRepository
     * @return mixed
     */
    private function checkEnrollmentFields($payerId, PayersListRepository $payersListRepository)
    {
        $endpoints = $payersListRepository->getPayerSupportedEndpoints($payerId);
        return $this->repository->getRequiredFieldsForEnrollment($endpoints);
    }

    /**
     * @param int $userId
     * @param UserSignatureRepository $userSignatureRepository
     * @return mixed
     */
    private function getDentalUserSignature($userId, UserSignatureRepository $userSignatureRepository)
    {
        return $userSignatureRepository->getOneBy('user_id', $userId);
    }

    /**
     * @param ApiEligibleEnrollmentRequest $request
     * @param TransactionTypeRepository $transactionTypeRepository
     */
    private function setTransactionTypeValue(
        ApiEligibleEnrollmentRequest $request,
        TransactionTypeRepository $transactionTypeRepository
    ) {
        $transactionTypes = $transactionTypeRepository->findWithStatusOne($request->get('transaction_type_id'));
        if (isset($transactionTypes->transaction_type)) {
            $this->transactionType = $transactionTypes->transaction_type;
        }
    }
}
