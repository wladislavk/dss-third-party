<?php

namespace DentalSleepSolutions\Eligible;

/**
 * This class encapsulates response received from the Eligible API.
 *
 * @link https://eligible.com/rest
 */
class Response
{
    private $response = null;
    private $json;
    private $response_success_attributes = null;
    private $content;

    /*********const****/

    /**
     * @param $response
     */
    public function __construct(\GuzzleHttp\Psr7\Response $response)
    {
        $this->response = $response;
        $this->content = $this->response->getBody()->getContents();
        $this->json = json_decode($this->content);
    }

    /**
     * set $response_success_attributes
     *
     * @param array $response_success_attributes
     */
    public function setResponseSuccessAttributes(Array $response_success_attributes)
    {
        $this->response_success_attributes = $response_success_attributes;
    }

    /**
     * return status code from last request
     *
     * @return null|int
     */
    public function getStatusCode()
    {
        if ($this->response) {
            return $this->response->getStatusCode();
        }
    }

    /**
     * return list of errors
     *
     * @return null|string|array
     */
    public function getErrorsList()
    {
        if (isset($this->json->error)) {
            if (is_array($this->json->error)) {
                return $this->json->error;
            }

            return [
                'errors' => [$this->json->error]
            ];
        }

        if (isset($this->json->errors)) {
            $errors = [];

            foreach ($this->json->errors as $er) {
                $errors[] = $er->message;
            }

            return ['errors' => $errors];
        }

        return null;
    }

    /**
     * Get JSON response from the Eligible API response.
     *
     * @return object
     */
    public function getObject()
    {
        return $this->json;
    }

    /**
     * Get raw content of the Eligible API response.
     *
     * @return object
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Determine if the request was successful.
     *
     * @return bool
     */
    public function isSuccess()
    {
        if (isset($this->json->success)) {
            return $this->json->success;
        }

        if (isset($this->json->error)) {
            return false;
        }

        if ($this->getStatusCode() < 200 || $this->getStatusCode() >= 300) {
            return false;
        }

        return true;
    }

    /**
     * Get error response structure.
     *
     * @return array
     */
    public function getErrorResponse()
    {
        return ['success'=> false, 'status' => $this->getStatusCode(),  'data' => $this->getErrorsList()];
    }

    /**
     * Get success response structure.
     *
     * @param array $attributes
     * @return array
     */
    public function getSuccessResponse(Array $attributes = [])
    {
        $data['success'] = true;
        $data['data'] = [];

        if ($this->response_success_attributes) {
            foreach ($this->response_success_attributes as $attr) {
                if (isset($this->json->$attr)) {
                    $data['data'][$attr] = $this->json->$attr;
                }
            }
        }

        $data['data'] = array_merge($data['data'], $attributes);

        if (!count($data['data'])) {
            $data['data'] = null;
        }

        return $data;
    }

    /**
     * Get structure of the response used further in the controller.
     *
     * @return array
     */
    public function getResponse()
    {
        if ($this->isSuccess()) {
            return $this->getSuccessResponse();
        }

        return $this->getErrorResponse();
    }
}
