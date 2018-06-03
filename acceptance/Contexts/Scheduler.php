<?php

namespace Contexts;

class Scheduler extends BaseContext
{
    /**
     * @Then I see :description scheduler event
     *
     * @param string $description
     * @throws BehatException
     */
    public function testSeeSchedulerEvent(string $description)
    {
        $this->wait(SHORT_WAIT_TIME);
        $events = $this->findAllCss('.dhx_body');
        foreach ($events as $event) {
            if ($event->getText() === $description) {
                return;
            }
        }
        throw new BehatException("No scheduler event with description '$description'");
    }
}
