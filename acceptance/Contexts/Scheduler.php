<?php

namespace Contexts;

use PHPUnit\Framework\Assert;

class Scheduler extends BaseContext
{
    /**
     * @Then I see :description scheduler event
     *
     * @param string $description
     */
    public function testSeeSchedulerEvent(string $description)
    {
        $this->wait(SHORT_WAIT_TIME);
        $events = $this->findAllCss('.dhx_body');
        $eventSeen = false;
        foreach ($events as $event) {
            if ($event->getText() === $description) {
                $eventSeen = true;
                break;
            }
        }
        Assert::assertTrue($eventSeen, "No scheduler event with description '$description'");
    }
}
