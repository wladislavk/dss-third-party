<?php

namespace Contexts;

use PHPUnit\Framework\Assert;

class LoginViaToken extends BaseContext
{
    public const BASE64_REGEXP = '[a-zA-Z\d\+\/\_\-]+';
    public const TOKEN_REGEXP = '/' . self::BASE64_REGEXP . '\.' . self::BASE64_REGEXP . '\.' . self::BASE64_REGEXP . '/';

    /**
     * @Then embedded token is :state
     *
     * @param string $state
     */
    public function testEmbeddedToken(string $state)
    {
        $field = $this->findCss('#dom-api-token');
        Assert::assertNotNull($field);
        if ($state === 'valid') {
            Assert::assertEquals(VALID_TOKEN, $field->getValue());
            return;
        }
        if ($state === 'new') {
            Assert::assertRegExp(self::TOKEN_REGEXP, $field->getValue());
            return;
        }
        Assert::assertEquals('', $field->getValue());
    }
}
