<?php
namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Create a new message
     *
     * @param $key
     * @param $message
     * @return MessageBag
     */
    public function addMessage($key, $message = null)
    {
        $messages = (is_array($key)) ? $key : [$key => $message];

        return new MessageBag($messages);
    }
}
