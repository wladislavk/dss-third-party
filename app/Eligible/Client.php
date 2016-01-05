<?php
namespace DentalSleepSolutions\Eligible;

use GuzzleHttp\Exception\ClientException;
use DentalSleepSolutions\DentalUserCompany;
use GuzzleHttp\Handler\MockHandler;

/**
 * This class encapsulates easy api for interacting with
 * Eligible REST API providing HIPAA compliant tools
 * to work with health insurance companies in US.
 *
 * @link https://eligible.com/rest
 */
class Client
{
    private $base_uri = 'https://gds.eligibleapi.com';
    private $version = 'v1.5';
    private $api_key;
    private $handler = null;

    /*********const****/

    /**claim statuses*/
    const DSS_CLAIM_PENDING = 0;
    const DSS_CLAIM_SENT = 1;
    const DSS_CLAIM_DISPUTE = 2;
    const DSS_CLAIM_PAID_INSURANCE = 3;
    const DSS_CLAIM_REJECTED = 4;
    const DSS_CLAIM_PAID_PATIENT = 5;
    const DSS_CLAIM_SEC_PENDING = 6;
    const DSS_CLAIM_SEC_SENT = 7;
    const DSS_CLAIM_SEC_DISPUTE = 8;
    const DSS_CLAIM_PAID_SEC_INSURANCE = 9;
    const DSS_CLAIM_PATIENT_DISPUTE = 10;
    const DSS_CLAIM_PAID_SEC_PATIENT = 11;
    const DSS_CLAIM_SEC_PATIENT_DISPUTE = 12;
    const DSS_CLAIM_SEC_REJECTED = 13;
    const DSS_CLAIM_EFILE_ACCEPTED = 14;
    const DSS_CLAIM_SEC_EFILE_ACCEPTED = 15;

    /**transaction types*/
    const DSS_TRXN_TYPE_MED =  1;
    const DSS_TRXN_TYPE_PATIENT = 2;
    const DSS_TRXN_TYPE_INS = 3;
    const DSS_TRXN_TYPE_DIAG = 4;
    const DSS_TRXN_TYPE_ADJ = 6;

    /**
     * @param string $version
     */
    public function __construct($version = null)
    {
        if ($version) {
            $this->version = $version;
        }

        $this->api_key = config('elligibleapi.default_api_key');
    }

    /**
     * return arguments for construct guzzle client
     *
     * @return array
     */
    private function getConstructArguments()
    {
        $arg['base_uri'] = $this->base_uri;

        if ($this->handler) {
            $arg['handler'] = $this->handler;
        }
        return $arg;
    }

    /**
     * set api key
     *
     * @param string $api_key
     */
    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * set default api key
     */
    public function restoreDefaultApiKey()
    {
        $this->api_key = config('elligibleapi.default_api_key');
    }

    /**
     * set api key from user company
     *
     * @param int $id
     */
    public function setApiKeyFromUser($id)
    {
        $new_key = DentalUserCompany::getApiKey($id);

        if ($new_key) {
            $this->api_key = $new_key;
        }
    }

    /**
     * set handler
     *
     * @param MockHandler $handler
     */
    public function setHandler(MockHandler  $handler)
    {
        $this->handler = $handler;
    }

    /**
     * create post/put request
     *
     * @param string $type
     * @param string $address
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function request($type, $address, $data)
    {
        $data['api_key'] = $this->api_key;

        if (config('elligibleapi.test')) {
            $data['test'] = 'true';
        }

        try {
            $client = new \GuzzleHttp\Client($this->getConstructArguments());
            $response = $client->request($type, '/' . $this->version . '/' . $address, [
                'json' => $data
            ]);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        if ($response->getStatusCode() >= 500) {
            throw new \Exception("Server error:" + $response->getStatusCode());
        }

        return new Response($response);
    }

    /**
     * create post request
     *
     * @param string $address
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function requestPost($address, $data)
    {
        return $this->request('POST', $address, $data);
    }

    /**
     * create put request
     *
     * @param string $address
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function requestPut($address, $data)
    {
        return $this->request('PUT', $address, $data);
    }

    /**
     * create delete request
     *
     * @param string $address
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function requestDelete($address, $data)
    {
        return $this->request('DELETE', $address, $data);
    }

    /**
     * send data for create claim
     *
     * @param array $data
     * @return Response
     */
    public function createClaim($data)
    {
        $response = $this->requestPost('claims.json', $data);
        $response->setResponseSuccessAttributes(['reference_id']);
        return $response;
    }

    /**
     * send data for create enrollment
     *
     * @param array $data
     * @return Response
     */
    public function createEnrollment($data)
    {
        return $this->requestPost('enrollment_npis', $data);
    }

    /**
     * send data for create Original Signature Pdf
     *
     * @param $data
     * @param $npi
     * @return Response
     */
    public function createOriginalSignaturePdf($data, $npi)
    {
        return $this->requestPost('enrollment_npis/' . $npi . '/original_signature_pdf', $data);
    }

    /**
     * send data for update Original Signature Pdf
     *
     * @param $data
     * @param $npi
     * @return Response
     */
    public function updateOriginalSignaturePdf($data, $npi)
    {
        return $this->requestPut('enrollment_npis/' . $npi . '/original_signature_pdf', $data);
    }

    /**
     * send data for delete Original Signature Pdf
     *
     * @param $data
     * @param $npi
     * @return Response
     */
    public function deleteOriginalSignaturePdf($data, $npi)
    {
        return $this->requestDelete('enrollment_npis/' . $npi . '/original_signature_pdf', $data);
    }
}
