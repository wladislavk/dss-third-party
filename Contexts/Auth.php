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
        // do nothing
    }

    /**
     * @Given user :user does not exist
     *
     * @param string $user
     */
    public function givenUserDoesNotExist($user)
    {
        // do nothing
    }

    /**
     * @When I type in :user as login and :password as password
     *
     * @param string $user
     * @param string $password
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
        Assert::assertNotNull($this->findCss('form#loginForm'));
    }

    /**
     * @Then I see main page with welcome text for user :user
     *
     * @param string $user
     */
    public function testSeeWelcomeText($user)
    {
        if (SUT_HOST != 'vue') {
            $this->reloadStartPage();
        }

        $this->wait(self::SHORT_WAIT_TIME);
        $welcomeDiv = $this->findCss('div.suckertreemenu');
        Assert::assertNotNull($welcomeDiv);
        Assert::assertContains('Welcome ' . $user, $welcomeDiv->getText());
    }

    /**
     * @Then I see auth error message
     */
    public function testSeeAuthError()
    {
        $span = $this->findCss('span.red');
        Assert::assertNotNull($span);
        Assert::assertContains('Username or password not found', $span->getText());
    }
}
