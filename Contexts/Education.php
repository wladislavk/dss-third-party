<?php

namespace Contexts;

use PHPUnit\Framework\Assert;

class Education extends BaseContext
{
    /**
     * @Then I see dental sleep procedures manual
     */
    public function testProceduresManual()
    {
        $heading = $this->findCss('h2');
        Assert::assertEquals('DENTAL SLEEP PROCEDURES MANUAL', $this->sanitizeText($heading->getText()));
    }
}
