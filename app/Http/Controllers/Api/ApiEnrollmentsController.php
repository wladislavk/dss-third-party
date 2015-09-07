<?php namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\BusinessObject\Enrollment;
use DentalSleepSolutions\Interfaces\EnrollmentInterface;

class ApiEnrollmentsController extends ApiBaseController
{
    /**
     * @SWG\Info(title="Dental Sleep Solutions Enrollment Api", version="0.1")
     */

    /**
     * @var
     */
    protected $enrollments;

    /**
     *
     * @param EnrollmentInterface $enrollments
     */
    public function __construct(EnrollmentInterface $enrollments)
    {
        $this->enrollments = $enrollments;
    }

    public function payersList()
    {

    }

    /**
     * @SWG\Post(
     *     path="/api/v1/enrollments.json",
     *     @SWG\Parameter(name="endpoint",
     *                    description="",required=true,type="string"),
     *     @SWG\Parameter(name="payer_id",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="transaction_type",
     *                    description="",
     *                    required=true,type="string"),
     *     @SWG\Parameter(name="facility_name",
     *                    description="", required=true,type="string"),
     *     @SWG\Parameter(name="provider_name",
     *                    description="", required=true,type="string"),
     *     @SWG\Parameter(name="tax_id",
     *                    description="", required=true,type="string"),
     *     @SWG\Response(response="200", description="Added a new memo.")
     * )
     */

    /**
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createEnrollment()
    {

        $elligibleEnrollment['endpoint'] = 'coverage';
        $elligibleEnrollment['payer_id'] = "00901";
        $elligibleEnrollment['transaction_type'] = "1";
        $elligibleEnrollment['facility_name'] = "abc";
        $elligibleEnrollment['provider_name'] = "abc123";
        $elligibleEnrollment['tax_id'] = "123456";
        $elligibleEnrollment['address'] = "Test Address";
        $elligibleEnrollment['city'] = "Lynnwood";
        $elligibleEnrollment['state'] = "WA";
        $elligibleEnrollment['zip'] = "98087";
        $elligibleEnrollment['npi'] = "1234567890";
        $elligibleEnrollment['ptan'] = "54321";
        $elligibleEnrollment['authorized_signer'] = ['title' => 'title',
                                                    'first_name' => 'fname',
                                                    'last_name' => 'lname',
                                                    'contact_number' => '12344444',
                                                    'email' => 'b@me.com',
                                                    'signature' => ['coordinates' => '']];

        $response = $this->enrollments->createEnrollment($elligibleEnrollment);
        return response()->json($response);

    }

    public function updateEnrollment()
    {

    }

    public function showEnrollment()
    {

    }

    public function destroyEnrollment()
    {

    }

    protected function checkEnrollmentFields() {
        $response = $this->enrollments->getRequiredFieldsForEnrollment('00901');
    }

}
