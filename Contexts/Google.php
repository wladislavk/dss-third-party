<?php

namespace Contexts;

use Behat\Mink\Element\NodeElement;
use PHPUnit\Framework\Assert;

class Google extends BaseContext
{
    /**
     * @When I open :url web page
     *
     * @param string $url
     */
    public function openPage($url)
    {
        $fullUrl = 'http://' . $url;
        $this->getCommonClient()->visit($fullUrl);
    }

    /**
     * @When I print :value in the search form
     *
     * @param string $value
     */
    public function fillField($value)
    {
        $this->page->fillField('q', $value);
        $this->getCommonClient()->wait(self::LONG_WAIT_TIME);
    }

    /**
     * @When I submit the search form
     */
    public function submitForm()
    {
        $button = $this->page->find('css', 'input[name=btnG]');
        $button->click();
    }

    /**
     * @Then I see a search form
     */
    public function testSeeSearchForm()
    {
        Assert::assertNotNull($this->page->find('css', "input[name=q]"));
    }

    /**
     * @Then I see a link to :url in the :place place on the results page
     *
     * @param string $url
     * @param string $place
     */
    public function testSeeLinkInPlace($url, $place)
    {
        $place = intval($place) - 1;
        /** @var NodeElement[] $allLinks */
        $allLinks = $this->page->findAll('css', 'div.g h3.r > a');
        $link = $allLinks[$place];
        Assert::assertContains($url, $link->getAttribute('href'));
    }
}
