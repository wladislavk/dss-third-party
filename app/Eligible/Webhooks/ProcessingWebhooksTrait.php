<?php

namespace DentalSleepSolutions\Eligible\Webhooks;

use Exception;
use Illuminate\Http\Request;
use DentalSleepSolutions\Eloquent\EligibleResponse;

trait ProcessingWebhooksTrait
{
    public function processing(Request $request)
    {
        $content = json_decode($request->getContent());

        if (!$content || !isset($content->event)) {
            throw new Exception("Wrong response from webhooks");
        }

        $reference_id = $this->callHandler($content, $this);

        $data = [
            'response' => $request->getContent(),
            'reference_id' => $reference_id,
            'event_type' => $content->event,
            'ip_address' => $request->server('REMOTE_ADDR'),
        ];

        EligibleResponse::add($data);

        return response()->json(); //return status 200
    }

    private function callHandler($content, $object)
    {
        $event = camel_case($content->event);

        if (method_exists($object, $event)) {
            return $object->$event($content);
        }

        return null;
    }
}
