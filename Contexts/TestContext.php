<?php

namespace Contexts;

use PHPUnit\Framework\Assert;

class TestContext extends BaseContext
{
    /**
     * @Given Google is opened
     */
    public function testGoogle()
    {
        $this->getCommonClient()->visit('http://www.google.com');
        $page = $this->getCommonClient()->getPage();
        Assert::assertContains('Google', $page->getText());
    }
}
