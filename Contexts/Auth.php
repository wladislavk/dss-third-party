<?php

namespace Contexts;

use PHPUnit\Framework\Assert;

class Auth extends BaseContext
{
    /**
     * @Given user :user exists and has password :password
     *
     * @param string $user
     * @param string $password
     */
    public function givenUserExists($user, $password)
    {
        Assert::assertTrue(array_key_exists($user, self::PASSWORDS));
        $realPassword = self::PASSWORDS[$user];
        Assert::assertEquals($password, $realPassword);
        $this->visitStartPage();
    }

    /**
     * @Given user :user does not exist
     *
     * @param string $user
     */
    public function givenUserDoesNotExist($user)
    {
        Assert::assertFalse(array_key_exists($user, self::PASSWORDS));
        $this->visitStartPage();
    }

    /**
     * @When I type in :user as login and :password as password
     *
     * @param string $user
     * @param string $password
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function sendAuthForm($user, $password)
    {
        $this->login($user, $password);
    }

    /**
     * @Then I see login form
     */
    public function testSeeAuthForm()
    {
        $this->wait(self::SHORT_WAIT_TIME);
        Assert::assertNotNull($this->findCss('form#loginForm'));
    }

    /**
     * @Then I see auth error message
     */
    public function testSeeAuthError()
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $span = $this->findCss('span.red');
        Assert::assertNotNull($span);
        Assert::assertEquals('Username or password not found. This account may be inactive.', $span->getText());
    }
}
