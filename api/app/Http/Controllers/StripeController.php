<?php

namespace DentalSleepSolutions\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Response;

class StripeController extends Controller
{
    /**
     * @param string $path
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function proxy(string $path)
    {
        $apiBase = 'https://api.stripe.com/';
        $url = $apiBase . $path;
        $query = $this->request->getQueryString();
        $method = $this->request->getRealMethod();
        $headers = $this->request->headers->all();
        $payload = $this->request->payload();
        if ($query) {
            $url .= '?' . $query;
        }
        $options = [
            'headers' => $headers,
            'form_params' => null,
        ];
        if ($payload) {
            $options['form_params'] = $payload;
        }
        $client = new Client();
        try {
            $response = $client->request($method, $url, $options);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }
        $statusCode = $response->getStatusCode();
        $headers = $response->getHeaders();
        $body = $response->getBody()->getContents();
        unset($headers['Content-Length']);
        unset($headers['Connection']);
        return new Response($body, $statusCode, $headers);
    }
}
