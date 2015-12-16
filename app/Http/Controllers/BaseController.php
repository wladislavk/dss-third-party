<?php
namespace DentalSleepSolutions\Http\Controllers;

use \Illuminate\Support\MessageBag as MessageBag;

class BaseController extends Controller {

    /**
     * Create a new message
     *
     * @param $key
     * @param $message
     * @return MessageBag
     */
    public function addMessage($key, $message)
    {
        return new MessageBag([$key => $message]);
    }

}
