<?php

namespace Contexts;

use Behat\Mink\Session;

class Main extends BaseContext
{
    /**
     * @return Session
     */
    public function getClient()
    {
        return $this->client;
    }
}
